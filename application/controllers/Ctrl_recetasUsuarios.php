<?php
//************************************************************************************
//Este módulo se encarga de proveer una interfaz para utilizar el modelo recetas
//para cargar la informacion de recetas del sistema en la vista recetas 
//(recetausuario.php).
//Autor: Gabriel Aleman
//Fecha de creación: 25/07/2018
//Lista modificaciones
//25/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_recetasUsuarios extends CI_Controller {

    //Permite cargar los modelos necesarios para crear las conexiones a las funciones.
	public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->model('Model_Receta','',TRUE);
            $this->load->model('Model_Usuario','',TRUE);
            $this->load->model('Model_TemaActual','',TRUE);
    }

    //Permite llamar y cargar las librerias Codeigniter para las vistas, formularios y validacion de formaularios
    public function index()
    {
        $this->load->helper('html');
       
       //Permite verifica el estado de la sesion del usuario
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();//Para tener tema en uso

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/recetausuario',$data);
            $this->load->view('templates/footer',$data);
        }
        else{
            //Permite verifica el tipo de Rol de usuario
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/recetausuario',$data);
                $this->load->view('templates/footer',$data);
            }
            else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/recetausuario',$data);
                $this->load->view('templates/footer',$data);
            }
        }
    }	
}

