<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_CreateLoginsTable extends CI_Migration {
    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'login_time' => array(
                'type' => 'DATETIME',
            ),
            'session_duration' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('login_sessions');
        
    }

    public function down() {
        log_message('error', 'Running down() method - Table will be dropped');
        $this->dbforge->drop_table('login_sessions');
        die('ss');

    }
}
