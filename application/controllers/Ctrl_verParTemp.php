<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_verParTemp extends CI_Controller {

public function __construct()
	{
	    parent::__construct();
	    $this->load->model('Model_Usuario','',TRUE);
	    $this->load->model('Model_TemaActual','',TRUE);
	}

public function index()
	{
		$session_data=$this->session->userdata('ax');
		$data['infoId'] = $session_data['idUsuario'];
		$data['infoRol'] = $session_data['idRol'];
		$data['infoUser'] = $session_data['nombre'];
		$data['infoApellido1'] = $session_data['apellido1'];
		$data['infoApellido2'] = $session_data['apellido2'];
		$data['infoCedula'] = $session_data['cedula'];
		$data['infoCorreo'] = $session_data['correo'];
		$data['infoTelefono'] = $session_data['telefono'];
		$data['infoFlag'] = $session_data['passForgot'];
		$data['infoCaduca'] = $session_data['caducaRec'];
		$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();
		$phpdate = strtotime($data['infoCaduca']);

		if($phpdate>time())
		{
			$this->Model_Usuario->met_resetFlag($data['infoCorreo']);
			redirect('Ctrl_perfilUsuario/met_redireccionModContra','refresh');
		}
		else
		{
			echo "<script type='text/javascript'>alert('Su contraseña temporal ha expirado. Debe solicitar una nueva contraseña.')</script>";
			redirect('Ctrl_bienvenida','refresh');
		}      
	}
}
