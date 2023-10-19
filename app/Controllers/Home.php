<?php

namespace App\Controllers;

use App\Models\KlinikModel;
use App\Models\PuskesmasModel;
use App\Models\RsiaModel;
use App\Models\RumahsakitModel;

class Home extends BaseController
{
	protected $klinikModel;
	protected $rsiaModel;
	protected $rumahsakitModel;
	protected $puskesmasModel;

	public function __construct()
	{

		$this->db = db_connect();
		$this->puskesmasModel = new PuskesmasModel();
		$this->rumahsakitModel = new RumahsakitModel();
		$this->rsiaModel = new RsiaModel();
		$this->klinikModel = new KlinikModel();
	}

	public function index()
	{
		$data = [
			'controller'    	=> 'home',
			'title'     		=> 'Dashboard',
			'puskesmas'			=> $this->puskesmasModel->countAllResults(),
			'rumahsakit'		=> $this->rumahsakitModel->countAllResults(),
			'rsia'				=> $this->rsiaModel->countAllResults(),
			'klinik'			=> $this->klinikModel->countAllResults(),
		];

		// var_dump($data);die;

		return view('dashboard', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$sql = "SELECT * FROM (SELECT * FROM tbl_klinik
		UNION ALL
		SELECT * FROM tbl_puskesmas
		UNION ALL
		SELECT * FROM tbl_rumah_sakit
		UNION ALL
		SELECT * FROM tbl_rumah_sakit_ibu_anak) z order by created_at DESC";
		$query = $this->db->query($sql)->getResult();
		// var_dump($query);
		$no = 1;
		foreach ($query as $key => $value) {
			$pattern = "/^([^-\s]+)-/";

			preg_match($pattern, $value->gambar, $matches);

			if (!empty($matches[1]))
				$result = $matches[1];
			$data['data'][$key] = array(
				$no,
				$value->nama,
				$value->kecamatan,
				$value->notelp,
				$value->deskripsi,
				$value->Latitude,
				$value->longitude,
				'<img src="' . base_url('/img/' . $result . '/' . $value->gambar) . '" alt="' . $value->gambar . '" style="width:120px">',
				$value->created_at,
				$value->updated_at,
			);

			$no++;
		}

		return $this->response->setJSON($data);
	}
}
