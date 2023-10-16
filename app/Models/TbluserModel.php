<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class TbluserModel extends Model {
    
	protected $table = 'tbl_user';
	protected $primaryKey = 'id_user';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['email_user', 'username', 'password', 'device_id', 'status','bearer_token'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}