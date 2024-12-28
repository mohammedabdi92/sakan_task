<?php 
class Login_sessions_model extends CI_Model {

    public function create_session($user_id, $session_duration) {
        $data = array(
            'user_id' => $user_id,
            'login_time' => date('Y-m-d H:i:s'),  // current timestamp
            'session_duration' => $session_duration  // token expiration time in seconds
        );

        return $this->db->insert('login_sessions', $data);
    }
    
    public function get_login_sessions_count($start_date, $end_date) {
        $this->db->from('login_sessions');
        if($start_date)
        {
            $this->db->where('login_time >=', $start_date);
        }
        if($end_date)
        {
            $this->db->where('login_time <=', $end_date);
        }
        return $this->db->count_all_results();
    }

    public function get_paginated_sessions($start_date, $end_date, $limit, $offset) {
        $this->db->select('user_id, username, login_time, TIMESTAMPDIFF(MINUTE, login_time, NOW()) AS session_duration');
        $this->db->from('login_sessions');
        $this->db->join('users', 'users.id = login_sessions.user_id');
        if($start_date)
        {
            $this->db->where('login_time >=', $start_date." 00:00:00");
        }
        if($end_date)
        {
            $this->db->where('login_time <=', $end_date." 11:59:59");
        }
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_peak_hours($start_date, $end_date) {
        $this->db->select('HOUR(login_time) as hour, COUNT(*) as login_count');
        $this->db->from('login_sessions');
        if($start_date)
        {
            $this->db->where('login_time >=', $start_date." 00:00:00");
        }
        if($end_date)
        {
            $this->db->where('login_time <=', $end_date." 11:59:59");
        }
        $this->db->group_by('hour');
        $this->db->order_by('hour', 'ASC'); // Order by hour (ascending)
        $query = $this->db->get();
        return $query->result_array();
    }
}
