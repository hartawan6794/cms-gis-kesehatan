<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblUser extends Migration
{
    public function up()
    {
        $fields = [
            'id_user' => [
                'type' => 'SMALLINT',
                'auto_increment' => true
            ],
            'email_user' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'device_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'telpon' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => 1,
                'null' => true,
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id_user');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_user', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_user');
    }
}
