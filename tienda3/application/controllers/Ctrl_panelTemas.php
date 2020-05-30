<?php
//************************************************
//Este controller sirve para el botón de temas en la vista opcionesadmin.php
//
//Autor: Javier Trejos
//Fecha de Creación: 02/07/2018
//Lista de Modificaciones:
//20/07/2018 Javier Trejos
//Se agrego al código de ajax la variable para recibir el CSS nuevo por medio de un párametro en lugar de un POST
//proveniente de un form.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelTemas extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Model_TemaActual','',TRUE);
                
        }

	public function index()
	{

		
	}


	public function ajax_update($cssNuevo)
	//este método sirve para actualizar el tema en la Base de Datos que replica a todo el sitio web
	//recibe de la vista el nuevo tema seleccionado del sitio web
	//Utiliza el  Modelo TemaActual para actualizar el tema en la Base de Datos
	{	
		$data = $cssNuevo;
		$this->Model_TemaActual->actualizarTema($data);
		echo json_encode(array("status" => TRUE));
	}
	
}


