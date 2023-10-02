<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblJadwal extends Migration
{
    public function up()
    {
        $fields = [
            'id_jadwal' => [
                'type' => 'TINYINT',
                'constraint' => 3
            ],
            'senin' => [
                'type' => 'varchar',
                'constraint' => '10',
                'null' => true,
            ],
            'jam_buka_senin' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5',
            ],
            'jam_tutup_senin' => [
                'type' => 'varchar',
                'constraint' => '5',
                'null' => true,
            ],
            'selasa' => [
                'type' => 'varchar',
                'constraint' => '10',
                'null' => true,
            ],
            'jam_buka_selasa' => [
                'type' => 'varchar',
                'constraint' => '5',
                'null' => true,
            ],
            'jam_tutup_selasa' => [
                'type' => 'varchar',
                'constraint' => '5',
                'null' => true,
            ],
            'rabu' => [
                'type' => 'varchar',
                'constraint' => '10',
                'null' => true,
            ],
            'jam_buka_rabu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'jam_tutup_rabu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'kamis' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '10'
            ],
            'jam_buka_kamis' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'jam_tutup_kamis' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'jumat' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '10'
            ],
            'jam_buka_jumat' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'jam_tutup_jumat' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'sabtu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '10'
            ],
            'jam_buka_sabtu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'jam_tutup_sabtu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'minggu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '10'
            ],
            'jam_buka_minggu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
            ],
            'jam_tutup_minggu' => [
                'type' => 'varchar',
                'null' => true,
                'constraint' => '5'
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
        $this->forge->addPrimaryKey('id_jadwal');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_jadwal', false, $attributes);

    }

    public function down()
    {
        $this->forge->dropTable('tbl_jadwal');
    }
}
