<?php
//**************************************************************************************
//Este controller es utilizado para mostrar la informacion del carrito, permite cambiar
//la direccion a la que se quiere enviar el pedido, y guardar la informacion de pago para
//enviar la transaccion a revision.
//Autor: Luis Benavies
//Fecha de Creación: 27/08/2018 
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Carrito extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
            $this->load->helper('url_helper');
            $this->load->helper('form');
            $this->load->model('Model_Transaccion','',TRUE);
            $this->load->model('Model_Direccion','',TRUE);
            $this->load->model('Model_Usuario','',TRUE);
            $this->load->model('Model_Producto','',TRUE);
            $this->load->model('Model_Imagen','',TRUE);
            $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
    }

    public function index()
    {
    	$imagenes = array();
        $this->load->helper('html');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        $data['productosImagenes'] = $this->Model_Imagen->met_traerImagenes();
        $data['title'] = 'Carrito de Compras';
        $modalRegistroValid = 1;
        $modalConfirmar = 0;
        $idTransac = 0; //se inicia el id de transaccion para verificaciones.
        $data['modalRegistroValid'] = $modalRegistroValid;
        $data['modalConfirmar'] = $modalConfirmar;
        $data['idTransac'] = $idTransac;

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/Carrito/carrito');
            $this->load->view('templates/footer',$data);
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;

            $session_data=$this->session->userdata('ax');
            $data['infoId'] = $session_data['idUsuario'];
            $data['infoUser'] = $session_data['nombre'];    

            $data['detalles'] = $this->Model_Transaccion->ObtenerInfoCarrito($session_data['idUsuario']);
            $data['carrito'] = $session_data['carrito'];
            $data['bancos'] = $this->Model_Transaccion->getAllBancos();
            $data['idTransac'] = $this->Model_Transaccion->TraerIdTransaccion($session_data['idUsuario']);
            $data['Direccones'] = $this->Model_Direccion->met_traerDirecciones($session_data['idUsuario']);

            foreach ($data['detalles'] as $key => $value) {
                $imagen = $this->Model_Producto->getProductobyCodigo($value->CODIGO);
                $value->imagen = $imagen->IMAGEN;
            }

            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/Carrito/carrito',$data);
                $this->load->view('templates/footer',$data);
            }
            else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/Carrito/carrito',$data);
                $this->load->view('templates/footer',$data);
            }
        }
    }

    public Function met_BorrarCarrito(){ // Funcion para borrar productos del carrito
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $session_data=$this->session->userdata('ax');
        
        $delIdProd = $this->input->post('idprod');
        $delIdTrans = $this->input->post('idTrans');

       
        $estado = $this->Model_Transaccion->removerDelCarrito($delIdTrans,$delIdProd);
        //Actualizamos el dato de la session del carrito
        $session_data['carrito'] = $this->Model_Transaccion->CantidadCarrito($session_data['idUsuario'])->CANTIDAD;
        $this->session->set_userdata('ax', $session_data);

        redirect('carrito', 'refresh');
    }
    	

    public Function met_ConfirmarCarrito(){ //Funcio para enviar el carrito a verificacion por un administrador
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');

        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        $data['productosImagenes'] = $this->Model_Imagen->met_traerImagenes();
        $data['title'] = 'Carrito de Compras';
        $modalRegistroValid = 1;
        $modalConfirmar = 0;
        $idTransac = 0;
        $data['modalRegistroValid'] = $modalRegistroValid;
        $data['modalConfirmar'] = $modalConfirmar;
        $data['idTransac'] = $idTransac;

        $session_data = $this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];

        $data['detalles'] = $this->Model_Transaccion->ObtenerInfoCarrito($session_data['idUsuario']);
        $data['carrito'] = $session_data['carrito'];
        $data['bancos'] = $this->Model_Transaccion->getAllBancos();
        $data['idTransac'] = $this->Model_Transaccion->TraerIdTransaccion($session_data['idUsuario']);

        foreach ($data['detalles'] as $key => $value) {
            $imagen = $this->Model_Producto->getProductobyCodigo($value->CODIGO);
            $value->imagen = $imagen->IMAGEN;
        }

        $this->form_validation->set_rules('SelectCodigo', 'Código de Transferencia', 'alpha_numeric|trim|required|min_length[4]|max_length[25]');

        if ($this->form_validation->run() === FALSE){ //Verificamos que la informacion este correcta

            $data['modalRegistroValid'] = 0;
            $data['modalConfirmar'] = 0;

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
            }else{ 
                $this->load->view('templates/headerUsuario',$data);
                }
            $this->load->view('pages/Carrito/carrito',$data);
            $this->load->view('templates/footer',$data);
            }
        }
        else{
            $IdTransac = $this->input->post('idTrans');
            $CodBanco = $this->input->post('SelectBanco');
            $CodCodigo = $this->input->post('SelectCodigo');
            $this->Model_Transaccion->registrarPagoCarrito($IdTransac, $CodBanco, $CodCodigo);//Agregamos la informacion de pago al carrito

            $data['modalConfirmar'] = 1;

            $session_data=$this->session->userdata('ax');
            $data['infoId'] = $session_data['idUsuario'];
            $data['infoUser'] = $session_data['nombre'];

            //Actualizamos el dato de la session del carrito
            $session_data['carrito'] = $this->Model_Transaccion->CantidadCarrito($session_data['idUsuario'])->CANTIDAD;
            $this->session->set_userdata('ax', $session_data);
            $data['modalConfirmar'] = 1;  
            $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
            $data['bancos'] = $this->Model_Transaccion->getAllBancos();
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
            }else{ 
                $this->load->view('templates/headerUsuario',$data);
                }
            $this->load->view('pages/Carrito/carrito',$data);
            $this->load->view('templates/footer',$data);
            }
        }
        
    }

    public function ajax_direcciones($id){ //Funcion para enviar las direcciones que tiene el usuario
        if ($this->input->is_ajax_request()) {//retorno de valores input de un javascripts(js)
            $data = $this->Model_Direccion->met_traerDirecciones($id);
            echo json_encode($data);
        }else{
            show_404();
        }
    }

    public function ajax_actualizarCantCarrito(){ //Funcion para actualizar el carrito con la informacion que se cambie
        if ($this->input->is_ajax_request()) {//retorno de valores input de un javascripts(js)
            $idTrans = $_POST['idTrans'];
            $idProd = $_POST['idProd'];
            $cant = $_POST['nuevaCant'];
                
            //Verificamos si ya existe el producto que intentamos agregar
            $detalles = $this->Model_Transaccion->ObtenerDetallesTransaccionProducto($idTrans,$idProd);
            $Subtotal = ($detalles->subtotal/$detalles->CANTIDAD)*$cant;
            if($detalles->DESCUENTO > 0){
                $descuento = ($detalles->DESCUENTO/$detalles->CANTIDAD)*$cant;
            }else{
                $descuento = 0;
            };
            $Total = ($detalles->TOTAL_PRODUCTO/$detalles->CANTIDAD)*$cant;
            //ACtualizamos los datos del producto
            $this->Model_Transaccion->actualizarDetallesCarrito($idTrans,$idProd,'CANTIDAD',$cant);
            $this->Model_Transaccion->actualizarDetallesCarrito($idTrans,$idProd,'PRECIO_SUBTOTAL',$Subtotal);
            $this->Model_Transaccion->actualizarDetallesCarrito($idTrans,$idProd,'DESCUENTO',$descuento);
            $this->Model_Transaccion->actualizarDetallesCarrito($idTrans,$idProd,'TOTAL_PRODUCTO',$Total);
        }else{
            show_404();
        }
    }


    public function ajax_actualizarDirCarrito(){ //Funcion para actualizar el carrito con la informacion de la direccion
        if ($this->input->is_ajax_request()) {//retorno de valores input de un javascripts(js)
            $field = "ID_DIRECCION";
            $idTrans = $_POST['idTrans'];
            $value = $_POST['idDir'];
            $data = $this->Model_Transaccion->actualizarCarrito($idTrans,$field,$value);
            echo json_encode($data);
        }else{
            show_404();
        }
    }
}
