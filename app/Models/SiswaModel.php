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
        "nisn",
        "nama_lengkap",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "jurusan_id",
        "tahun_masuk",
        "asal_sekolah",
        "foto_diri",
        "nama_ayah",
        "nama_ibu",
        "nama_wali"
    ];
}
