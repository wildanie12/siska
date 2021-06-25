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
		"Postingan|fas fa-newspaper|primary|admin/postingan/artikel",
		"Data Mitra|fas fa-store|primary|admin/mitra",
		"Pengguna|fas fa-users|primary|admin/pengguna",
		"Tata Letak|fas fa-ruler-combined|primary|admin/tataletak",
		"Konfigurasi|fas fa-cog|primary|admin/konfigurasi",
	];
	protected $navbar_link = [
		"Tambah Mitra|fas fa-plus-circle|admin/mitra/tambah|primary",
		"List Mitra|fas fa-list|admin/mitra/",
		"Laporan|fas fa-clipboard-list|admin/mitra/laporan",
		"Statistik|fas fa-chart-line|admin/mitra/statistik",
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
		$data['ui_sidebar'] = [
			"Dashboard|fas fa-tachometer-alt|primary|admin",
			"Postingan|fas fa-newspaper|primary|admin/postingan/artikel",
			"Data Mitra|fas fa-store|primary|admin/mitra",
			"Pengguna|fas fa-users|primary|admin/pengguna",
			"Tata Letak|fas fa-ruler-combined|primary|admin/tataletak",
			"Konfigurasi|fas fa-cog|primary|admin/konfigurasi",
		];
		$data['ui_sidebar_active'] = 'Dashboard';

		$data['ui_navbar'] = ['||'];
		$data['validation'] = \Config\Services::validation();
		$data['ui_navbar_active'] = "List Akun Admin";

		return view('admin/data/siswa/list', $data);
	}
	
	/**
	 * Jenis method : Ajax
	 * Catatan		: Mengambil data siswa untuk list dan detail.
	 * Parameter	: 
	 * 		> $page 	: ('single'|view_list_siswa)
	 */
	public function ajax_list($page)
	{
		$request = $this->request;
		if ($request->isAJAX()) {
			$nama = $request->getPost('hello');
			$model = new \App\Models\AdminModel();

			$model->insert(["nama" => $nama]);
		}
	}
}