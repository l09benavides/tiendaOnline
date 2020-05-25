<?php
//************************************************************************************
/*Este controlador forma parte del módulo Panel de imágenes, contiene los métodos que permiten acceso a las vistas relacionadas con imágenes de productos, permite además comunicación y transferencia de información con los modelos que tienen acceso a la BD, se comunica con los siguientes archivos:
-Model_Usuario.php
-Model_Imagen.php
-Model_Producto.php
-Model_TemaActual.php
-vis_imagenProducto.php*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelImagenesProductos extends CI_Controller {

	//Método constructor que permite inicializar clases paternas y librerías
	public function __construct()
    {
		parent::__construct();
		$this->load->helper('html');//Permite utilizar funciones y sintáxis de librería para manejar elementos html
		$this->load->helper('url');//Permite utilizar funciones y sintáxis de librería para manejar URLs
		$this->load->helper('url_helper');//Permite utilizar funciones y sintáxis de librería para manejar URLs
		$this->load->helper('form');  //Permite utilizar funciones y sintáxis de librería para manejar elementos de form  
		$this->load->model('Model_Producto','',TRUE);//Carga modelo producto y permite conexiones a las funciones
		$this->load->model('Model_Usuario','',TRUE);//Carga modelo usuario y permite conexiones a las funciones
		$this->load->model('Model_Imagen','',TRUE);//Carga modelo imagen y permite conexiones a las funciones
		$this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
		$loginstatus = $this->session->userdata('ax');//Variable que almacena datos de sesión del usuario
		if($loginstatus == NULL){
			redirect('Ctrl_bienvenida','refresh');
		}else{
			$rolechecker = $loginstatus['idRol'];//Variable que guarda el rol id extraído de la sesión de usuario
			$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);//Variable que recibe resultado de query para el string del rol
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
		$modalValid = 1;//Variable que identifica si existió algún error en los datos de entrada del form de modificación de imágenes de producto
		$modalAgregValid = 1;//Variable que identifica si existió algún error en los datos de entrada del form de agregar de imágenes de productos
		$data['infoUser'] = $session_data['nombre'];
        $data['listaProductos'] = $this->Model_Producto->getAllProductos();//Guarda imágenes de productos dentro del arreglo que se manda a la vista
		$data['listaImagenes'] = $this->Model_Imagen->met_traerImagenes();//Guarda imágenes de productos dentro del arreglo que se manda a la vista
		$data['modalValid'] = $modalValid;
		$data['modalAgregValid'] = $modalAgregValid;
        $this->load->view('templates/headerAdmin',$data);
        $this->load->view('pages/visImagenes/vis_imagenProducto',$data);
        $this->load->view('templates/footer',$data);
    }
	
	//Función para agregar imágenes de productos
    public function met_agregarImag()
    {
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$modalValid = 1;//modal validacion para modificar
		
		
		$this->form_validation->set_rules('AgReferencia', 'Referencia', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			$session_data=$this->session->userdata('ax');
			$data['infoUser'] = $session_data['nombre'];
			$data['listaProductos'] = $this->Model_Producto->getAllProductos();
			$data['listaImagenes'] = $this->Model_Imagen->met_traerImagenes();
			$data['modalValid'] = $modalValid;
			$data['modalAgregValid'] = 0;
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/visImagenes/vis_imagenProducto',$data);
			$this->load->view('templates/footer',$data);
		}else{
			$config = [
			'upload_path'=>'./uploads/',
			'allowed_types'=>'gif|png|jpg|jpeg'
			];
			$this->load->library('upload',$config);
			$this->form_validation->set_error_delimiters();
			if($this->upload->do_upload()){
				$data = $this->input->post();
				$info = $this->upload->data();
				$image_path = base_url("uploads/".$info['orig_name']);
				$imagename = $info['orig_name'];
				//$data['IMG_PRO'] = $image_path;
				unset($data['submit']);
				if($this->Model_Imagen->met_agreIm($image_path,$imagename)){
					$varProdId = $this->input->post('AgProductos');
					$varProdRef = $this->input->post('AgReferencia');
					$latestId = ($this->Model_Imagen->met_getLastImg())->ID_IMGPRO;
					$this->Model_Imagen->met_agregarRelImgPro($varProdId,$latestId,$varProdRef);
					//$infoUpload = array('error' => $this->upload->data()); prueba de imagenes
					//print_r($infoUpload); prueba IMAGENES
					echo "<script type='text/javascript'>alert('¡Imagen guardada satisfactoriamente!')</script>";
					redirect('Ctrl_panelImagenesProductos', 'refresh');
				}else{
					echo "<script type='text/javascript'>alert('¡Error al guardar imagen en DB!')</script>";
					redirect('Ctrl_panelImagenesProductos', 'refresh');
				}
			}else{
				/* echo "<script type='text/javascript'>alert('¡Error al subir imagen!')</script>";
				redirect('Ctrl_panelImagenesProductos', 'refresh'); */
				$error = array('error' => $this->upload->data());
				$this->load->view('display', $error);
			}
		}	
	
    }
	
	//Función para modificar imágenes de productos
	public function met_modifImag(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$modalAgregValid = 1;//modal validacion para agregar
		$this->form_validation->set_rules('referenciaModIm', 'Referencia', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$session_data=$this->session->userdata('ax');
			$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
			$data['infoUser'] = $session_data['nombre'];
			$data['listaProductos'] = $this->Model_Producto->getAllProductos();
			$data['listaImagenes'] = $this->Model_Imagen->met_traerImagenes();
			$data['modalValid'] = 0;
			$data['modalAgregValid'] = $modalAgregValid;
			$this->load->view('templates/headerAdmin',$data);
			$this->load->view('pages/visImagenes/vis_imagenProducto',$data);
			$this->load->view('templates/footer',$data);
		}else{
			$config = [
			'upload_path'=>'./uploads',
			'allowed_types'=>'gif|png|jpg|jpeg'
			];
			$this->load->library('upload',$config);
			$this->form_validation->set_error_delimiters();
		
			if($this->upload->do_upload()){
				$varModIdPro = $this->input->post('idModPro');
				$varModIdImg = $this->input->post('idModIm');
				$varModRef = $this->input->post('referenciaModIm');
				$varRefComp = $this->input->post('referenciaComp');
				$rows = $this->Model_Imagen->met_buscarImagen($varModIdImg);
				foreach($rows as $row){
					unlink("uploads/".$row->NOMBREARCHIVO);
				}
				$data = $this->input->post();
				$info = $this->upload->data();
				$image_path = base_url("uploads/".$info['orig_name']);
				$imagename = $info['orig_name'];
				unset($data['submit']);
				if($this->Model_Imagen->met_modIm($image_path,$imagename,$varModIdImg)){
					if($varModRef!=$varRefComp){
						$this->Model_Imagen->met_modificarRelImgPro($varModIdPro,$varModIdImg,$varModRef);
					}
					echo "<script type='text/javascript'>alert('¡Imagen modificada satisfactoriamente!')</script>";
					redirect('Ctrl_panelImagenesProductos', 'refresh');
				}else{
					echo "<script type='text/javascript'>alert('¡Error al guardar imagen en DB!')</script>";
					redirect('Ctrl_panelImagenesProductos', 'refresh');
				}
			}else{
				echo "<script type='text/javascript'>alert('¡Error al subir imagen!')</script>";
				
				redirect('Ctrl_panelImagenesProductos', 'refresh');
			}
		}
		
	}
	
	//Función para eliminar imágenes de productos
	public function met_elimImag(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
		$varEliPro = $this->input->post('idProEli');
		$varEliImg = $this->input->post('idImgEli');
		$varEliRef = $this->input->post('referenciaImgEli');
		$rows = $this->Model_Imagen->met_buscarImagen($varEliImg);
		foreach($rows as $row){
			unlink("uploads/".$row->NOMBREARCHIVO);
		}
		$this->Model_Imagen->met_eliminarRELIMGPRO($varEliPro,$varEliImg);
		$this->Model_Imagen->met_eliminarImagen($varEliImg);
		echo "<script type='text/javascript'>alert('¡Imagen eliminada satisfactoriamente!')</script>";
		redirect('Ctrl_panelImagenesProductos', 'refresh');	
	}

}
