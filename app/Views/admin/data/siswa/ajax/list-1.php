<table class="table table-striped">
    <tr>
        <th></th>
        <th>Nama</th>
        <th>NIS/NISN</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th></th>
    </tr>
    <?php
        $no = 0 + $offset;
        $index = 0;
        foreach ($data as $siswa) {
            $index++;
            $kelas = $kelasModel->find($siswa['kelas_id']);
            $jurusan = $jurusanModel->find($siswa['jurusan_id']);
            $no++;
    ?>
        <tr>
            <td style="vertical-align: middle;"><?=$no?></td>
            <td class="d-flex align-items-center">
                <div class="rounded-circle content-edit-foto_diri <?=(($siswa['foto_diri'] == '') ? 'bg-light justify-content-center d-flex align-items-center' : '')?>" data-nis="<?=$siswa['nis']?>" style="overflow: hidden; height: 56px; width: 56px; cursor: pointer">
                    <?php if ($siswa['foto_diri'] != '') : ?>
                        <img src="<?=(($siswa['foto_diri'] != '') ? site_url('/images/siswa/'. $siswa['foto_diri']) : '')?>" class="foto-profil">
                    <?php else : ?>
                        <i class="fas fa-question text-xl"></i>
                    <?php endif;?>
                </div>
                <div class="font-weight-bold pl-2">
                    <h4 class="mb-0">
                        <?=$siswa['nama_lengkap']?>
                        <?php if ($siswa['jenis_kelamin'] == 'L') : ?>
                            <i class="ml-1 fas fa-venus" style="color: blue"></i>
                        <?php else :?>
                            <i class="ml-1 fas fa-mars" style="color: #ec0fe6"></i>
                        <?php endif;?>
                    </h4>
                    <?php if ($siswa['tanggal_lahir'] != '') :?>
                    <span class="text-muted font-italic">
                        <?=$siswa['tempat_lahir']?>, 
                        <?=date('d', strtotime($siswa['tanggal_lahir']))?> 
                        <?=$bulan[date('n', strtotime($siswa['tanggal_lahir'])) - 1]?> 
                        <?=date('Y', strtotime($siswa['tanggal_lahir']))?>
                    </span>
                    <?php endif;?>
                </div>
            </td>
            <td style="vertical-align: middle;" class="text-center"><strong><?=$siswa['nis']?><br/><?=$siswa['nisn']?></strong></td>
            <td style="vertical-align: middle;"><strong><?=$kelas['nama']?></strong></td>
            <td style="vertical-align: middle;"><strong><?=$jurusan['nama']?></strong></td>
            <td class="text-center">
                <a href="#" data-nis='<?=$siswa['nis']?>' class="m-0 mb-1 btn content-edit btn-secondary btn-sm rounded-circle">
                    <i class="fas fa-pencil-alt"></i>
                </a><br/>
                <a href="#" data-nis='<?=$siswa['nis']?>' class="m-0 mb-1 btn content-delete btn-danger btn-sm rounded-circle">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>  
    <?php
        }
        if ($index == 0) {
    ?>
    <tr>
        <td colspan="12" class="text-center">
            <h4>Ups.! <br/>Tidak ada data ditemukan</h4>
        </td>
    </tr>
    <?php
        }
    ?>
</table>
