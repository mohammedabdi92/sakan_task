<?php

class User_model extends CI_Model {

    public function get_user_by_username($username) {
        // Query to fetch user by username
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        // Return user data if found
        return $query->row_array();
    }
}
