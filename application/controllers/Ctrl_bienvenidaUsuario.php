<?php
//************************************************************************************
/*Este controlador forma parte del módulo de Bienvenida, contiene los métodos que permiten acceso a la vista relacionada con la página de bienvenida usuario, permite además comunicación y transferencia de información con los modelos que tienen acceso a la BD, se comunica con los siguientes archivos:
-Model_Imagen.php
-Model_TemaActual.php
-welcome_message_0.php*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_bienvenidaUsuario extends CI_Controller {

	//Método constructor que permite inicializar clases paternas y librerías
	public function __construct()
        {
                parent::__construct();
                $this->load->helper('html');
				$this->load->helper('url');
				$this->load->helper('url_helper');
				$this->load->model('Model_Imagen','',TRUE);
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
                $loginstatus = $this->session->userdata('ax');
                $rolechecker = $loginstatus['idRol'];
                $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
    			$rolUsuario = $buscaRol->TIPO;
                if($rolUsuario!="USUARIO"){
                    redirect('Ctrl_bienvenida','refresh');
                }
        }

	//Esta función hace el llamado a los modelos para traer información de imágenes de inicio y de temas, así como información de sesión que identifica al usuario, permite también desplegar la vista de bienvenida	
	public function index()
	{
		if($this->session->userdata('ax')){
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			$data['listaImagenesInicio'] = $this->Model_Imagen->met_traerImagenesInicio();
			$this->load->helper('html');
			$this->load->view('templates/headerUsuario',$data);
			$this->load->view('welcome_message');
			$this->load->view('templates/footer',$data);
		}else{
			redirect('Ctrl_bienvenida','refresh');
		}
	}

	//Esta función ejecuta el proceso para terminar la sesión del usuario registrado
	public function met_logout(){
	   $this->session->unset_userdata('ax');
	   session_destroy();
	   $_SESSION = [];
	   redirect('Ctrl_bienvenida', 'refresh');
	 }

	 
	
}
