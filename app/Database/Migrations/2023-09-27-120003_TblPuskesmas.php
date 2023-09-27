<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblPuskesmas extends Migration
{
    public function up()
    {
        $fields = [ 
            'id_puskesmas' => [
                'type' => 'TINYINT',
                'unsigned' => 3,
            ],
            'nama_puskesmas' => [
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
        $this->forge->addPrimaryKey('id_puskesmas');
        $attributes = ['ENGINE' => 'InnoDB'];
        $this->forge->createTable('tbl_puskesmas', false, $attributes);

    }

    public function down()
    {
        $this->forge->dropTable('tbl_puskesmas');
    }
}
