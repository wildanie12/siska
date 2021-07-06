<?php 
namespace App\Models;

use CodeIgniter\Model;

Class RPesertaEvaluasiModel extends Model {

    protected $table = "r_peserta_evaluasi";
    protected $primaryKey = "id";

    protected $returnType = "array";
    
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        "nomor_peserta", 
        "anggota_kelas_id", 
        "evaluasi_kelas_id",
    ];
}
?>