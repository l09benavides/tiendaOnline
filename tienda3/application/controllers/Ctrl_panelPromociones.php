<?php
//************************************************
//Este controller es usado por la vista panelPromociones.php
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//14/07/2018 Javier Trejos
//Se comento código para revisar su importancia, código de sesión que no se ejecuta.
//16/07/2018 Javier Trejos
//Se removió código que no se usaba, código previamente comentado.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_panelPromociones extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
                //constructor para cargar helper url y modelos
                $this->load->helper('url_helper');
                $this->load->model('Model_Usuario','',TRUE);
                $this->load->model('Model_Receta','',TRUE);
                $this->load->model('Model_TemaActual','',TRUE);
        }

	public function index()
	{
		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Promociones';
        $estadoCambio = false; //contenido promocion

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
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

            
            $this->load->view('admin/panelPromociones',$data);
            $this->load->view('templates/footer',$data);

			}

	public function met_creaPromo(){
        //Este método valida a traves de un formulario cuando un administrador quiere crear una nueva promoción. Devuelve un alert de confirmación si los datos son correctos o se muestra con un borde rojo y texto los campos incorrectos.

		$this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $promocionContenido = $this->Model_Receta->met_traerPromo();;

        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['infoapellido1'] = $session_data['apellido1'];
        $data['infoapellido2'] = $session_data['apellido2'];
        $data['infocedula'] = $session_data['cedula'];
        $data['infocorreo'] = $session_data['correo'];
        $data['infotelefono'] = $session_data['telefono'];
        $data['promocionContenido'] = $promocionContenido;
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

		$this->form_validation->set_rules('titulo', 'Titulo', 'required',array('required'=>'Se requiere un Título para la Promoción')); 
        $this->form_validation->set_rules('contenido', 'Contenido', 'required',array('required'=>'Se requiere un contenido / detalles para la Promoción')); 
        
            

   		if ($this->form_validation->run() === FALSE){
   			
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

            
            $this->load->view('admin/panelPromociones',$data);
            $this->load->view('templates/footer',$data);
             

            }else{
                
			//Testing validation rule for uniqueness
                $result = $this->Model_Receta->met_cambiarPromo();

                if($result){
                    echo "<script type='text/javascript'>alert('Promoción Cambiada correctamente!')</script>";
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

            
            $this->load->view('admin/panelPromociones',$data);
            $this->load->view('templates/footer',$data);
				       	
						}else{

				     echo "<script type='text/javascript'>alert('Error!')</script>";
      					redirect('Ctrl_bienvenida', 'refresh');
				   }


				}
	}

		}	
