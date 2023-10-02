<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblKlinik extends Migration
{
    public function up()
    {
        $fields = [
            'id_klinik' => [
                'type' => 'TINYINT',
                'unsigned' => 3,
            ],
            'nama_klinik' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'deskripsi' => [
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
            'gambar' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => '255'
            ],
            'is_jadwal' => [
                'type' => 'TINYINT',
                'constraint' => 3,
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
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id_klinik');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_klinik', false, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_klinik');
    }
}
