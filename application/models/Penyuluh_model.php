<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Penyuluh_model extends CI_Model
{
	var $api_key = 'f13914d292b53b10936b7a7d1d6f2406';
	var $api_url = 'https://api.pertanian.go.id/api/';
	
	public function getmetode(){
		$this->db->order_by('metode_id','asc');
		return $this->db->get('tb_metode')->result_array();
	}
	
	public function getteknologi(){
		$this->db->order_by('teknologi_id','asc');
		return $this->db->get('tb_teknologi')->result_array();
	}
	
	public function getusaha(){
		$this->db->order_by('usaha_id','asc');
		return $this->db->get('tb_usaha')->result_array();
	}
	
	public function getkomoditas($id=""){
		if ($id <> "")
			$this->db->where('komoditas_id',$id);
		$this->db->order_by('komoditas_id','asc');
		return $this->db->get('tb_komoditas')->result_array();
	}
	
	public function getkecamatan($kode=""){
		$this->db->like('kd_kec',$kode, 'after');
		$this->db->order_by('kd_kec','asc');
		return $this->db->get('tblm_kec')->result_array();
	}
	
	public function getdesabykecamatan($kode=""){
		$this->db->like('kd_desa',$kode, 'after');
		$this->db->order_by('kd_desa','asc');
		return $this->db->get('tblm_desa')->result_array();
	}
	
	
	public function getdiseminasi($nip=""){
		$this->db->where('penyuluh_nip',$nip);
		$this->db->join('tb_metode b','b.metode_id = a.metode');
		$this->db->join('tb_teknologi c','c.teknologi_id = a.kategori_teknologi');
		$this->db->order_by('a.id','asc');
		return $this->db->get('tr_diseminasi_teknologi a')->result_array();
	}
	
    public function getPenyuluhbysatminkal($kode='',$search="x")
    {
		//echo $this->api_url.'simantap/penyuluhbysatminkal/list?kode='.$kode.'&search='.$search.'&api-key='.$this->api_key;die();
		$pencarian = ($search == '') ? '': '&search='.$search.'';
		$json = file_get_contents($this->api_url.'simantap/penyuluhbysatminkal/list?kode='.$kode.$pencarian.'&api-key='.$this->api_key);
		//echo $this->api_url.'simantap/penyuluhbysatminkal/list?satminkal='.$satminkal.'&start='.$start.'&length='.$length.'&api-key='.$this->api_key;die();
		return json_decode($json,true);
    }
	
	public function getPenyuluhbynip($nip='')
    {
		$json = file_get_contents($this->api_url.'simantap/detailpenyuluh/list?nip='.$nip.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	public function getWilker($wilker='')
    {
		$json = file_get_contents($this->api_url.'simantap/getwilker/list?wilker='.$wilker.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	public function getPoktan($wilker='')
    {
		$json = file_get_contents($this->api_url.'simantap/getpoktan/list?wilker='.$wilker.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	public function getPoktanbykab($kab='',$search="x")
    {
		$pencarian = ($search == '') ? '': '&search='.$search.'';
		$json = file_get_contents($this->api_url.'simantap/getpoktanbykab/list?kode='.$kab.$pencarian.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	
	 public function getPenyuluhbyid($id='')
    {
		$json = file_get_contents($this->api_url.'simantap/detailpenyuluhbyid/list?id='.$id.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	 public function getjumpoktananggota($id='')
    {
		$json = file_get_contents($this->api_url.'simantap/getjumpoktananggota/list?id='.$id.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	public function getPoktanbyid($id='')
    {
		$json = file_get_contents($this->api_url.'simantap/getpoktanbyid/list?id='.$id.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	public function getPenilaianPoktanbyid($id='')
    {
		$json = file_get_contents($this->api_url.'simantap/getpenilaianpoktanbyid/list?id='.$id.'&api-key='.$this->api_key);
		return json_decode($json,true);
    }
	
	public function getPenilaianPoktanbyidtahun($id='',$tahun="")
    {
		$json = file_get_contents($this->api_url.'simantap/getpenilaianpoktanbyidtahun/list?id='.$id.'&tahun='.$tahun.'&api-key='.$this->api_key);
		//print_r($json);die();
		return json_decode($json,true);
    }
	
	public function getPenilaianSimantap($id=""){
		$this->db->select('a.*, b.kelas_nama as kelasawal, c.kelas_nama as kelasakhir');
		$this->db->join('tb_kelaskelompok c','a.kelas_kelompok_akhir_tahun = c.kelas_id');
		$this->db->join('tb_kelaskelompok b','a.kelas_kelompok_awal_tahun = b.kelas_id','left');
		$this->db->order_by('tahun','asc');
		$this->db->where('kelompok_id',$id);
		$this->db->where('status','1');
		return $this->db->get('tr_penilaian_kelas_kelompok a')->result_array();
	}
	
	public function getpetanimilenial($param=array()){
		//$this->db->join('tblm_prov b','b.kd_prov = a.kode_prop');
		//$this->db->join('tblm_kab c','c.kd_kab = a.kode_kab');
		$this->db->join('tblm_kec d','d.kd_kec = a.kode_kec');
		$this->db->join('tblm_desa e','e.kd_desa = a.kode_desa');
		$this->db->join('tb_usaha f','f.usaha_id = a.jenis_usaha');
		$this->db->where('a.status','1');
		if (! empty($param['id']))
			$this->db->where('a.id',$param['id']);
		if (! empty($param['kab']))
			$this->db->where('a.kode_kab',$param['kab']);
		if ((! empty($param['search'])) && (trim($param['search']) <> ''))
			$this->db->like('nama', $param['search'], 'both');
		if (! empty($param['start']))
			$this->db->limit($param['length'],$param['start']);
		return $this->db->get('tr_petani_milenial_binaan a')->result_array();
	}
	
	public function getproduksi($param=array()){
		//$this->db->join('tblm_prov b','b.kd_prov = a.kode_prop');
		//$this->db->join('tblm_kab c','c.kd_kab = a.kode_kab');
		$this->db->join('tblm_kec d','d.kd_kec = a.kode_kec');
		$this->db->join('tblm_desa e','e.kd_desa = a.kode_desa');
		$this->db->join('tb_komoditas k','k.komoditas_id = a.komoditas_id');
		$this->db->where('a.status','1');
		if (! empty($param['id']))
			$this->db->where('a.id',$param['id']);
		if (! empty($param['kab']))
			$this->db->where('a.kode_kab',$param['kab']);
		if ((! empty($param['search'])) && (trim($param['search']) <> '')){
			$this->db->like('nm_kec', $param['search'], 'both');
			$this->db->or_like('nm_desa', $param['search'], 'both');
		}
		if (! empty($param['start']))
			$this->db->limit($param['length'],$param['start']);
		$db =  $this->db->get('tr_peningkatan_produksi_wilker a');
		//print_r($this->db->last_query());
		return $db->result_array();
	}
}
