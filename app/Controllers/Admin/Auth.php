<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class Auth extends Controller
{
	function init() {
		helper('cookie');
		$logged_username = get_cookie('logged_username');
		$logged_secret = get_cookie('logged_secret');
    	$adminModel = new AdminModel();
		$user = $adminModel->find($logged_username);
		if ($logged_username != '' && $logged_secret != '') {
			if ($user != '') {
				if (password_verify($user['token'], $logged_secret)) {
					return $user;
				}
				else {
					return 'reject';
				}
			}
			else {
				return 'reject';
			}
		}
	}
	public function do_login()
    {
    	helper('cookie');
    	$request = $this->request;
    	$adminModel = new AdminModel();
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        $redirect_url = site_url('admin/');
        $user_db = $adminModel->find($username);
        if ($user_db != '') {
            // user ditemukan
            if (password_verify($password, $user_db['password'])) {
                // password cocok
                $secret = base64_encode('anjay' . time() . '-' . rand(1, 1000));  // To database
                $token = password_hash($secret, PASSWORD_DEFAULT); // To Cookie
                $adminModel->update($user_db['username'], ['token' => $secret]);
                setcookie('logged_username', $user_db['username'], time()+60*60*24*30);
                setcookie('logged_secret', $token, time()+60*60*24*30);
                return redirect()->to($redirect_url);
            }
            else {
                // Password tidak cocok
                session()->setFlashdata('admin_message', 'Password tidak cocok');
                return redirect()->to(site_url('login'));
            }
        }
        else {
            // user tidak ditemukan
            session()->setFlashdata('admin_message', 'Username tidak ditemukan');
            return redirect()->to(site_url('login'));
        }
    }

    public function logout()
    {
    	unset($_COOKIE['logged_username']);
    	setcookie('logged_username', null, -1);
    	unset($_COOKIE['logged_secret']);
    	setcookie('logged_secret', null, -1);
        return redirect()->to(site_url('login'));
    }
	public function index()
	{
		$konfigurasiModel = new \App\Models\KonfigurasiModel();
		$data['konfigurasi'] = $konfigurasiModel->showKeyValue();

		$user = $this->init();
		if (is_array($user)) {
            return redirect()->to(site_url('admin'));
		}

		$konfigurasiModel = new \App\Models\KonfigurasiModel();
		$data['konfigurasi'] = $konfigurasiModel->showKeyValue();

		$data['ui_title'] = "Masuk - " . $data['konfigurasi']['APP_JUDUL']['value'];

		// Navbar
		$konfigurasiModel = new \App\Models\KonfigurasiModel();
		$navbar = $konfigurasiModel->find('APP_NAVBAR');
		$navbar = json_decode($navbar['value_text']);
		$navbar_converted = ["Beranda|fas fa-home|". base_url()];

		foreach ($navbar as $nav) {
			if (isset($nav->dropdown)) {
				$nav_dropdown = [];
				foreach ($nav->dropdown as $dropdown) {
					$nav_dropdown[] = (($dropdown->judul != '') ? $dropdown->judul : '-') . '|' . $dropdown->icon. '|' . $dropdown->url;
				}
				$navbar_converted[$nav->judul . '|' . $nav->icon] = $nav_dropdown;
			}
			else {
				$navbar_converted[] = (($nav->judul != '') ? $nav->judul : '-') . '|' . $nav->icon. '|' . $nav->url;
			}
		}
		$data['ui_navbar'] = $navbar_converted;

		return view('template/login', $data);
	}
}