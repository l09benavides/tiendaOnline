<?php

//************************************************************************************
//Este modulo sirve para realizar todas las transacciones de base de datos en la 
//tabla de bitacora.
//Autor: Luis Benavides
//Fecha de creación: 21/07/2018
//Lista modificaciones:
//
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

Class Model_Bitacora extends CI_Model{

	public $idUsuario;
	public $idAccion;
	public $detalles;
	public $timestamp;

	//Constructor para Instanciacion para crear un objecto Bitacora
	//Parametros:
	//	$idUsuario: Id del usuario que realiza la accion
	//	$idAccion: el ID se asigna en base a los valores de la tabla BITACORA_ACCIONES
	//		'1', 'Agregar Usuario'
	//		'2', 'Modificar Usuario'
	//		'3', 'Deshabilitar Usuario'
	//		'4', 'Agregar Producto'
	//		'5', 'Modificar Producto'
	//	$detalles: Json con la informacion de la acccion que ejecuto el usuario
	public Function __constructor($idUsuario,$idAccion,$detalles){
		$this->idUsuario = $idUsuario;
		$this->idAccion = $idAccion;
		$this->detalles = $detalles;
	}

	//Metodo que crea un registro que bitacora
	public Function Crear(){
		try 
		{
			$this->timestamp = date('Y-m-d G:i:s');
			$this->db->insert('BITACORA',$this);
		} 
		catch (Exception $e) 
		{
			return $e;
		}
		
	}

	//Metodo para consultar todos los registros de la bitacora
	public Function Todos(){
		try 
		{
			$query = $this->db->get('VBitacora');
			return $query->result();	
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}

	//Metodo para realizar una consulta generica a la tabla de bitacora, re enviara un termino de busqueda 
	//y la columna en la que se buscara dicho teermino
	public Function Consultar($busqueda, $atributo){
		try 
		{
			$sql = "SELECT * FROM VBitacora WHERE ".$this->db->escape_like_str($atributo)." LIKE '%" .
    		$this->db->escape_like_str($busqueda)."%';";	
    		$query = $this->db->query($sql);
    		return $query->result();
		} 
		catch (Exception $e)
		{
			return $e;
		}
		
	}

}