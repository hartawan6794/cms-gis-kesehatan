<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTblUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_user', [
            'bearer_token' => [
                'type' => 'varchar',
                'constraint' => '500'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_user','bearer_token');
    }
}
