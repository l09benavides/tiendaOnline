<?php
//************************************************
//Este controller sirve para la vista de cambio de contraseñas en perfilUsuario.php (El modal con id= modalPass)
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//29/06/2018 Javier Trejos
//Se agregan validaciones y las variables para levantar el modal de vuelta
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_cambioContrasena extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
        }


public function index(){
  //El formulario del modal descrito al principio de este documento utiliza todo el controler como un solo método
  //No recibe parámetros como tal pero valida datos por medio de POST
  //Valida que las contraseña anterior sea la correcta y si lo es envía un query por medio del método met_modContrasena al Modelo de Usuarios para cambiar la contraseña del usuario

  $this->load->helper('form');
  $this->load->library('form_validation');
  $estadoCambio = false; //variable para revisar cambios
  $validacionPass = 1; //variable para volver a levantar el modal si ocurre un error
  $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
  $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
         

   //$this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|xss_clean');
   //$this->form_validation->set_rules('contrasena', 'Contrasena', 'trim|required|xss_clean|callback_check_database');

    $this->form_validation->set_rules('contrasenaActual', 'ContrasenaActual', 'required|callback_check_database');

   $this->form_validation->set_rules('contrasena', 'Contraseña','required');

    $this->form_validation->set_rules('contrasenaver', 'Validación de Contraseña', 'required|matches[contrasena]');



   if($this->form_validation->run() === FALSE){
      $this->load->helper('html');
     
      $data['validacionPass'] = 0;
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
            
        }else{
          $varId = $data['infoId'];
          $varContrasena = $this->input->post('contrasena');

          if($varContrasena!=NULL){
              $this->Model_Usuario->met_modContrasena($varId,$varContrasena); //PASSWORD en MODEL
              $estadoCambio = true;
          }



         

                    if($estadoCambio){
                    echo "<script type='text/javascript'>alert('¡Contraseña Cambiada Correctamente!')</script>";
                       }else{
                        echo "<script type='text/javascript'>alert('No se modificó ningun dato.')</script>";
                       }
                       redirect('Ctrl_perfilUsuario', 'refresh');       

   }
}

function check_database($contrasenaActual){
   //Esté metodo recibe la constraseñaActual y mediante post utiliza el correo para revisar si coincide con la Base de datos
  $session_data=$this->session->userdata('ax');
   $correo = $session_data['correo'];
   //query the database
   $result = $this->Model_Usuario->met_login($correo, $contrasenaActual);

   if($result){

     return TRUE;
   }else{

     $this->form_validation->set_message('check_database', 'Contraseña Actual incorrecta');
     return false;

   }
 }









}