<?php
//************************************************************************************
//Este módulo sirve para controlar la interaccion entre el controlador y la base de datos
//de categorias.
//Autor: Dany Alvarado
//Fecha de creación: 20/07/2018
//Lista modificaciones
//
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_Categoria extends CI_Model {

	//Variable que almacena datos que se carga de los campos de la tabla Categorias de la base de datos mechesfermentsDB.
	var $table = 'CATEGORIAS'; 
   
   //Variable que almacena datos para orden del regsitro del datatable. 
	var $column_order = array('NOMBRE','DETALLE',null); 

   // Variable que almacena valor de busqueda por nombre o detalle. 
	var $column_search = array('NOMBRE','DETALLE');  

   // Variable que almacena valor de busqueda por ID y ordena por defecto.
	var $order = array('ID' => 'desc'); 

   //Método que permite cargar la conexion con la base de datos mechesfermentsDB.
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

//Método que permite realizar busqueda de registros de categorias en el datatable mediante filtrado de palabras o letras.
	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) //Columna de bucle
		{
			if($_POST['search']['value']) //Si es datable enviar POST para la búsqueda
			{
				
				if($i===0) 
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // Proceso solicitud 
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

//Método que permite mostrar resultado de busqueda de registros de categorias en el datatable.
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

//Método que permite buscar un registro de categoria especifico filtrando por una palabra o letra clave en la 
//tabla CATEGORIAS de la base de datos mechesfermenstDB
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

//Método que permite buscar todos registro de categorias en la tabla CATEGORIAS de la base de datos mechesfermenstDB
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

//Método que permite buscar un registro de categoria especifico mediante el id en la tabla CATEGORIAS de la base de datos mechesfermenstDB
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('ID',$id);
		$query = $this->db->get();

		return $query->row();
	}

//Método que permite guardar un nuevo registro de categoria en la tabla CATEGORIAS de la base de datos mechesfermenstDB
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

//Método que permite actualizar el registro de una categoria especifica en la tabla CATEGORIAS de la base de datos //mechesfermenstDB
	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

//Método que permite eliminar el registro de una categoria especifica de tabla CATEGORIAS de la base de datos //mechesfermenstDB
	public function delete_by_id($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete($this->table);
	}


}
