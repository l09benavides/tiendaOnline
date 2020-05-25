<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_sugerencias extends CI_Controller {

	public function __construct()
        {
			parent::__construct();
			$this->load->helper('url_helper');
            $this->load->model('Model_Producto','',TRUE);
            $this->load->model('Model_Usuario','',TRUE);
			$this->load->model('Model_Imagen','',TRUE);
            $this->load->model('Model_TemaActual','',TRUE);
        }

	public function index()
	{
		$session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/vis_sugerencias',$data);
            $this->load->view('templates/footer',$data);
        }else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/vis_sugerencias',$data);
                $this->load->view('templates/footer',$data);
            }else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/vis_sugerencias',$data);
                $this->load->view('templates/footer',$data);
            }
        }
	}

	
}


