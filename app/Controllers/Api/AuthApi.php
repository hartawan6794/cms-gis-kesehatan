<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TbluserModel;
use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;

class AuthApi extends BaseController
{
    protected $user;
    protected $privateKey;
    protected $userDetail;
    function __construct()
    {
        $this->user = new TbluserModel();
        $this->userDetail = new UserModel();

        $this->privateKey = Services::privateKey()['keyServer'];
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = $this->user->where('email_user', $email)->orWhere('username', $email)->first();

        if ($data) {
            if (password_verify($password, $data->password)) {


                // var_dump
                $response = [
                    'status'    => true,
                    'message'   => 'Berhasil Mendapatkan Data',
                    'data'      => $data
                ];
            } else {
                $response = [
                    'status'    => false,
                    'message'   => 'Password salah',
                    'data'      => []
                ];
            }
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Gagal Mendapatkan Data',
                'data'      => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function getUser()
    {
        $email = $this->request->getPost('email');
        $data = $this->user->where('email_user', $email)->orWhere('username', $email)->first();
        if ($data) {
            $response = [
                'status'    => true,
                'message'   => 'Berhasil Mendapatkan Data',
                'data'      => $data,
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Gagal Mendapatkan Data',
                'data'      => []
            ];
        }

        return $this->response->setJSON($response);
    }


    public function register()
    {
        $response = array();
        $db = \Config\Database::connect();

        $fields['id_user_detail'] = $this->request->getPost('id_user_detail');
        $fields['nik'] = $this->request->getPost('nik');
        $fields['nama_lengkap'] = $this->request->getPost('nama_lengkap');
        $fields['tgl_lahir'] = $this->request->getPost('tgl_lahir');
        $fields['tmp_lahir'] = $this->request->getPost('tmp_lahir');
        $fields['jns_kelamin'] = $this->request->getPost('jns_kelamin');
        // $img_user = $this->request->getFile('img_user');
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

        $db->transBegin();

        try {

            $key = $this->privateKey;
            $iat = time(); // current timestamp value
            $payload = array(
                "iss" => "GisKesehatan",
                "aud" => "GisKesehatan",
                "sub" => "GisKesehatan",
                "iat" => $iat, //Time the JWT issued at
                "data" => [
                    'email_user'  => $fields['email'],
                    'username'    => $fields['username'],
                ],
            );
            $token = JWT::encode($payload, $key, 'HS256');

            // var_dump($token)
            $user = [
                'email_user'    => $fields['email'],
                'username'      => $fields['username'],
                'password'      => password_hash($fields['password'], PASSWORD_BCRYPT),
                'bearer_token'   => $token
            ];


            if ($this->user->insert($user)) {

                $id_user = $this->user->insertID();
                $userFields['id_user_detail'] = $id_user;
                if ($this->userDetail->insert($userFields)) {

                    $response['success'] = true;
                    $response['messages'] = lang("Berhasil menambahkan data");
                } else {

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

        return $this->response->setJSON($response);
    }
}
