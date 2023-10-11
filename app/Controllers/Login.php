<?php

namespace App\Controllers;

use App\Models\TbluserModel;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $user;
    protected $session;
    protected $userDetail;

    public function __construct()
    {
        $this->user = new TbluserModel();
        $this->userDetail = new UserModel();
        $this->session = \Config\Services::session();
    }


    public function index()
    {

        $data = [
            'title' => 'Form Login',
            'controller' => 'login'
        ];

        return view('login', $data);
    }

    public function login()
    {

        $response = array();

        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('password');

        $data = $this->user->where('email_user', $email)->orWhere('username',$email)->first();
        // var_dump($data);die;
        if ($data) {
            if ((password_verify($pass, $data->password))) {
                $user = $this->userDetail->where('id_user_detail',$data->id_user)->first();
                $session = [
                    'isLogin' => true,
                    'id_user' => $data->id_user,
                    'nama_lengkap' => $user->nama_lengkap,
                    'gambar' => $user->img_user,
                ];
                $this->session->set($session);
                $response['success'] = true;
                $response['message'] = "Berhasil login";
            } else {
                $response['success'] = false;
                $response['message'] = "Kata sandi salah";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Email tidak terdaftar";
        }

        return $this->response->setJSON($response);
    }

    function logout(){
        $this->session->destroy();
        return redirect()->to('login');
    }
}
