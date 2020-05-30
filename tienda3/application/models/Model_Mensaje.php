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

Class Model_Mensaje extends CI_Model{
	
	//Funcion para grabar un mensaje en la Base de Datos
	function met_agreMensaje($menNombre,$menApellido,$menEmail,$menTelefono,$menComSugPre){
		$data = array(

			'NOMBRE' => $menNombre,
			'APELLIDO_1' => $menApellido,
			'CORREO' => $menEmail,
			'TELEFONO' => $menTelefono,
			'MENSAJE' => $menComSugPre,
			'LEIDO' => 0
		);

		return $this->db->insert('MENSAJES', $data);
	}
	
	//Funcion para obtener todos los mensajes no leidos en la Base de Datos
	function met_traerMensajes(){
		$query = $this->db->query('SELECT * FROM vLISTAMENSAJESNOLEIDOS');
		return $query->result_array();
	}
	
	//Funcion para obterner todos los mensajes en la Base de Datos
	function met_traerMensajesTodos(){
		$query = $this->db->query('SELECT * FROM vLISTAMENSAJESTODOS');
		return $query->result_array();
	}

	//Funcion para cambiar el estaod de un mensaje en la Base de Datos	
	//parametros:
	//$mensajeIdAtController -> Id del mensaje que se desea modificar
	function met_cambiarEstado($mensajeIdAtController){
		$data = array('LEIDO' => 1);
		$this->db->where('ID_MENSAJE',$mensajeIdAtController);
		return $this->db->update('MENSAJES', $data);
	}
	
}
?>	