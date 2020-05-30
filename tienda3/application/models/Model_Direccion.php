<?php
//************************************************************************************
//Este módulo sirve para controlar la interaccion entre el controlador y la base de datos
//de direcciones de usuario
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//
//**************************************************************************************


Class Model_Direccion extends CI_Model{
	
	//Método que permite obtener las direcciones relacionadas con un usuario en especifico
	function met_traerDirecciones($idUsuario){
		$query = $this->db->query('SELECT DIRECCIONES.LOCALIZACION AS LOCA,DIRECCIONES.PROVINCIA  AS PROV,DIRECCIONES.CANTON AS CANT,DIRECCIONES.DISTRITO AS DIST,DETALLE_DIRECCIONES.REFERENCIA AS REFER,DETALLE_DIRECCIONES.ID_DIRECCION AS DIRECCIONID  FROM DIRECCIONES,DETALLE_DIRECCIONES
		WHERE DIRECCIONES.ID_DIRECCION=DETALLE_DIRECCIONES.ID_DIRECCION AND DETALLE_DIRECCIONES.ID_USUARIO=?',array($idUsuario));
		return $query->result_array();
			
		
		
	}
	
	//Método que permite obtener una direcciones specifica de un usuario en especifico
	function met_traerDirPorIdUsuarioIdDirec($idUsuario,$idDireccion){
		$query = $this->db->query('SELECT DIRECCIONES.LOCALIZACION AS LOCA,DIRECCIONES.PROVINCIA  AS PROV,DIRECCIONES.CANTON AS CANT,DIRECCIONES.DISTRITO AS DIST,DETALLE_DIRECCIONES.REFERENCIA AS REFER,DETALLE_DIRECCIONES.ID_DIRECCION AS DIRECCIONID  FROM DIRECCIONES,DETALLE_DIRECCIONES
		WHERE DIRECCIONES.ID_DIRECCION=DETALLE_DIRECCIONES.ID_DIRECCION AND DETALLE_DIRECCIONES.ID_USUARIO=? AND DIRECCIONES.ID_DIRECCION=?',array($idUsuario,$idDireccion));
		return $query->row();
	}
	
	//Método que permite modificar la referencia de una direccion de un usuario en especifico
	function met_modReferencia($modRef,$idUsuario,$idDireccion){
		$data = array('REFERENCIA' => $modRef);

		$where = "ID_USUARIO = '".$idUsuario."' AND ID_DIRECCION = '".$idDireccion."'";

		$up = $this->db->update_string('DETALLE_DIRECCIONES', $data, $where);
		return $this->db->query($up);
	}
	
	//Método que permite modificar la provincia de una direccion de un usuario en especifico
	function met_modProv($idDireccion,$modProv){
		$data = array('PROVINCIA' => $modProv);
		$this->db->where('ID_DIRECCION',$idDireccion);
		return $this->db->update('DIRECCIONES', $data);
	}
	
	//Método que permite modificar el canton de una direccion de un usuario en especifico
	function met_modCan($idDireccion,$modCan){
		$data = array('CANTON' => $modCan);
		$this->db->where('ID_DIRECCION',$idDireccion);
		return $this->db->update('DIRECCIONES', $data);
	}
	
	//Método que permite modificar el distrito de una direccion de un usuario en especifico
	function met_modDis($idDireccion,$modDis){
		$data = array('DISTRITO' => $modDis);
		$this->db->where('ID_DIRECCION',$idDireccion);
		return $this->db->update('DIRECCIONES', $data);
	}
	
	//Método que permite modificar el detalle de una direccion de un usuario en especifico
	function met_modDet($idDireccion,$modDet){
		$data = array('LOCALIZACION' => $modDet);
		$this->db->where('ID_DIRECCION',$idDireccion);
		return $this->db->update('DIRECCIONES', $data);
	}
	
	//Método que permite borrar una direccion de un usuario en especifico
	function met_borDetDir($delIdUsuario,$delIdDireccion){
		$data = array('ID_USUARIO'=>$delIdUsuario,'ID_DIRECCION'=>$delIdDireccion);
		return $query = $this->db->delete('DETALLE_DIRECCIONES',$data);
	}
	
	//Método que permite borrar una direccion en especifico
	function met_borDirec($delIdDireccion){
		$data = array('ID_DIRECCION'=>$delIdDireccion);
		return $query = $this->db->delete('DIRECCIONES',$data);
	}
	
	//Método que permite agregar una direccion nueva
	function met_agreDirec($modProv,$modCan,$modDis,$modDet){
		$data = array(

                'LOCALIZACION' => $modDet,
                'PROVINCIA' => $modProv,
                'CANTON' => $modCan,
                'DISTRITO' => $modDis
		);

		return $this->db->insert('DIRECCIONES', $data);
	}
	
	//Método que permite obtener la ultima direccion creada
	function met_getLastDir(){
		$query = $this->db->query('SELECT ID_DIRECCION FROM DIRECCIONES ORDER BY ID_DIRECCION DESC LIMIT 1;');
		return $query->row();
	}
	
	//Método que permite agregar los detalles de una direccion en especifico
	function met_agregarDetDir($idUsuario,$idDireccion,$referencia){
		$data = array(
			'ID_USUARIO'=>$idUsuario,
			'ID_DIRECCION'=>$idDireccion,
			'REFERENCIA'=>$referencia
		);
		return $this->db->insert('DETALLE_DIRECCIONES',$data);
	}
	
}
?>	