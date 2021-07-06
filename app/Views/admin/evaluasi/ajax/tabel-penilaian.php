<?php
$data_evaluasi_kelas = $rEvaluasiKelasModel
    ->whereIn('id', $evaluasi_kelas_id)
    ->orderBy('id', 'desc')
    ->findAll();
$kelas_id = -1;
?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Peserta</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>JK</th>
            <?php
            foreach ($data_evaluasi_kelas as $evaluasi_kelas) {
                $kelas_id = $evaluasi_kelas['kelas_id'];
                $mata_pelajaran = $mataPelajaranModel->find($evaluasi_kelas['mata_pelajaran_id']);
                ?>
                <th><?= $mata_pelajaran['nama'] ?></th>
            <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
            $data_anggota_kelas = $rAnggotaKelasModel
                ->join('siswa', 'r_anggota_kelas.siswa_nis = siswa.nis')
                ->where('kelas_id', $kelas_id)
                ->orderBy('nama_lengkap', 'asc')
                ->findAll();
            
            
            $no = 0;
            foreach ($data_anggota_kelas as $anggota_kelas) {
                $no++;
                $peserta_evaluasi = $rPesertaEvaluasiModel->where('anggota_kelas_id', $anggota_kelas['id'])->first()
        ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $peserta_evaluasi['nomor_peserta'] ?></td>
                <td><?= $anggota_kelas['nis'] ?></td>
                <td><?= $anggota_kelas['nama_lengkap'] ?></td>
                <td><?= $anggota_kelas['jenis_kelamin'] ?></td>
                <?php
                    foreach ($data_evaluasi_kelas as $evaluasi_kelas) {
                        $peserta_evaluasi = $rPesertaEvaluasiModel
                            ->where('anggota_kelas_id', $anggota_kelas['id'])
                            ->where('evaluasi_kelas_id', $evaluasi_kelas['id'])
                            ->first();
                        $penilaian = $penilaianModel
                            ->where('siswa_id', $peserta_evaluasi['id'])
                            ->first();
                ?>
                    <th><?= $penilaian['nilai'] ?></th>
                <?php
                    }
                ?>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>