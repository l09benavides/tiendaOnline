<?php
//************************************************************************************
/*Este controlador forma parte del módulo Panel de imágenes, contiene los métodos que permiten acceso a las vistas relacionadas con imágenes de inicio y de nosotras, permite además comunicación y transferencia de información con los modelos que tienen acceso a la BD, se comunica con los siguientes archivos:
-Model_Usuario.php
-Model_Imagen.php
-Model_Producto.php
-Model_TemaActual.php
-vis_imagenGeneral.php*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelImagenesGenerales extends CI_Controller {

	//Método constructor que permite inicializar clases paternas y librerías
	public function __construct()
    {
		parent::__construct();
		$this->load->helper('html');//Permite utilizar funciones y sintáxis de librería para manejar elementos html
		$this->load->helper('url');//Permite utilizar funciones y sintáxis de librería para manejar URLs
		$this->load->helper('url_helper');//Permite utilizar funciones y sintáxis de librería para manejar URLs
		$this->load->helper('form');//Permite utilizar funciones y sintáxis de librería para manejar elementos de form    
		$this->load->model('Model_Producto','',TRUE);//Carga modelo producto y permite conexiones a las funciones
		$this->load->model('Model_Usuario','',TRUE);//Carga modelo usuario y permite conexiones a las funciones
		$this->load->model('Model_Imagen','',TRUE);//Carga modelo imagen y permite conexiones a las funciones
		$this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
		$loginstatus = $this->session->userdata('ax');//Variable que almacena datos de sesión del usuario
		if($loginstatus == NULL){
			redirect('Ctrl_bienvenida','refresh');
		}else{
			$rolechecker = $loginstatus['idRol'];//Variable que guarda el rol id extraído de la sesión de usuario
			$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);//Variable que recibe resultado de query para el stringo del rol
			$rolUsuario = $buscaRol->TIPO;//Variable que se le asigna el rol extraído del query de BD
			if($rolUsuario!="ADMIN"){
				redirect('Ctrl_bienvenida','refresh');
			}
		}
    }

	//Función para página inicial
	
    public function index()
    {
        $this->load->helper('html');
		$session_data=$this->session->userdata('ax');

		$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
		$modalValid = 1;//Variable que identifica si existió algún error en los datos de entrada del form de modificación de imágenes iniciales
		$modalAgregValid = 1;//Variable que identifica si existió algún error en los datos de entrada del form de agregar de imágenes iniciales
		$modalValidNosotras = 1;//Variable que identifica si existió algún error en los datos de entrada del form de modificación de imágenes de nosotras
		$modalAgregValidNosotras = 1;//Variable que identifica si existió algún error en los datos de entrada del form de agregar de imágenes de nosotras
		$data['infoUser'] = $session_data['nombre'];
        //$data['listaProductos'] = $this->Model_Producto->getAllProductos();
		$data['listaImagenesInicio'] = $this->Model_Imagen->met_traerImagenesInicio();//Guarda imágenes de inicio dentro del arreglo que se manda a la vista
		$data['listaImagenesNosotras'] = $this->Model_Imagen->met_traerImagenesNosotras();//Guarda imágenes de nosotras dentro del arreglo que se manda a la vista
		$data['modalValid'] = $modalValid;
		$data['modalAgregValid'] = $modalAgregValid;
		$data['modalValidNosotras'] = $modalValidNosotras;
		$data['modalAgregValidNosotras'] = $modalAgregValidNosotras;
        $this->load->view('templates/headerAdmin',$data);
        $this->load->view('pages/visImagenes/vis_imagenGeneral',$data);
        $this->load->view('templates/footer',$data);
    }
	
	//Funciones para sección de imágenes del carrusel de inicio
	
	//Función para agregar imágenes de inicio
    public function met_agregarImagIni()
    {
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$modalValid = 1;//modal validacion para modificar
		
		
		$this->form_validation->set_rules('AgDescripcion', 'Descripción', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			//$data['listaProductos'] = $this->Model_Producto->getAllProductos();
			$data['listaImagenesInicio'] = $this->Model_Imagen->met_traerImagenesInicio();
			$data['listaImagenesNosotras'] = $this->Model_Imagen->met_traerImagenesNosotras();
			$data['modalValid'] = $modalValid;
			$data['modalAgregValid'] = 0;
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/visImagenes/vis_imagenGeneral',$data);
			$this->load->view('templates/footer',$data);
		}else{
			$config = [
			'upload_path'=>'./uploads/generales',
			'allowed_types'=>'gif|png|jpg|jpeg'
			];
			$this->load->library('upload',$config);
			$this->form_validation->set_error_delimiters();
			if($this->upload->do_upload()){
				$data = $this->input->post();
				$info = $this->upload->data();
				$image_path = base_url("uploads/generales/".$info['orig_name']);
				$imagename = $info['orig_name'];
				//$data['IMG_PRO'] = $image_path;
				unset($data['submit']);
				if($this->Model_Imagen->met_agreImaGen($image_path,$imagename)){
					//$varGenId = $this->input->post('AgProductos');
					$varImgDes = $this->input->post('AgDescripcion');
					$latestId = ($this->Model_Imagen->met_getLastImgInicio())->ID_IMGGEN;
					$this->Model_Imagen->met_agregarRelImgIni($latestId,$varImgDes);
					echo "<script type='text/javascript'>alert('¡Imagen guardada satisfactoriamente!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}else{
					echo "<script type='text/javascript'>alert('¡Error al guardar imagen en DB!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}
			}else{
				echo "<script type='text/javascript'>alert('¡Error al subir imagen!')</script>";
				redirect('Ctrl_panelImagenesGenerales', 'refresh');
			}
		}	
	
    }
	
	//Función para modificar imágenes de inicio
	public function met_modifImagIni(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$modalAgregValid = 1;//modal validacion para agregar
		$this->form_validation->set_rules('descripcionModIm', 'Descripción', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			//$data['listaProductos'] = $this->Model_Producto->getAllProductos();
			$data['listaImagenesInicio'] = $this->Model_Imagen->met_traerImagenesInicio();
			$data['listaImagenesNosotras'] = $this->Model_Imagen->met_traerImagenesNosotras();
			$data['modalValid'] = 0;
			$data['modalAgregValid'] = $modalAgregValid;
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/visImagenes/vis_imagenGeneral',$data);
			$this->load->view('templates/footer',$data);
		}else{
			$config = [
			'upload_path'=>'./uploads/generales',
			'allowed_types'=>'gif|png|jpg|jpeg'
			];
			$this->load->library('upload',$config);
			$this->form_validation->set_error_delimiters();
		
			if($this->upload->do_upload()){
				$varModIdGen = $this->input->post('idModGen');
				$varModIdImg = $this->input->post('idModIm');
				$varModDes = $this->input->post('descripcionModIm');
				$varDesComp = $this->input->post('descripcionComp');
				$rows = $this->Model_Imagen->met_buscarImagenIni($varModIdImg);
				foreach($rows as $row){
					unlink("uploads/generales/".$row->NOMBREARCHIVO);
				}
				$data = $this->input->post();
				$info = $this->upload->data();
				$image_path = base_url("uploads/generales".$info['orig_name']);
				$imagename = $info['orig_name'];
				unset($data['submit']);
				if($this->Model_Imagen->met_modImgIni($image_path,$imagename,$varModIdImg)){
					if($varModDes!=$varDesComp){
						$this->Model_Imagen->met_modificarRelImgGen($varModIdGen,$varModIdImg,$varModDes);
					}
					echo "<script type='text/javascript'>alert('¡Imagen modificada satisfactoriamente!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}else{
					echo "<script type='text/javascript'>alert('¡Error al guardar imagen en DB!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}
			}else{
				echo "<script type='text/javascript'>alert('¡Error al subir imagen!')</script>";
				
				redirect('Ctrl_panelImagenesGenerales', 'refresh');
			}
		}
		
	
	}
	
	//Función para eliminar imágenes de inicio
	public function met_elimImagIni(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$varEliGen = $this->input->post('idGenEli');
		$varEliImg = $this->input->post('idImgEli');
		$varEliDes = $this->input->post('descripcionImgEli');
		$rows = $this->Model_Imagen->met_buscarImagenIni($varEliImg);
		foreach($rows as $row){
			unlink("uploads/generales/".$row->NOMBREARCHIVO);
		}
		$this->Model_Imagen->met_eliminarRELIMGGEN($varEliGen,$varEliImg);
		$this->Model_Imagen->met_eliminarImagenIni($varEliImg);
		echo "<script type='text/javascript'>alert('¡Imagen eliminada satisfactoriamente!')</script>";
		redirect('Ctrl_panelImagenesGenerales', 'refresh');	
	}
	
	//Funciones para sección de imágenes de nosotras
	
	//Función para agregar imágenes de nosotras
	public function met_agregarImagNos()
    {
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$modalValidNosotras = 1;//modal validacion para modificar
		
		
		$this->form_validation->set_rules('AgDescripcionNos', 'Descripción', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			//$data['listaProductos'] = $this->Model_Producto->getAllProductos();
			$data['listaImagenesInicio'] = $this->Model_Imagen->met_traerImagenesInicio();
			$data['listaImagenesNosotras'] = $this->Model_Imagen->met_traerImagenesNosotras();
			$data['modalValidNosotras'] = $modalValidNosotras;
			$data['modalAgregValidNosotras'] = 0;
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/visImagenes/vis_imagenGeneral',$data);
			$this->load->view('templates/footer',$data);
		}else{
			$config = [
			'upload_path'=>'./uploads/generalesNosotras',
			'allowed_types'=>'gif|png|jpg|jpeg'
			];
			$this->load->library('upload',$config);
			$this->form_validation->set_error_delimiters();
			if($this->upload->do_upload()){
				$data = $this->input->post();
				$info = $this->upload->data();
				$image_path = base_url("uploads/generalesNosotras/".$info['orig_name']);
				$imagename = $info['orig_name'];
				//$data['IMG_PRO'] = $image_path;
				unset($data['submit']);
				if($this->Model_Imagen->met_agreImaGen($image_path,$imagename)){
					//$varGenId = $this->input->post('AgProductos');
					$varImgDes = $this->input->post('AgDescripcionNos');
					$latestId = ($this->Model_Imagen->met_getLastImgInicio())->ID_IMGGEN;
					$this->Model_Imagen->met_agregarRelImgNos($latestId,$varImgDes);
					echo "<script type='text/javascript'>alert('¡Imagen guardada satisfactoriamente!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}else{
					echo "<script type='text/javascript'>alert('¡Error al guardar imagen en DB!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}
			}else{
				echo "<script type='text/javascript'>alert('¡Error al subir imagen!')</script>";
				redirect('Ctrl_panelImagenesGenerales', 'refresh');
			}
		}	
	
    }
	
	//Función para modificar imágenes de nosotras
	public function met_modifImagNos(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$modalAgregValidNosotras = 1;//modal validacion para agregar
		$this->form_validation->set_rules('descripcionModImNos', 'Descripción', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			//$data['listaProductos'] = $this->Model_Producto->getAllProductos();
			$data['listaImagenesInicio'] = $this->Model_Imagen->met_traerImagenesInicio();
			$data['listaImagenesNosotras'] = $this->Model_Imagen->met_traerImagenesNosotras();
			$data['modalValidNosotras'] = 0;
			$data['modalAgregValidNosotras'] = $modalAgregValidNosotras;
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/visImagenes/vis_imagenGeneral',$data);
			$this->load->view('templates/footer',$data);
		}else{
			$config = [
			'upload_path'=>'./uploads/generalesNosotras',
			'allowed_types'=>'gif|png|jpg|jpeg'
			];
			$this->load->library('upload',$config);
			$this->form_validation->set_error_delimiters();
		
			if($this->upload->do_upload()){
				$varModIdGen = $this->input->post('idModGenNos');
				$varModIdImg = $this->input->post('idModImNos');
				$varModDes = $this->input->post('descripcionModImNos');
				$varDesComp = $this->input->post('descripcionCompNos');
				$rows = $this->Model_Imagen->met_buscarImagenIni($varModIdImg);
				foreach($rows as $row){
					unlink("uploads/generalesNosotras/".$row->NOMBREARCHIVO);
				}
				$data = $this->input->post();
				$info = $this->upload->data();
				$image_path = base_url("uploads/generalesNosotras".$info['orig_name']);
				$imagename = $info['orig_name'];
				unset($data['submit']);
				if($this->Model_Imagen->met_modImgIni($image_path,$imagename,$varModIdImg)){
					if($varModDes!=$varDesComp){
						$this->Model_Imagen->met_modificarRelImgGen($varModIdGen,$varModIdImg,$varModDes);
					}
					echo "<script type='text/javascript'>alert('¡Imagen modificada satisfactoriamente!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}else{
					echo "<script type='text/javascript'>alert('¡Error al guardar imagen en DB!')</script>";
					redirect('Ctrl_panelImagenesGenerales', 'refresh');
				}
			}else{
				echo "<script type='text/javascript'>alert('¡Error al subir imagen!')</script>";
				
				redirect('Ctrl_panelImagenesGenerales', 'refresh');
			}
		}
		
	
	}
	
	//Función para eliminar imágenes de nosotras
	public function met_elimImagNos(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$varEliGen = $this->input->post('idGenEliNos');//Variable que almacena dato del form de id general de tabla intermedia
		$varEliImg = $this->input->post('idImgEliNos');//Variable que almacena dato del form de id de imagen de nosotras
		$varEliDes = $this->input->post('descripcionImgEliNos');//Variable que almacena dato del form de descripción de imagen
		$rows = $this->Model_Imagen->met_buscarImagenIni($varEliImg);
		foreach($rows as $row){
			unlink("uploads/generalesNosotras/".$row->NOMBREARCHIVO);
		}
		$this->Model_Imagen->met_eliminarRELIMGGEN($varEliGen,$varEliImg);
		$this->Model_Imagen->met_eliminarImagenIni($varEliImg);
		echo "<script type='text/javascript'>alert('¡Imagen eliminada satisfactoriamente!')</script>";
		redirect('Ctrl_panelImagenesGenerales', 'refresh');	
	}
	
	

}
