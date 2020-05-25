<?php
//************************************************************************************
/*Este controlador forma parte del módulo de Login, contiene los métodos que permiten acceso a las vistas relacionadas con la página de ingreso de credenciales, permite además comunicación y transferencia de información con los modelos que tienen acceso a la BD, se comunica con los siguientes archivos:
-Model_TemaActual.php
-accesousuario.php*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_accesodeusuarios extends CI_Controller {

	//Método constructor que permite inicializar clases paternas y librerías
	public function __construct()
        {
                parent::__construct();
                $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
                $this->load->helper('url_helper');
                
        }

	
	//Esta función permite el llamado al método que actualiza el tema configurado, y llama además a la vista accesousuario.php
	public function met_useraccess(){
		$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
		$this->load->helper('html');	
    	$this->load->helper(array('form'));
    	$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->load->view('templates/header',$data);
		$this->load->view('pages/accesousuario');
		$this->load->view('templates/footer',$data);
	}







}
