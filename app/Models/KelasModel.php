<?php 
namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model {
    
    protected $table = "kelas";
    protected $primaryKey = "id";

    protected $returnType = "array";
    
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        "nama",
        "jurusan_id",
        "ketua_kelas_nis",
        "wali_kelas",
        "tahun_pelajaran"
    ];
}
