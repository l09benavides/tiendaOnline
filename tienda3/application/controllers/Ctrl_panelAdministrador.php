<?php
//**************************************************************************************
//Este controller es utilizado para mostrar el panel de ADministracion para el adminisrtador
//Autor: Javier Trejos
//Fecha de Creación: 18/10/2018 
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelAdministrador extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
                
                $loginstatus = $this->session->userdata('ax');
                $rolechecker = $loginstatus['idRol'];
                $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
    			$rolUsuario = $buscaRol->TIPO;
                if($rolUsuario!="ADMIN"){
                    redirect('Ctrl_bienvenida','refresh');
                }
        }

    //Carga la pagina de administracion
	public function index()
	{
		if($this->session->userdata('ax')){
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			$this->load->helper('html');
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/opcionesadmin',$data);
			$this->load->view('templates/footer',$data);
		}else{
			redirect('Ctrl_bienvenida','refresh');
		}
	}
	
	//Cierra sesion
	public function met_logout(){
	   $this->session->unset_userdata('ax');
	   session_destroy();
	   redirect('Ctrl_bienvenida', 'refresh');
	 }
	
}
