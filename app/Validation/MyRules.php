<?php

namespace App\Validation;

use App\Models\TbluserModel;
use App\Models\UserbiodataModel;

class MyRules
{

    public function userExist(string $str, string $fields, array $data)
    {
        $m = new TbluserModel();
        $d = $m->where('username', $data['username'])->first();
        if (!$d) {
            return true;
        }
        return false;
    }

    public function emailExist(string $str, string $fields, array $data)
    {
        $m = new TbluserModel();
        $d = $m->where('email_user', $data['email'])->first();
        if (!$d) {
            return true;
        }
        return false;
    }
}
