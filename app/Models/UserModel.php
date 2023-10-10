<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    
	protected $table = 'tbl_user_detail';
	protected $primaryKey = 'id_user_detail';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nik', 'nama_lengkap', 'tgl_lahir', 'tmp_lahir', 'jns_kelamin', 'img_user', 'created_at', 'updated_at'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}