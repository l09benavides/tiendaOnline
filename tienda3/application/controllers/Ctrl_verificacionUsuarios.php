<?php
//************************************************
//Este Controller es utilizado por el view accesousuario.php (Login) para logearse al sitio
//
//Autor: Diego Carrillo
//Fecha de Creación: 17/06/2018
//Lista de Modificaciones:
//20/06/2018 Diego Carrillo
//Se cambio el modo de verificación de nombre de usuario a correo
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_verificacionUsuarios extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_Transaccion','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE);
        }


public function index(){
//Se considera el index como el único método ya que se utiliza todo el controller para hacer solo el proceso de login
//Este método valida que los campos no estén vacios, y revisa que sean los correctos
  //El método crea una sesión si los datos son correctos para el usuario de lo contrario muestra un error.
  //$this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');

   //$this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|xss_clean');
   //$this->form_validation->set_rules('contrasena', 'Contrasena', 'trim|required|xss_clean|callback_check_database');

   $this->form_validation->set_rules('correo', 'Correo', 'trim|required|valid_email');
   $this->form_validation->set_rules('contrasena', 'Contrasena', 'trim|required|callback_check_database');
   $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();


   if($this->form_validation->run() == FALSE){ 
     //Field validation failed.  User redirected to login page
    $this->load->view('templates/header',$data);
    $this->load->view('pages/accesousuario');
    $this->load->view('templates/footer',$data);
   }else{
      //Verify type of role
    $cor = $this->input->post('correo');
    $contra = $this->input->post('contrasena');
    $resultado = $this->Model_Usuario->met_rolid($cor, $contra);
    $varRol = $resultado->ID_ROL;
    
    $buscaRol = $this->Model_Usuario->met_searchrolname($varRol);
    $rolUsuario = $buscaRol->TIPO;

    $session_data=$this->session->userdata('ax');
   if($session_data['passForgot']==1){
      redirect('Ctrl_verParTemp','refresh');
   }else{
    if($rolUsuario=="ADMIN"){
        //echo $opcion;
        redirect('Ctrl_bienvenidaAdmin', 'refresh');
      }elseif($rolUsuario=="USUARIO"){
        redirect('Ctrl_bienvenidaUsuario', 'refresh');
      }else{
        //echo "cliente";
        redirect('Ctrl_bienvenida','refresh');
      }
   }

   }
}

function check_database($contrasena){
   //Método para validad contra la BDD
   //Esté metodo recibe la constraseña y mediante post utiliza el correo para revisar si coincide con la Base de datos con el metodo del Modelo Usuarios met_login, si los datos son validados correctamente se crea la sesión
   $correo = $this->input->post('correo');

   //query the database
   $result = $this->Model_Usuario->met_login($correo, $contrasena);

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
         'telefono' => $row->TELEFONO,
         'passForgot' => $row->PASSFORGOT,
         'caducaRec' => $row->CADUCAREC,
         'carrito' => $this->Model_Transaccion->CantidadCarrito($row->ID_USUARIO)->CANTIDAD
       );
       $this->session->set_userdata('ax', $sess_array);
     }
     return TRUE;
   }else{

     $this->form_validation->set_message('check_database', 'Credenciales incorrectas');
     return false;

   }
 }









}
