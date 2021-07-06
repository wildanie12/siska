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