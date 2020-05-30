<?php
//************************************************
//Este controller es utilizado por el panel de usuarios en el módulo general de administrador (vista panelUsuarios.php)
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//28/06/2018 Javier Trejos
//Se generan metodos de validación para confirmar si cambiar el rol a un usuario normal o cambiar el rol del administrador logeado
//**************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelUsuarios extends CI_Controller {

	public function __construct(){
        //Consturctor para cargar los modelos y generar la sesión del administrador

                parent::__construct();
                $this->load->helper('url_helper');
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE);
                
                $loginstatus = $this->session->userdata('ax');
                $rolechecker = $loginstatus['idRol'];
                if ($loginstatus == null){redirect('Ctrl_bienvenida','refresh');}else{
                $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
    			$rolUsuario = $buscaRol->TIPO;
                if($rolUsuario!="ADMIN"){
                    redirect('Ctrl_bienvenida','refresh');
                }
            }
        }

        public function index(){

        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $estadoCambio = false;
        // variable si se cambio información del form
        $verificador = 1; 
        // variable para mostrar error si no hay datos para mostrar
        $modalValid = 1;// variable para mostrar el modal de modificación y recargarlo si hubieron errores
        $modalAgregValid = 1;// variable para mostrar el modal de agregar y recargarlo si hubieron errores
        $verificadorRol = 0;// variable para mostrar el modal para confirmar el cambio de rol
        $rolAV = 0;// variable para validar si el usuario a modificar es actualmente usuario normal o admin
        $idUC = 0; // variable para manejar el id del usuario a modificar.
        $propioPerfil = 0; //variable para ver si es el perfil del administrador logeado que se va a modificar
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //aplicar tema actual



        $data['queryUsuarios'] = $this->Model_Usuario->met_traerUsuarios(); // llama al metodo met_traerUsuarios del Modelo Usuarios para traer todos los usuarios
        if (empty($data['queryUsuarios'])){
            $verificador = 0;
        }

        $data['queryRoles'] = $this->Model_Usuario->met_opcionesRol();
        // llama al metodo met_opcionesRol para trear los roles disponibles
        $data['idUC'] = $idUC;
        $data['rolAV'] = $rolAV;
        $data['verificadorRol'] = $verificadorRol;
        $data['verificador'] = $verificador;
        $data['modalValid'] = $modalValid;
        $data['modalAgregValid'] = $modalAgregValid;
        $data['propioPerfil'] = $propioPerfil;

        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido_1', 'PrimerApellido', 'required');
        $this->form_validation->set_rules('apellido_2', 'SegundoApellido');

        $this->form_validation->set_rules('cedula', 'Cedula', 'required');
        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email');

        $this->form_validation->set_rules('telefono', 'Telefono', 'required');

         if($this->session->userdata('ax')){
            $session_data=$this->session->userdata('ax');
            $data['infoUser'] = $session_data['nombre'];
            $this->load->helper('html');
            $this->load->view('templates/headerAdmin',$data);
            $this->load->view('admin/panelUsuarios',$data);
            $this->load->view('templates/footer',$data);
        }else{
            redirect('Ctrl_bienvenida','refresh');
        }
    }

    public function met_agregarUsuario(){ //Método para agregar un administrador
        //no recibe datos, solo envía un insert al Modelo de Usuarios mediante el método met_setadmin(); 
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $estadoCambio = false;
        $verificador = 1; //modal valdacion
        $modalValid = 1;//modal validacion
        $modalAgregValid = 1;//modal validacion
        $verificadorRol = 0;
        $rolAV = 0;
        $idUC = 0;
        $propioPerfil = 0;
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();


        $data['queryRoles'] = $this->Model_Usuario->met_opcionesRol();

        $data['queryUsuarios'] = $this->Model_Usuario->met_traerUsuarios();
                if (empty($data['queryUsuarios'])){
                    $verificador = 0;
                }
        $data['rolAV'] = $rolAV;
        $data['idUC'] = $idUC;
        $data['verificador'] = $verificador;
        $data['modalValid'] = $modalValid;
        $data['modalAgregValid'] = $modalAgregValid;
         $data['verificadorRol'] = $verificadorRol;
         $data['propioPerfil'] = $propioPerfil;

        $this->form_validation->set_rules('nombre', 'Nombre', 'required',array('required'=>'El nombre es requerido.'));
        $this->form_validation->set_rules('apellido_1', 'PrimerApellido', 'required',array('required'=>'El primer apellido es requerido.'));
        $this->form_validation->set_rules('apellido_2', 'SegundoApellido');

        $this->form_validation->set_rules('cedula', 'Cedula', 'required|is_unique[USUARIOS.CEDULA]',array('required'=>'La cédula es requerida.','is_unique'=>'Esta cédula ya está registrada.'));

        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email|is_unique[USUARIOS.CORREO]',array('required'=>'El correo es requerido.','is_unique'=>'Este correo ya está registrado.'));

        $this->form_validation->set_rules('telefono', 'Telefono', 'required',array('required'=>'El teléfono es requerido.'));
       
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required',array('required'=>'La contraseña es requerida.'));
        $this->form_validation->set_rules('contrasenaver', 'Validación de contraseña', 'required|matches[contrasena]',array('required'=>'La corroboración de contraseña es requerida.','matches'=>'La verificación no coincide con la contraseña escrita.'));
        //TÉRMINOS Y CONDICIONES
        // $this->form_validation->set_rules('terminos', 'Terminos', 'required',array('required'=>'Debe aceptar los Términos y Condiciones del Sitio.'));   
            

        if ($this->form_validation->run() === FALSE){
            $data['modalAgregValid'] = 0;
            
            
                if($this->session->userdata('ax')){
                    $session_data=$this->session->userdata('ax');
                    $data['infoUser'] = $session_data['nombre'];
                    $this->load->helper('html');
                    $this->load->view('templates/headerAdmin',$data);
                    $this->load->view('admin/panelUsuarios',$data);
                    $this->load->view('templates/footer',$data);
                }else{
                    redirect('Ctrl_bienvenida','refresh');
                }

            }else{
                
            //Testing validation rule for uniqueness
                $result = $this->Model_Usuario->met_setadmin();

                if($result){
                       echo "<script type='text/javascript'>alert('¡Administrador registrado correctamente! ' )</script>";
                       redirect('Ctrl_panelUsuarios', 'refresh');      
                }else{

                     echo "<script type='text/javascript'>alert('Error!')</script>";
                        
                   }


                }

    }

    public function met_valRolActual(){//método para validar si el rol que se va a modificar es del administrador logeado en esa sesión o bien si es de un usuario normal, usado por modal con id= modalPass
        //No recibe parámetros.
        //Retorna 3 posibles escenarios: 
        //1- el Modal de Confirmar Cambio de Rol a Usuario Normal, si el rol a modificar es de usuario normal
        //2- el Modal de Confirmar Cambio en Perfil Propio, si el rol a modificar es del administrador logeado
        //3- si no es ninguna de las anteriores se envía el query al modelo de usuarios para modificar el rol
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $estadoCambio = false;
        $verificador = 1; //modal valdacion
        $modalValid = 1;//modal validacion
        $modalAgregValid = 1;//modal validacion
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

         $data['queryUsuarios'] = $this->Model_Usuario->met_traerUsuarios();
        if (empty($data['queryUsuarios'])){
            $verificador = 0;
        }

         $data['verificador'] = $verificador;
        $data['modalValid'] = $modalValid;
        $data['modalAgregValid'] = $modalAgregValid;

        $session_data=$this->session->userdata('ax');
                $idSession = $session_data['idUsuario'];

        $data['queryRoles'] = $this->Model_Usuario->met_opcionesRol();

        $verificaRol =  $this->input->post('rol');
        $rolActual = $this->input->post('rolact');
        $idUCambio = $this->input->post('id');

        if($verificaRol != 0){
            if($rolActual == "INVITADO" OR $rolActual == "USUARIO"){
                    $data['verificadorRol'] = 1;
                    $data['rolAV'] = $verificaRol;
                    $data['idUC'] = $idUCambio;
                    $data['propioPerfil'] = 0;
                    $session_data=$this->session->userdata('ax');
                    $data['infoUser'] = $session_data['nombre'];
                    $this->load->helper('html');
                    $this->load->view('templates/headerAdmin',$data);
                    $this->load->view('admin/panelUsuarios',$data);
                    $this->load->view('templates/footer',$data);
            }else{
                if ($idUCambio == $idSession){
                    $data['propioPerfil'] = 1;
                    $data['verificadorRol'] = 0;
                    $data['rolAV'] = $verificaRol;
                    $data['idUC'] = $idUCambio;
                    $session_data=$this->session->userdata('ax');
                    $data['infoUser'] = $session_data['nombre'];
                    $this->load->helper('html');
                    $this->load->view('templates/headerAdmin',$data);
                    $this->load->view('admin/panelUsuarios',$data);
                    $this->load->view('templates/footer',$data);
                } else {
            $result = $this->Model_Usuario->met_cambioRol();
            if ($result) {

               // echo "idUCambio: ".$idUCambio."    - rolActual: ".$rolActual."     - verificaRol: ".$verificaRol;
                 echo "<script type='text/javascript'>alert('¡Rol cambiado correctamente! ' )</script>";
                       redirect('Ctrl_panelUsuarios', 'refresh');
            }else{
                echo "<script type='text/javascript'>alert('Error!')</script>";
                redirect('Ctrl_panelUsuarios', 'refresh');
            }
        }
        }
    }else{
            echo "<script type='text/javascript'>alert('No se escogio ningun rol nuevo!')</script>";
            redirect('Ctrl_panelUsuarios', 'refresh');
        }
    }

    public function met_editarRol(){
        //Método utilizado por el Modal con id= modalValRol
        //No recibe datos
        //El método procede cuando se confirmó que el rol de un usuario normal si tiene que ser cambiado.
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $estadoCambio = false;
        $verificador = 1; //modal valdacion
        $modalValid = 1;//modal validacion
        $modalAgregValid = 1;//modal validacion

        $verificaRol =  $this->input->post('rolModVal');

        if($verificaRol != 0){
            $result = $this->Model_Usuario->met_cambioRolVal();
            if ($result) {
                 echo "<script type='text/javascript'>alert('¡Rol cambiado correctamente! ' )</script>";
                       redirect('Ctrl_panelUsuarios', 'refresh');
            }else{
                echo "<script type='text/javascript'>alert('Error!')</script>";
                redirect('Ctrl_panelUsuarios', 'refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('No se escogio ningun rol nuevo!')</script>";
            redirect('Ctrl_panelUsuarios', 'refresh');
        }

    }

    public function met_editarRolPerf(){
        //Método utilizado por el Modal con id= modalValRol
        //No recibe datos
        //El método procede cuando se confirmó que el rol de un usuario normal si tiene que ser cambiado.
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $estadoCambio = false;
        $verificador = 1; //modal valdacion
        $modalValid = 1;//modal validacion
        $modalAgregValid = 1;//modal validacion

        $verificaRol =  $this->input->post('rolModValPerf');

        if($verificaRol != 0){
            $result = $this->Model_Usuario->met_cambioRolPerfil();
            if ($result) {
                 echo "<script type='text/javascript'>alert('¡Rol cambiado correctamente! ' )</script>";
                       redirect('Ctrl_panelUsuarios', 'refresh');
            }else{
                echo "<script type='text/javascript'>alert('Error!')</script>";
                redirect('Ctrl_panelUsuarios', 'refresh');
            }
        }else{
            echo "<script type='text/javascript'>alert('No se escogio ningun rol nuevo!')</script>";
            redirect('Ctrl_panelUsuarios', 'refresh');
        }

    }



    public function met_elimUsuario(){
        //Método para eliminar usuario, no recibe parámetros
        //Envía el query para eliminar al usuario y se notifica  al adminsitrador
        $this->Model_Usuario->met_borUsuario();
        echo "<script type='text/javascript'>alert('Usuario eliminado correctamente!')</script>";
        redirect('Ctrl_panelUsuarios', 'refresh'); 
    }





    public function met_logout(){
        //Destruye sesión - Logout
       $this->session->unset_userdata('ax');
       session_destroy();
       redirect('Ctrl_bienvenida', 'refresh');
     }


}