<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PuskesmasModel;

class Puskesmas extends BaseController
{

	protected $puskesmasModel;
	protected $validation;

	public function __construct()
	{
		$this->puskesmasModel = new PuskesmasModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'puskesmas',
			'title'     		=> 'Puskesmas'
		];

		return view('puskesmas', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->puskesmasModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_puskesmas . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_puskesmas . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nama_puskesmas,
				$value->kecamatan,
				$value->notelp,
				$value->deskripsi,
				$value->Latitude,
				$value->longitude,
				'<img src="' . base_url('/img/puskesmas/' . $value->gambar) . '" alt="' . $value->gambar . '" style="width:120px">',
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

		$id = $this->request->getPost('id_puskesmas');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->puskesmasModel->where('id_puskesmas', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_puskesmas'] = $this->request->getPost('id_puskesmas');
		$fields['nama_puskesmas'] = $this->request->getPost('nama_puskesmas');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['notelp'] = $this->request->getPost('notelp');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$gambar = $this->request->getFile('gambar');
		$fields['created_at'] = date('Y-m-d H:i:s');

		$this->validation->setRules([
			'nama_puskesmas' => ['label' => 'Nama puskesmas', 'rules' => 'required'],
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

				$fileName = 'puskesmas-' . $gambar->getRandomName();
				$fields['gambar'] = $fileName;
				$gambar->move(WRITEPATH . '../public/img/puskesmas', $fileName);
			}

			if ($this->puskesmasModel->insert($fields)) {

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

		$fields['id_puskesmas'] = $this->request->getPost('id_puskesmas');
		$fields['nama_puskesmas'] = $this->request->getPost('nama_puskesmas');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['notelp'] = $this->request->getPost('notelp');
		$fields['deskripsi'] = $this->request->getPost('deskripsi');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$gambar = $this->request->getFile('gambar');
		$fields['updated_at'] =  date('Y-m-d H:i:s');

		$data = $this->puskesmasModel->select()->where('id_puskesmas', $fields['id_puskesmas'])->first();

		$this->validation->setRules([
			'nama_puskesmas' => ['label' => 'Nama puskesmas', 'rules' => 'required'],
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
				if (file_exists('img/puskesmas/' . $data->gambar)) {
					unlink('img/puskesmas/' . $data->gambar);
				}
				$fileName = 'puskesmas-' . $gambar->getRandomName();
				$fields['gambar'] = $fileName;
				$gambar->move(WRITEPATH . '../public/img/puskesmas', $fileName);
			}
			if ($this->puskesmasModel->update($fields['id_puskesmas'], $fields)) {

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

		$id = $this->request->getPost('id_puskesmas');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->puskesmasModel->where('id_puskesmas', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Berhasil menghapus data");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Gagal menghapus data");
			}
		}

		return $this->response->setJSON($response);
	}
}
