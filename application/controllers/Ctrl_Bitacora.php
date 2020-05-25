<?php
//************************************************************************************
// Este modulo se encarga de proveer una interfaz para utilizar el Modelo para cargar
//la informacion de bitacora del sistema,
//Autor: Luis Benavides
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************


defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Bitacora extends CI_Controller {

	//Metodo constructor que inicializa la clase
    public Function __construct()
	{
		parent::__construct();
		$this->load->library("bitacora"); //Carga la libreria de Bitacora con las funciones necesarias

        $this->load->model('Model_Usuario','',TRUE); //carga el modelo de usuario
        $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO

		$loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario!="ADMIN"){
                redirect('Ctrl_bienvenida','refresh');
            }
        }
	}

    //Metodo de inicio de la clase, carga la pagina a mostrar
	public Function index()
	{
		$this->load->helper('html');
		$data['lista'] = $this->bitacora->Todos();
		$data['title'] = "Reporte Bitacora";
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO


 		$session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];


        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/bitacora/index',$data);
            $this->load->view('templates/footer',$data);
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/bitacora/index',$data);
                $this->load->view('templates/footer',$data);
            }
            else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/bitacora/index',$data);
                $this->load->view('templates/footer',$data);
            }
        }
	}


}