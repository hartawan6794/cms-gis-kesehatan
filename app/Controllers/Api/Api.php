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

        $data = $this->request->getJSON();

        $latitude = $data->latitude;
        $longitude = $data->longitude;

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
        8";

        $data = $this->db->query($sql)->getResult();

        $value = array();
        foreach ($data as $row) {
            $distance = round($this->haversineDistance($latitude, $longitude, $row->latitude, $row->longitude), 1);
            array_push($value, array(
                'id'         => $row->id,
                'table'      => $row->tabel,
                'nama'       => $row->nama,
                'kecamatan'  => $row->kecamatan,
                'deskripsi'  => $row->deskripsi,
                'latitude'   => $row->latitude,
                'longitude'  => $row->longitude,
                'gambar'     => $row->gambar,
                'notelp'     => $row->notelp,
                'distance'   => $distance,
            ));
        }

        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'result'      => $value,
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
        $latitude = $data->latitude;
        $longitude = $data->longitude;

        $sql = "SELECT * FROM $table";

        $data = $this->db->query($sql)->getResult();
        $value = array();
        foreach ($data as $row) {
            $distance = round($this->haversineDistance($latitude, $longitude, $row->Latitude, $row->longitude), 1);
            if ($distance <= 2.0) {
                array_push($value, array(
                    'id'         => $row->id,
                    'table'      => $table,
                    'nama'       => $row->nama,
                    'kecamatan'  => $row->kecamatan,
                    'deskripsi'  => $row->deskripsi,
                    'latitude'   => $row->Latitude,
                    'longitude'  => $row->longitude,
                    'gambar'     => $row->gambar,
                    'notelp'     => $row->notelp,
                    'distance'   => $distance,
                ));
            }
        }
        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'result'      => $value,
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

    public function searchLayananKesehatan()
    {
        $response = array();
        $db = \Config\Database::connect();
        $data = $this->request->getJSON();

        $table = $data->tabel;
        $nama = $data->nama;
        $latitude = $data->latitude;
        $longitude = $data->longitude;

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
        $value = array();
        foreach ($data as $row) {
            $distance = round($this->haversineDistance($latitude, $longitude, $row->latitude, $row->longitude), 1);
            array_push($value, array(
                'id'         => $row->id,
                'table'      => $table,
                'nama'       => $row->nama,
                'kecamatan'  => $row->kecamatan,
                'deskripsi'  => $row->deskripsi,
                'latitude'   => $row->latitude,
                'longitude'  => $row->longitude,
                'gambar'     => $row->gambar,
                'notelp'     => $row->notelp,
                'distance'   => $distance,
            ));
        }
        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'result'      => $value,
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

    function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $radius = 6371; // Radius Bumi dalam kilometer

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1) * cos($lat2) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c; // Jarak dalam kilometer
        return $distance;
    }
}
