<?php
class Seed extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the Seeder model
        $this->load->model('Seeder_model');
    }

    // Run all seeders (users and login_sessions)
    public function index() {
        echo "Seeding all data...\n";
        $this->Seeder_model->seed_all();
        echo "Seeding completed!\n";
    }

    // Run only the users seeder
    public function seed_users() {
        echo "Seeding users...\n";
        $this->Seeder_model->seed_users();
        echo "Users seeding completed!\n";
    }

    // Run only the login_sessions seeder
    public function seed_login_sessions() {
        echo "Seeding login_sessions...\n";
        $this->Seeder_model->seed_login_sessions();
        echo "Login_sessions seeding completed!\n";
    }
}
