<?php 
namespace App\Models;

use CodeIgniter\Model;

class REvaluasiKelasModel extends Model
{
    protected $table = "r_evaluasi_kelas";
    protected $primaryKey = "id";

    protected $returnType = "array";
    
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        "kelas_id",
        "mata_pelajaran_id",
        "evaluasi_id",
        "tanggal_mulai",
        "tanggal_selesai"
    ];
}

?>