<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblPuskesmas extends Migration
{
    public function up()
    {
        $fields = [ 
            'id' => [
                'type' => 'TINYINT',
                'unsigned' => 3,
                'auto_increment' => true
            ],
            'nama' => [
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
            ],'is_jadwal' => [
                'type' => 'TINYINT',
                'null' => true,
                'constraint' => 3
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
        $this->forge->addPrimaryKey('id');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_puskesmas', false, $attributes);

    }

    public function down()
    {
        $this->forge->dropTable('tbl_puskesmas');
    }
}
