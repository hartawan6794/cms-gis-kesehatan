<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Altertbluserdetail extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('tbl_user', 'telpon');
        $this->forge->addColumn('tbl_user_detail', [
            'telpon' => [

                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,

            ]
        ]);
    }

    public function down()
    {
        //
    }
}
