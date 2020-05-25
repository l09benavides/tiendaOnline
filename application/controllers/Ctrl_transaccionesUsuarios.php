<?php
//************************************************************************************
//Este módulo se encarga de definir los métodos utilizados para gestionar las transacciones
//aprobadas, en proceso o rechazadas en la pagina de transacciones de usuario.
//Autor: Pablo Hernández
//Fecha de creación: 03/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//15/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');


//Método constructor que inicializa la clase Ctrl_transaccionesUsuarios
class Ctrl_transaccionesUsuarios extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->helper('form');

        $this->load->model('Model_Usuario','',TRUE); //carga el modelo de usuarios
        $this->load->model('Model_Transaccion','',TRUE); //carga el modelo de transacción
        $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO

    }
    //Método de inicio de la clase, carga la página a mostrar
    public function index()
    {
        $this->load->helper('html');

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        //ejecuta la validación del rol del usuario y asigna el acceso correspondiente
        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }
            else
            {
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/vis_paneltransaccionesUsuarios',$data);
            $this->load->view('templates/footer',$data);
        }
    }

    //Método de la clase de transacciones en proceso del usuario
    public function met_transancProceso()
    {
        $this->load->helper('html');

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        //Obtiene la información de las transacciones en proceso de cada usuario
        $data['Detalles'] = $this->Model_Transaccion->transaccionesPendientesUsuario($session_data['idUsuario'],'Revision');
        
        //ejecuta la validación del rol del usuario y asigna el acceso correspondiente
        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }
            else
            {
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/vis_transaccionesUsuarioProceso',$data);
            $this->load->view('templates/footer',$data);
        }
    }

    //Método de la clase de transacciones aprobadas del usuario
    public function met_transacAprobadas()
    {
        $this->load->helper('html');

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        //Obtiene la información de las transacciones aprobadas de cada usuario
        $data['Detalles'] = $this->Model_Transaccion->transaccionesPendientesUsuario($session_data['idUsuario'],'Facturado');

        //ejecuta la validación del rol del usuario y asigna el acceso correspondiente
        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }
            else
            {
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/vis_transaccionesUsuarioAprobadas',$data);
            $this->load->view('templates/footer',$data);
        }
    }

    //Método de la clase de transacciones rechazadas del usuario
    public function met_transacRechazadas()
    {
        $this->load->helper('html');

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

       //Obtiene la información de las transacciones rechazadas de cada usuario
        $data['Detalles'] = $this->Model_Transaccion->transaccionesPendientesUsuario($session_data['idUsuario'],'Rechazado');

        //ejecuta la validación del rol del usuario y asigna el acceso correspondiente
        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }
            else
            {
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/vis_transaccionesUsuarioRechazadas',$data);
            $this->load->view('templates/footer',$data);
        }
    }

    //Método para generar la factura de las transacciones aprobadas
    public function met_facturaUsuario()
    {
        $this->load->helper('html');

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();
        
        //Obtener datos del usuario y de la transacción para generar la factura
        $IdTransac = $this->input->post('IdTransaccion');
        $data['Usuario'] = $this->Model_Usuario->met_infoUsuario($session_data['idUsuario']);
        $data['DetalleFactura'] = $this->Model_Transaccion->ObtenerDetallesTransaccion($IdTransac);
        $data['Factura'] = $this->Model_Transaccion->TraerFactura($IdTransac);
		
		$varCorreo = $data['Usuario']->CORREO;
		$varNombreCompleto = $data['Usuario']->NOMBRE." ".$data['Usuario']->APELLIDO_1;

        //ejecuta la validación del rol del usuario y asigna el acceso correspondiente
        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
            }
            else
            {
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/vis_factura',$data);
            $this->load->view('templates/footer',$data);
        }
    }

}
