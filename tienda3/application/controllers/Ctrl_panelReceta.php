<?php
//************************************************************************************
//Este módulo se encarga de proveer una interfaz para utilizar el modelo recetas
//para cargar la informacion de los registro de recetas a la vista administrador 
//de recetas (vis_panelReceta.php), y ademas provee la funcionalidad CRUD para 
//manejo de registro de recetas.
//Autor: Gabriel Aleman
//Fecha de creación: 30/07/2018
//Lista modificaciones
//20/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelReceta extends CI_Controller {

    //Permite cargar los modelos necesarios para crear las conexiones a las funciones. 
	public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->model('Model_Usuario','',TRUE);
            $this->load->model('Model_TemaActual','',TRUE); //Para tener el tema en uso y aplicado
            $this->load->model('Model_Receta','Ctrl_panelReceta'); 
			$loginstatus = $this->session->userdata('ax');
			$rolechecker = $loginstatus['idRol'];
			$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
			$rolUsuario = $buscaRol->TIPO;
			if($rolUsuario!="ADMIN"){
				redirect('Ctrl_bienvenida','refresh');
			}
    }
    //Permite llamar y cargar las librerias Codeigniter para las vistas, formularios y validacion de formaularios
    public function index()
    {
    	$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //Permite verifica el estado de la sesion del usuario 
    	if($this->session->userdata('ax')){
            $session_data=$this->session->userdata('ax');
            $data['infoUser'] = $session_data['nombre'];
            $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();
            $this->load->helper('html');
            $this->load->view('templates/headerAdmin',$data);
            $this->load->view('pages/vis_panelReceta');
            $this->load->view('templates/footer',$data);
        }else{
            redirect('Ctrl_bienvenida','refresh');
        }

    }

    //Carga la informacion de la base de datos en una tabla que se muestra en la vista vis_panelCategoria.php
	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->Ctrl_panelReceta->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $receta) {
			$no++;
			$row = array();
			$row[] = $receta->NOMBRE;
			$row[] = $receta->DETALLE;

			if($receta->IMAGEN)
				$row[] = '<a href="'.base_url('./assets/images/uploads/'.$receta->IMAGEN).'" target="_blank"><img src="'.base_url('./assets/images/uploads/'.$receta->IMAGEN).'" class="img-responsive" style=width:300px; height:25px; /></a>';
			else
				$row[] = '<--Imagen No Disponible-->';

			//Defino la accion de los botones de la tabla en la estructura html 
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_receta('."'".$receta->ID."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_receta('."'".$receta->ID."'".')"><i class="glyphicon glyphicon-trash"></i> Borrar</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Ctrl_panelReceta->count_all(),
						"recordsFiltered" => $this->Ctrl_panelReceta->count_filtered(),
						"data" => $data,
				);
		
        //Salida a formato json
		echo json_encode($output);
	}

    //Permite modificar los registro de recetas en la vista vis_panelCategoria.php
	public function ajax_edit($id)
	{
		$data = $this->Ctrl_panelReceta->get_by_id($id);
		echo json_encode($data);
	}

    //Permite agregar nuevos registro de recetas en la vista vis_panelCategoria.php
	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'NOMBRE' => $this->input->post('Nombre'),
				'DETALLE' => $this->input->post('Detalle'),

			);

		if(!empty($_FILES['Imagen']['name']))
		{
			$upload = $this->_do_upload();
			$data['Imagen'] = $upload;
		}

		$insert = $this->Ctrl_panelReceta->save($data);

		echo json_encode(array("status" => TRUE));
	}

   //Permite refrescar la informacion de la tabla que se muestra en la vista vis_panelCategoria.php
	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'NOMBRE' => $this->input->post('Nombre'),
				'DETALLE' => $this->input->post('Detalle'),

			);

		if($this->input->post('remove_imagen')) // if remove photo checked
		{
			if(file_exists('./assets/images/uploads/'.$this->input->post('remove_imagen')) && $this->input->post('remove_imagen'))
				unlink('./assets/images/uploads/'.$this->input->post('remove_imagen'));
			$data['IMAGEN'] = '';
		}

		if(!empty($_FILES['Imagen']['name']))
		{
			$upload = $this->_do_upload();
			
			//borrar archivo
			$receta = $this->Ctrl_panelReceta->get_by_id($this->input->post('Id'));
			if(file_exists('./assets/images/uploads/'.$receta->IMAGEN) && $receta->IMAGEN)
				unlink('./assets/images/uploads/'.$receta->IMAGEN);

			$data['Imagen'] = $upload;
		}

		$this->Ctrl_panelReceta->update(array('Id' => $this->input->post('Id')), $data);
		echo json_encode(array("status" => TRUE));
	}

    //Permite remover registro de tabla Recetas de la base de datos.
	public function ajax_delete($id)
	{
		//borrar archivo
		$receta = $this->Ctrl_panelReceta->get_by_id($id);
		if(file_exists('./assets/images/uploads/'.$receta->IMAGEN) && $receta->IMAGEN)
			unlink('./assets/images/uploads/'.$receta->IMAGEN);
		
		$this->Ctrl_panelReceta->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

   //Permite cargar imagenes a la carpeta assets\images\uploads
	private function _do_upload()
	{
		$config['upload_path']          = './assets/images/uploads/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 100; // Establecer el tamaño máximo permitido en Kilobyte de la imagen
        $config['max_width']            = 1000; // Establecer el ancho máximo permitido de la imagen
        $config['max_height']           = 1000; // Establecer la altura máxima permitida
        $config['file_name']            = round(microtime(true) * 1000); // Marca de tiempo para nombre de imagen

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('Imagen'))//Subir y validar imagen
        {
            $data['inputerror'][] = 'Imagen';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //Mostrar error ajax
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

    //Permite la validacion de los campos del formulario para la funcion agregar y editar de la vista
    //vis_panelReceta.php 
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('Nombre') == '')
		{
			$data['inputerror'][] = 'Nombre';
			$data['error_string'][] = 'Nombre es requerido';
			$data['status'] = FALSE;
		}

		if($this->input->post('Detalle') == '')
		{
			$data['inputerror'][] = 'Detalle';
		//	$data['error_string'][] = 'Detalle es requerido';
			$data['status'] = FALSE;
		}



		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
