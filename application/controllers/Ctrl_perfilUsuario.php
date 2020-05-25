<?php
//************************************************
//Control de perfil de usuarios para recibir y enviar información a la Base de Datos
//
//Autor: Diego Carrillo
//Fecha de Creación: 27/05/2018
//Lista de Modificaciones:
//20/07/2018 Javier Trejos
//Se agregaron Metodos para el panel de usuarios (Traer Usuarios, Opciones de Rol y Validaciones)
//29/09/2018 Diego Carrillo/Berny Hernandez
//Se agrego la documentacion interna necesaria para la correcta descripcion de metodos.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

///Método con el cual se agrega un usuario a la base de datos.
class Ctrl_perfilUsuario extends CI_Controller {
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
// Función para levantar los datos almacenados del usuario y modificarlos en caso de ser requerido por el usuario. 
// Aqui mismo se valida que el usuario no ingrese datos que se encuentran en la base de datos. La cédula y el correo electrónico son datos únicos en la base de datos.
    public function index()
    {
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Perfil del usuario';
        $estadoCambio = false;
        $validacionPass = 1; //modal valdacion

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        $data['validacionPass'] = $validacionPass;
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();


        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido_1', 'PrimerApellido', 'required');
        $this->form_validation->set_rules('apellido_2', 'SegundoApellido');

        $this->form_validation->set_rules('cedula', 'Cedula', 'required');
        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email');

        $this->form_validation->set_rules('telefono', 'Telefono', 'required');


        //$this->form_validation->set_rules('contrasena', 'Contrasena','required');
        //$this->form_validation->set_rules('contrasenaver', 'Validación de Contraseña', 'required|matches[contrasena]');



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
            $this->load->view('pages/perfilusuario',$data);
            $this->load->view('templates/footer',$data);

        }else
        {

                                //$this->check_cedulaORuserORemail();
                $varId = $data['infoId'];
                $varNombre = $this->input->post('nombre');
                $varApellido1 = $this->input->post('apellido_1');
                $varApellido2 = $this->input->post('apellido_2');
                $varCedula = $this->input->post('cedula');
                $varCorreo = $this->input->post('correo');
                $varTelefono = $this->input->post('telefono');
                //$varContrasena = $this->input->post('contrasena');


                if($varCedula!=$data['infocedula']){
                    $chequeoCedula = $this->Model_Usuario->met_checkduplicatesCedula($varCedula);
                    if($chequeoCedula){
                        echo "<script type='text/javascript'>alert('Este registro ya existe. Por favor revise sus datos o refiérase al acceso de recuperación de contraseña')</script>";
                               redirect('Ctrl_perfilUsuario', 'refresh');  
                    }
                    $this->Model_Usuario->met_modCedula($varId,$varCedula);
                    $estadoCambio = true;
                }

                if($varCorreo!=$data['infocorreo']){
                    $chequeoCorreo = $this->Model_Usuario->met_checkduplicatesCorreo($varCorreo);
                    if($chequeoCorreo){
                        echo "<script type='text/javascript'>alert('Este registro ya existe. Por favor revise sus datos o refiérase al acceso de recuperación de contraseña')</script>";
                               redirect('Ctrl_perfilUsuario', 'refresh');  
                    }
                    $this->Model_Usuario->met_modCorreo($varId,$varCorreo);
                    $estadoCambio = true;
                }

                if($varNombre!=$data['infoUser']){
                    $this->Model_Usuario->met_modNombre($varId,$varNombre);
                    $estadoCambio = true;
                }

                if($varApellido1!=$data['infoapellido1']){
                    $this->Model_Usuario->met_modApellido_1($varId,$varApellido1);
                    $estadoCambio = true;
                }

                if($varApellido2!=$data['infoapellido2']){
                    $this->Model_Usuario->met_modApellido_2($varId,$varApellido2);
                    $estadoCambio = true;
                }




                if($varTelefono!=$data['infotelefono']){
                    $this->Model_Usuario->met_modTelefono($varId,$varTelefono);
                    $estadoCambio = true;
                }

                /*if($varContrasena!=NULL){
                    $this->Model_Usuario->met_modContrasena($varId,$varContrasena);
                    $estadoCambio = true;
                }*/



                                $resultado = $this->Model_Usuario->met_busUsuarioPorId($varId);



                if($resultado){
                    $sess_array = array();
                    foreach($resultado as $row){

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

					if($estadoCambio){
					echo "<script type='text/javascript'>alert('¡Usuario modificado correctamente!')</script>";
                       }else{
                        echo "<script type='text/javascript'>alert('No se modificó ningun dato.')</script>";
                       }
                       redirect('Ctrl_perfilUsuario', 'refresh');       
                    }
                }else{
                    echo "<script type='text/javascript'>alert('¡Error al recobrar información de la Base de Datos!')</script>";
                       redirect('Ctrl_bienvenida', 'refresh');
                }   
            



        }

    }


	//Esta función identifica cambios provenientes del form de modificación y actualiza la BD de ser necesario
    public function met_redireccionModContra()
    {
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Perfil del usuario';
        $estadoCambio = false;
        $validacionPass = 0; //modal valdacion

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        $data['validacionPass'] = $validacionPass;
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();


        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido_1', 'PrimerApellido', 'required');
        $this->form_validation->set_rules('apellido_2', 'SegundoApellido');

        $this->form_validation->set_rules('cedula', 'Cedula', 'required');
        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email');

        $this->form_validation->set_rules('telefono', 'Telefono', 'required');


        //$this->form_validation->set_rules('contrasena', 'Contrasena','required');
        //$this->form_validation->set_rules('contrasenaver', 'Validación de Contraseña', 'required|matches[contrasena]');



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
            $this->load->view('pages/perfilusuario',$data);
            $this->load->view('templates/footer',$data);

        }else
        {

                                //$this->check_cedulaORuserORemail();
                $varId = $data['infoId'];
                $varNombre = $this->input->post('nombre');
                $varApellido1 = $this->input->post('apellido_1');
                $varApellido2 = $this->input->post('apellido_2');
                $varCedula = $this->input->post('cedula');
                $varCorreo = $this->input->post('correo');
                $varTelefono = $this->input->post('telefono');
                //$varContrasena = $this->input->post('contrasena');


                if($varCedula!=$data['infocedula']){
                    $chequeoCedula = $this->Model_Usuario->met_checkduplicatesCedula($varCedula);
                    if($chequeoCedula){
                        echo "<script type='text/javascript'>alert('Este registro ya existe. Por favor revise sus datos o refiérase al acceso de recuperación de contraseña')</script>";
                               redirect('Ctrl_perfilUsuario', 'refresh');  
                    }
                    $this->Model_Usuario->met_modCedula($varId,$varCedula);
                    $estadoCambio = true;
                }

                if($varCorreo!=$data['infocorreo']){
                    $chequeoCorreo = $this->Model_Usuario->met_checkduplicatesCorreo($varCorreo);
                    if($chequeoCorreo){
                        echo "<script type='text/javascript'>alert('Este registro ya existe. Por favor revise sus datos o refiérase al acceso de recuperación de contraseña')</script>";
                               redirect('Ctrl_perfilUsuario', 'refresh');  
                    }
                    $this->Model_Usuario->met_modCorreo($varId,$varCorreo);
                    $estadoCambio = true;
                }

                if($varNombre!=$data['infoUser']){
                    $this->Model_Usuario->met_modNombre($varId,$varNombre);
                    $estadoCambio = true;
                }

                if($varApellido1!=$data['infoapellido1']){
                    $this->Model_Usuario->met_modApellido_1($varId,$varApellido1);
                    $estadoCambio = true;
                }

                if($varApellido2!=$data['infoapellido2']){
                    $this->Model_Usuario->met_modApellido_2($varId,$varApellido2);
                    $estadoCambio = true;
                }




                if($varTelefono!=$data['infotelefono']){
                    $this->Model_Usuario->met_modTelefono($varId,$varTelefono);
                    $estadoCambio = true;
                }

                /*if($varContrasena!=NULL){
                    $this->Model_Usuario->met_modContrasena($varId,$varContrasena);
                    $estadoCambio = true;
                }*/



                                $resultado = $this->Model_Usuario->met_busUsuarioPorId($varId);

                if($resultado){
                    $sess_array = array();
                    foreach($resultado as $row){

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

					if($estadoCambio){
					echo "<script type='text/javascript'>alert('¡Usuario modificado correctamente!')</script>";
                       }else{
                        echo "<script type='text/javascript'>alert('No se modificó ningun dato.')</script>";
                       }
                       redirect('Ctrl_perfilUsuario', 'refresh');       
                    }
                }else{
                    echo "<script type='text/javascript'>alert('¡Error al recobrar información de la Base de Datos!')</script>";
                       redirect('Ctrl_bienvenida', 'refresh');
                }   
            



        }

    }




	
}
