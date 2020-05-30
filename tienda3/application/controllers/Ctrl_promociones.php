<?php
//************************************************
//Este controller es utilizado por el módulo de promociones (vista promociones.php)
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_promociones extends CI_Controller {

	public function __construct()
    //constructor para cargar helper url y modelos
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_Receta','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE);

                /*$loginstatus = $this->session->userdata('ax');
                $rolechecker = $loginstatus['idRol'];
                $buscaRol = $this->Usuario->met_searchrolname($rolechecker);
    			$rolUsuario = $buscaRol->TIPO;
                if($rolUsuario!="ADMIN"){
                    redirect('Ctrl_bienvenida','refresh');
                }*/
        }

	public function index()
	{
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Promociones';
        $estadoCambio = false;
        //variable para validar si cambio la promoción
        $modalP = 0; //utilizada en la vista para #modalAgregar
        $modalGracias = 0; //utilizada en la vista para #modalGra
        

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        $data['modalP'] = $modalP;
        $data['modalGracias'] = $modalGracias;
        $data['promocionContenido'] = $this->Model_Receta->met_traerPromo();
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        if($this->session->userdata('ax')){
                    $session_data=$this->session->userdata('ax');
                    $data['infoUser'] = $session_data['nombre'];
                    $this->load->helper('html');
                    $rolechecker = $session_data['idRol'];
                    $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
                    $rolUsuario = $buscaRol->TIPO;
                    if($rolUsuario=="ADMIN"){
		                $this->load->view('templates/headerAdmin',$data);
		            }else{
		                $this->load->view('templates/headerUsuario',$data);
		            }
                }else{
                    $this->load->view('templates/header',$data);
                }

            
            $this->load->view('pages/promociones',$data);
            $this->load->view('templates/footer',$data);

			}

	public function met_participa(){
        //este método sirve para registrar un usuario desde el formulario de participación desde la vista de promociones
        //Devuelve un error en el formulario si los datos son incorrectos o ya utilizados o registra el usuario e informa através del modalGracias al usuario

		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $modalP = 0; //modal agregar
        $modalGracias = 0; //modal de confirmación
        

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        $data['modalP'] = $modalP;
        $data['modalGracias'] = $modalGracias;
        $data['promocionContenido'] = $this->Model_Receta->met_traerPromo();
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

		$this->form_validation->set_rules('nombre', 'Nombre', 'required',array('required'=>'El nombre es requerido.'));
        $this->form_validation->set_rules('apellido_1', 'PrimerApellido', 'required',array('required'=>'El primer apellido es requerido.'));
        $this->form_validation->set_rules('apellido_2', 'SegundoApellido');

        $this->form_validation->set_rules('cedula', 'Cedula', 'required|numeric|is_unique[USUARIOS.CEDULA]',array('required'=>'La cédula es requerida.','is_unique'=>'Esta cédula ya está registrada.'));

        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email|is_unique[USUARIOS.CORREO]',array('required'=>'El correo es requerido.','is_unique'=>'Este correo ya está registrado.'));

        $this->form_validation->set_rules('telefono', 'Telefono', 'required',array('required'=>'El teléfono es requerido.'));
       
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required',array('required'=>'La contraseña es requerida.'));
        $this->form_validation->set_rules('contrasenaver', 'Validación de contraseña', 'required|matches[contrasena]',array('required'=>'La corroboración de contraseña es requerida.','matches'=>'La verificación no coincide con la contraseña escrita.'));
        //TÉRMINOS Y CONDICIONES
        $this->form_validation->set_rules('terminos', 'Terminos', 'required',array('required'=>'Debe aceptar los Términos y Condiciones del Sitio.'));   
            

   		if ($this->form_validation->run() === FALSE){
            //método de validación del form, si es falso (hay errores) abre de nuevo el modal del formulario
   			$data['modalP'] = 1;
   			if($this->session->userdata('ax')){
                    $session_data=$this->session->userdata('ax');
                    $data['infoUser'] = $session_data['nombre'];
                    $this->load->helper('html');
                    $rolechecker = $session_data['idRol'];
                    $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
                    $rolUsuario = $buscaRol->TIPO;
                    if($rolUsuario=="ADMIN"){
		                $this->load->view('templates/headerAdmin',$data);
		            }else{
		                $this->load->view('templates/headerUsuario',$data);
		            }
                }else{
                    $this->load->view('templates/header',$data);
                }

            
            $this->load->view('pages/promociones',$data);
            $this->load->view('templates/footer',$data);
             

            }else{
                
			//Regla de validación única
            	$this->Model_Usuario->met_setuser(2);

				$result = $this->Model_Usuario->met_login($this->input->post('correo'), $this->input->post('contrasena'));

   				if($result){
                    //verifica si el registro se completó correctamente através de una consulta a la BD

				     $data['modalGracias'] = 1;
				     if($this->session->userdata('ax')){
                    $session_data=$this->session->userdata('ax');
                    $data['infoUser'] = $session_data['nombre'];
                    $this->load->helper('html');
                    $rolechecker = $session_data['idRol'];
                    $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
                    $rolUsuario = $buscaRol->TIPO;
                    if($rolUsuario=="ADMIN"){
		                $this->load->view('templates/headerAdmin',$data);
		            }else{
		                $this->load->view('templates/headerUsuario',$data);
		            }
                }else{
                    $this->load->view('templates/header',$data);
                }

            
            $this->load->view('pages/promociones',$data);
            $this->load->view('templates/footer',$data);
				       	
						}else{

				     echo "<script type='text/javascript'>alert('Error!')</script>";
      					redirect('Ctrl_bienvenida', 'refresh');
				   }


				}
	}

		}	
