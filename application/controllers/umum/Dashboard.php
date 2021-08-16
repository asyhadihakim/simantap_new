<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //  $this->load->model('Wilayah_model', 'wilayah');
        //is_logged_in();
    }

    public function publik()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'pages/dashboard'
        ];
        $this->load->view('templates/main_template', $data);
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil Penyuluh',
            'content' => 'pages/profil'
        ];
        $this->load->view('templates/main_template', $data);
    }

    public function oke()
    {
        echo 'ok 321';
    }

    public function Pusatgerakanpembangunan()
    {
        redirect(site_url('kinerjaBPP/PgppBpp'));
    }
}
