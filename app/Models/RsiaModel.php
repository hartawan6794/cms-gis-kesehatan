<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class RsiaModel extends Model {
    
	protected $table = 'tbl_rumah_sakit_ibu_anak';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama', 'kecamatan', 'deskripsi', 'Latitude', 'longitude', 'gambar', 'is_jadwal', 'created_at', 'updated_at','notelp'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}