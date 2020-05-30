<?php
//************************************************************************************
// Esta libreria se encarga de realizar las acciones basicas del modelo de forma 
//instanciada.
//Autor: Luis Benavides
///Fecha de creación: 17/06/2018
//Lista modificaciones
//
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora {

	public $Model; //Variable para Instanciar el objeto Model_Bitacora

	//Se iniciar el Model Bitacora y se instancia
	public Function __construct()
	{
		$CI =& get_instance();
        $CI->load->model('Model_Bitacora','',TRUE);
        $this->Model = new Model_Bitacora();
	}

	//Se asignas los atributos al Objeto Modelo y se llama a la funcion crear
	public Function Guardar($idUsuario,$idAccion,$detalles){
		//Se asignan las variables para poder crear el objeto Bitacora
		$this->Model->idUsuario = $idUsuario;
		$this->Model->idAccion = $idAccion;
		$this->Model->detalles = $detalles;
		
		//Se llama la funcion crear el modelo
		$this->Model->Crear();
	}

	//Obtiene todos los registros de la bitacora y devuelve los valores en forma de arreglo
	public Function Todos(){

		$registros =  array();
		$registros = $this->Model->Todos();

		return $registros;
	}

	//Crea una consulta generica y devuelve los valores en forma de arreglo
	public Function Consultar($busqueda,$atributo){
		$registros = array();
		$registros = $this->Model->Consultar($busqueda,$atributo);

		return $registros;
	}


}