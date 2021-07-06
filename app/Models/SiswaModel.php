<?php
namespace App\Models;
use CodeIgniter\Model;

class SiswaModel extends Model
{

    protected $table = "siswa";
    protected $primaryKey = "nis";

    protected $returnType = "array";

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = [
        "nis",
        "nama_lengkap",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "jurusan_id",
        "tahun_masuk",
        "asal_sekolah",
        "nama_orangtua",
        "nama_wali"
    ];
}
