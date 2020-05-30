<?php
//************************************************************************************
//Este módulo se encarga de proveer una interfaz para utilizar el modelo categorias
//para cargar la informacion de categorias del sistema en la vista categoria 
//(vis_categorias.php).
//Autor: Dany Alvarado
//Fecha de creación: 28/06/2018
//Lista modificaciones
//20/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Categorias extends CI_Controller {

   //Permite cargar los modelos necesarios para crear las conexiones a las funciones. 

	public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper'); //Permite utilizar funciones y sintáxis de librería para manejar URLs
            $this->load->model('Model_Categoria','',TRUE); //Carga modelo usuario y permite conexiones a las funciones
            $this->load->model('Model_Usuario','',TRUE); //Carga modelo usuario y permite conexiones a las funciones
            $this->load->model('Model_TemaActual','',TRUE); //Para tener el tema en uso
    }

   //Permite llamar y cargar las librerias Codeigniter para las vistas, formularios y validacion de formaularios
    public function index() 
    {
        $this->load->helper('html');

       //Permite Verifica el estado de la sesion del usuario 
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //Para tener tema en uso

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/vis_categorias',$data);
            $this->load->view('templates/footer',$data);
        }
        else{

           //Permite Verifica el tipo de Rol de usuario          
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/vis_categorias',$data);
                $this->load->view('templates/footer',$data);
            }
            else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/vis_categorias',$data);
                $this->load->view('templates/footer',$data);
            }
        }
    }	
}