<?php 
namespace App\Controllers\Admin\Data;

use CodeIgniter\Controller;

class Siswa extends Controller
{	
	/**
	 * Fix Intelephense
	 * @var HTTP\IncomingRequest
	 */
	protected $request;
	protected $sidebar_link = [
		"Dashboard|fas fa-tachometer-alt|primary|admin",
		"Data|fas fa-database|primary|admin/data",
		"Evaluasi|fas fa-clipboard-check|primary|admin/evaluasi",
		"Konfigurasi|fas fa-cog|primary|admin/konfigurasi",
	];
	protected $navbar_link = [
		'Siswa|fas fa-users|admin/data/siswa',
		'Kelas|fas fa-school|admin/data/jurusan',
		'Mata Pelajaran|fas fa-book|admin/data/matapelajaran',
		'Jurusan|fas fa-school|admin/data/jurusan',
	];
	function auth() {
		helper('cookie');
		$logged_username = get_cookie('logged_username');
		$logged_secret = get_cookie('logged_secret');
    	$adminModel = new \App\Models\AdminModel();
		$array = ['hello' => 21];
		
		$user = $adminModel->find($logged_username);
		if ($logged_username != '' && $logged_secret != '') {
			if ($user != '') {
				if (password_verify($user['token'], $logged_secret)) {
					return $user;
				}
				else {
					session()->setFlashdata('admin_message', 'Anda telah keluar dari sistem, silahkan masuk kembali menggunakan akun anda');
					return false;
				}
			}
			else {
				session()->setFlashdata('admin_message', 'Anda telah keluar dari sistem, silahkan masuk kembali menggunakan akun anda');
				return false;
			}
		}
		else {
			session()->setFlashdata('admin_message', 'Anda telah keluar dari sistem, silahkan masuk kembali menggunakan akun anda');
			return false;
		}
	}
	
	/**
	 * Jenis method	: Halaman
	 * Catatan		: Halaman utama list data siswa
	 */
	public function list()
	{
		$konfigurasiModel = new \App\Models\KonfigurasiModel();
		$data['konfigurasi'] = $konfigurasiModel->showKeyValue();
		$data['userdata'] = $this->auth();
		if (!$data['userdata']) {
			return redirect()->to(site_url('logout'));
		}
		$data['ui_title'] = "Dashboard - Administrator";
		$data['ui_sidebar'] = $this->sidebar_link;
		$data['ui_sidebar_active'] = 'Data';

		$data['ui_navbar'] = $this->navbar_link;
		$data['ui_navbar_active'] = 'Siswa';
		$data['validation'] = \Config\Services::validation();

		$jurusanModel = new \App\Models\JurusanModel();
        $data['data_jurusan'] = $jurusanModel->orderBy('nama')->findAll();

		$kelasModel = new \App\Models\KelasModel();
        $data['data_kelas'] = $kelasModel->orderBy('nama')->findAll();

        $siswaModel = new \App\Models\SiswaModel();
        $data['data_tahun_masuk'] = $siswaModel->select('DISTINCT(`tahun_masuk`)')->where('tahun_masuk !=', '')->where('tahun_masuk IS NOT NULL')->findAll();

		return view('admin/data/siswa/list', $data);
	}
	
	/**
	 * Jenis method : Ajax
	 * Catatan		: Mengambil data siswa untuk list dan detail.
	 * Parameter	: 
	 * 		> $ui 	: ('single'|view_list_siswa)
	 */
	public function ajax_list($ui)
	{
		$request = $this->request;
		if ($request->isAJAX()) {

			// MIDDLEWARE - Userdata
			$data['userdata'] = $this->auth();
			if (!$data['userdata']) {
				return redirect()->to(site_url('logout'));
			}
			
			$siswaModel = new \App\Models\SiswaModel();

			$data['limit'] = $request->getGet('limit');
			$data['page'] = $request->getGet('page');
			$data['offset'] = ($data['page'] - 1) * $data['limit'];
			
			$pencarian = $request->getGet('pencarian');
			$cari_berdasarkan = $request->getGet('cari_berdasarkan');
			if ($pencarian != '') {
				if ($cari_berdasarkan != '') $cari_berdasarkan == 'nama_lengkap';
				$siswaModel->like($cari_berdasarkan, $pencarian, 'both');
			}

			$jenis_kelamin = $request->getGet('jenis_kelamin');
			if ($jenis_kelamin != '') {
				$siswaModel->where('jenis_kelamin', $jenis_kelamin);
			}

			$jurusan_id = $request->getGet('jurusan_id');
			if ($jurusan_id != '') {
				$siswaModel->where('jurusan_id', $jurusan_id);
			}

			$tahun_masuk = $request->getGet('tahun_masuk');
			if ($tahun_masuk != '') {
				$siswaModel->where('tahun_masuk', $tahun_masuk);
			}

			$kelas_id = $request->getGet('kelas_id');
			if ($kelas_id != '') {
				$siswaModel->where('kelas_id', $kelas_id);
			}

			$siswaModel->join('r_anggota_kelas', 'r_anggota_kelas.siswa_nis = siswa.nis');

			$siswaModel->orderBy('nama_lengkap', 'asc');
			$data['data'] = $siswaModel->findAll($data['limit'], $data['offset']);

			$data['bulan'] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			$data['jurusanModel'] = new \App\Models\jurusanModel();
			$data['kelasModel'] = new \App\Models\KelasModel();

			return view('admin/data/siswa/ajax/' . $ui, $data);
		}
	}

	/**
	 * Jenis method : Ajax
	 * Catatan		: Mengambil satu data siswa via json.
	 * Parameter	: -
	 * Method		: GET
	 * HTTP Data	: > id -> id dari data siswa yang akan dicari
	 */
	public function ajax_single()
	{
		$request = $this->request;
		if ($request->isAJAX()) {
			$nis = $request->getGet('nis');

			$siswaModel = new \App\Models\SiswaModel();
			$json = $siswaModel->find($nis);
			$json['foto_diri_url'] = site_url('images/siswa/' . $json['foto_diri']);
			echo json_encode($json);
		}
	}

	/**
	 * Jenis method : Ajax
	 * Catatan		: Update data siswa.
	 * Parameter	: -
	 * Method		: POST
	 * HTTP data	: formData Siswa
	 * Return 		: json (alert message)
	 */
	public function ajax_modify()
	{
		$request = $this->request;
		if ($request->isAJAX()) {
			$siswaModel = new \App\Models\SiswaModel();
			$nis = $request->getPost('nis');
			$data = [
				"nisn" => $request->getPost('nisn'),
				"nama_lengkap" => $request->getPost('nama_lengkap'),
				"jenis_kelamin" => $request->getPost('edit_jenis_kelamin'),
				"tempat_lahir" => $request->getPost('tempat_lahir'),
				"tanggal_lahir" => $request->getPost('tanggal_lahir'),
				"jurusan" => $request->getPost('jurusan'),
				"tahun_masuk" => $request->getPost('tahun_masuk'),
				"asal_sekolah" => $request->getPost('asal_sekolah'),
				"nama_ayah" => $request->getPost('nama_ayah'),
				"nama_ibu" => $request->getPost('nama_ibu'),
				"nama_wali" => $request->getPost('nama_wali'),
			];

			$foto_diri = $request->getFile('foto_diri');
			if ($foto_diri->isValid()) {

				$path = new \Config\Paths();
				
				// Hapus gambar sebelumnya
				$siswa = $siswaModel->find($nis);
				if ($siswa['foto_diri'] != '') {
					if (file_exists($path->publicDirectory . '/images/siswa/' . $siswa['foto_diri'])) {
						unlink($path->publicDirectory . '/images/siswa/' . $siswa['foto_diri']);
					}
				}

				// Upload gambar baru
				$foto_diri->move($path->publicDirectory . '/images/siswa/');
				$data['foto_diri'] = $foto_diri->getName();
			}	 
			$modify = $siswaModel->update($nis, $data);
			if ($modify) {
				$json['alert']['message'] = "Data berhasil di edit";
				$json['alert']['icon'] = "fas fa-thumbs-up";
				$json['alert']['color'] = "default";
			}
			else {
				$json['alert']['message'] = "Data gagak di edit";
				$json['alert']['icon'] = "fas fa-thumbs-down";
				$json['alert']['color'] = "danger";
			}

			echo json_encode($json);
			die;
		}
	}

	/**
	 * Jenis method : Ajax
	 * Catatan		: Update data foto_diri siswa.
	 * Parameter	: -
	 * Method		: POST
	 * HTTP data	: formData Siswa
	 * Return 		: json (alert message)
	 */
	public function ajax_modify_foto_diri()
	{
		$request = $this->request;
		if ($request->isAJAX()) {
			$siswaModel = new \App\Models\SiswaModel();
			
			$nis = $request->getPost('nis');
			$foto_diri = $request->getFile('foto_diri');

			if ($foto_diri->isValid()) {
				$path = new \Config\Paths();

				// Hapus gambar sebelumnya
				$siswa = $siswaModel->find($nis);
				if ($siswa['foto_diri'] != '') {
					if (file_exists($path->publicDirectory . '/images/siswa/' . $siswa['foto_diri'])) {
						unlink($path->publicDirectory . '/images/siswa/' . $siswa['foto_diri']);
					}
				}

				// Upload gambar baru
				$foto_diri->move($path->publicDirectory . '/images/siswa/');

				$modify = $siswaModel->update($nis, ['foto_diri' => $foto_diri->getName()]);
				if ($modify) {
					$json['alert']['message'] = "Data berhasil di edit";
					$json['alert']['icon'] = "fas fa-thumbs-up";
					$json['alert']['color'] = "default";
				}
				else {
					$json['alert']['message'] = "Data gagak di edit";
					$json['alert']['icon'] = "fas fa-thumbs-down";
					$json['alert']['color'] = "danger";
				}
				echo json_encode($json);
				die;
			}
		}
	}

}