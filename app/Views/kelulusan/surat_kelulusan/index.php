<?php $this->extend('template/guest'); ?>

<?php $this->section('content'); ?>
<header class="d-flex justify-content-center pt-5" style="background: url('http://10.0.0.2/siska/public/images/graduation.jpg') 0 -110px/100%; margin-top: -13px; height: 300px">
	<h4 class="text-center text-dark" style="font-weight: 600; font-size: 24pt; margin-top: 40px">Cetak Surat Keterangan Lulus</h4>
</header>
<div class="container" style="margin-top: -100px">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header">
					<h4 class="m-2" style="font-size: 12pt; font-weight: 400;">Cari data anda menggunakan penyaringan data berikut</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group mb-0">
										<label class="form-control-label mb-0">Pencarian</label>
										<div class="input-group input-group-merge input-group-sm">
											<input type="text" class="form-control form-control-sm filter-pencarian">
											<div class="input-group-append">
												<span class="input-group-text"><i class="fas fa-search"></i></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-1">
										<label class="form-control-label mb-0">Kelas</label>
										<select class="form-control form-control-sm filter-kelas">
											<option value="">- Pilih Kelas -</option>
											<?php
												foreach ($data_kelas as $kelas) {
											?>
												<option value="<?=$kelas['id']?>"><?=$kelas['nama']?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group mb-1">
										<label class="form-control-label mb-0 d-block mb-2">Cari Berdasarkan</label>	
										<div class="custom-control custom-control-inline custom-radio">
											<input type="radio" name="cari_berdasarkan" value="nama_lengkap" id="cari_berdasarkan-nama_lengkap" class="custom-control-input filter-cari_berdasarkan">
											<label for="cari_berdasarkan-nama_lengkap" class="custom-control-label text-uppercase pt-1 text-xs font-weight-bold">Nama Lengkap</label>
										</div>
										<div class="custom-control custom-control-inline custom-radio">
											<input type="radio" name="cari_berdasarkan" value="nisn" id="cari_berdasarkan-nis" class="custom-control-input filter-cari_berdasarkan" checked>
											<label for="cari_berdasarkan-nis" class="custom-control-label text-uppercase pt-1 text-xs font-weight-bold">NISN</label>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group mb-1">
										<label class="form-control-label d-block mb-2">Jenis Kelamin</label>
										<div class="custom-control custom-control-inline custom-radio">
											<input type="radio" class="custom-control-input filter-jenis_kelamin" name="filter_jenis_kelamin" value="" id="jenis_kelamin-S" checked>
											<label for="jenis_kelamin-S" class="custom-control-label text-xs font-weight-bold text-uppercase pt-1">Semua</label>
										</div>
										<div class="custom-control custom-control-inline custom-radio">
											<input type="radio" class="custom-control-input filter-jenis_kelamin" name="filter_jenis_kelamin" value="L" id="jenis_kelamin-L">
											<label for="jenis_kelamin-L" class="custom-control-label text-xs font-weight-bold text-uppercase pt-1">Laki-laki</label>
										</div>
										<div class="custom-control custom-control-inline custom-radio">
											<input type="radio" class="custom-control-input filter-jenis_kelamin" name="filter_jenis_kelamin" value="P" id="jenis_kelamin-P">
											<label for="jenis_kelamin-P" class="custom-control-label text-xs font-weight-bold text-uppercase pt-1">Perempuan</label>
										</div>
									</div>
								</div> <!-- end col -->
								<div class="col-md-4">
									<div class="form-group mb-1">
										<label class="form-control-label mb-0">Jurusan</label>
										<select class="form-control form-control-sm filter-jurusan_id">
											<option value="">- Pilih Jurusan -</option>
											<?php
												foreach ($data_jurusan as $jurusan) {
											?>
												<option value="<?=$jurusan['id']?>"><?=$jurusan['nama']?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div> <!-- end col -->
							</div> <!-- end row -->
							<div class="progress-wrapper mt-2 mb-2">
								<div class="progress">
									<div class="progress-bar bg-primary progress-bar-animated progress-bar-striped" style="width: 100%;"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col table-responsive load-siswa">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('jsContent') ?>
<script>
	var siswaParams = {
		cari_berdasarkan: 'nisn',
		page: 1,
		limit: 50,
	}
	function refreshSiswa() {
		$(".progress-wrapper").show()
		$.ajax({
			type: "GET",
			url: "<?=site_url('kelulusan/ajax_list/list-1')?>",
			data: siswaParams,
			dataType: "html",
			success: function (data) {
				$.getScript('<?=site_url('js/dynamic-img.js')?>')
				$(".load-siswa").html(data)
				onLoadSiswa(data)
				$(".progress-wrapper").hide()
			},
		});
	}
	function onLoadSiswa(data) {
		$(".content-edit").click(function(e) {
			e.preventDefault()
			nis = $(this).data('nis')
			$.ajax({
				type: "GET",
				url: "<?=site_url('admin/data/siswa/ajax_single')?>",
				data: {nis: nis},
				dataType: "json",
				success: function (data) {
					modalEditSiswaCtx.modal('show')
					modalEditSiswaCtx.find("input[name='nis']").val(nis);
					modalEditSiswaCtx.find("input[name='nisn']").val(data.nisn);
					modalEditSiswaCtx.find("input[name='nama_lengkap']").val(data.nama_lengkap)
					modalEditSiswaCtx.find("[name='edit_jenis_kelamin'][value='"+data.jenis_kelamin+"']").prop('checked', true)
					modalEditSiswaCtx.find("input[name='tempat_lahir']").val(data.tempat_lahir)
					modalEditSiswaCtx.find("input[name='tanggal_lahir']").val(data.tanggal_lahir)
					modalEditSiswaCtx.find("input[name='jurusan']").val(data.jurusan)
					modalEditSiswaCtx.find("input[name='tahun_masuk']").val(data.tahun_masuk)
					modalEditSiswaCtx.find("input[name='asal_sekolah']").val(data.asal_sekolah)
					modalEditSiswaCtx.find("input[name='nama_ayah']").val(data.nama_ayah)
					modalEditSiswaCtx.find("input[name='nama_ibu']").val(data.nama_ibu)
					modalEditSiswaCtx.find("input[name='nama_wali']").val(data.nama_wali)
					if (data.foto_diri != '') 
						modalEditSiswaCtx.find(".gambar-fill").attr('src', data.foto_diri_url)
					else 
						modalEditSiswaCtx.find(".gambar-fill").attr('src', '<?=site_url('images/default-profile.png')?>')
				}
			});
		})

		$(".content-edit-foto_diri").click(function (e) {
			form = $(".form-edit-foto_diri");
			form.find("input[name='nis']").val($(this).data('nis'));
			form.find("input[name='foto_diri']").click();
		})

		/**
		 * Submit Edit Foto
		 */
		$(".form-edit-foto_diri input[name='foto_diri']").unbind().change(function (e) {
			e.preventDefault()
			nis = $(".form-edit-foto_diri [name='nis']").val()
			$(`.content-edit-foto_diri[data-nis='${nis}'] > i`).removeClass('fa-question').addClass('fa-circle-notch fa-spin')
			form = $(".form-edit-foto_diri")[0];
			formData = new FormData(form)
			$.ajax({
				type: "POST",
				url: "<?=site_url('admin/data/siswa/ajax_modify_foto_diri')?>",
				data: formData,
				dataType: "json",
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					showAlert(data.alert.message, data.alert.icon, data.alert.color)
					refreshSiswa()
				}
			})
		})
	}
	refreshSiswa()
	$(".filter-pencarian").on('input', function(e) {
		e.preventDefault();
		value = $(this).val()
		if (value != '')
			siswaParams.pencarian = value
		else 
			delete siswaParams.pencarian
		refreshSiswa()
	})
	$(".filter-cari_berdasarkan").change( function(e) {
		e.preventDefault();
		value = $(this).val()
		if (value != '')
			siswaParams.cari_berdasarkan = value
		else 
			delete siswaParams.cari_berdasarkan
		refreshSiswa()
	})
	$(".filter-jenis_kelamin").change( function(e) {
		e.preventDefault();
		value = $(this).val()
		if (value != '')
			siswaParams.jenis_kelamin = value
		else 
			delete siswaParams.jenis_kelamin
		refreshSiswa()
	})
	$(".filter-jurusan_id").change( function(e) {
		e.preventDefault();
		value = $(this).val()
		if (value != '')
			siswaParams.jurusan_id = value
		else 
			delete siswaParams.jurusan_id
		refreshSiswa()
	})
	$(".filter-tahun_masuk").change( function(e) {
		e.preventDefault();
		value = $(this).val()
		if (value != '') 
			siswaParams.tahun_masuk = value
		else 
			delete siswaParams.tahun_masuk
		refreshSiswa()
	})
	$(".filter-kelas").change( function(e) {
		e.preventDefault();
		value = $(this).val()
		if (value != '')
			siswaParams.kelas_id = value
		else 
			delete siswaParams.kelas_id
		refreshSiswa()
	})

	$(".filter-limit").change(function(e) {
		value = $(this).val()
		if (value != '') {
			if (value > 0) {
				siswaParams.limit = value
				siswaParams.page = 1
				$(".filter-page").val(1)
			}
			else {
				siswaParams.limit = 50
				$(this).val(50)
				siswaParams.page = 1
				$(".filter-page").val(1)
			}
		}
		else {
			siswaParams.limit = 50
			$(this).val(50)
			siswaParams.page = 1
			$(".filter-page").val(1)
		}
		refreshSiswa()
	})
	$(".filter-page").change(function(e) {
		value = $(this).val()
		if (value != '') {
			siswaParams.page = value
		}
		else {
			delete siswaParams.page
		}
		refreshSiswa()
	})
	$(".filter-btn-previous").click(function(e) {
		value = $(".filter-page").val()
		value = parseInt(value) - 1
		if (value <= 0) {
			value = 1;
		}
		$(".filter-page").val(value)
		siswaParams.page = value
		refreshSiswa()
	})
	$(".filter-btn-next").click(function(e) {
		value = $(".filter-page").val()
		value = parseInt(value) + 1
		$(".filter-page").val(value)
		siswaParams.page = value
		refreshSiswa()
	})
</script>
<?php $this->endSection(); ?>