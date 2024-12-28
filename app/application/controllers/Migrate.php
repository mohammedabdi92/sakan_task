<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index() {
        if ($this->migration->latest()) {
            echo "Migrations ran successfully.";
        } else {
            show_error($this->migration->error_string());
        }
    }

    public function create($name) {
        $timestamp = date('YmdHis');
        $filename = APPPATH . "migrations/{$timestamp}_{$name}.php";
        $content = "<?php\n\n" .
                   "defined('BASEPATH') OR exit('No direct script access allowed');\n\n" .
                   "class Migration_" . ucfirst($name) . " extends CI_Migration {\n" .
                   "    public function up() {\n" .
                   "        // Add your migration code here\n" .
                   "    }\n\n" .
                   "    public function down() {\n" .
                   "        // Add code to reverse migration here\n" .
                   "    }\n" .
                   "}\n";

        if (file_put_contents($filename, $content)) {
            echo "Migration file created: {$filename}\n";
        } else {
            echo "Failed to create migration file.\n";
        }
    }
}
