<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class User extends CI_Controller {

    private $secret_key = 'f8b2fcbbe59d8491bcae8a3fa074dd8e7c9eab17c421e59d03c9db31f6150421';  // Change this to a secure key

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        // Get POST data (username and password)
        $username = $this->input->post('username');
        $password = $this->input->post('password');
    
        // Validate input
        if (empty($username) || empty($password)) {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['message' => 'Username and password are required']));
            return;
        }
    
        // Get the user from the database
        $user = $this->User_model->get_user_by_username($username);
    
        if ($user && password_verify($password, $user['password'])) {
            // Generate JWT token
            $issued_at = time();
            $session_duration = 3600;
            $expiration_time = $issued_at + $session_duration; // token expires in 1 hour
            $payload = array(
                'iat' => $issued_at,
                'exp' => $expiration_time,
                'user_id' => $user['id']
            );
    
            try {
                $jwt = JWT::encode($payload, $this->secret_key, 'HS256');
                $this->load->model('Login_sessions_model');
                $this->Login_sessions_model->create_session($user['id'], $session_duration);
                // Return the token as JSON response
                $this->output
                     ->set_status_header(200)
                     ->set_content_type('application/json')
                     ->set_output(json_encode(['token' => $jwt]));
            } catch (Exception $e) {
                $this->output
                     ->set_status_header(500)
                     ->set_content_type('application/json')
                     ->set_output(json_encode(['message' => 'Token generation failed']));
            }
        } else {
            // Return error if invalid credentials
            $this->output
                 ->set_status_header(401)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['message' => 'Invalid credentials']));
        }
    }
    
    
}
