<?php 
namespace App\Models;

use CodeIgniter\Model;

class EvaluasiModel extends Model 
{
    protected $table = 'evaluasi';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;

    protected $allowedFields = ["nama", "deskripsi", "tanggal_mulai", "tanggal_selesai"];

}
?>