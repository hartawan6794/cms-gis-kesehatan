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
        $data = $this->request->getJSON();

        $db = \Config\Database::connect();

        $email = $data->email;
        $password = $data->password;

        $result = $this->user->select('tbl_user.*, tud.nama_lengkap,tud.img_user')->join('tbl_user_detail tud','tbl_user.id_user = tud.id_user_detail')->where('email_user', $email)->orWhere('username', $email)->find();

        if ($result) {
            if (password_verify($password, $result[0]->password)) {
                // var_dump
                $response = [
                    'status'    => true,
                    'message'   => 'Berhasil Mendapatkan Data',
                    'result'     => $result
                ];
            } else {
                $response = [
                    'status'    => false,
                    'message'   => 'Password salah',
                    'result'      => []
                ];
            }
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Gagal Mendapatkan Data',
                'result'      => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function getUser()
    {
        $data = $this->request->getJSON();
        $id_user = $data->id_user_detail;

        // $id_user = $this->request->getPost('id_user');
        $data = $this->userDetail->where('id_user_detail', $id_user)->find();
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

    public function register()
    {
        $response = array();
        $db = \Config\Database::connect();

        $data = $this->request->getJSON();
        $nama_lengkap = $data->userDetailModel->nama_lengkap;
        $email = $data->userModel->email_user;
        $username = $data->userModel->username;
        $password = $data->userModel->password;
        $device_id = $data->userModel->device_id;

        $userFields['nama_lengkap'] = $nama_lengkap;

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
                    'email_user'  => $email,
                    'username'    => $username,
                    'device_id'   => $device_id
                ],
            );
            $token = JWT::encode($payload, $key, 'HS256');

            $user = [
                'email_user'    => $email,
                'username'      => $username,
                'password'      => password_hash($password, PASSWORD_BCRYPT),
                'device_id'   => $device_id,
                'bearer_token'   => $token
            ];


            if ($this->user->insert($user)) {

                $id_user = $this->user->insertID();
                $userFields['id_user_detail'] = $id_user;
                if ($this->userDetail->insert($userFields)) {

                    $response['status'] = true;
                    $response['message'] = lang("Berhasil menambahkan data");
                } else {

                    $response['status'] = false;
                    $response['message'] = lang("Gagal menambahkan data user detail");
                }
            } else {

                $response['status'] = false;
                $response['message'] = $this->user->errors;
            }
            $db->transCommit();
        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = lang("Gagal menambahkan data");
            // Rollback the transaction if any insert fails
            $db->transRollback();
        }
        return $this->response->setJSON($response);
    }

    public function checkEmail()
    {
        $data = $this->request->getJSON();

        $db = \Config\Database::connect();

        $email = $data->email;

        $result = $this->user->where('email_user', $email)->find();

        if ($result) {
            $response = [
                'status'    => true,
                'message'   => 'Email terdaftar',
                'result'    => $result
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Email tidak terdaftar',
                'result'    => []
            ];
        }

        return $this->response->setJSON($response);
    }

    public function passwordReset()
    {
        $response = array();
        $db = \Config\Database::connect();
        $data = $this->request->getJSON();
        // $password = $this->request->getPost('password');
        // $field['email_user'] = $this->request->getPost('email');
        $password = $data->password;
        $field['id_user'] = $data->id_user;

        // var_dump($field);die;

        $db->transBegin();

        try {
           
            $value = [
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ];

            if ($this->user->update($field, $value)) {
                $response['status'] = true;
                $response['message'] = lang("Berhasil mengubah password");
            } else {
                $response['status'] = false;
                $response['message'] = lang("Gagal mengubah password");
            }
            $db->transCommit();
        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = lang("Gagal mengubah password");
            // Rollback the transaction if any insert fails
            $db->transRollback();
        }
        return $this->response->setJSON($response);
    }
}
