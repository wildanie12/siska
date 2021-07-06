<?php 
namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model {
    
    protected $table = "jurusan";
    protected $primaryKey = "id";

    protected $returnType = "array";
    
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ["nama", "deskripsi"];
}
