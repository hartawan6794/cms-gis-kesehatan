<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TbluserModel;
use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;

class Api extends BaseController
{
    protected $privateKey;
    protected $db;

    function __construct()
    {
        $this->db = db_connect();
        $this->privateKey = Services::privateKey()['keyServer'];
    }

    public function tempatKesehatanTerkini()
    {

        $sql = "SELECT
        id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(gambar, '-', -1), '_', 1) AS tabel,
        nama,
        kecamatan,
        deskripsi,
        latitude,
        longitude,
        gambar,
        notelp
    FROM
        (
            SELECT
                *
            FROM
                tbl_klinik
            UNION
            ALL
            SELECT
                *
            FROM
                tbl_puskesmas
            UNION
            ALL
            SELECT
                *
            FROM
                tbl_rumah_sakit
            UNION
            ALL
            SELECT
                *
            FROM
                tbl_rumah_sakit_ibu_anak
        ) z
    order by
        created_at DESC
    LIMIT
        5";
        $data = $this->db->query($sql)->getResult();

        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'result'      => $data,
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Gagal Mendapatkan Data',
                'result'      => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function layananKesehatan()
    {
        $response = array();
        $db = \Config\Database::connect();
        $data = $this->request->getJSON();

        $table = $data->tabel;

        $sql = "SELECT 
        id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(gambar, '-', -1), '_', 1) AS tabel,
        nama,
        kecamatan,
        deskripsi,
        latitude,
        longitude,
        gambar,
        notelp
        FROM $table";

        $data = $this->db->query($sql)->getResult();
        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'result'      => $data,
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Gagal Mendapatkan Data',
                'result'      => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function searchLayananKesehatan(){
        $response = array();
        $db = \Config\Database::connect();
        $data = $this->request->getJSON();

        $table = $data->tabel;
        $nama = $data->nama;

        $sql = "SELECT 
        id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(gambar, '-', -1), '_', 1) AS tabel,
        nama,
        kecamatan,
        deskripsi,
        latitude,
        longitude,
        gambar,
        notelp
        FROM $table 
        WHERE nama like '%$nama%'";

        $data = $this->db->query($sql)->getResult();
        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'result'      => $data,
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Gagal Mendapatkan Data',
                'result'      => []
            ];
        }

        return $this->response->setJSON($response);
    }
}
