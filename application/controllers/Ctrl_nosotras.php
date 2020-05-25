<?php
//************************************************************************************
//Este controlador sirve para cambiar los temas de colores en nosotras ya sea para un  
//usuario administrador o normal. 
//se comunica con los siguientes archivos:
//-Model_Usuario.php
//-Model_Imagen.php
//-Model_TemaActual.php
//-vis_nosotras.php
//Autor: Javier Trejos
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************


//funciones para llamar los colores, imagenes y sesiones de usuario
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_nosotras extends CI_Controller {

	public function __construct()
        {
			parent::__construct();
			$this->load->helper('url_helper');
            $this->load->model('Model_Producto','',TRUE);
            $this->load->model('Model_Usuario','',TRUE);
			$this->load->model('Model_Imagen','',TRUE);
            $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
        }

	public function index(){
		
		$session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
		$data['listaImagenesNosotras'] = $this->Model_Imagen->met_traerImagenesNosotras();

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/vis_nosotras',$data);
            $this->load->view('templates/footer',$data);
        }else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/vis_nosotras',$data);
                $this->load->view('templates/footer',$data);
            }else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/vis_nosotras',$data);
                $this->load->view('templates/footer',$data);
            }
        }
	}

	
}


