<?php

//************************************************************************************
// Este modulo sirve para desplegar los mensajes que se envian desde la pagina nosotras
//a los administradosres. Brinda la capacidad de marcar los mensajes como leidos por el
//administrador par un mejor control.
//Autor: Diego Carrillo
//Fecha de creación: 04/08/2018
//Lista modificaciones
//20/08/2018 Javier Trejos
//Agregar manejo de tema actual
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelMensajes extends CI_Controller {
    
	//Inicializacion de la clase 
    public function __construct()
    {
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('url_helper');
		$this->load->helper('form'); 
		$this->load->model('Model_Usuario','',TRUE);
		$this->load->model('Model_Mensaje','',TRUE);
		$this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
		$loginstatus = $this->session->userdata('ax');
		if($loginstatus == NULL){
			redirect('Ctrl_bienvenida','refresh');
		}else{
			$rolechecker = $loginstatus['idRol'];
			$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
			$rolUsuario = $buscaRol->TIPO;
			if($rolUsuario!="ADMIN"){
				redirect('Ctrl_bienvenida','refresh');
			}
		}
    }
    //Funcion que inicia la renderizacion de la pagina 
    public function index()
    {
        $this->load->helper('html');
        $this->load->library('form_validation');
        $data['title'] = 'Mensajes';
        $estadoCambio = false; //Variable para indicar si la pagina tuvo un error de validacion y se necesita verificar los datos, el comportamiento se controlara en la vista
        
		
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
		$data['queryMensajes'] = $this->Model_Mensaje->met_traerMensajes();
		$data['queryMensajesTodos'] = $this->Model_Mensaje->met_traerMensajesTodos();
		$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        	
		$this->load->helper('html');
		$loginstatus = $this->session->userdata('ax');
		$rolechecker = $loginstatus['idRol'];
		$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
		$rolUsuario = $buscaRol->TIPO;
		if($rolUsuario=="ADMIN"){
			$this->load->view('templates/headerAdmin',$data);
		}else{
			$this->load->view('templates/headerUsuario',$data);
		}
		$this->load->view('pages/vis_panelMensajes',$data);
		$this->load->view('templates/footer',$data);

        

    }

    //funcion que actualiza el estado de un mensaje de No leido a leido
	public function met_marcarLeido(){
		$mensajeIdAtController = $_POST['cedulaJSON'];
		$reply = $this->Model_Mensaje->met_cambiarEstado($mensajeIdAtController);
		if($reply){
			echo json_encode($reply);
		}else{
			echo false;
		}
	}
    
}
