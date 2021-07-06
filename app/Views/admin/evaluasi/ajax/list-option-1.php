<?php 
    foreach ($data as $evaluasi) {
        $kelas = $kelasModel->find($evaluasi['kelas_id']);
        $mata_pelajaran = $mataPelajaranModel->find($evaluasi['mata_pelajaran_id']);
?>
<option value="<?=$evaluasi['id']?>"><?=$mata_pelajaran['nama'] . ' - ' . $kelas['nama'] . ' - ' . $evaluasi['nama']?></option>
<?php 
    }
?>