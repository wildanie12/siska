<?php 
namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model {

    protected $table = "penilaian";
    protected $primaryKey = "id";
    
    protected $returnType = "array";

    protected $useSoftDeletes = false; 
    protected $useTimestamps = true;

    protected $allowedFields = ["nilai", "siswa_id", "mata_pelajaran_id", "evaluasi_kelas_id"];
}
?>