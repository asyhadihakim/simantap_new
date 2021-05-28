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
	
    public function getPenyuluhbysatminkal($satminkal='3404',$start="",$length="")
    {
		$json = file_get_contents($this->api_url.'simantap/penyuluhbysatminkal/list?satminkal='.$satminkal.'&start='.$start.'&length='.$length.'&api-key='.$this->api_key);
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
	
}
