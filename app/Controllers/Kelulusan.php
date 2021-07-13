<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class Kelulusan extends Controller {

    protected $sidebar;

	function __construct() {
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
		$this->sidebar = $navbar_converted;
	}

    public function cetak_kelulusan()
    {
        $konfigurasiModel = new \App\Models\KonfigurasiModel();
		$data['konfigurasi'] = $konfigurasiModel->showKeyValue();
		$data['ui_title'] = "Cetak surat kelulusan" . $data['konfigurasi']['APP_JUDUL']['value'];
		$data['ui_container'] = 'container';
		$data['ui_navbar'] = $this->sidebar;
        $data['ui_background_image'] = site_url('images/pattern-paper.jpg');
        $jurusanModel = new \App\Models\JurusanModel();
        $data['data_jurusan'] = $jurusanModel->orderBy('nama')->findAll();

		$kelasModel = new \App\Models\KelasModel();
        $data['data_kelas'] = $kelasModel->orderBy('nama')->findAll();

        $siswaModel = new \App\Models\SiswaModel();
        $data['data_tahun_masuk'] = $siswaModel->select('DISTINCT(`tahun_masuk`)')->where('tahun_masuk !=', '')->where('tahun_masuk IS NOT NULL')->findAll();

		return view('kelulusan/surat_kelulusan/index', $data);
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
			$siswaModel = new \App\Models\SiswaModel();

			$data['limit'] = $request->getGet('limit');
			$data['page'] = $request->getGet('page');
			$data['offset'] = ($data['page'] - 1) * $data['limit'];
			
			$pencarian = $request->getGet('pencarian');
			$cari_berdasarkan = $request->getGet('cari_berdasarkan');
			if ($pencarian != '') {
				if ($cari_berdasarkan != '') $cari_berdasarkan == 'nisn';
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

			return view('kelulusan/surat_kelulusan/ajax/' . $ui, $data);
		}
	}

}
?>