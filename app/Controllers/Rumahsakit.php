<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\RumahsakitModel;

class Rumahsakit extends BaseController
{

	protected $rumahsakitModel;
	protected $validation;

	public function __construct()
	{
		$this->rumahsakitModel = new RumahsakitModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'rumahsakit',
			'title'     		=> 'Rumah Sakit'
		];

		return view('rumahsakit', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->rumahsakitModel->select()->findAll();
		$no = 1;

		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_rs . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_rs . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("App.delete")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nama_rs,
				$value->kecamatan,
				$value->Latitude,
				$value->longitude,
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

		$id = $this->request->getPost('id_rs');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->rumahsakitModel->where('id_rs', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_rs'] = $this->request->getPost('id_rs');
		$fields['nama_rs'] = $this->request->getPost('nama_rs');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama_rs' => ['label' => 'Nama rs', 'rules' => 'required|min_length[0]|max_length[255]'],
			'kecamatan' => ['label' => 'Kecamatan', 'rules' => 'required|min_length[0]|max_length[255]'],
			'Latitude' => ['label' => 'Latitude', 'rules' => 'required|min_length[0]|max_length[255]'],
			'longitude' => ['label' => 'Longitude', 'rules' => 'required|min_length[0]|max_length[255]'],
			'created_at' => ['label' => 'Dibuat', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Diubah', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->rumahsakitModel->insert($fields)) {

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

		$fields['id_rs'] = $this->request->getPost('id_rs');
		$fields['nama_rs'] = $this->request->getPost('nama_rs');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama_rs' => ['label' => 'Nama rs', 'rules' => 'required|min_length[0]|max_length[255]'],
			'kecamatan' => ['label' => 'Kecamatan', 'rules' => 'required|min_length[0]|max_length[255]'],
			'Latitude' => ['label' => 'Latitude', 'rules' => 'required|min_length[0]|max_length[255]'],
			'longitude' => ['label' => 'Longitude', 'rules' => 'required|min_length[0]|max_length[255]'],
			'created_at' => ['label' => 'Dibuat', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Diubah', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->rumahsakitModel->update($fields['id_rs'], $fields)) {

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

		$id = $this->request->getPost('id_rs');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->rumahsakitModel->where('id_rs', $id)->delete()) {

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
