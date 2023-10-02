<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblRumahSakitIbuDanAnak extends Migration
{
    public function up()
    {
        $fields = [ 
            'id_rsia' => [
                'type' => 'TINYINT',
                'unsigned' => 3,
                'auto_increment' => true
            ],
            'nama_rsia' => [
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
                'constraint' => '255',
                'null' => true,
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
        $this->forge->addPrimaryKey('id_rsia');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_rumah_sakit_ibu_anak', false, $attributes);

    }

    public function down()
    {
        $this->forge->dropTable('tbl_rumah_sakit_ibu_anak');
    }
}
