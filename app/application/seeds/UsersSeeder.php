<?php

class UsersSeeder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function run()
    {
        $data = [
            [
                'username' => 'john_doe',
                'email'    => 'john@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'jane_doe',
                'email'    => 'jane@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert users data into the users table
        $this->db->insert_batch('users', $data);
    }
}
