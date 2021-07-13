<?php $this->extend('template/admin'); ?>

<?php $this->section('content'); ?>
<!------------------------------------------------->
<!-------   Filter / Penyaringan data      -------->
<!------------------------------------------------->


<div class="alert alert-default alert-dismissible justify-content-between col-md-3 col-11 py-3 pl-3 pr-0 align-items-center" role="alert" style="position: fixed; right: 16px; top: 16px; z-index: 1050; display: none">
	<div class="text-left d-flex align-items-center">
	    <div class="alert-icon"><i class="fas fa-thumbs-up"></i></div>
	    <div class="alert-text mr-3"><?=session()->getFlashdata('admin_artikel_msg')?></div>
	</div>
    <a href="javascript:void(0)" data-dismiss='alert' class="btn btn-link text-white">
    	<i class="fas fa-times"></i> 
    </a>
</div>
<div class="header bg-success py-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body pt-3 pl-3 pr-3 pb-0">
						<div class="row">
							<div class="col-lg-4 col-sm-6 col-12">
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
							<div class="col-lg-3 col-sm-6 col-12">
								<div class="form-group mb-1">
									<label class="form-control-label mb-1 d-block">Jumlah data/halaman</label>
									<div class="input-group input-group-merge input-group-sm">
										<input type="number" class="form-control form-control filter-limit" value="50">
										<div class="input-group-append">
											<div class="input-group-text" style="font-size: 9pt !important">/ Halaman</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-6 col-12">
								<div class="form-group mb-1">
									<label class="form-control-label mb-1 d-block">Halaman</label>
									<div class="input-group input-group-merge input-group-sm">
										<div class="input-group-prepend">
											<button class="btn btn-sm btn-warning filter-btn-previous">
												<i class="fas fa-arrow-left"></i>
											</button>
										</div>
										<input type="number" class="filter-page form-control form-control text-center font-weight-bold" value="1" min="1">
										<div class="input-group-append">
											<button class="btn btn-sm btn-warning filter-btn-next">
												<i class="fas fa-arrow-right"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2 pl-md-1">
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
										<input type="radio" name="cari_berdasarkan" value="nama_lengkap" id="cari_berdasarkan-nama_lengkap" class="custom-control-input filter-cari_berdasarkan" checked>
										<label for="cari_berdasarkan-nama_lengkap" class="custom-control-label text-uppercase pt-1 text-xs font-weight-bold">Nama Lengkap</label>
									</div>
									<div class="custom-control custom-control-inline custom-radio">
										<input type="radio" name="cari_berdasarkan" value="nis" id="cari_berdasarkan-nis" class="custom-control-input filter-cari_berdasarkan">
										<label for="cari_berdasarkan-nis" class="custom-control-label text-uppercase pt-1 text-xs font-weight-bold">NIS</label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
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
							<div class="col-md-3">
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
							<div class="col-md-2 pl-md-1">
								<div class="form-group mb-1">
									<label class="form-control-label mb-0">Tahun Masuk</label>
									<select class="form-control form-control-sm filter-tahun_masuk">
										<option value="">- Pilih Tahun -</option>
										<?php
											foreach ($data_tahun_masuk as $tahun_masuk) {
										?>
											<option value="<?=$tahun_masuk['tahun_masuk']?>"><?=$tahun_masuk['tahun_masuk']?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div> <!-- end col -->
						</div> <!-- end row -->
						<div class="progress-wrapper p-0" style="visibility: visible;">
							<div class="progress mb-1">
								<div class="progress-bar bg-success progress-bar-animated progress-bar-striped" style="width: 100%"></div>
							</div>
						</div>
						<div class="d-none">
							<form action="<?=site_url('admin/mitra/delete')?>" method="post" id="form-delete">
								<input type="hidden" name="id">
							</form>
						</div>
					</div> <!-- end card-body -->
				</div> <!-- end card -->
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div> <!-- end container-fluid -->
</div> <!-- end header -->

<div class="container-fluid mt--4">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body load-siswa table-responsive">
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

<div class="modal fade" id="modal-edit_siswa">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header pb-0">
				<h4 class="modal-title mb-0">Edit data siswa</h4>
				<button class="close" type="button" data-dismiss="modal">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="row">
						<div class="col-md-8">
							<div class="row">
								<div class="col-sm pr-sm-1 form-group">
									<label class="form-control-label">NIS</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-key"></i></span>
										</div>
										<input type="text" class="form-control" name="nis" autocomplete="off" readonly>
									</div>
								</div>
								<div class="col-sm pl-sm-1 form-group ">
									<label class="form-control-label">NISN</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-key"></i></span>
										</div>
										<input type="text" class="form-control" autocomplete="off" name="nisn">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label class="form-control-label">Nama lengkap</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-signature"></i></span>
										</div>
										<input type="text" class="form-control" name="nama_lengkap">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md form-group">
									<label class="form-control-label mb-2 d-block">Jenis Kelamin</label>
									<div class="custom-control custom-control-inline custom-radio">
										<input type="radio" name="edit_jenis_kelamin" value="L" id="edit_jenis_kelamin-L" class="custom-control-input" checked>
										<label for="edit_jenis_kelamin-L" class="custom-control-label">Laki-laki</label>
									</div>
									<div class="custom-control custom-control-inline custom-radio">
										<input type="radio" name="edit_jenis_kelamin" value="P" id="edit_jenis_kelamin-P" class="custom-control-input">
										<label for="edit_jenis_kelamin-P" class="custom-control-label">Perempuan</label>
									</div>
								</div>
								<div class="col-md form-group">
									<label class="form-control-label">Tempat Lahir</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
										</div>
										<input type="text" class="form-control" name="tempat_lahir">
									</div>
								</div>
								<div class="col-md pl-md-1 form-group">
									<label class="form-control-label">Tanggal Lahir</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-calendar"></i></span>
										</div>
										<input type="date" class="form-control" name="tanggal_lahir">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col form-group">
									<label class="form-control-label">Jurusan</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-school"></i></span>
										</div>
										<select name="jurusan" class="form-control">
											<?php foreach ($data_jurusan as $jurusan) { ?>
											<option value="<?=$jurusan['id']?>"><?=$jurusan['nama']?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm form-group pr-sm-1">
									<label class="form-control-label">Tahun Masuk</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-calendar"></i></span>
										</div>
										<input type="number" min="1900" max="3000" class="form-control" name="tahun_masuk">
									</div>
								</div>
								<div class="col-sm form-group pl-sm-1">
									<label class="form-control-label">Asal Sekolah</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-school"></i></span>
										</div>
										<input type="text" min="1900" max="3000" class="form-control" name="asal_sekolah">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm form-group pr-sm-1">
									<label class="form-control-label">Nama Ayah</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" name="nama_ayah">
									</div>
								</div>
								<div class="col-sm form-group pl-sm-1 pr-sm-1">
									<label class="form-control-label">Nama Ibu</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" name="nama_ibu">
									</div>
								</div>
								<div class="col-sm form-group pl-sm-1">
									<label class="form-control-label">Nama Wali</label>
									<div class="input-group input-group-merge">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<input type="text" class="form-control" name="nama_wali">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="row">
								<div class="form-group">
									<img src="<?=site_url('images/default-profile.png')?>" class="img-thumbnail gambar-fill">
									<label class="form-control-label">Upload Foto Diri</label>
									<input type="file" class="form-control element-gambar" name="foto_diri">
								</div>
							</div>
							<div class="row">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<button class="btn btn-primary btn-block">
								<i class="fas fa-paper-plane mr-1"></i>
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<form class="form-edit-foto_diri d-none">
	<input type="hidden" name="nis">
	<input type="file" name="foto_diri">
</form>

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
			$(".alert").css({opacity: '0.0'}).animate({opacity: '1.0'}, 500)
			setTimeout(function() {
				$(".alert").animate({opacity: '0.0'}, 500, 'linear', function() {
					$(this).removeClass('d-flex')
					$(this).css('display', 'none')
				})
			}, 5000)
		}	

		var siswaParams = {
			cari_berdasarkan: 'nama_lengkap',
			page: 1,
			limit: 50,
		}
		function refreshSiswa() {
			$(".progress-wrapper").show()
			$.ajax({
				type: "GET",
				url: "<?=site_url('admin/data/siswa/ajax_list/list-1')?>",
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

		/**
		 * Submit Form EDIT
		 */
		var modalEditSiswaCtx = $("#modal-edit_siswa");
		$("#modal-edit_siswa form").submit(function(e) {
			e.preventDefault()
			formData = new FormData(this);
			$.ajax({
				type: "POST",
				url: "<?=site_url('admin/data/siswa/ajax_modify')?>",
				data: formData,
				dataType: "json",
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					showAlert(data.alert.message, data.alert.icon, data.alert.color)
					$("#modal-edit_siswa form")[0].reset()
					$("#modal-edit_siswa .gambar-fill").attr('src', '<?=site_url('images/default-profile.png')?>')
					refreshSiswa()
					modalEditSiswaCtx.modal('hide');
				}
			})
		})
		

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
	});

</script>
<?php $this->endSection(); ?>