<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblRumahSakit extends Migration
{
    public function up()
    {
        $fields = [ 
            'id_rs' => [
                'type' => 'TINYINT',
                'unsigned' => 3,
            ],
            'nama_rs' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'Latitude' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
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
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id_rs');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_rumah_sakit', false, $attributes);

    }

    public function down()
    {
        $this->forge->dropTable('tbl_user');
    }
}
