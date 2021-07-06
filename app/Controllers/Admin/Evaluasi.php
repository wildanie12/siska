<?php 
namespace App\Controllers\Admin;

use App\Models\REvaluasiKelasModel;
use CodeIgniter\Controller;

class Evaluasi extends Controller {
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
        'List|fas fa-list|admin/evaluasi',
        'Peserta|fas fa-users|admin/evaluasi/peserta',
        'Penilaian|fas fa-check|admin/evaluasi/penilaian'
    ];
    function auth()
    {
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

    public function list()
    {
        $konfigurasiModel = new \App\Models\KonfigurasiModel();
        $data['konfigurasi'] = $konfigurasiModel->showKeyValue();
        $data['userdata'] = $this->auth();
        if (!$data['userdata']) {
            return redirect()->to(site_url('logout'));
        }
        $data['ui_title'] = "List Evaluasi - Administrator" . $data['konfigurasi']['APP_JUDUL']['value_text'];
        $data['ui_sidebar'] = $this->sidebar_link;
        $data['ui_sidebar_active'] = 'Evaluasi';

        $data['ui_navbar'] = $this->navbar_link;
        $data['ui_navbar_active'] = "List";

        return view('admin/evaluasi/list', $data);
    }

    public function penilaian()
    {
        $konfigurasiModel = new \App\Models\KonfigurasiModel();
        $data['konfigurasi'] = $konfigurasiModel->showKeyValue();
        $data['userdata'] = $this->auth();
        if (!$data['userdata']) {
            return redirect()->to(site_url('logout'));
        }
        

        $data['ui_title'] = "List Evaluasi - Administrator" . $data['konfigurasi']['APP_JUDUL']['value_text'];
        $data['ui_css'] = [
            'lib/tail-select/css/tail.select-default.css'
        ];
        $data['ui_js'] = [
            'lib/tail-select/js/tail.select.min.js',
        ];
        $data['ui_sidebar'] = $this->sidebar_link;
        $data['ui_sidebar_active'] = 'Evaluasi';

        $data['ui_navbar'] = $this->navbar_link;
        $data['ui_navbar_active'] = "Penilaian";

        $mataPelajaranModel = new \App\Models\MataPelajaranModel();
        $data['data_mata_pelajaran'] = $mataPelajaranModel->findAll();
        
        $kelasModel = new \App\Models\KelasModel();
        $data['data_kelas'] = $kelasModel->orderBy('tahun_pelajaran', 'desc')->findAll();

        return view('admin/evaluasi/penilaian', $data);
    }

    /**
     * Jenis Method : AJAX
     * Catatan      : Untuk mendapatkan data evaluasi secara lengkap (sudah di join dengan tabel evaluasi_kelas)
     * Method       : POST
     * Params       : $ui -> file view yang digunakan method
     * HTTP Data    :   kelas_id
                        mata_pelajaran_id
                        tanggal_mulai
     */
    public function ajax_list_evaluasi($ui = 'json')
    {
        $request = $this->request;
        if ($request->isAJAX()) {
            $data['kelasModel'] = new \App\Models\KelasModel();
            $data['mataPelajaranModel'] = new \App\Models\MataPelajaranModel();
            $rEvaluasiKelasModel = new \App\Models\REvaluasiKelasModel();
            
            $kelas_id = $request->getGet('kelas_id');
            if ($kelas_id != '') {
                $rEvaluasiKelasModel->where('kelas_id', $kelas_id);
            }

            $mata_pelajaran_id = $request->getGet('mata_pelajaran_id');
            if ($mata_pelajaran_id != '') {
                $rEvaluasiKelasModel->where('mata_pelajaran_id', $mata_pelajaran_id);
            }

            $tanggal_mulai = $request->getGet('tanggal_mulai');
            if ($tanggal_mulai != '') {
                $rEvaluasiKelasModel->where('tanggal_mulai', $tanggal_mulai);
            }

            $rEvaluasiKelasModel->select('r_evaluasi_kelas.*, evaluasi.nama, evaluasi.deskripsi');
            $rEvaluasiKelasModel->join('evaluasi', 'r_evaluasi_kelas.evaluasi_id = evaluasi.id');

            $data['data'] = $rEvaluasiKelasModel->findAll();
            if ($ui == 'json') {
                return json_encode($data['data']);
            }
            else {
                return view('admin/evaluasi/ajax/' . $ui, $data);
            }
        }
        die;
    }
    /**
     * Jenis Method : AJAX
     * Catatan      : Menampilkan tabel penilaian berdasarkan filter terpilih
     * Method       : GET
     * Params       : -
     * HTTP Data    :   evaluasi_kelas_id -> data penilaian evaluasi yang akan ditampilkan
     */
    public function ajax_tabel_penilaian()
    {
        $request = $this->request;
        // if ($request->isAJAX()) {
            $data['kelasModel'] = new \App\Models\KelasModel();
            $data['rAnggotaKelasModel'] = new \App\Models\RAnggotaKelasModel();
            $data['siswaModel'] = new \App\Models\SiswaModel();

            $data['rEvaluasiKelasModel'] = new \App\Models\REvaluasiKelasModel();
            $data['mataPelajaranModel'] = new \App\Models\MataPelajaranModel();
            $data['rPesertaEvaluasiModel'] = new \App\Models\RPesertaEvaluasiModel();
            $data['penilaianModel'] = new \App\Models\PenilaianModel();

            $evaluasi_kelas_id = $request->getGet("evaluasi_kelas_id");
            $data['evaluasi_kelas_id'] = explode('|', $evaluasi_kelas_id);

            return view('admin/evaluasi/ajax/tabel-penilaian', $data);
        // }
    }


    /**
     * Jenis Method : Form Handler
     * Catatan      : Menerima file excel untuk diterjemahkan menjadi entry data penilaian evaluasi
     * Method       : POST
     * Params       : $preview -> untuk acuan operasi yang akan dilakukan (preview|Insert operation)
     * HTTP Data    :   file_excel -> file excel yang diupload
     * Return       : View|Json
     */
    public function excel_penilaian_evaluasi($preview = FALSE)
    {
        $request = $this->request;

        $siswaModel = new \App\Models\SiswaModel();
        $rAnggotaKelasModel = new \App\Models\RAnggotaKelasModel();
        $jurusanModel = new \App\Models\JurusanModel();
        $kelasModel = new \App\Models\KelasModel();
        $mataPelajaranModel = new \App\Models\MataPelajaranModel();
        $evaluasiModel = new \App\Models\EvaluasiModel();
        $rEvaluasiKelasModel = new \App\Models\REvaluasiKelasModel();
        $rPesertaEvaluasiModel = new \App\Models\RPesertaEvaluasiModel();
        $penilaianModel = new \App\Models\PenilaianModel();

        if ($preview) {
            $file_excel = $request->getFile('file_excel');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_excel);
            $spreadsheetNames = $spreadsheet->getSheetNames();
            for ($spreadsheetIndex=0; $spreadsheetIndex < count($spreadsheetNames); $spreadsheetIndex++) { 
                $worksheet = $spreadsheet->getSheet($spreadsheetIndex);

                // Data Jurusan || Cell C10
                $jurusanCell = $worksheet->getCell("C10")->getValue();
                $jurusan = $jurusanModel->find($jurusanCell);
                if (!$jurusan) {
                    $jurusan = $jurusanModel->like("nama", $jurusanCell, "both")->first();
                    if (!$jurusan) {
                        $excel[$spreadsheetIndex]['jurusan']['id'] = -1;
                        $excel[$spreadsheetIndex]['jurusan']['nama'] = $jurusanCell;
                        $excel[$spreadsheetIndex]['jurusan']['excel_raw'] = $jurusanCell;
                    }
                    else {
                        $excel[$spreadsheetIndex]['jurusan']['id'] = $jurusan['id'];
                        $excel[$spreadsheetIndex]['jurusan']['nama'] = $jurusan['nama'];
                        $excel[$spreadsheetIndex]['jurusan']['excel_raw'] = $jurusanCell;
                    }
                }
                else {
                    $excel[$spreadsheetIndex]['jurusan']['id'] = $jurusan['id'];
                    $excel[$spreadsheetIndex]['jurusan']['nama'] = $jurusan['nama'];
                    $excel[$spreadsheetIndex]['jurusan']['excel_raw'] = $jurusanCell;
                }

                // Data Kelas || Cell C11
                $kelasCell = $worksheet->getCell("C11")->getValue();
                $kelas = $kelasModel->find($kelasCell);
                if (!$kelas) {
                    $kelas = $kelasModel->like('nama', $kelasCell, 'both')->first();
                    if (!$kelas) {
                        $excel[$spreadsheetIndex]['kelas']['id'] = -1;
                        $excel[$spreadsheetIndex]['kelas']['nama'] = $kelasCell;
                        $excel[$spreadsheetIndex]['kelas']['jurusan'] = $excel[$spreadsheetIndex]['jurusan']['id'];
                        $excel[$spreadsheetIndex]['kelas']['excel_raw'] = $kelasCell;
                    }
                    else {
                        $excel[$spreadsheetIndex]['kelas']['id'] = $kelas['id'];
                        $excel[$spreadsheetIndex]['kelas']['nama'] = $kelas['nama'];
                        $excel[$spreadsheetIndex]['kelas']['jurusan'] = $kelas['jurusan_id'];
                        $excel[$spreadsheetIndex]['kelas']['excel_raw'] = $kelasCell;
                    }
                }
                else {
                    $excel[$spreadsheetIndex]['kelas']['id'] = $kelas['id'];
                    $excel[$spreadsheetIndex]['kelas']['nama'] = $kelas['nama'];
                    $excel[$spreadsheetIndex]['kelas']['jurusan'] = $kelas['jurusan_id'];
                    $excel[$spreadsheetIndex]['kelas']['excel_raw'] = $kelasCell;
                }

                // Data Mata Pelajaran || Cell C12
                $mataPelajaranCell = $worksheet->getCell("C12")->getValue();
                $mataPelajaran = $mataPelajaranModel->find($mataPelajaranCell);
                if (!$mataPelajaran) {
                    $mataPelajaran = $mataPelajaranModel->like('nama', $mataPelajaranCell, 'both')->first();
                    if (!$mataPelajaran) {
                        $excel[$spreadsheetIndex]['mata_pelajaran']['id'] = -1;
                        $excel[$spreadsheetIndex]['mata_pelajaran']['nama'] = $mataPelajaranCell;
                        $excel[$spreadsheetIndex]['mata_pelajaran']['jurusan_id'] = $excel[$spreadsheetIndex]['jurusan']['id'];
                        $excel[$spreadsheetIndex]['mata_pelajaran']['excel_raw'] = $mataPelajaranCell;
                    } else {
                        $excel[$spreadsheetIndex]['mata_pelajaran']['id'] = $mataPelajaran['id'];
                        $excel[$spreadsheetIndex]['mata_pelajaran']['nama'] = $mataPelajaran['nama'];
                        $excel[$spreadsheetIndex]['mata_pelajaran']['jurusan'] = $kelas['jurusan_id'];
                        $excel[$spreadsheetIndex]['mata_pelajaran']['excel_raw'] = $mataPelajaranCell;
                    }
                } else {
                    $excel[$spreadsheetIndex]['mata_pelajaran']['id'] = $mataPelajaran['id'];
                    $excel[$spreadsheetIndex]['mata_pelajaran']['nama'] = $mataPelajaran['nama'];
                    $excel[$spreadsheetIndex]['mata_pelajaran']['jurusan'] = $kelas['jurusan_id'];
                    $excel[$spreadsheetIndex]['mata_pelajaran']['excel_raw'] = $mataPelajaranCell;
                }

                // Data Evaluasi || Cell B7
                $evaluasiTanggalMulaiCell = $worksheet->getCell("C8")->getValue();
                $evaluasiTanggalMulaiCell = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($evaluasiTanggalMulaiCell);
                $evaluasiTanggalSelesaiCell = $worksheet->getCell("F8")->getValue();
                $evaluasiTanggalSelesaiCell = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($evaluasiTanggalSelesaiCell);
                $evaluasiNama = $worksheet->getCell("B7")->getValue();
                $evaluasi = $evaluasiModel->like('nama', $evaluasiNama,'both')->first();
                if (!$evaluasi) {
                    $excel[$spreadsheetIndex]['evaluasi']['id'] = -1;
                    $excel[$spreadsheetIndex]['evaluasi']['nama'] = $evaluasiNama;
                    $excel[$spreadsheetIndex]['evaluasi']['excel_raw'] = $evaluasiNama;
                }
                else {
                    $excel[$spreadsheetIndex]['evaluasi']['id'] = $evaluasi['id'];
                    $excel[$spreadsheetIndex]['evaluasi']['nama'] = $evaluasi['nama'];
                    $excel[$spreadsheetIndex]['evaluasi']['excel_raw'] = $evaluasiNama;
                }
                
                // Data R Evaluasi Kelas || Cell C8 dan F8
                $rEvaluasiKelas = $rEvaluasiKelasModel
                    ->where('kelas_id', $excel[$spreadsheetIndex]['kelas']['id'])
                    ->where('evaluasi_id', $excel[$spreadsheetIndex]['evaluasi']['id'])
                    ->where('mata_pelajaran_id', $excel[$spreadsheetIndex]['mata_pelajaran']['id'])
                    ->first();
                if ($rEvaluasiKelas) {
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['id'] = $rEvaluasiKelas['id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['kelas_id'] = $rEvaluasiKelas['kelas_id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['mata_pelajaran_id'] = $rEvaluasiKelas['mata_pelajaran_id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['evaluasi_id'] = $rEvaluasiKelas['evaluasi_id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['tanggal_mulai'] = $rEvaluasiKelas['tanggal_mulai'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['tanggal_selesai'] = $rEvaluasiKelas['tanggal_selesai'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['excel_raw']['tanggal_mulai'] = $evaluasiTanggalMulaiCell->format('Y-m-d');
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['excel_raw']['tanggal_selesai'] = $evaluasiTanggalSelesaiCell->format('Y-m-d');
                }
                else {
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['id'] = -1;
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['kelas_id'] = $excel[$spreadsheetIndex]['kelas']['id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['mata_pelajaran_id'] = $excel[$spreadsheetIndex]['mata_pelajaran']['id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['evaluasi_id'] = $excel[$spreadsheetIndex]['evaluasi']['id'];
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['tanggal_mulai'] = $evaluasiTanggalMulaiCell->format('Y-m-d');
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['tanggal_selesai'] = $evaluasiTanggalSelesaiCell->format('Y-m-d');
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['excel_raw']['tanggal_mulai'] = $evaluasiTanggalMulaiCell->format('Y-m-d');
                    $excel[$spreadsheetIndex]['r_evaluasi_kelas']['excel_raw']['tanggal_selesai'] = $evaluasiTanggalSelesaiCell->format('Y-m-d');
                }

                // Tabel siswa dan penilaian|| Row 16 dan seterusnya 
                $nisAda = true;
                $index = 0;
                while ($nisAda) {
                    
                    // Nomor Peserta || Kolom 2
                    // NIS || Kolom 3
                    // Nama || Kolom 4
                    // Jenis Kelamin || Kolom 5
                    // Nilai || Kolom 6
                    $nis_cell = $worksheet->getCellByColumnAndRow(3, $index + 16)->getValue();
                    $nama_cell = $worksheet->getCellByColumnAndRow(4, $index + 16)->getValue();
                    $jenis_kelamin_cell = $worksheet->getCellByColumnAndRow(5, $index + 16)->getValue();
                    $no_peserta_cell = $worksheet->getCellByColumnAndRow(2, $index + 16)->getValue();
                    $nilai_cell = $worksheet->getCellByColumnAndRow(6, $index + 16)->getValue();
                    
                    if ($nis_cell == '') {
                        $nisAda = false;
                        break;
                    }

                    // Data Siswa
                    $siswa = $siswaModel->find($nis_cell);
                    if (!$siswa) {
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['inserted'] = 0;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['nis'] = $nis_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['nama_lengkap'] = $nama_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['jenis_kelamin'] = $jenis_kelamin_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['jurusan_id'] = $excel[$spreadsheetIndex]['jurusan']['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['excel_raw']['nis'] = $nis_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['excel_raw']['nama_lengkap'] = $nama_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['excel_raw']['jenis_kelamin'] = $jenis_kelamin_cell;
                    }
                    else {
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['inserted'] = 1;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['nis'] = $siswa['nis'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['nama_lengkap'] = $siswa['nama_lengkap'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['jenis_kelamin'] = $siswa['jenis_kelamin'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['jurusan_id'] = $siswa['jurusan_id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['excel_raw']['nis'] = $nis_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['excel_raw']['nama_lengkap'] = $nama_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['excel_raw']['jenis_kelamin'] = $jenis_kelamin_cell;
                    }
                    


                    // Data r_anggota_kelas
                    $rAnggotaKelas = $rAnggotaKelasModel
                        ->where('siswa_nis', $nis_cell)
                        ->where('kelas_id', $excel[$spreadsheetIndex]['kelas']['id'])
                        ->first();
                    if (!$rAnggotaKelas) {
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['id'] = -1;
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['siswa_nis'] = $excel[$spreadsheetIndex]['tabel'][$index]['siswa']['nis'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['kelas_id'] = $excel[$spreadsheetIndex]['kelas']['id'];
                    }
                    else {
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['id'] = $rAnggotaKelas['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['siswa_nis'] = $rAnggotaKelas['siswa_nis'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['kelas_id'] = $rAnggotaKelas['kelas_id'];
                    }
                    
                    // Data peserta evaluasi
                    $rPesertaEvaluasi = $rPesertaEvaluasiModel
                        ->where('anggota_kelas_id', $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['id'])
                        ->where('evaluasi_kelas_id', $excel[$spreadsheetIndex]['r_evaluasi_kelas']['id'])
                        ->first();
                    if (!$rPesertaEvaluasi) {
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['id'] = -1;
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['nomor_peserta'] = $no_peserta_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['anggota_kelas_id'] = $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['evaluasi_kelas_id'] = $excel[$spreadsheetIndex]['r_evaluasi_kelas']['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['excel_raw'] = $no_peserta_cell;
                    }
                    else {
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['id'] = $rPesertaEvaluasi['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['nomor_peserta'] = $rPesertaEvaluasi['nomor_peserta'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['anggota_kelas_id'] = $rPesertaEvaluasi['anggota_kelas_id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['evaluasi_kelas_id'] = $rPesertaEvaluasi['evaluasi_kelas_id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['excel_raw'] = $no_peserta_cell;
                    }

                    // Penilaian
                    $penilaian = $penilaianModel
                        ->where('siswa_id', $excel[$spreadsheetIndex]['tabel'][$index]['r_peserta_evaluasi']['id'])
                        ->where('mata_pelajaran_id', $excel[$spreadsheetIndex]['mata_pelajaran']['id'])
                        ->where('evaluasi_kelas_Id', $excel[$spreadsheetIndex]['r_evaluasi_kelas']['id'])
                        ->first();
                    if (!$penilaian) {
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['id'] = -1;
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['siswa_id'] = $excel[$spreadsheetIndex]['tabel'][$index]['r_anggota_kelas']['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['mata_pelajaran_id'] = $excel[$spreadsheetIndex]['mata_pelajaran']['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['evaluasi_kelas_id'] = $excel[$spreadsheetIndex]['r_evaluasi_kelas']['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['nilai'] = $nilai_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['excel_raw'] = $nilai_cell;
                    }
                    else {
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['id'] = $penilaian['id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['siswa_id'] = $penilaian['siswa_id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['mata_pelajaran_id'] = $penilaian['mata_pelajaran_id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['evaluasi_kelas_id'] = $penilaian['evaluasi_kelas_id'];
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['nilai'] = $nilai_cell;
                        $excel[$spreadsheetIndex]['tabel'][$index]['penilaian']['excel_raw'] = $nilai_cell;
                    }

                    $index++;
                }
            }
            $data['excel'] = $excel;
            
            $konfigurasiModel = new \App\Models\KonfigurasiModel();
            $data['konfigurasi'] = $konfigurasiModel->showKeyValue();
            $data['userdata'] = $this->auth();
            if (!$data['userdata']) {
                return redirect()->to(site_url('logout'));
            }

            $data['ui_title'] = "Preview File Excel - Administrator" . $data['konfigurasi']['APP_JUDUL']['value_text'];
            $data['ui_sidebar'] = $this->sidebar_link;
            $data['ui_sidebar_active'] = 'Evaluasi';

            $data['ui_navbar'] = $this->navbar_link;
            $data['ui_navbar_active'] = "Penilaian";

            $data['siswaModel'] = $siswaModel;
            $data['rAnggotaKelasModel'] = $rAnggotaKelasModel;
            $data['jurusanModel'] = $jurusanModel;
            $data['kelasModel'] = $kelasModel;
            $data['mataPelajaranModel'] = $mataPelajaranModel;
            $data['evaluasiModel'] = $evaluasiModel;
            $data['rEvaluasiKelasModel'] = $rEvaluasiKelasModel;
            $data['rPesertaEvaluasiModel'] = $rPesertaEvaluasiModel;
            $data['penilaianModel'] = $penilaianModel;

            return view('admin/evaluasi/preview_excel_penilaian', $data);
        }
        else {
            $excel_json = $request->getPost('excel_json');
            $excel = json_decode($excel_json, true);
        
            foreach ($excel as $worksheet) {
                // Data Jurusan || Cell C10
                $jurusan_id = -1;
                $jurusanCell = $worksheet['jurusan']['excel_raw'];
                $jurusan = $jurusanModel->find($jurusanCell);
                if (!$jurusan) {
                    $jurusan = $jurusanModel->like("nama", $jurusanCell, "both")->first();
                    if (!$jurusan) {
                        $jurusan_id = $jurusanModel->insert([
                            "nama" => $jurusanCell
                        ]);
                    } else {
                        $jurusan_id = $jurusan['id'];
                    }
                } else {
                    $jurusan_id = $jurusan['id'];
                }

                // Data Kelas || Cell C11
                $kelas_id = -1;
                $kelasCell = $worksheet['kelas']['excel_raw'];
                $kelas = $kelasModel->find($kelasCell);
                if (!$kelas) {
                    $kelas = $kelasModel->like('nama', $kelasCell, 'both')->first();
                    if (!$kelas) {
                        $kelas_id = $kelasModel->insert([
                            "nama" => $worksheet['kelas']['excel_raw'],
                            "jurusan_id" => $jurusan_id
                        ]);
                    } else {
                        $kelas_id = $kelas['id'];
                    }
                } else {
                    $kelas_id = $kelas['id'];
                }

                // Data Mata Pelajaran || Cell C12
                $mata_pelajaran_id = -1;
                $mataPelajaranCell = $worksheet['mata_pelajaran']['excel_raw'];
                $mataPelajaran = $mataPelajaranModel->find($mataPelajaranCell);
                if (!$mataPelajaran) {
                    $mataPelajaran = $mataPelajaranModel->like('nama', $mataPelajaranCell, 'both')->first();
                    if (!$mataPelajaran) {
                        $mata_pelajaran_id = $mataPelajaranModel->insert([
                            "nama" => $mataPelajaranCell,
                            "jurusan_id" => $jurusan_id,
                        ]);
                    } 
                    else {
                        $mata_pelajaran_id = $mataPelajaran['id'];
                    }
                } else {
                    $mata_pelajaran_id = $mataPelajaran['id'];
                }

                // Data Evaluasi || Cell B7
                $evaluasi_id = -1;
                $evaluasiNama = $worksheet['evaluasi']['excel_raw'];
                $evaluasi = $evaluasiModel->like('nama', $evaluasiNama, 'both')->first();
                if (!$evaluasi) {
                    $evaluasi_id = $evaluasiModel->insert(["nama" => $evaluasiNama]);
                } else {
                    $evaluasi_id = $evaluasi['id'];
                }
                
                // Data R Evaluasi Kelas || Cell C8 dan F8
                $evaluasi_kelas_id = -1;
                $rEvaluasiKelas = $rEvaluasiKelasModel
                    ->where('kelas_id', $kelas_id)
                    ->where('evaluasi_id', $evaluasi_id)
                    ->where('mata_pelajaran_id', $mata_pelajaran_id)
                    ->first();
                if (!$rEvaluasiKelas) {
                    $evaluasi_kelas_id = $rEvaluasiKelasModel->insert([
                        "kelas_id" => $kelas_id,
                        "mata_pelajaran_id" => $mata_pelajaran_id,
                        "evaluasi_id" => $evaluasi_id,
                        "tanggal_mulai" => $worksheet['r_evaluasi_kelas']['excel_raw']['tanggal_mulai'],
                        "tanggal_selesai" => $worksheet['r_evaluasi_kelas']['excel_raw']['tanggal_selesai']
                    ]);
                } else {
                    $evaluasi_kelas_id = $rEvaluasiKelas['id'];
                }

                // echo "evaluasi_kelas_Id: " . $evaluasi_kelas_id . '<br/>';
                // die;
                

                // Tabel
                $index = -1;
                foreach ($worksheet['tabel'] as $tabel) {
                    $index++;

                    // Data Siswa
                    $siswa_nis = -1;
                    $siswa_nis_cell = $tabel['siswa']['excel_raw']['nis'];
                    $siswa = $siswaModel->find($siswa_nis_cell);
                    if (!$siswa) {
                        $siswa_nis = $siswaModel->insert([
                            'nis' => $siswa_nis_cell,
                            'nama_lengkap' => ucwords(strtolower($tabel['siswa']['excel_raw']['nama_lengkap'])),
                            'jenis_kelamin' => strtoupper($tabel['siswa']['excel_raw']['jenis_kelamin']),
                            'jurusan_id' => $jurusan_id
                        ]);
                        $siswa_nis = $siswa_nis_cell;
                    } else {
                        $siswa_nis = $siswa['nis'];
                    }
                    
                    
                    
                    // Data r_anggota_kelas
                    $anggota_kelas_id = -1;
                    $rAnggotaKelas = $rAnggotaKelasModel
                    ->where('siswa_nis', $siswa_nis)
                    ->where('kelas_id', $kelas_id)
                    ->first();
                    if (!$rAnggotaKelas) {
                        $anggota_kelas_id = $rAnggotaKelasModel->insert([
                            "siswa_nis" => $siswa_nis,
                            "kelas_id" => $kelas_id,
                        ]);
                    } else {
                        $anggota_kelas_id = $rAnggotaKelas['id'];
                    }
                    
                    
                    // Data peserta evaluasi
                    $peserta_evaluasi_id = -1;
                    $rPesertaEvaluasi = $rPesertaEvaluasiModel
                    ->where('anggota_kelas_id', $anggota_kelas_id)
                    ->where('evaluasi_kelas_id', $evaluasi_kelas_id)
                    ->first();
                    if (!$rPesertaEvaluasi) {
                        $peserta_evaluasi_id = $rPesertaEvaluasiModel->insert([
                            "nomor_peserta" => $tabel['r_peserta_evaluasi']['excel_raw'],
                            "anggota_kelas_id" => $anggota_kelas_id,
                            "evaluasi_kelas_id" => $evaluasi_kelas_id
                        ]);
                        
                    } else {
                        $peserta_evaluasi_id = $rPesertaEvaluasi['id'];
                    }
                    
                    // Penilaian
                    $penilaian_id = -1;
                    $penilaian = $penilaianModel
                        ->where('siswa_id', $peserta_evaluasi_id)
                        ->where('mata_pelajaran_id', $mata_pelajaran_id)
                        ->where('evaluasi_kelas_Id', $evaluasi_kelas_id)
                        ->first();
                    if (!$penilaian) {
                        $penilaian_id = $penilaianModel->insert([
                            "siswa_id" => $peserta_evaluasi_id,
                            "mata_pelajaran_id" => $mata_pelajaran_id,
                            "evaluasi_kelas_id" => $evaluasi_kelas_id,
                            "nilai" => $tabel['penilaian']['excel_raw']
                        ]);
                    } else {
                        $penilaian_id = $penilaianModel->update($penilaian['id'], ["nilai" => $tabel['penilaian']['excel_raw']]);
                    }   
                    $index++;
                }
            }            
            return redirect()->to(site_url('admin/evaluasi/penilaian'));
        }
    }
}

?>