<?php $this->extend('template/admin'); ?>

<?php $this->section('content'); ?>
<!------------------------------------------------->
<!-------   Filter / Penyaringan data      -------->
<!------------------------------------------------->


<div class="alert alert-default alert-dismissible justify-content-between col-md-3 col-11 py-3 pl-3 pr-0 align-items-center" role="alert" style="position: fixed; right: 16px; top: 16px; z-index: 1050; display: none">
    <div class="text-left d-flex align-items-center">
        <div class="alert-icon"><i class="fas fa-thumbs-up"></i></div>
        <div class="alert-text mr-3"><?= session()->getFlashdata('admin_artikel_msg') ?></div>
    </div>
    <a href="javascript:void(0)" data-dismiss='alert' class="btn btn-link text-white">
        <i class="fas fa-times"></i>
    </a>
</div>
<div class="header bg-default">
    <div class="container-fluid">
        <div class="row">
            <div class="col p-4 pb-5 m-2 d-flex justify-content-left align-items-center" style="line-height: 20px;">
                <i class="fas fa-database text-white mr-4" style="font-size: 32pt;"></i>
                <div style="line-height: 12px;">
                    <h2 class="text-white text-uppercase mb-0 mt-0">Selamat datang.!</h2>
                    <div class="text-sm pb-2" style="color: #b1b1b1">Di Pusat Data</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header py-2">
                    <h4 class="card-title mb-0 text-center">
                        Anda dapat mengelola data-data berikut :
                    </h4>
                </div>
                <div class="card-body load-list">
                    <div class="row justify-content-center align-items-stretch">
                        <div class="border border-success py-3 px-4 rounded col-auto justify-content-center mr-4 d-flex flex-column text-center" onclick="location.href='<?= site_url('admin/data/siswa') ?>'" style="cursor: pointer; border-width: 2px !important">
                            <i class="fas text-success fa-users" style="font-size: 36pt;"></i>
                            <h4 class="text-uppercase text-success mt-2" style="font-size: 11pt; font-weight: bold">Siswa</h4>
                        </div>
                        <div class="border border-warning py-3 px-4 rounded col-auto justify-content-center mr-4 d-flex flex-column text-center" onclick="location.href='<?= site_url('admin/data/kelas') ?>'" style="cursor: pointer; border-width: 2px !important">
                            <i class="fas text-warning fa-school" style="font-size: 36pt;"></i>
                            <h4 class="text-uppercase text-warning mt-2" style="font-size: 11pt; font-weight: bold">Kelas</h4>
                        </div>
                        <div class="border border-default py-3 px-4 rounded col-auto justify-content-center mr-4 d-flex flex-column text-center" onclick="location.href='<?= site_url('admin/data/matapelajaran') ?>'" style="cursor: pointer; border-width: 2px !important">
                            <i class="fas text-default fa-book" style="font-size: 36pt;"></i>
                            <h4 class="text-uppercase text-default mt-2" style="font-size: 11pt; font-weight: bold">Mapel</h4>
                        </div>
                        <div class="border border-danger py-3 px-4 rounded col-auto justify-content-center mr-4 d-flex flex-column text-center" onclick="location.href='<?= site_url('admin/data/jurusan') ?>'" style="cursor: pointer; border-width: 2px !important">
                            <i class="fas text-danger fa-journal-whills" style="font-size: 36pt;"></i>
                            <h4 class="text-uppercase text-danger mt-2" style="font-size: 11pt; font-weight: bold">Jurusan</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end container-fluid -->


<?php $this->endSection(); ?>

<?php $this->section('jsContent') ?>
<script type="text/javascript">
</script>
<?php $this->endSection(); ?>