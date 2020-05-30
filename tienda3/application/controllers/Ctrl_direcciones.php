<?php
//************************************************************************************
//Este módulo corresponde con el controlador que permite cargar la vista de direcciones 
//que se muestra a los usuarios, y que además provee la funcionalidad CRUD para las 
//direcciones del usuario
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************


defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_direcciones extends CI_Controller {
	
	//Método constructor que permite inicializar clases paternas y librerías
    public function __construct()
    {
		parent::__construct();
		$this->load->helper('url_helper');//Permite utilizar funciones y sintáxis de librería para manejar URLs
		$this->load->model('Model_Usuario','',TRUE);//Carga modelo usuario y permite conexiones a las funciones
		$this->load->model('Model_Direccion','',TRUE);//Carga modelo direccion y permite conexiones a las funciones
		$this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
    }

	//Método de inicio carga los elementos para vista y elementos funcionales
    public function index()
    {
        $this->load->helper('html');//Permite utilizar funciones y sintáxis de librería para manejar elementos html
        $this->load->helper('form');//Permite utilizar funciones y sintáxis de librería para manejar elementos de form
        $this->load->library('form_validation');//Permite utilizar funciones y sintáxis de librería para validaciones de form
        $data['title'] = 'Direcciones';//Título mostrado en la pestaña del browser
        $estadoCambio = false;//Variable que identifica si se realizan cambios a información de direcciones
        $verificador = 1;//Variable que identificar si existen registros de direcciones en la BD 
		$modalValid = 1;//Variable que identifica si existió algún error en los datos de entrada del form de modificación
		$modalAgregValid = 1;////Variable que identifica si existió algún error en los datos de entrada del form de agregar

		$data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        $session_data=$this->session->userdata('ax');//Variable que almacena datos de sesión del usuario
        $data['infoId'] = $session_data['idUsuario'];//Guarda id dentro del arreglo que se manda a la vista
        $data['infoUser'] = $session_data['nombre'];//Guarda nombre dentro del arreglo que se manda a la vista
        $data['infoapellido1'] = $session_data['apellido1'];//Guarda apellido dentro del arreglo que se manda a la vista
        $data['infoapellido2'] = $session_data['apellido2'];//Guarda apellido dentro del arreglo que se manda a la vista
        $data['infocedula'] = $session_data['cedula'];//Guarda cédula dentro del arreglo que se manda a la vista
        $data['infocorreo'] = $session_data['correo'];//Guarda correo dentro del arreglo que se manda a la vista
        $data['infotelefono'] = $session_data['telefono'];//Guarda teléfono dentro del arreglo que se manda a la vista
        
		
		$data['queryDirecciones'] = $this->Model_Direccion->met_traerDirecciones($data['infoId']);
		if (empty($data['queryDirecciones'])){
			$verificador = 0;
		}
		
		$data['verificador'] = $verificador;
		$data['modalValid'] = $modalValid;
		$data['modalAgregValid'] = $modalAgregValid;

		$this->form_validation->set_rules('id', 'Identificador', 'required');
        $this->form_validation->set_rules('referencia', 'Referencia', 'required');
        $this->form_validation->set_rules('provincia', 'Provincia', 'required');
        $this->form_validation->set_rules('canton', 'Canton','required');
        $this->form_validation->set_rules('distrito', 'Distrito', 'required');
        $this->form_validation->set_rules('localizacion', 'Detalle', 'required');




        if ($this->form_validation->run() === FALSE){
			
            $this->load->helper('html');
			$loginstatus = $this->session->userdata('ax');
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
			$rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }else{
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/direccionesusuario',$data);
            $this->load->view('templates/footer',$data);

        }else
        {
        }

    }

    //Método para modificar los datos de una direccion que se le muestra al usuario
	public function met_modifDir(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        $data['title'] = 'Direcciones';
        $estadoCambio = false;
        $verificador = 1; //modal valdacion
		$modalValid = 1;//modal validacion
		$modalAgregValid = 1;//modal validacion
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        
		
		$data['queryDirecciones'] = $this->Model_Direccion->met_traerDirecciones($data['infoId']);
		if (empty($data['queryDirecciones'])){
			$verificador = 0;
		}
		
		$data['verificador'] = $verificador;
		$data['modalValid'] = $modalValid;
		$data['modalAgregValid'] = $modalAgregValid;

		$this->form_validation->set_rules('id', 'Identificador', 'required');
        $this->form_validation->set_rules('referencia', 'Referencia', 'required');
        $this->form_validation->set_rules('provincia', 'Provincia', 'required');
        $this->form_validation->set_rules('canton', 'Canton','required');
        $this->form_validation->set_rules('distrito', 'Distrito', 'required');
        $this->form_validation->set_rules('localizacion', 'Detalle', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$data['modalValid'] = 0;
			
			
			
            $this->load->helper('html');
			$loginstatus = $this->session->userdata('ax');
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
			$rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }else{
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/direccionesusuario',$data);
            $this->load->view('templates/footer',$data);

        }else{
			$modId =$this->input->post('id');
			$modRefer =$this->input->post('referencia');
			$modProv =$this->input->post('provincia');
			$modCan =$this->input->post('canton');
			$modDis =$this->input->post('distrito');
			$modDet =$this->input->post('localizacion');
			
			$queryPorUsuarioDireccion = $this->Model_Direccion->met_traerDirPorIdUsuarioIdDirec($data['infoId'],$modId);

			
			if($modRefer!=$queryPorUsuarioDireccion->REFER){
                    $this->Model_Direccion->met_modReferencia($modRefer,$data['infoId'],$modId);
                    $estadoCambio = true;
                } 
			
			if($modProv!=$queryPorUsuarioDireccion->PROV){
                    $this->Model_Direccion->met_modProv($modId,$modProv);
                    $estadoCambio = true;
                } 			
			
			if($modCan!=$queryPorUsuarioDireccion->CANT){
                    $this->Model_Direccion->met_modCan($modId,$modCan);
                    $estadoCambio = true;
                }
				
			if($modDis!=$queryPorUsuarioDireccion->DIST){
                    $this->Model_Direccion->met_modDis($modId,$modDis);
                    $estadoCambio = true;
                }	
				
			if($modDet!=$queryPorUsuarioDireccion->LOCA){
                    $this->Model_Direccion->met_modDet($modId,$modDet);
                    $estadoCambio = true;
                }		
			if($estadoCambio){
				echo "<script type='text/javascript'>alert('Dirección modificada correctamente!')</script>";
		   }else{
				echo "<script type='text/javascript'>alert('No se modificó ningun dato.')</script>";
		   }
		   redirect('Ctrl_direcciones', 'refresh'); 
			
			
			
			
		}
		
	}
	
	//Método para agregar una direccion que el usuario agregue al sistema 
	public function met_agregarDir(){
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Direcciones';
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        $estadoCambio = false;
        $verificador = 1; //modal valdacion
		$modalValid = 1;//modal validacion
		$modalAgregValid = 1;//modal validacion
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        
		
		$data['queryDirecciones'] = $this->Model_Direccion->met_traerDirecciones($data['infoId']);
		if (empty($data['queryDirecciones'])){
			$verificador = 0;
		}
		
		$data['verificador'] = $verificador;
		$data['modalValid'] = $modalValid;
		$data['modalAgregValid'] = $modalAgregValid;

		
        $this->form_validation->set_rules('referenciaAg', 'Referencia', 'required');
        $this->form_validation->set_rules('provinciaAg', 'Provincia', 'required');
        $this->form_validation->set_rules('cantonAg', 'Canton','required');
        $this->form_validation->set_rules('distritoAg', 'Distrito', 'required');
        $this->form_validation->set_rules('localizacionAg', 'Detalle', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$data['modalAgregValid'] = 0;
			
			
			
            $this->load->helper('html');
			$loginstatus = $this->session->userdata('ax');
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
			$rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }else{
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/direccionesusuario',$data);
            $this->load->view('templates/footer',$data);

        }else{
			
			$modRefer =$this->input->post('referenciaAg');
			$modProv =$this->input->post('provinciaAg');
			$modCan =$this->input->post('cantonAg');
			$modDis =$this->input->post('distritoAg');
			$modDet =$this->input->post('localizacionAg');
			$lugar = $this->input->post('tienda');
			
			$this->Model_Direccion->met_agreDirec($modProv,$modCan,$modDis,$modDet);
			$latestId = ($this->Model_Direccion->met_getLastDir())->ID_DIRECCION;
			$this->Model_Direccion->met_agregarDetDir($data['infoId'],$latestId,$modRefer);
			if($lugar==tienda){
				redirect('productosUsuarios', 'refresh');	
			}
			echo "<script type='text/javascript'>alert('Dirección agregada correctamente!')</script>";
					redirect('Ctrl_direcciones', 'refresh');
		
			
			
			
			
		}
		
	}
	

	//Método para eliminar una direccion si el usuario lo desea
	public function met_elimDir(){
		
		$session_data=$this->session->userdata('ax');
        $delIdUsuario= $session_data['idUsuario'];
		$delIdDireccion =$this->input->post('idEli');
		$delRefer =$this->input->post('referenciaEli');
		
		$this->Model_Direccion->met_borDetDir($delIdUsuario,$delIdDireccion);
		$this->Model_Direccion->met_borDirec($delIdDireccion);
		echo "<script type='text/javascript'>alert('Dirección eliminada correctamente!')</script>";
		redirect('Ctrl_direcciones', 'refresh'); 
		
		
	}





    
}
