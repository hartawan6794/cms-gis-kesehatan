<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TbluserModel;
use App\Models\UserModel;

class User extends BaseController
{

	protected $userModel;
	protected $user;
	protected $validation;

	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->user = new TbluserModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> 'user',
			'title'     		=> 'Pengguna'
		];

		return view('user', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->userModel->select()->join('tbl_user tu', 'tu.id_user = tbl_user_detail.id_user_detail')->findAll();

		$no = 1;

		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_user_detail . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Ubah")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_user_detail . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Hapus")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$no,
				$value->email_user,
				$value->username,
				$value->nik,
				$value->nama_lengkap,
				$value->tgl_lahir,
				$value->tmp_lahir,
				$value->jns_kelamin,
				'<img src="' . base_url('/img/user/' . $value->img_user) . '" alt="' . $value->img_user . '" style="width:120px">',
				// $value->img_user,
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

		$id = $this->request->getPost('id_user_detail');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->userModel->join('tbl_user tu','tu.id_user = tbl_user_detail.id_user_detail')->where('id_user_detail', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();
		$db = \Config\Database::connect();

		$fields['id_user_detail'] = $this->request->getPost('id_user_detail');
		$fields['nik'] = $this->request->getPost('nik');
		$fields['nama_lengkap'] = $this->request->getPost('nama_lengkap');
		$fields['tgl_lahir'] = $this->request->getPost('tgl_lahir');
		$fields['tmp_lahir'] = $this->request->getPost('tmp_lahir');
		$fields['jns_kelamin'] = $this->request->getPost('jns_kelamin');
		$img_user = $this->request->getFile('img_user');
		$fields['email'] = $this->request->getPost('email');
		$fields['username'] = $this->request->getPost('username');
		$fields['password'] = $this->request->getPost('password');
		$fields['confpassword'] = $this->request->getPost('confpassword');

		$userFields['nik'] = $fields['nik'];
		$userFields['nama_lengkap'] = $fields['nama_lengkap'];
		$userFields['tgl_lahir'] = $fields['tgl_lahir'];
		$userFields['tmp_lahir'] = $fields['tmp_lahir'];
		$userFields['jns_kelamin'] = $fields['jns_kelamin'];
		$userFields['created_at'] = date('Y-m-d H:i:s');

		$user = [
			'email_user' => $fields['email'],
			'username' => $fields['username'],
			'password' => password_hash($fields['password'], PASSWORD_BCRYPT)
		];

		$this->validation->setRules([
			'nik' => ['label' => 'Nik', 'rules' => 'permit_empty|min_length[0]|max_length[16]'],
			'nama_lengkap' => ['label' => 'Nama lengkap', 'rules' => 'required'],
			'password' => ['label' => 'Password', 'rules' => 'required'],
			'confpassword' => ['label' => 'Password', 'rules' => 'required|matches[password]', 'errors' => ['matches' => 'Kata sandi tidak sama']],
			'tgl_lahir' => ['label' => 'Tanggal Lahir', 'rules' => 'permit_empty'],
			'tmp_lahir' => ['label' => 'Tempat Lahir', 'rules' => 'permit_empty'],
			'jns_kelamin' => ['label' => 'Gender', 'rules' => 'permit_empty'],
			'img_user' => [
				'label' => 'Gambar',
				'rules' => 'uploaded[img_user]|is_image[img_user]|mime_in[img_user,image/jpg,image/jpeg,image/png]|max_size[img_user,1024]',
				'errors' => [
					'max_size' => 'Ukuran file harus maksimal 1Mb',
					'mime_in' => 'Harap masukkan file berupa gambar (jpg, jpeg, png)',
					'is_image' => 'Harap masukkan file berupa gambar'
				]
			],
			'email' => ['label' => 'Email', 'rules' => 'trim|required|valid_email'],
			'username' => ['label' => 'Username', 'rules' => 'required|trim'],
		]);

		// var_dump($this->validation->run($fields));die;



		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			$db->transBegin();

			try {


				if ($this->user->insert($user)) {

					$id_user = $this->user->insertID();
					$userFields['id_user_detail'] = $id_user;
					if ($img_user->getName() != '') {

						$fileName = 'user-' . $img_user->getRandomName();
						$userFields['img_user'] = $fileName;
						$img_user->move(WRITEPATH . '../public/img/user', $fileName);
					}
					if ($this->userModel->insert($userFields)) {

						$response['success'] = true;
						$response['messages'] = lang("Berhasil menambahkan data");
					}else {

						$response['success'] = false;
						$response['messages'] = lang("Gagal menambahkan data");
					}
				} else {

					$response['success'] = false;
					$response['messages'] = lang("Gagal menambahkan data");
				}
				$db->transCommit();
			} catch (\Exception $e) {
				$response['success'] = false;
				$response['messages'] = lang("Gagal menambahkan data");
				// Rollback the transaction if any insert fails
				$db->transRollback();
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id_user_detail'] = $this->request->getPost('id_user_detail');
		$fields['nik'] = $this->request->getPost('nik');
		$fields['nama_lengkap'] = $this->request->getPost('nama_lengkap');
		$fields['tgl_lahir'] = $this->request->getPost('tgl_lahir');
		$fields['tmp_lahir'] = $this->request->getPost('tmp_lahir');
		$fields['jns_kelamin'] = $this->request->getPost('jns_kelamin');
		$fields['img_user'] = $this->request->getPost('img_user');
		$fields['created_at'] = $this->request->getPost('created_at');
		$fields['updated_at'] = $this->request->getPost('updated_at');


		$this->validation->setRules([
			'nik' => ['label' => 'Nik', 'rules' => 'permit_empty|min_length[0]|max_length[20]'],
			'nama_lengkap' => ['label' => 'Nama lengkap', 'rules' => 'required|min_length[0]|max_length[255]'],
			'tgl_lahir' => ['label' => 'Tanggal Lahir', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'tmp_lahir' => ['label' => 'Tempat Lahir', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'jns_kelamin' => ['label' => 'Gender', 'rules' => 'permit_empty|min_length[0]|max_length[50]'],
			'img_user' => ['label' => 'Gambar', 'rules' => 'permit_empty|min_length[0]|max_length[255]'],
			'created_at' => ['label' => 'Dibuat', 'rules' => 'permit_empty|valid_date|min_length[0]'],
			'updated_at' => ['label' => 'Diubah', 'rules' => 'permit_empty|valid_date|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->userModel->update($fields['id_user_detail'], $fields)) {

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

		$id = $this->request->getPost('id_user_detail');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->userModel->where('id_user_detail', $id)->delete()) {

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
