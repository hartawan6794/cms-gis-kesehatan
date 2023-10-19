<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\KlinikModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Klinik extends BaseController
{

	protected $klinikModel;
	protected $validation;

	public function __construct()
	{
		$this->klinikModel = new KlinikModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'klinik',
			'title'     		=> 'Klinik'
		];

		return view('klinik', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->klinikModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nama,
				$value->kecamatan,
				$value->notelp,
				$value->deskripsi,
				$value->Latitude,
				$value->longitude,
				'<img src="' . base_url('/img/klinik/' . $value->gambar) . '" alt="' . $value->gambar . '" style="width:120px">',
				// $value->is_jadwal,
				$value->created_at,
				$value->updated_at,

				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->klinikModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		// $fields['id'] = $this->request->getPost('id');
		$fields['nama'] = $this->request->getPost('nama');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$fields['notelp'] = $this->request->getPost('notelp');
		$gambar = $this->request->getFile('gambar');
		$fields['created_at'] = date('Y-m-d H:i:s');
		// $fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama' => ['label' => 'Nama klinik', 'rules' => 'required'],
			'kecamatan' => ['label' => 'Kecamatan', 'rules' => 'required'],
			'notelp' => ['label' => 'Notelp', 'rules' => 'required'],
			'Latitude' => ['label' => 'Latitude', 'rules' => 'required'],
			'longitude' => ['label' => 'Longitude', 'rules' => 'required'],
			'gambar' => [
				'label' => 'Gambar',
				'rules' => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
				'errors' => [
					'max_size' => 'Ukuran file harus maksimal 1Mb',
					'mime_in' => 'Harap masukkan file berupa gambar (jpg, jpeg, png)',
					'is_image' => 'Harap masukkan file berupa gambar'
				]
			],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($gambar->getName() != '') {

				$fileName = 'klinik-' . $gambar->getRandomName();
				$fields['gambar'] = $fileName;
				$gambar->move(WRITEPATH . '../public/img/klinik', $fileName);
			}

			// var_dump($fields);die;

			if ($this->klinikModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menambahkan data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menambahkan data");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama'] = $this->request->getPost('nama');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$fields['notelp'] = $this->request->getPost('notelp');
		$gambar = $this->request->getFile('gambar');
		$fields['updated_at'] =  date('Y-m-d H:i:s');

		$data = $this->klinikModel->select()->where('id', $fields['id'])->first();

		$this->validation->setRules([
			'nama' => ['label' => 'Nama klinik', 'rules' => 'required'],
			'kecamatan' => ['label' => 'Kecamatan', 'rules' => 'required'],
			'notelp' => ['label' => 'Notelp', 'rules' => 'required'],
			'Latitude' => ['label' => 'Latitude', 'rules' => 'required'],
			'longitude' => ['label' => 'Longitude', 'rules' => 'required'],
			'gambar' => [
				'label' => 'Gambar',
				'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
				'errors' => [
					'max_size' => 'Ukuran file harus maksimal 1Mb',
					'mime_in' => 'Harap masukkan file berupa gambar (jpg, jpeg, png)',
					'is_image' => 'Harap masukkan file berupa gambar'
				]
			],
		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($gambar->getName() != '') {

				//ketika file ada, menghapus file lama
				if (file_exists('img/klinik/' . $data->gambar)) {
					unlink('img/klinik/' . $data->gambar);
				}
				$fileName = 'klinik-' . $gambar->getRandomName();
				$fields['gambar'] = $fileName;
				$gambar->move(WRITEPATH . '../public/img/klinik', $fileName);
			}

			if ($this->klinikModel->update($fields['id'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil perbarui data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal Perbarui data");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id');

		$data = $this->klinikModel->where('id',$id)->first();

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			//ketika file ada, menghapus file lama
			if ($data->gambar) {
				unlink('img/klinik/' . $data->gambar);
			}
			if ($this->klinikModel->where('id', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menghapus data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menghapus data");
			}
		}

		return $this->response->setJSON($response);
	}


	public function import()
	{ // Ambil file Excel dari form unggahan
		$file = $this->request->getFile('excel');
		var_dump($file);
		die;

		if ($file->isValid() && !$file->hasMoved()) {
			// Load file Excel
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

			$spreadsheet = $render->load($spreadsheet);
			// Ambil data dari lembar kerja pertama (Sheet)
			// $worksheet = $spreadsheet->getActiveSheet();
			$data = $spreadsheet->getActiveSheet()->toArray();

			// Lakukan sesuatu dengan data yang diimpor
			foreach ($data as $row) {
				// Lakukan sesuatu dengan setiap baris data
				print_r($row); // contoh: tampilkan data ke layar
			}
		} else {
			// Kesalahan unggah file Excel
			echo 'Terjadi kesalahan saat mengunggah file Excel.';
		}
	}
}
