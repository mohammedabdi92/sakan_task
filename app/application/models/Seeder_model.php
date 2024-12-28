<?php
class Seeder_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    // Seeder method for users table
    public function seed_users() {
        $users_data = [
            ['username' => 'mohammed', 'email' => 'mohammed@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
            ['username' => 'ahmad', 'email' => 'ahmad@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)]
        ];

        // Insert the users data into the database
        $this->db->insert_batch('users', $users_data);
    }

    // Seeder method for login_sessions table
    public function seed_login_sessions() {
        $users = [
            ['user_id' => 1],
            ['user_id' => 2],
        ];

        $start_date = '2024-12-01';

      
        $data = [];

        foreach ($users as $user) {
            for ($day = 0; $day < 2; $day++) {
                $date = date('Y-m-d', strtotime("$start_date +$day day"));

                for ($session = 0; $session < 100; $session++) {
                    $login_time = $this->generateRandomLoginTime($date);

                    $data[] = [
                        'user_id'    => $user['user_id'],
                        'login_time' => $login_time,
                    ];
                }
            }
        }

        $this->db->insert_batch('login_sessions', $data);

    }
    public function generateRandomLoginTime($date) {
        $hour = rand(0, 23);
        $minute = rand(0, 59);
        return "$date " . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minute, 2, '0', STR_PAD_LEFT) . ':00';
    }


    // Method to seed all data
    public function seed_all() {
        $this->seed_users();
        $this->seed_login_sessions();
    }
}
