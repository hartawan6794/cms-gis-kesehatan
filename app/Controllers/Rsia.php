<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\RsiaModel;

class Rsia extends BaseController
{

	protected $rsiaModel;
	protected $validation;

	public function __construct()
	{
		$this->rsiaModel = new RsiaModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'rsia',
			'title'     		=> 'Rumah Sakit Ibu dan Anak'
		];

		return view('rsia', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->rsiaModel->select()->findAll();

		$no = 1;

		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_rsia . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_rsia . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("App.delete")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->nama_rsia,
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

		$id = $this->request->getPost('id_rsia');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->rsiaModel->where('id_rsia', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id_rsia'] = $this->request->getPost('id_rsia');
		$fields['nama_rsia'] = $this->request->getPost('nama_rsia');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama_rsia' => ['label' => 'Nama rsia', 'rules' => 'required|min_length[0]|max_length[255]'],
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

			if ($this->rsiaModel->insert($fields)) {

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

		$fields['id_rsia'] = $this->request->getPost('id_rsia');
		$fields['nama_rsia'] = $this->request->getPost('nama_rsia');
		$fields['kecamatan'] = $this->request->getPost('kecamatan');
		$fields['Latitude'] = $this->request->getPost('Latitude');
		$fields['longitude'] = $this->request->getPost('longitude');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nama_rsia' => ['label' => 'Nama rsia', 'rules' => 'required|min_length[0]|max_length[255]'],
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

			if ($this->rsiaModel->update($fields['id_rsia'], $fields)) {

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

		$id = $this->request->getPost('id_rsia');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->rsiaModel->where('id_rsia', $id)->delete()) {

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
