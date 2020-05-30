<?php
//************************************************************************************
///Control de Contactenos contiene los metodos para cargar el formulario que se enviara al administrador 
//Ctrl.contactenos.php
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Se agrego la documentacion interna necesaria para la correcta descripcion de metodos.
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_contactenos extends CI_Controller {
	
//Método constructor que permite inicializar clases paternas y librerías

	public function __construct()
        {
            parent::__construct();
			$this->load->helper('url_helper');
            $this->load->model('Model_Usuario','',TRUE);
			$this->load->model('Model_Mensaje','',TRUE);
			$this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
        }

		// Función para levantar los datos almacenados del usuario dependiendo si esta logueado o no y que tipo de perfil posee 
		
	public function index()
	{
		$this->load->helper('form');
        $this->load->library('form_validation');
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
		$session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
		$modalValid = 1;
        $loginstatus = $this->session->userdata('ax');
		
		$this->form_validation->set_rules('nombreSug', 'Nombre', 'required');
        $this->form_validation->set_rules('apellidoSug', 'Apellido', 'required');
        $this->form_validation->set_rules('emailSug', 'Email', 'required');
        $this->form_validation->set_rules('telefonoSug', 'Teléfono','required');
        $this->form_validation->set_rules('comPreSug', 'Campo', 'required');
		$data['modalValid'] = $modalValid;
		if ($this->form_validation->run() === FALSE){
			//$data['modalValid'] = 0;
			if($loginstatus == NULL){
				$this->load->view('templates/header',$data);
				$this->load->view('pages/vis_contactenos',$data);
				$this->load->view('templates/footer',$data);
			}else{
				$rolechecker = $loginstatus['idRol'];
				$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
				$rolUsuario = $buscaRol->TIPO;
				if($rolUsuario=="ADMIN"){
					$this->load->view('templates/headerAdmin',$data);
					$this->load->view('pages/vis_contactenos',$data);
					$this->load->view('templates/footer',$data);
				}else{
					$this->load->view('templates/headerUsuario',$data);
					$this->load->view('pages/vis_contactenos',$data);
					$this->load->view('templates/footer',$data);
				}
			}
		}
	}
	
	//Metodo que comprueba que todos los datos esten completos y con el formato correcto antes de enviar el formulario para solicitar informacion 
	//si esta correcto mostrara un mensaje de exito y si falta un dato lo indicara conletras rojas
	
	public function met_agregarSugComPre(){
		$this->load->helper('form');
        $this->load->library('form_validation');
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
		$session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
		$modalValid = 1;
        $loginstatus = $this->session->userdata('ax');
		
		$this->form_validation->set_rules('nombreSug', 'Nombre', 'required',array('required'=>'El nombre es requerido.'));
        $this->form_validation->set_rules('apellidoSug', 'Apellido', 'required',array('required'=>'El apellido es requerido.'));
        $this->form_validation->set_rules('emailSug', 'Email', 'required|valid_email',array('required'=>'El correo es requerido.','valid_email'=>'El formato del email debe ser "example@domain.com"'));
        $this->form_validation->set_rules('telefonoSug', 'Teléfono','required',array('required'=>'El teléfono es requerido.'));
        $this->form_validation->set_rules('comPreSug', 'Campo', 'required',array('required'=>'El mensaje es requerido.'));
		$data['modalValid'] = $modalValid;
		if ($this->form_validation->run() === FALSE){
			$data['modalValid'] = 0;
			if($loginstatus == NULL){
				$this->load->view('templates/header',$data);
				$this->load->view('pages/vis_contactenos',$data);
				$this->load->view('templates/footer',$data);
			}else{
				$rolechecker = $loginstatus['idRol'];
				$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
				$rolUsuario = $buscaRol->TIPO;
				if($rolUsuario=="ADMIN"){
					$this->load->view('templates/headerAdmin',$data);
					$this->load->view('pages/vis_contactenos',$data);
					$this->load->view('templates/footer',$data);
				}else{
					$this->load->view('templates/headerUsuario',$data);
					$this->load->view('pages/vis_contactenos',$data);
					$this->load->view('templates/footer',$data);
				}
			}
		}else{
			$menNombre =$this->input->post('nombreSug');
			$menApellido =$this->input->post('apellidoSug');
			$menEmail =$this->input->post('emailSug');
			$menTelefono =$this->input->post('telefonoSug');
			$menComSugPre =$this->input->post('comPreSug');
			$this->Model_Mensaje->met_agreMensaje($menNombre,$menApellido,$menEmail,$menTelefono,$menComSugPre);
			echo "<script type='text/javascript'>alert('¡Mensaje enviado correctamente!')</script>";
			redirect('Ctrl_contactenos', 'refresh');
		}
		
		
	}

	
}


