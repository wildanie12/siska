<?php
namespace App\Models;

use CodeIgniter\Model;

class RAnggotaKelasModel extends Model
{

    protected $table = "r_anggota_kelas";
    protected $primaryKey = "id";

    protected $returnType = "array";

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        "siswa_nis",
        "kelas_id"
    ];
}
