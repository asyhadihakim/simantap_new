<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyuluh extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();   
        $this->load->model('Wilayah_model', 'wilayah');     
        $this->load->model('Penyuluh_model', 'penyuluh');
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
				$content .= '<td scope="row" align="center"><a href="#">ubah</a> <a href="#">hapus</a></td>';
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
		$kode='3404'; //disesuaikan dengan daerahnya
		  
		//$draw = intval($this->input->get("draw"));
        //$start = intval($this->input->get("start"));
        //$length = intval($this->input->get("length"));
		//print_r($_POST);die();
		$draw=1;
		$start=0;
		$length=30;
		
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
		
		$jumrecord = count($this->penyuluh->getPenyuluhbysatminkal($kode));
		$postdata = http_build_query(
			array(
				'satminkal' => $kode,
				'start' => $start,
				'length' => $length,
				'api-key' => 'f13914d292b53b10936b7a7d1d6f2406',
			)
		);
		//print_r($_POST);die();
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
		//print_r(json_decode$penyuluh);die();
		
		$data = array();
		
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
				$no,
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
			//print_r($data);die();	
          $output = array(
               //"draw" => $draw,
			   "draw" => $draw,
                 "recordsTotal" => $jumrecord,
                 "recordsFiltered" => $jumrecord,
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
			 return 1;
		 else
			 return 0;

	 }
	 
	 function getanggotapoktan($idpoktan=""){
		$data = $this->penyuluh->getjumpoktananggota($idpoktan);
		
		die($data['jumanggota']);

	}
	 
}
