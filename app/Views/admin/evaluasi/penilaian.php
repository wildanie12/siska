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
<div class="header bg-default" style="z-index: 1050">
    <div class="container-fluid">
        <div class="row py-4 justify-content-between align-items-center">
            <div class="col d-flex justify-content-start align-items-center">
                <i class="fas fa-check text-white mr-4" style="font-size: 32pt;"></i>
                <div style="line-height: 12px;" class="pb-2">
                    <h2 class="text-white text-uppercase mb-0 mt-0">Penilaian Evaluasi</h2>
                    <div class="text-sm" style="color: #b1b1b1">Pilih kelas dan evaluasi yang diinginkan dibawah</div>
                </div>
            </div>
            <div class="col-auto text-right">
                <form class="d-none form-input-file_excel" action="<?= site_url("admin/evaluasi/excel_penilaian_evaluasi/preview") ?>" method="post" enctype="multipart/form-data">
                    <input id="input-file_excel" type="file" name="file_excel">
                </form>
                <label for="input-file_excel" class="btn btn-sm btn-success text-uppercase font-weight-bold" style="background: #099543; border: #099543; margin-bottom: 0;">
                    <i class="fas fa-file-excel mr-1"></i>
                    Entry data menggunakan Excel
                </label><br />
                <a href="#" class="btn btn-sm btn-link text-white">
                    <i class="fas fa-download mr-1"></i>
                    Download template entry data
                </a>
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
                                        <option value="">-Pilih Kelas-</option>
                                        <?php foreach ($data_kelas as $kelas) { ?>
                                            <option value="<?= $kelas['id'] ?>"><?= $kelas['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm pr-sm-1 pl-sm-1">
                                <label class="form-control-label">Mata Pelajaran</label>
                                <div class="input-group input-group-merge input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                                    </div>
                                    <select class="form-control filter-mata_pelajaran_id">
                                        <option value="">-Pilih Mata Pelajaran-</option>
                                        <?php foreach ($data_mata_pelajaran as $mata_pelajaran) { ?>
                                            <option value="<?= $mata_pelajaran['id'] ?>"><?= $mata_pelajaran['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm pl-sm-1">
                                <label class="form-control-label">Evaluasi / Ujian</label>
                                <div class="input-group-merge input-group input-group-sm flex-shrink">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clipboard-check"></i></span>
                                    </div>
                                    <select class="form-control filter-evaluasi_id" multiple>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="progress-wrapper p-0">
                            <div class="progress mb-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 100%"></div>
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
                <div class="card-body load-list table-responsive load-penilaian">

                </div>
            </div>
        </div>
    </div> <!-- end row -->
    <div class="row justify-content-center pagination">
        <div class="col-6">
            <div class="form-group mb-1 text-center">
                <label class="form-control-label mb-1 d-block">Halaman</label>
                <div class="input-group input-group-merge input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-sm btn-warning filter-btn-previous">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                    <input type="number" class="text-lg text-dark filter-page form-control form-control text-center font-weight-bold" value="1" min="1">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-warning filter-btn-next">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div> <!-- end form-group -->
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- end container-fluid -->


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

    $(".progress-wrapper").hide();

    $(".form-input-file_excel input[type='file']").change(function(e) {
        e.preventDefault();
        fileType = $(this).val().split('.').pop().toLowerCase()
        if (fileType != 'xls' && fileType != 'xlsx') {
            alert('Format file salah, gunakan template yang disediakan.!')
        } else {
            $(".progress-wrapper").show();
            $(".form-input-file_excel").submit()
        }
    })

    var evaluasiList = []
    var evaluasi = tail.select(".filter-evaluasi_id", {
        animate: true,
        hideSelected: true,
        search: true,
        multiContainer: true,
        multiShowCount: false,
        items: evaluasiList,
    })

    var evaluasiParams = {

    }

    function refreshEvaluasi() {
        $(".progress-wrapper").show();
        evaluasiList = []
        $.ajax({
            type: "GET",
            url: "<?= site_url("admin/evaluasi/ajax_list_evaluasi/list-option-1") ?>",
            data: evaluasiParams,
            dataType: "html",
            success: function(data) {
                $(".filter-evaluasi_id").html(data)
                evaluasi.reload()
                $(".filter-evaluasi_id").trigger('change')
                $(".progress-wrapper").hide();
            }
        });
    }
    refreshEvaluasi()
    $(".filter-kelas_id").change(function(e) {
        e.preventDefault()
        value = $(this).val()
        if (value != '')
            evaluasiParams.kelas_id = value
        else
            delete evaluasiParams.kelas_id
        refreshEvaluasi()
    })

    $(".filter-mata_pelajaran_id").change(function(e) {
        e.preventDefault()
        value = $(this).val()
        if (value != '')
            evaluasiParams.mata_pelajaran_id = value
        else
            delete evaluasiParams.mata_pelajaran_id
        refreshEvaluasi()
    })

    $(".filter-evaluasi_id").change(function(e) {
        $(".progress-wrapper").show();
        value = $(this).val()
        evaluasi_kelas_id = value.join('|')
        $.ajax({
            url: "<?= site_url('admin/evaluasi/ajax_tabel_penilaian') ?>",
            type: "GET",
            data: {
                evaluasi_kelas_id: evaluasi_kelas_id
            },
            dataType: "html",
            success: function(data) {
                $(".load-penilaian").html(data)
                $(".progress-wrapper").hide();
            }
        });
    })
</script>
<?php $this->endSection(); ?>