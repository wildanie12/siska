<?php $this->extend('template/admin'); ?>

<?php $this->section('content'); ?>
<!---------------------------------------------------------->
<!-----------   Filter / Penyaringan data      ------------->
<!---------------------------------------------------------->
<div class="alert alert-default alert-dismissible justify-content-between col-md-3 col-11 py-3 pl-3 pr-0 align-items-center" role="alert" style="position: fixed; right: 16px; top: 16px; z-index: 1050; display: none">
    <div class="text-left d-flex align-items-center">
        <div class="alert-icon"><i class="fas fa-thumbs-up"></i></div>
        <div class="alert-text mr-3"><?= session()->getFlashdata('admin_artikel_msg') ?></div>
    </div>
    <a href="javascript:void(0)" data-dismiss='alert' class="btn btn-link text-white">
        <i class="fas fa-times"></i>
    </a>
</div>
<?php
$sheetIndex = 0;
foreach ($excel as $worksheet) {
    $sheetIndex++;
    ?>
    <div class="header" style="z-index: 1050; background: #099543">
        <div class="container-fluid">
            <div class="row py-4 justify-content-between align-items-center">
                <div class="col d-flex justify-content-start align-items-center">
                    <i class="fas fa-file-excel text-white mr-4" style="font-size: 32pt;"></i>
                    <div style="line-height: 12px;" class="pb-2">
                        <h2 class="text-white text-uppercase mb-0 mt-0">Sheet <?= $sheetIndex ?></h2>
                        <div class="text-sm" style="color: #d4d4d4">Preview data penilaian yang terbaca</div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="row">
                        <div class="col d-flex align-items-center">

                            <div class="badge badge-info rounded-circle">
                                <i class="fas fa-asterisk"></i>
                            </div>
                            <div class="text-white mr-2 ml-2">=</div>
                            <div class="text-white font-weight-bold text-uppercase text-xs" style="line-height: 12px">
                                Belum terdaftar pada sistem <br />
                                <span style="font-size: 6pt; color: #d2d2d2">(Data akan didaftarkan secara otomatis)</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="text-center text-white font-weight-bold text-uppercase" style="font-size: 8pt">
                                Scroll kebawah lalu <br />
                                klik Kirim untuk mengkonfirmasi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body pt-3 pl-3 pr-3 pb-0">
                            <div class="row">
                                <div class="form-group col-sm pr-sm-1">
                                    <label class="form-control-label">Kelas</label>
                                    <div class="input-group-sm input-group input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                                        </div>
                                        <select class="form-control filter-kelas_id">
                                            <option value=""><?= $worksheet['kelas']['nama'] ?></option>
                                        </select>
                                        <?php if ($worksheet['kelas']['id'] == -1) : ?>
                                            <div class="badge badge-info rounded-circle" style="position: absolute; top: -9px; left: -9px;padding: 3px 4px">
                                                <i class="fas fa-asterisk" style="font-size: 6pt;position: relative;top: -1px;"></i>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group col-sm pr-sm-1 pl-sm-1">
                                    <label class="form-control-label">Mata Pelajaran</label>
                                    <div class="input-group input-group-merge input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                                        </div>
                                        <select class="form-control filter-mata_pelajaran_id">
                                            <option value=""><?= $worksheet['mata_pelajaran']['nama'] ?></option>
                                        </select>
                                        <?php if ($worksheet['mata_pelajaran']['id'] == -1) : ?>
                                            <div class="badge badge-info rounded-circle" style="position: absolute; top: -9px; left: -9px;padding: 3px 4px">
                                                <i class="fas fa-asterisk" style="font-size: 6pt;position: relative;top: -1px;"></i>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group col-sm pl-sm-1">
                                    <label class="form-control-label">Evaluasi</label>
                                    <div class="input-group-merge input-group input-group-sm flex-shrink">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-check"></i></span>
                                        </div>
                                        <select class="form-control filter-evaluasi_id">
                                            <option value=""><?= $worksheet['evaluasi']['nama'] ?></option>
                                        </select>
                                        <?php if ($worksheet['evaluasi']['id'] == -1) : ?>
                                            <div class="badge badge-info rounded-circle" style="position: absolute; top: -9px; left: -9px;padding: 3px 4px">
                                                <i class="fas fa-asterisk" style="font-size: 6pt;position: relative;top: -1px;"></i>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </div> <!-- end header -->

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px; padding: 1rem 9px">No</th>
                                    <th>Nomor Peserta</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = -1;
                                    foreach ($worksheet['tabel'] as $tabel) {
                                        $no++;
                                        ?>
                                    <tr>
                                        <td style="width: 50px; padding: 1rem 9px"><?= $no ?></td>
                                        <td style="position: relative">
                                            <strong><?= $tabel['r_peserta_evaluasi']['nomor_peserta'] ?></strong>
                                            <?php if ($tabel['r_peserta_evaluasi']['id'] == -1) : ?>
                                                <div class="badge badge-info rounded-circle" style="position: absolute; left: 0; top: 0px; font-size: 5pt; padding: 4px">
                                                    <i class="fas fa-asterisk"></i>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td style="position: relative">
                                            <strong><?= $tabel['siswa']['nis'] ?></strong>
                                            <?php if ($tabel['siswa']['inserted'] == 0) : ?>
                                                <div class="badge badge-info rounded-circle" style="position: absolute; left: 0; top: 0px; font-size: 5pt; padding: 4px">
                                                    <i class="fas fa-asterisk"></i>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td style="position: relative">
                                            <strong><?= $tabel['siswa']['nama_lengkap'] ?></strong>
                                            <?php if ($tabel['siswa']['inserted'] == 0) : ?>
                                                <div class="badge badge-info rounded-circle" style="position: absolute; left: 0; top: 0px; font-size: 5pt; padding: 4px">
                                                    <i class="fas fa-asterisk"></i>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td style="position: relative">
                                            <?= $tabel['siswa']['jenis_kelamin'] ?>
                                            <?php if ($tabel['siswa']['inserted'] == 0) : ?>
                                                <div class="badge badge-info rounded-circle" style="position: absolute; left: 0; top: 0px; font-size: 5pt; padding: 4px">
                                                    <i class="fas fa-asterisk"></i>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td style="position: relative">
                                            <strong><?= $tabel['penilaian']['nilai'] ?></strong>
                                            <?php if ($tabel['penilaian']['id'] == -1) : ?>
                                                <div class="badge badge-info rounded-circle" style="position: absolute; left: 0; top: 0px; font-size: 5pt; padding: 4px">
                                                    <i class="fas fa-asterisk"></i>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container-fluid -->
<?php
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="<?= site_url('admin/evaluasi/excel_penilaian_evaluasi') ?>" method="post">
                        <input type="hidden" name="excel_json" value="<?= htmlspecialchars(json_encode($excel)) ?>">
                        <button class="btn btn-primary btn-block" type="submit">
                            <i class="fas fa-paper-plane mr-1"></i>
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('jsContent') ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        <?php
        if (session()->getFlashdata('admin_artikel_msg')) {
            echo "showAlert('" . session()->getFlashdata('admin_artikel_msg') . "', 'fas fa-thumbs-up', 'default')";
            echo "\n";
        }
        ?>

        function showAlert(text, icon, color) {
            $(".alert").addClass('d-flex')
            $(".alert-icon i").attr('class', '')
            $(".alert-icon i").addClass(icon)
            $(".alert-text").html(text)
            classArray = ['alert-danger', 'alert-success', 'alert-info', 'alert-dark', 'alert-light', 'alert-warning', 'alert-primary', 'alert-secondary', 'alert-default']
            $.each(classArray, function(index, value) {
                $(".alert").removeClass(value)
            })
            $(".alert").addClass('alert-' + color)
            $(".alert").css({
                opacity: '0.0'
            }).animate({
                opacity: '1.0'
            }, 500)
            setTimeout(function() {
                $(".alert").animate({
                    opacity: '0.0'
                }, 500, 'linear', function() {
                    $(this).removeClass('d-flex')
                    $(this).css('display', 'none')
                })
            }, 5000)
        }
    });

    $(".form-input-file_excel input[type='file']").change(function(e) {
        e.preventDefault();
        fileType = $(this).val().split('.').pop().toLowerCase()
        if (fileType != 'xls' && fileType != 'xlsx') {
            alert('Format file salah, gunakan template yang disediakan.!')
        } else {
            $(".form-input-file_excel").submit()
        }
    })
</script>
<?php $this->endSection(); ?>