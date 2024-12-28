<?php

class LoginSessionsSeeder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function run()
    {
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

        echo "Login sessions seeded successfully.";
    }

    public function generateRandomLoginTime($date) {
        $hour = rand(0, 23);
        $minute = rand(0, 59);
        return "$date " . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minute, 2, '0', STR_PAD_LEFT) . ':00';
    }

   
}
