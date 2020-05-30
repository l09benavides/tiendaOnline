<?php
//************************************************************************************
/*Este modelo forma parte del módulo Panel de imágenes, contiene los métodos que permiten realizar consultas con la BD */

//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

Class Model_Imagen extends CI_Model{
	
	//FUNCIONES UTILIZADAS EN EL PANEL DE IMÁGENES DE PRODUCTOS
	
	function met_agreIm($image_path,$imagename){
		$data = array(

                'IMG_PRO' => $image_path,
				'NOMBREARCHIVO' => $imagename
                
		);

		return $this->db->insert('IMAGENES_PRODUCTOS',$data);
	}
	
	function met_getLastImg(){
		$query = $this->db->query('SELECT ID_IMGPRO FROM IMAGENES_PRODUCTOS ORDER BY ID_IMGPRO DESC LIMIT 1;');
		return $query->row();
	}
	
	function met_agregarRelImgPro($varProdId,$latestId,$varProdRef){
		$data = array(
			'ID_PRODUCTO'=>$varProdId,
			'ID_IMGPRO'=>$latestId,
			'REFERENCIA'=>$varProdRef
		);
		return $this->db->insert('REL_IMG_PRO',$data);
	}
	
	function met_traerImagenes(){
		$query = $this->db->query('SELECT * FROM vLISTAIMAGENESPRODUCTOS');
		return $query->result_array();
	}
	
	function met_buscarImagen($varModIdImg){
		$result=$this->db->get_where('IMAGENES_PRODUCTOS',array('ID_IMGPRO' => $varModIdImg));
		return $result->result();
	}
	
	function met_modIm($image_path,$imagename,$varModIdImg){
		$data = array(
		'IMG_PRO' => $image_path,
		'NOMBREARCHIVO' => $imagename
		);
		$this->db->where('ID_IMGPRO',$varModIdImg);
		return $this->db->update('IMAGENES_PRODUCTOS', $data);
	}
	
	function met_modificarRelImgPro($varModIdPro,$varModIdImg,$varModRef){
		$data = array('REFERENCIA' => $varModRef);

		$where = "ID_PRODUCTO = '".$varModIdPro."' AND ID_IMGPRO = '".$varModIdImg."'";

		$up = $this->db->update_string('REL_IMG_PRO', $data, $where);
		return $this->db->query($up);
	}
	
	function met_eliminarRELIMGPRO($varEliPro,$varEliImg){
		$data = array('ID_PRODUCTO'=>$varEliPro,'ID_IMGPRO'=>$varEliImg);
		return $query = $this->db->delete('REL_IMG_PRO',$data);
	}
	
	function met_eliminarImagen($varEliImg){
		$data = array('ID_IMGPRO'=>$varEliImg);
		return $query = $this->db->delete('IMAGENES_PRODUCTOS',$data);
	}
	
	//FUNCIONES UTILIZADAS EN EL PANEL DE IMÁGENES GENERALES
	
	function met_traerImagenesInicio(){
		$query = $this->db->query('SELECT * FROM vLISTAIMAGENESINICIO');
		return $query->result_array();
	}
	
	function met_traerImagenesNosotras(){
		$query = $this->db->query('SELECT * FROM vLISTAIMAGENESNOSOTRAS');
		return $query->result_array();
	}
	
	function met_agreImaGen($image_path,$imagename){
		$data = array(
                'IMG_GEN' => $image_path,
				'NOMBREARCHIVO' => $imagename
		);
		return $this->db->insert('IMAGENES_GENERALES',$data);
	}
	
	function met_getLastImgInicio(){
		$query = $this->db->query('SELECT ID_IMGGEN FROM IMAGENES_GENERALES ORDER BY ID_IMGGEN DESC LIMIT 1;');
		return $query->row();
	}
	
	function met_agregarRelImgIni($latestId,$varImgDes){
		$data = array(
			'ID_GENERAL'=>1,
			'ID_IMGGEN'=>$latestId,
			'DESCRIPCION'=>$varImgDes
		);
		return $this->db->insert('REL_IMG_GEN',$data);
	}
	
	function met_agregarRelImgNos($latestId,$varImgDes){
		$data = array(
			'ID_GENERAL'=>2,
			'ID_IMGGEN'=>$latestId,
			'DESCRIPCION'=>$varImgDes
		);
		return $this->db->insert('REL_IMG_GEN',$data);
	}
	
	function met_buscarImagenIni($varModIdImg){
		$result=$this->db->get_where('IMAGENES_GENERALES',array('ID_IMGGEN' => $varModIdImg));
		return $result->result();
	}
	
	function met_modImgIni($image_path,$imagename,$varModIdImg){
		$data = array(
		'IMG_GEN' => $image_path,
		'NOMBREARCHIVO' => $imagename
		);
		$this->db->where('ID_IMGGEN',$varModIdImg);
		return $this->db->update('IMAGENES_GENERALES', $data);
	}
	
	function met_modificarRelImgGen($varModIdGen,$varModIdImg,$varModDes){
		$data = array('DESCRIPCION' => $varModDes);

		$where = "ID_GENERAL = '".$varModIdGen."' AND ID_IMGGEN = '".$varModIdImg."'";

		$up = $this->db->update_string('REL_IMG_GEN', $data, $where);
		return $this->db->query($up);
	}
	
	function met_eliminarRELIMGGEN($varEliGen,$varEliImg){
		$data = array('ID_GENERAL'=>$varEliGen,'ID_IMGGEN'=>$varEliImg);
		return $query = $this->db->delete('REL_IMG_GEN',$data);
	}
	
	function met_eliminarImagenIni($varEliImg){
		$data = array('ID_IMGGEN'=>$varEliImg);
		return $query = $this->db->delete('IMAGENES_GENERALES',$data);
	}
	
	//FUNCIONES UTILIZADAS EN EL PANEL DE IMÁGENES NOSOTRAS
	
}
?>