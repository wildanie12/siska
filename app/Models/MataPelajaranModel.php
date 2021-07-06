<?php 
namespace App\Models;

use CodeIgniter\Model;

class MataPelajaranModel extends Model {
    
    protected $table = "mata_pelajaran";
    protected $primaryKey = "id";

    protected $returnType = "array";
    
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ["nama", "jurusan_id", "deskripsi"];
}
?>