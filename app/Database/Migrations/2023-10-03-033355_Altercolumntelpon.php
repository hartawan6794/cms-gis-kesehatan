<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Altercolumntelpon extends Migration
{
    public function up()
    {
        $field = [
            'notelp' => [
                'type' => 'varchar',
                'constraint' => '15',
                'null' => true,
            ]
        ];

        $this->forge->addColumn('tbl_rumah_sakit_ibu_anak',$field);
        $this->forge->addColumn('tbl_klinik',$field);
        $this->forge->addColumn('tbl_rumah_sakit',$field);
        $this->forge->addColumn('tbl_puskesmas',$field);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_rumah_sakit_ibu_anak','notelp');
        $this->forge->dropColumn('tbl_klinik','notelp');
        $this->forge->dropColumn('tbl_rumah_sakit','notelp');
        $this->forge->dropColumn('tbl_puskesmas','notelp');
    }
}
