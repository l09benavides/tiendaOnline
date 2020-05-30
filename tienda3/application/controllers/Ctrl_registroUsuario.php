<?php
//************************************************************************************
/*Este controlador forma parte del módulo de Login, contiene los métodos que permiten acceso a las vistas relacionadas con la página de registro de Usuario, permite además comunicación y transferencia de información con los modelos que tienen acceso a la BD, se comunica con los siguientes archivos:
-Model_Usuario
-Model_TemaActual.php
-registrousuario.php*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_registroUsuario extends CI_Controller {

	//Método constructor que permite inicializar clases paternas y librerías
	public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE);
                /*$loginstatus = $this->session->userdata('ax');
                $rolechecker = $loginstatus['idRol'];
                $buscaRol = $this->Usuario->met_searchrolname($rolechecker);
    			$rolUsuario = $buscaRol->TIPO;
                if($rolUsuario!="ADMIN"){
                    redirect('Ctrl_bienvenida','refresh');
                }*/
        }

	//Esta función permite mostrar la página de registro, brinda además la funcionalidad para realizar las validaciones necesarias para que se ingresen datos apropiados
	public function index()
	{
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Registrar nuevo usuario';
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();




    	$this->form_validation->set_rules('nombre', 'Nombre', 'required',array('required'=>'El nombre es requerido.'));
        $this->form_validation->set_rules('apellido_1', 'PrimerApellido', 'required',array('required'=>'El primer apellido es requerido.'));
        $this->form_validation->set_rules('apellido_2', 'SegundoApellido');

        $this->form_validation->set_rules('cedula', 'Cedula', 'required|is_unique[USUARIOS.CEDULA]',array('required'=>'La cédula es requerida.','is_unique'=>'Esta cédula ya está registrada.'));

        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email|is_unique[USUARIOS.CORREO]',array('required'=>'El correo es requerido.','is_unique'=>'Este correo ya está registrado.'));

        $this->form_validation->set_rules('telefono', 'Telefono', 'required',array('required'=>'El teléfono es requerido.'));
       
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required',array('required'=>'La contraseña es requerida.'));
        $this->form_validation->set_rules('contrasenaver', 'Validación de contraseña', 'required|matches[contrasena]',array('required'=>'La corroboración de contraseña es requerida.','matches'=>'La verificación no coincide con la contraseña escrita.'));
        //TÉRMINOS Y CONDICIONES
        $this->form_validation->set_rules('terminos', 'Terminos', 'required',array('required'=>'Debe aceptar los Términos y Condiciones del Sitio.'));   
            

   		if ($this->form_validation->run() === FALSE){

                $data['inicio'] = true;

                $this->load->helper('html');
				$this->load->view('templates/header',$data);
				$this->load->view('pages/registrousuario');
				$this->load->view('templates/footer',$data);

            }else{
                
			//Testing validation rule for uniqueness
            	$this->Model_Usuario->met_setuser();

				$result = $this->Model_Usuario->met_login($this->input->post('correo'), $this->input->post('contrasena'));

   				if($result){

				     $sess_array = array();
				     foreach($result as $row){

				       $sess_array = array(
				         'idUsuario' => $row->ID_USUARIO,
				         'idRol' => $row->ID_ROL,
				         'nombre' => $row->NOMBRE,
				         'apellido1' => $row->APELLIDO_1,
				         'apellido2' => $row->APELLIDO_2,
				         'cedula' => $row->CEDULA,
				         'correo' => $row->CORREO,
				         'telefono' => $row->TELEFONO
				         
				       );
				       $this->session->set_userdata('ax', $sess_array);
				       echo "<script type='text/javascript'>alert('¡Usuario registrado correctamente!')</script>";
				       redirect('Ctrl_bienvenidaUsuario', 'refresh');		
						}
				}else{

				     echo "<script type='text/javascript'>alert('Error!')</script>";
      					redirect('Ctrl_bienvenida', 'refresh');
				   }


				}

			}

		}	
