<?php
//**************************************************************************************
//Este controller es utilizado para mostrar los productos que los usuarios pueden comprar
//tambien se encarga de crear uns transaccion si el usuario no tiene una actualmente.
//Autor: Luis Benavies
//Fecha de Creación: 27/06/2018 
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_productosUsuarios extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->helper('form');

        $this->load->model('Model_Producto','',TRUE);
        $this->load->model('Model_Usuario','',TRUE);
        $this->load->model('Model_Transaccion','',TRUE);
        $this->load->model('Model_Direccion','',TRUE);
        $this->load->model('Model_Imagen','',TRUE);
        $this->load->model('Model_TemaActual','',TRUE);

       $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('carrito','refresh');
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario == NULL){
                redirect('Ctrl_bienvenida','refresh');
            }
        }

    }

    public function index()
    {
        $this->load->helper('html');

        $data['lista'] = $this->Model_Producto->getProductobyActivos();

        $data['productosImagenes'] = $this->Model_Imagen->met_traerImagenes();
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();
        $data['Direccones'] = $this->Model_Direccion->met_traerDirecciones($session_data['idUsuario']);

        $modalAgrValid = 1;
        $data['modalAgrValid'] = $modalAgrValid;
        $data['idProductoMod'] = 0;

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            $this->load->view('templates/header',$data);
            $this->load->view('pages/productos/productosUsuarios',$data);
            $this->load->view('templates/footer',$data);
        }
        else{
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/productos/productosUsuarios',$data);
                $this->load->view('templates/footer',$data);
            }
            else{
                $this->load->view('templates/headerUsuario',$data);
                $this->load->view('pages/productos/productosUsuarios',$data);
                $this->load->view('templates/footer',$data);
            }
        }
    }

    public Function met_AgregarCarrito()
    {
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');

        $session_data = $this->session->userdata('ax');

        $data['title'] = 'Agregar Producto al Carrito';
        $modalAgrValid = 1;
        $data['modalAgrValid'] = $modalAgrValid;
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();
        $data['Direccones'] = $this->Model_Direccion->met_traerDirecciones($session_data['idUsuario']);

        $this->form_validation->set_rules('ModalcantidadI', 'Cantidad', 'trim|required|is_natural_no_zero|min_length[1]|max_length[2]');

        if ($this->form_validation->run() === FALSE){//verificamos que todos datos que necesitamos estan correctos
            
            $data['modalAgrValid'] = 0;
            
            $this->load->helper('html');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->helper('url_helper');
            $this->load->library('form_validation');

            
            $data['infoId'] = $session_data['idUsuario'];
            $data['infoUser'] = $session_data['nombre'];
            $data['idProductoMod'] = $_COOKIE['idProducto'];
            $data['Direccones'] = $this->Model_Direccion->met_traerDirecciones($session_data['idUsuario']);
            $data['lista'] = $this->Model_Producto->getProductobyActivos();
        
            //no se puede ingresar al carrito sin login
            $loginstatus = $this->session->userdata('ax');
            $rolechecker = $loginstatus['idRol'];
            $buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
            $rolUsuario = $buscaRol->TIPO;
            if($rolUsuario=="ADMIN"){ 
                $this->load->view('templates/headerAdmin',$data);
            }else{ 
                $this->load->view('templates/headerUsuario',$data);
            }
            $this->load->view('pages/productos/productosUsuarios',$data);
            $this->load->view('templates/footer',$data);
        }
        else{
            //cargamos los datos que necesitamos para actualizar o crear el carrito
            $agrIdProd = $this->input->post('InIdProducto');
            $agrIdUsuario = $session_data['idUsuario'];
            $agrFecha = date("Y-m-d H:i:s");
            $agrPrecio = $this->input->post('InProductoPrecio');
            $agrPDesc = $this->input->post('InProductoPDescuento');
            $agrCant = $this->input->post('ModalcantidadI');
            $agrDesc = ($agrPrecio*$agrCant)*($agrPDesc/100);
            $agrSubTotal = ($agrPrecio*$agrCant) - $agrDesc;
            $agrTotal = $agrSubTotal + ($agrSubTotal*0.13);

            $detalles = array(
                'ID_PRODUCTO' =>  $agrIdProd,
                'ID_USUARIO' => $agrIdUsuario,
                'FECHA_INGRESO' => $agrFecha,
                'CANTIDAD' => $agrCant,
                'PRECIO_UNITARIO' => $agrPrecio,
                'PRECIO_SUBTOTAL' => $agrSubTotal,
                'PORCENTAJE_DESCUENTO' => $agrPDesc,
                'DESCUENTO' => $agrDesc,
                'TOTAL_PRODUCTO' => $agrTotal
            );
            
            if($this->Model_Transaccion->VerificarTransaccion($session_data['idUsuario'])){
                //Obtenermos el id de la transaccion que exite para el usuario
                $id_Trans = $this->Model_Transaccion->TraerIdTransaccion($session_data['idUsuario'])->ID_TRANSACCION;
                //Agregamos el id a los detalles de la transaccion
                $detalles['ID_TRANSACCION'] = $id_Trans;
                
                //Verificamos si ya existe el producto que intentamos agregar
                $existe=0;
                $Cant = 0;
                $Subtotal =0;
                $descuento = 0;
                $Total = 0;
                $detalle = $this->Model_Transaccion->ObtenerDetallesTransaccion($id_Trans);
                foreach ($detalle as $value) {
                    if($value->ID == $detalles['ID_PRODUCTO']){
                        $existe = 1;
                        $Cant = $value->CANTIDAD;
                        $Subtotal = $value->subtotal;
                        $descuento = $value->DESCUENTO;
                        $Total = $value->TOTAL_PRODUCTO;
                    }
                }
                if($existe == 1){
                    $Cant += $detalles['CANTIDAD'];
                    $Subtotal += $detalles['PRECIO_SUBTOTAL'];
                    $descuento += $detalles['DESCUENTO'];
                    $Total += $detalles['TOTAL_PRODUCTO'];
                    //ACtualizamos los datos del producto
                    $this->Model_Transaccion->actualizarDetallesCarrito($id_Trans,$detalles['ID_PRODUCTO'],'CANTIDAD',$Cant);
                    $this->Model_Transaccion->actualizarDetallesCarrito($id_Trans,$detalles['ID_PRODUCTO'],'PRECIO_SUBTOTAL',$Subtotal);
                    $this->Model_Transaccion->actualizarDetallesCarrito($id_Trans,$detalles['ID_PRODUCTO'],'DESCUENTO',$descuento);
                    $this->Model_Transaccion->actualizarDetallesCarrito($id_Trans,$detalles['ID_PRODUCTO'],'TOTAL_PRODUCTO',$Total);
                }else{
                    //Agregamos el detalle
                    $this->Model_Transaccion->AgregarDetallesTransaccion($detalles);
                }
                
            }else{
                //Como no existe una Transaccion pendiente para el usuario creamos una
                //Nota: la tabla de direcciones hay que modificarla para poder obtener la direccion por defecto de un cliente
                //por ahora tomaremos la primera direccion del usuario, y el usuario puede cambiar la direccion en el carrito
                $datos = array(
                    'ID_USUARIO' => $agrIdUsuario,
                    'ID_ESTADO_COMPRA' => 1,
                    'FECHA' => date("Y-m-d"), 
                    'HORA' => date("H:i:s"),
                    'ID_DIRECCION' => $this->Model_Direccion->met_traerDirecciones($agrIdUsuario)[0]['DIRECCIONID']

                );
                $this->Model_Transaccion->CrearTransaccion($datos);
                //Obtenermos el id de la transaccion que creamos para el usuario
                $id_Trans = $this->Model_Transaccion->TraerIdTransaccion($session_data['idUsuario'])->ID_TRANSACCION;
                //Agregamos el id a los detalles de la transaccion
                $detalles['ID_TRANSACCION'] = $id_Trans;
                //Agregamos el detalle
                $this->Model_Transaccion->AgregarDetallesTransaccion($detalles);
                //Actualizamos el dato de la session del carrito
                $session_data['carrito'] = $this->Model_Transaccion->CantidadCarrito($session_data['idUsuario'])->CANTIDAD;
                $this->session->set_userdata('ax', $session_data);
            }

        }
         //Actualizamos el dato de la session del carrito
        $session_data['carrito'] = $this->Model_Transaccion->CantidadCarrito($session_data['idUsuario'])->CANTIDAD;
        $this->session->set_userdata('ax', $session_data);
        redirect('productosUsuarios', 'refresh');
    }
}
