<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyuluh extends CI_Controller
{
	var $kode;
    public function __construct()
    {
        parent::__construct();   
        $this->load->model('Wilayah_model', 'wilayah');     
        $this->load->model('Penyuluh_model', 'penyuluh');
		$this->kode = '3404';
		//$this->output->enable_profiler();
    }

    public function index(){

        $this->Aktivitasbulanan();
    }
	
	public function detail($id="")
    {
		$list = $this->penyuluh->getPenyuluhbyid($id);
		$dt = $list[0];
		
		$myDateTime = DateTime::createFromFormat('Y-m-d', $dt['tgl_lahir']);
		$formatted = $myDateTime->format('d-m-Y');
		$dt['ttl'] = $dt['tempat_lahir'].', '.$formatted;
		switch ($dt['jenis_kelamin']){
			case 1 : $dt['jenkel']="Pria";break;
			case 2 : $dt['jenkel']="Wanita";break;			
			default : $dt['jenkel']="";break;
		}
		
		
		switch ($dt['kode_kab']){
			case 4 : $dt['penempatan']="Kecamatan";break;
			case 3 : $dt['penempatan']="Kabupaten";break;
			case 2 : $dt['penempatan']="Provinsi";break;
			default : $dt['penempatan']="";break;
		}
		
		switch ($dt['status']) {
			case 0 : $dt['stat'] = 'PNS Aktif';break;
			case 6 : $dt['stats'] = 'Tugas Belajar';break;
			case 7 : $dt['stat'] = 'CPNS';break;
			default : $dt['stat'] = '';break;
		}
		$w = '';
		$desa = array();
		foreach ($dt['wilker'] as $k => $v){
			$w .= $v['nm_desa'];
			$desa[] = $v['id_desa'];
		}
		$dt['wilkerja'] = $w;
		$dt['unker'] = (($dt['kode_kab'] == '3') ? $dt['namabapel'] : $dt['namabpp']);
        $data['profil'] = $dt;
		
		$iddesa = implode('m',$desa);
		$getpoktan = $this->penyuluh->getPoktan($iddesa);
		$opsipoktan = "<option value=''>-pilih poktan-</option>";
		foreach ($getpoktan as $p)
			$opsipoktan .= "<option value='".$p['id_poktan'].'xx'.$p['nama_poktan']."'>".$p['nama_poktan']."</option>";		
		$data['poktan'] = $opsipoktan;
		
		$getmetode = $this->penyuluh->getmetode();
		$opsimetode = "<option value=''>-pilih metode-</option>";
		foreach ($getmetode as $m)
			$opsimetode .= "<option value='".$m['metode_id']."'>".$m['metode_nama']."</option>";
		$data['metode'] = $opsimetode;
		
		$getteknologi = $this->penyuluh->getteknologi();
		$opsiteknologi = "<option value=''>-pilih teknologi-</option>";
		foreach ($getteknologi as $t)
			$opsiteknologi .= "<option value='".$t['teknologi_id']."'>".$t['teknologi_nama']."</option>";
		$data['teknologi'] = $opsiteknologi;
		
		$bulan = array('1'=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); 
		$tabel = $this->penyuluh->getdiseminasi($dt['nip']);
		$content = '';
		if (count($tabel) > 0){
			$no=1;
			
			foreach ($tabel as $t){
				$content .= '<tr>';
				$content .= '<td scope="row" align="center">'.$no++.'</td>';
				$content .= '<td scope="row" align="center">'.$bulan[$t['bulan']].' '.$t['tahun'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['kelompok_nama'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['metode_nama'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['teknologi_nama'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['nama_teknologi'].'</td>';
				$content .= '<td scope="row" align="center"><a style="color:#fff" title="Edit Data" id="popup" class="btn btn-info btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="showubah('.$t['id'].')"><i class="fas  fa-edit"></i></a> <a style="color:#fff" title="Edit Data" id="popup" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="showhapus('.$t['id'].')"><i class="fas  fa-trash"></a></td>';
				$content .= '</tr>';
			}
		}
		else
			$content .= '<tr><td scope="row" colspan="7" align="center"> Belum ada data </td></tr>';
		$data['tabel'] = $content;

		echo json_encode($data);
    }

   public function Aktivitasbulanan(){
		$data['title'] = 'Aktivitas Bulanan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('penyuluh/profil', $data);
		$this->load->view('templates/footer');
   }
		    
	public function penyuluh_data()
    {
		$kode=$this->kode; //disesuaikan dengan daerahnya
		  
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
		$search = $this->input->post("search_keywords");
		
		$search = str_replace(' ','xxx',$search);
		
		$jumrecord = $this->penyuluh->getPenyuluhbysatminkal($kode,$search);
		
		//print_r($_POST);die();
		$pencarian = array(
				'kode' => $kode,
				'start' => $start,
				'length' => $length,				
				'api-key' => 'f13914d292b53b10936b7a7d1d6f2406',
			);
		if ($search <> "")
			$pencarian['search'] = $search;
		
		$postdata = http_build_query(
			$pencarian
		);
		//print_r($postdata);die();
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);
		$result = file_get_contents('https://api.pertanian.go.id/api/simantap/penyuluhbysatminkal/list', false, $context);		
		$penyuluh = json_decode($result,true);
		
		$data = array();
		//print_r($result);die();
		$no = 1;
        foreach($penyuluh as $p) {
		  	$myDateTime = DateTime::createFromFormat('Y-m-d', $p['tgl_lahir']);
			$formatted = $myDateTime->format('d-m-Y');
			switch ($p['status']) {
				case 0 : $status = 'Aktif';break;
				case 6 : $status = 'Tugas Belajar';break;
				case 7 : $status = 'CPNS';break;
				default : $status = '';break;
			}
			
			
			
            $data[$no-1] = array(
				$start+$no,
				$p['namalengkap'].'<br />'.$p['nip'],
                $p['tempat_lahir'].', '.$formatted,
                (($p['kode_kab'] == '3') ? $p['bapel'] : $p['nama_bpp']),
                implode('<br />',$p['dtwilker']),			
				$p['jumpoktan'],
				'<a style="color:#fff" title="Detail Penyuluh" id="popup" class="btn btn-primary mb-3" data-toggle="modal" style="cursor: pointer;" onclick="viewdetail('.$p['idpns'].')">Detail</a>
				'
               );
			   //<a style="color:#fff" title="Aktivitas Bulanan" id="popup" class="btn btn-primary mb-3" data-toggle="modal" style="cursor: pointer;" onclick="viewaktivitas('.$idwil.')">Aktivitas Bulanan</a>
			   
			$no++;
          }
          $output = array(
               //"draw" => $draw,
			   "draw" => $draw,
                 "recordsTotal" => $jumrecord[0]['jumlahpenyuluh'],
                 "recordsFiltered" => $jumrecord[0]['jumlahpenyuluh'],
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 function simpanaktivitas(){
		 $periode = explode('-',$this->input->post('periode'));
		 $kelompok = explode('xx',$this->input->post('poktan'));
		 
		 $dt=array(
			'kelompok_id'=>$kelompok[0],
			'kelompok_nama'=>$kelompok[1],
			'tahun'=>$periode[1],
			'bulan'=>$periode[0],
			'jumlah_anggota'=>$this->input->post('jumlahanggota'),
			'metode'=>$this->input->post('metode'),
			'kategori_teknologi'=>$this->input->post('teknologi_kategori'),
			'nama_teknologi'=>$this->input->post('teknologi_nama'),
			'date'=>date('Y-m-d H:i:s'),
			'penyuluh_nip'=>$this->input->post('penyuluh_nip'),
		 );
		 
		 $this->db->insert('tr_diseminasi_teknologi',$dt);
		 //echo $this->db->last_query();die();
		  if ($this->db->affected_rows() > 0)
			return json_encode(array("status"=>"success","tabel"=>$tabel));
		 else
			return json_encode(array("status"=>"error"));

	 }
	 
	function getanggotapoktan($idpoktan=""){
		$data = $this->penyuluh->getjumpoktananggota($idpoktan);
		
		die($data['jumanggota']);

	}
	
	function getdesabykecamatan($kodekec=""){
		$txt = '';
		$data = $this->penyuluh->getdesabykecamatan($kodekec);
		$txt .= "<option value=''>-pilih desa-</option>";
		foreach ($data as $d)
			$txt .= "<option value='".$d["kd_desa"]."'>".$d["nm_desa"]."</option>";
		
		die($txt);

	}
	 
	 public function Penilaiankelaskelompok(){
		$data['title'] = 'Penilaian Kelas Kelompok';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('penyuluh/kelaskelompok', $data);
		$this->load->view('templates/footer');
   }
   
   public function poktan_data()
    {
		$kode=$this->kode; //disesuaikan dengan daerahnya
		  
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
		$search = $this->input->post("search_keywords");
		
		$search = str_replace(' ','xxx',$search);
		
		$jumrecord = $this->penyuluh->getPoktanbykab($kode,$search);
		
		$pencarian = array(
				'kode' => $kode,
				'start' => $start,
				'length' => $length,
				
				'api-key' => 'f13914d292b53b10936b7a7d1d6f2406',
			);
		if ($search <> "")
			$pencarian['search'] = $search;
		
		$postdata = http_build_query(
			$pencarian
		);
		//print_r($_POST);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$context  = stream_context_create($opts);
		$result = file_get_contents('https://api.pertanian.go.id/api/simantap/getpoktanbykab/list', false, $context);		
		$poktan = json_decode($result,true);
		
		$data = array();
		
		$no = 1;

        foreach($poktan as $p) {
		  	
            $data[$no-1] = array(
				$start+$no,
				$p['nama_poktan'],
                $p['nm_kec'],
                $p['nm_desa'],
                $p['ketua_poktan'],	
				'<a style="color:#fff" title="Detail Poktan" id="popup" class="btn btn-primary mb-3" data-toggle="modal" style="cursor: pointer;" onclick="viewdetail('.$p['id_poktan'].')">Detail</a>
				
				'				
               );
			$no++;
          }
			//print_r($data);die();	
          $output = array(
			   "draw" => $draw,
                 "recordsTotal" => $jumrecord[0]['jumlahpoktan'],
                 "recordsFiltered" => $jumrecord[0]['jumlahpoktan'],
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	public function poktandetail($id="")
    {
		$list = $this->penyuluh->getPoktanbyid($id);
		$dt = $list[0];

		$data['tabel'] = $this->showtabelkelompok($id);
		$data['curyear'] = $this->penyuluh->getPenilaianPoktanbyidtahun($id,date('Y'));
		$data['datapoktan'] = $dt;
		$data['idpoktan'] = $id;
		echo json_encode($data);
    }
	
	function simpanpenilaian(){
		 switch ($this->input->post('kelasawal')){
			 case 'pemula' : $kelasawal = '1';break;
			 case 'lanjut' : $kelasawal = '2';break;
			 case 'madya' : $kelasawal = '3';break;
			 case 'utama' : $kelasawal = '4';break;
			 default : $kelasawal = '';break;
		 }
		 if ($this->input->post('skorakhir') > 1000)
			$kelasakhir = "";
		 elseif ($this->input->post('skorakhir') > 700)
			$kelasakhir = "4";
		 elseif ($this->input->post('skorakhir') > 455)
			$kelasakhir = "3";
		 elseif ($this->input->post('skorakhir') > 245)
			$kelasakhir = "2";
		 else
			 $kelasakhir = "1";
			
		 $dt=array(
			'kelompok_id'=>$this->input->post('idpoktan'),
			'kelompok_nama'=>$this->input->post('namapoktan'),
			'tahun'=>$this->input->post('tahun'),
			'skor_kelas_awal_tahun'=>$this->input->post('skorawal'),
			'kelas_kelompok_awal_tahun'=>$kelasawal,
			'skor_kelas_akhir_tahun'=>$this->input->post('skorakhir'),
			'kelas_kelompok_akhir_tahun'=>$kelasakhir,
			'date'=>date('Y-m-d H:i:s'),
		 );
		 
		 $this->db->insert('tr_penilaian_kelas_kelompok',$dt);
		//update tabel
		$tabel = $this->showtabelkelompok($this->input->post('idpoktan'));
		 if ($this->db->affected_rows() > 0)
			return json_encode(array("status"=>"success","tabel"=>$tabel));
		 else
			return json_encode(array("status"=>"error"));

	 }
	 
	 public function ajax_hapuskelompok($id)
    {
		if ($id == "") return false;
		//get id poktan
		$id_poktan = $this->db->get_where("tr_penilaian_kelas_kelompok",array('id'=>$id))->row()->kelompok_id;
		//ubah status 
		$this->db->update("tr_penilaian_kelas_kelompok",array("status"=>'0'),array('id'=>$id));
		//update tabel
		$tabel = $this->showtabelkelompok($id_poktan);
		echo json_encode(array("status" => TRUE,"tabel"=>$tabel));
	}
	
	function showtabelkelompok($id_poktan){
		$no=1;
		$content = '';
		$penilaian = $this->penyuluh->getPenilaianPoktanbyid($id_poktan);
		$penilaiansimantap = $this->penyuluh->getPenilaianSimantap($id_poktan);
		$content = '';

		if ($penilaian[0] <> 'none'){
			foreach ($penilaian as $t){
				$content .= '<tr>';
				$content .= '<td scope="row" align="center">'.$no++.'</td>';
				$content .= '<td scope="row" align="center">'.$t['tahun'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['kelas'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['skor'].'</td>';
				$content .= '<td scope="row" align="center">SIMLUH</td>';
				$content .= '<td scope="row" align="center">&nbsp;</td>';
				$content .= '</tr>';
			}
		}
		
		if (count($penilaiansimantap) > 0){			
			foreach ($penilaiansimantap as $t){
				$content .= '<tr>';
				$content .= '<td scope="row" align="center">'.$no++.'</td>';
				$content .= '<td scope="row" align="center">'.$t['tahun'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['kelasakhir'].'</td>';
				$content .= '<td scope="row" align="center">'.$t['skor_kelas_akhir_tahun'].'</td>';
				$content .= '<td scope="row" align="center">SIMANTAP</td>';
				$content .= '<td scope="row" align="center"><a style="color:#fff" title="Edit Data" id="popup" class="btn btn-info btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="showubah('.$t['id'].')"><i class="fas  fa-edit"></i></a> <a style="color:#fff" title="Edit Data" id="popup" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="showhapus('.$t['id'].')"><i class="fas  fa-trash"></a></td>';
				$content .= '</tr>';
			}
		}		
		if ($content == '')
			$content = '<tr><td scope="row" colspan="6" align="center"> Belum ada data </td></tr>';
		return $content;
	}
	 
	 
	 
	public function Petanimilenialbinaan(){
		$data['title'] = 'Petani Milenial Binaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['usaha'] = $this->penyuluh->getusaha();
		$data['kecamatan'] = $this->penyuluh->getkecamatan($this->kode);
        //print_r($this->db->last_query());die();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('penyuluh/petanimilenial', $data);
		$this->load->view('templates/footer');
   }
   
    public function milenial_data()
    {
		$kode=$this->kode; //disesuaikan dengan daerahnya
		  
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
		$search = $this->input->post("search_keywords");
		
		
		$jumrecord = count($this->penyuluh->getpetanimilenial(array("kab"=>$kode,"search"=>$search)));
		$milenial = $this->penyuluh->getpetanimilenial(array("kab"=>$kode,'start'=>$start,'length'=>$length,"search"=>$search));
		
		$data = array();		
		$no = 1;
        foreach($milenial as $p) {		  	
            $data[$no-1] = array(
				$start+$no,
				$p['nama'].'<br />'.$p['nik'],
                $p['nm_kec'],
                $p['nm_desa'],
                $p['alamat_usaha'],	
				$p['usaha_nama'],
				$p['detail_usaha'],				
				'<a style="color:#fff" title="Edit Data" id="popup" class="btn btn-info btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="viewdetail('.$p['id'].')"><i class="fas  fa-edit"></i></a> <a style="color:#fff" title="Edit Data" id="popup" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="showhapus('.$p['id'].')"><i class="fas  fa-trash"></a>'
               );
			$no++;
          }
			//print_r($data);die();	
          $output = array(
			   "draw" => $draw,
                 "recordsTotal" => $jumrecord,
                 "recordsFiltered" => $jumrecord,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	function simpanmilenial(){
		 $prop = substr($this->kode,0,2);
		 $kab = $this->kode;
		 $kec = $this->input->post('kecamatan');
		 $desa = $this->input->post('desa');
		 $dt=array(
			'kode_prop'=>$prop,
			'kode_kab'=>$kab,
			'kode_kec'=>$kec,
			'kode_desa'=>$desa,
			'nama'=>$this->input->post('nama'),
			'nik'=>$this->input->post('nik'),
			'alamat_usaha'=>$this->input->post('alamat'),
			'jenis_usaha'=>$this->input->post('usaha'),
			'detail_usaha'=>$this->input->post('detail')
		 );
		 
		 if (! empty($this->input->post('id')) || ($this->input->post('id') <> ''))
			$this->db->update('tr_petani_milenial_binaan',$dt,array("id"=>$this->input->post('id')));
		 else {
			 $dt['date'] = date('Y-m-d H:i:s');
			 $this->db->insert('tr_petani_milenial_binaan',$dt);
		 }
		
		 if ($this->db->affected_rows() > 0)
			 return "success";
		 else
			 return "error";
	 }
	 
	public function milenialdetail($id="")
    {
		$data = array();
		$list = $this->penyuluh->getpetanimilenial(array('id'=>$id));
		$data["detail"] = $list[0]; 
		
		$txt = '';
		$q = $this->penyuluh->getdesabykecamatan($list[0]['kode_kec']);
		$txt .= "<option value=''>-pilih desa-</option>";
		foreach ($q as $d)
			$txt .= "<option value='".$d["kd_desa"]."' ".(($d["kd_desa"] == $list[0]['kode_desa']) ? ' selected="selected" ' : '' ).">".$d["nm_desa"]."</option>";
		
		$data["desa"] = $txt;
		
		echo json_encode($data);
    }
	
	public function ajax_hapusmilenial($id)
    {
		if ($id == "") return false;
		$this->db->update("tr_petani_milenial_binaan",array("status"=>'0'),array('id'=>$id));
		echo json_encode(array("status" => TRUE));
	}
	
	public function Peningkatanproduksi(){
		$data['title'] = 'Peningkatan Produksi di Wilayah Kerja';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['komoditas'] = $this->penyuluh->getkomoditas();
		$data['kecamatan'] = $this->penyuluh->getkecamatan($this->kode);
        //print_r($this->db->last_query());die();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('penyuluh/produksi', $data);
		$this->load->view('templates/footer');
   }
   
   public function produksi_data()
    {
		$kode=$this->kode; //disesuaikan dengan daerahnya
		  
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
		$search = $this->input->post("search_keywords");
		
		
		$jumrecord = count($this->penyuluh->getproduksi(array("kab"=>$kode,"search"=>$search)));
		$produksi = $this->penyuluh->getproduksi(array("kab"=>$kode,'start'=>$start,'length'=>$length,"search"=>$search));
		
		$data = array();		
		$no = 1;
        foreach($produksi as $p) {		  	
            $data[$no-1] = array(
				$start+$no,				
                $p['nm_kec'],
                $p['nm_desa'],
				$p['komoditas_nama'],
                $p['tahun'],	
				($p['komoditas_subsektor_id'] == "4") ? "" : $p['produksi_awal'],
				($p['komoditas_subsektor_id'] <> "4") ? "" : $p['populasi_awal'],				
				($p['komoditas_subsektor_id'] == "4") ? "" : $p['produktivitas_awal'],				
				($p['komoditas_subsektor_id'] == "4") ? "" :$p['produksi_akhir'],
				($p['komoditas_subsektor_id'] <> "4") ? "" :$p['populasi_akhir'],				
				($p['komoditas_subsektor_id'] == "4") ? "" :$p['produktivitas_akhir'],				
				'<a style="color:#fff" title="Edit Data" id="popup" class="btn btn-info btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="viewdetail('.$p['id'].')"><i class="fas  fa-edit"></i></a> <a style="color:#fff" title="Edit Data" id="popup" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" style="cursor: pointer;" onclick="showhapus('.$p['id'].')"><i class="fas  fa-trash"></a>'
               );
			$no++;
          }
			//print_r($data);die();	
          $output = array(
			   "draw" => $draw,
                 "recordsTotal" => $jumrecord,
                 "recordsFiltered" => $jumrecord,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 function getopsiproduksi($komoditas=""){
		$txt = '';
		if ($komoditas <> "") {
			$data = $this->penyuluh->getkomoditas($komoditas);		
			die($data[0]['komoditas_subsektor_id']);
		}
		else 
			die(0);
	}
	
	public function produksidetail($id="")
    {
		$data = array();
		$list = $this->penyuluh->getproduksi(array('id'=>$id));
		$data["detail"] = $list[0]; 
		
		$txt = '';
		$q = $this->penyuluh->getdesabykecamatan($list[0]['kode_kec']);
		$txt .= "<option value=''>-pilih desa-</option>";
		foreach ($q as $d)
			$txt .= "<option value='".$d["kd_desa"]."' ".(($d["kd_desa"] == $list[0]['kode_desa']) ? ' selected="selected" ' : '' ).">".$d["nm_desa"]."</option>";
		
		$data["desa"] = $txt;
		
		echo json_encode($data);
    }
	
	function simpanproduksi(){
		 $prop = substr($this->kode,0,2);
		 $kab = $this->kode;
		 $kec = $this->input->post('kecamatan');
		 $desa = $this->input->post('desa');
		 $dt=array(
			'kode_prop'=>$prop,
			'kode_kab'=>$kab,
			'kode_kec'=>$kec,
			'kode_desa'=>$desa,
			'komoditas_id'=>$this->input->post('komoditas'),
			'tahun'=>$this->input->post('tahun'),
			'produksi_awal'=>$this->input->post('produksi_awal'),
			'populasi_awal'=>$this->input->post('populasi_awal'),
			'produktivitas_awal'=>$this->input->post('produktivitas_awal'),
			'produksi_akhir'=>$this->input->post('produksi_akhir'),
			'populasi_akhir'=>$this->input->post('populasi_akhir'),
			'produktivitas_akhir'=>$this->input->post('produktivitas_akhir')
		 );
		 
		 if (! empty($this->input->post('id')) || ($this->input->post('id') <> ''))
			$this->db->update('tr_peningkatan_produksi_wilker',$dt,array("id"=>$this->input->post('id')));
		 else {
			 $dt['date'] = date('Y-m-d H:i:s');
			 $this->db->insert('tr_peningkatan_produksi_wilker',$dt);
		 }
		//print_r($this->db->last_query());die();
		 if ($this->db->affected_rows() > 0)
			 return "success";
		 else
			 return "error";
	 }
	 
	 public function ajax_hapusproduksi($id)
    {
		if ($id == "") return false;
		$this->db->update("tr_peningkatan_produksi_wilker",array("status"=>'0'),array('id'=>$id));
		echo json_encode(array("status" => TRUE));
	}
}
