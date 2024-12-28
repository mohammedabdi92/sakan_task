<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary models and libraries
        $this->load->model('Login_sessions_model'); // Assuming you have this model
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index()
    {
        // Get start_date and end_date from query params, or set defaults
        $start_date = $this->input->get('start_date', true) ?? '';
        $end_date = $this->input->get('end_date', true) ?? '';

        // Pagination configuration
        $base_url = base_url('dashboard/index');
        $config['base_url'] = $base_url; // Ensure base_url is always set
        $config['total_rows'] = $this->Login_sessions_model->get_login_sessions_count($start_date, $end_date);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3; // Segment for page number
        $config['num_links'] = 2;

        // Construct query parameters for filters
        $query_suffix = http_build_query(array_filter([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])); // `array_filter` removes null or empty values

        // Ensure `suffix` and `first_url` are set correctly
        $config['suffix'] = $query_suffix ? '?' . $query_suffix : '';
        $config['first_url'] = $base_url . ($query_suffix ? '?' . $query_suffix : '');

        // Initialize pagination
        $this->pagination->initialize($config);

        // Get the current page from the URL
        $page = intval($this->uri->segment(3, 0)); // Default to 0 if not present

        // Fetch paginated login sessions
        $data['login_sessions'] = $this->Login_sessions_model->get_paginated_sessions(
            $start_date, $end_date, $config['per_page'], $page
        );

        // Generate peak hours data for the chart
        $peak_hours_data = $this->Login_sessions_model->get_peak_hours($start_date, $end_date);

        // Prepare peak hours data for the chart
        $data['chart_data'] = json_encode($peak_hours_data);

        // Pass data for filters, pagination, and chart
        $data['pagination_links'] = $this->pagination->create_links();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // Load the view
        $this->load->view('dashboard', $data);
    }

    
    
}
