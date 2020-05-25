<?php
//************************************************************************************
/*Este controlador forma parte del módulo Cambio de Contraseña, contiene los métodos que permiten acceso a las vistas relacionadas con el proceso de recuperación y cambio de contraseña, permite además comunicación y transferencia de información con los modelos que tienen acceso a la BD, se comunica con los siguientes archivos:
-Model_Usuario.php
-Model_TemaActual.php
-recuperacioncontrasena.php*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_recupcontra extends CI_Controller {


	//Método constructor que permite inicializar clases paternas y librerías
	public function __construct()
	{
		parent::__construct();


		$this->load->model('Model_Usuario','',TRUE);
		$this->load->model('Model_TemaActual','',TRUE);
	}

	//Este método permite abrir la vista correspondiente para iniciar el proceso de recuperación de contraseña
	public function index(){
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('correo', 'Correo', 'required|callback_revisarCorreo');

		$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();




		if ($this->form_validation->run() === FALSE){
			$data['inicio'] = true;
			$this->load->view('templates/header',$data);
			$this->load->view('pages/recuperacioncontrasena');
			$this->load->view('templates/footer',$data);
		}else{
			$correo=$this->input->post('correo');
			$tempPass = $this->random_str(10);
			$timePlus3Hr = date('Y-m-d H:i:s', time()+3*60*60);
			//$timePlus3Hr = date('Y-m-d H:i:s', time()+1);
			$this->Model_Usuario->met_guardarPassTemp($correo,$tempPass,$timePlus3Hr);

			/*
			echo "<script type='text/javascript'>alert('Email Sent".$timePlus3Hr."')</script>";
			redirect('Ctrl_recupcontra', 'refresh');
			*/
			$this->load->library('email');
			$this->email->from('mechesferments@gmail.com', 'Meches Ferments');
			//$this->email->to('diegocarrillo05@gmail.com');
			$this->email->to($correo);
			//$this->email->cc('another@another-example.com');
			//$this->email->bcc('them@their-example.com');

			$this->email->subject('Meches Ferments: Recuperar mi contraseña');
			$this->email->message('Se ha generado la contraseña temporal: '.$tempPass.'. A partir de este momento cuenta con un período de 3 horas para utilizar la contraseña temporal. En caso contrario se invalidará y deberá requerir una nueva contraseña temporal.');

			//$this->email->send();
			if($this->email->send()){
				echo "<script type='text/javascript'>alert('¡Correo enviado!')</script>";
				redirect('Ctrl_recupcontra', 'refresh');
			}else{
				show_error($this->email->print_debugger());
			}
		}


	}

	//Esta función se encarga de crear la contraseña temporal que se le brindará el usuario y que se guardará temporalmente en la BD
	function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$pieces = [];
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$pieces []= $keyspace[random_int(0, $max)];
		}
		return implode('', $pieces);
	}

	//Esta función revisa que el correo provisto por el usuario de verdad existe en la BD 
	function revisarCorreo($correo){
		//Field validation succeeded.  Validate against database
		$correo = $this->input->post('correo');

		//query the database
		$result = $this->Model_Usuario->met_checkCorreoExista($correo);

		if($result){

			return TRUE;
		}else{

			$this->form_validation->set_message('revisarCorreo', 'El correo no está registrado en nuestra base de datos.');
			return false;

		}
	}





}
