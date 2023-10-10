<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblUserDetail extends Migration
{
    public function up()
    {
        $fields = [
            'id_user_detail' => [
                'type' => 'SMALLINT',
                // 'constraint' => 5,
                'auto_increment' => true
            ],
            'nik' => [
                'type' => 'varchar',
                'constraint' => '20',
                'null' => true,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'tgl_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tmp_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'jns_kelamin' => [
                'type' => 'varchar',
                'constraint' => '50',
                'null' => true,
            ],
            'img_user' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null' => true,
                // 'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                // 'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id_user_detail');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_user_detail', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_user_detail');
    }
}
