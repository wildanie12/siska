<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Konfigurasi extends Controller
{
    /**
     * Fix PHP Intelephense
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
        "Website|fas fa-cog|admin/konfigurasi",
    ];
    function auth()
    {
        helper('cookie');
        $logged_username = get_cookie('logged_username');
        $logged_secret = get_cookie('logged_secret');
        $adminModel = new \App\Models\AdminModel();
        $user = $adminModel->find($logged_username);
        if ($logged_username != '' && $logged_secret != '') {
            if ($user != '') {
                if (password_verify($user['token'], $logged_secret)) {
                    return $user;
                } else {
                    session()->setFlashdata('admin_message', 'Anda telah keluar dari sistem, silahkan masuk kembali menggunakan akun anda');
                    return false;
                }
            } else {
                session()->setFlashdata('admin_message', 'Anda telah keluar dari sistem, silahkan masuk kembali menggunakan akun anda');
                return false;
            }
        } else {
            session()->setFlashdata('admin_message', 'Anda telah keluar dari sistem, silahkan masuk kembali menggunakan akun anda');
            return false;
        }
    }

    /**
     * Jenis Method : Halaman
     * Catatan      : Halaman Utama konfigurasi
     */
    public function index()
    {
        $data['userdata'] = $this->auth();
        if (!$data['userdata']) {
            return redirect()->to(site_url('logout'));
        }
        $data['ui_title'] = "Administrator - Konfigurasi Website";
        $data['ui_sidebar'] = $this->sidebar_link;
        $data['ui_sidebar_active'] = 'Konfigurasi';

        $data['ui_navbar'] = $this->navbar_link;
        $data['ui_navbar_active'] = "Website";

        $adminModel = new \App\Models\AdminModel();
        $data['data_penulis'] = $adminModel->orderBy('nama_lengkap', 'asc')->findAll();

        $konfigurasiModel = new \App\Models\KonfigurasiModel();
        $data['konfigurasi'] = $konfigurasiModel->showKeyValue();
        
        return view('admin/konfigurasi/index', $data);
    }

    /**
     * Jenis Method : AJAX
     * Catatan      : Untuk mengambil data konfigurasi tunggal 
     * Method       : GET
     * Params       : -
     * HTTP Data    : [nama=>"Nama Kunci Konfigurasi"]
     * Return       : [json] berupa data konfigurasi tunggal
     */
    public function ajax_get_configuration()
    {
        $request = $this->request;
        if ($request->isAJAX()) {
            $nama = $request->post('nama');

            $konfigurasiModel = new \App\Models\KonfigurasiModel();
            $konfigurasi = $konfigurasiModel->find($nama);

            echo json_encode($konfigurasi);
        }
    }

    /**
     * Jenis Method : AJAX
     * Catatan      : Untuk melakukan update konfigurasi secara tunggal
     * Method       : POST
     * Params       : - 
     * HTTP Data    :   nama          => Nama kunci konfigurasi
     *                  value         => Isi nilai dari konfigurasi (VarChar)
     *                  value_text    => Isi nilai dari konfigurasi (Text)
     * Return       : [Json] hasil status dari operasi update
     */
    public function ajax_set_configuration()
    {
        $request = $this->request;
        if ($request->isAJAX()) {
            $nama = $request->getPost('nama');
            $valueType = $request->getPost('value_type');
            $value = $request->getPost('value');

            $konfigurasiModel = new \App\Models\KonfigurasiModel();
            if ($valueType == 'text')
                $konfigurasiModel->update($nama, ['value_text' => $value]);
            else
                $konfigurasiModel->update($nama, ['value' => $value]);

            $json['affected_id'] = $nama;
            $json['status'] = 'success';
            $json['text'] = "Konfigurasi berhasil diperbarui<br/>";
            $json['icon'] = 'fas fa-thumbs-up';
            $json['color'] = 'default';
            echo json_encode($json);
        }
    }

    /**
     * Jenis method : AJAX
     * Catatan      : Melakukan update konfigurasi yang berkaitan dengan upload gambar
     * Method       : POST
     * Params       : -
     * HTTP Data    :   nama    => Nama kunci konfigurasi
     *                  image   => File gambar (FormData)
     */
    public function ajax_set_configuration_image()
    {
        $request = $this->request;
        if ($request->isAJAX()) {
            $nama = $request->getPost('nama');

            $gambar = $request->getFile('image');
            if ($gambar->isValid()) {
                $path_config = new \Config\Paths();

                $konfigurasiModel = new \App\Models\KonfigurasiModel();
                $konfigurasi = $konfigurasiModel->find($nama);
                if (file_exists($path_config->publicDirectory . '/' . $konfigurasi['value_text'])) {
                    unlink($path_config->publicDirectory . '/' . $konfigurasi['value_text']);
                }

                $gambar->move($path_config->publicDirectory);
                $imagick = \Config\Services::image();
                $imagick->withFile($path_config->publicDirectory . '/' . $gambar->getName())
                    ->resize(500, 500, true)
                    ->save($path_config->publicDirectory . '/' . $gambar->getName(), 70);

                $konfigurasiModel->update($nama, ['value_text' => $gambar->getName()]);

                $json['affected_id'] = $nama;
                $json['status'] = 'success';
                $json['text'] = "Konfigurasi berhasil diperbarui<br/>";
                $json['icon'] = 'fas fa-thumbs-up';
                $json['color'] = 'default';
            } else {
                $json['affected_id'] = $nama;
                $json['status'] = 'success';
                $json['text'] = "Tidak dapat menerapkan konfigurasi<br/>";
                $json['icon'] = 'fas fa-times';
                $json['color'] = 'warning';
            }

            echo json_encode($json);
        }
    }
}
