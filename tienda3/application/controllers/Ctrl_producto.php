<?php
//************************************************************************************
//Este módulo se encarga de definir los métodos utilizados para la inclusión, modificación,
//listado o eliminación de productos en la pantalla de administración de productos.
//Autor: Pablo Hernández
//Fecha de creación: 15/06/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//15/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_producto extends CI_Controller {

	//Método constructor que inicializa la clase Ctrl_producto
    public function __construct()
    {
            parent::__construct();
            $this->load->helper('html');
            $this->load->helper('url');
            $this->load->helper('url_helper');
            $this->load->helper('form');    

            $this->load->model('Model_Producto','',TRUE); //carga el modelo de productos
			$this->load->model('Model_Usuario','',TRUE); //carga el modelo de usuarios
            $this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
			
            //ejecuta la validación del rol del usuario y asigna el acceso correspondiente
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

//Método de inicio de la clase, carga la página a mostrar
    public function index()
    {
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Lista de Productos';
        
        //Variables para controlar los estados de los modales
        $modalAgrValid = 1;
        $modalModValid = 1;
        $modalProdAgregado = 0;
        $modalProdModificado = 0;
        $modalProdEliminado = 0;
        $estadoCambio = false;

		$session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
		$data['infoUser'] = $session_data['nombre'];
        
        //Asigna diferentes datos de productos desde el modelo para ser mostrados en la vista 
        $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
        $data['listaCategorias'] = $this->Model_Producto->getAllCategorias();
        $data['listaCapacidades'] = $this->Model_Producto->getAllCapacidades();
        $data['listaEstados'] = $this->Model_Producto->getAllEstados();
        $data['listaImpuestos'] = $this->Model_Producto->getAllImpuestos();

        //Asignar los valores de las variables para el control de los modales
        $data['modalAgrValid'] = $modalAgrValid;
        $data['modalModValid'] = $modalModValid;
        $data['modalProdAgregado'] = $modalProdAgregado;
        $data['modalProdModificado'] = $modalProdModificado;
        $data['modalProdEliminado'] = $modalProdEliminado;
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        
        $this->load->view('templates/headerAdmin',$data);
        $this->load->view('pages/productos/productos',$data);
        $this->load->view('templates/footer',$data);
    }
	
    //Método para que el administrador pueda agregar los productos
    public function met_agregarProd()
    {
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');

         //Variables para controlar los estados de los modales en la vista de productos
        $data['title'] = 'Agregar Productos';
        $modalAgrValid = 1;
        $modalModValid = 1;
        $modalProdAgregado = 0;
        $modalProdModificado = 0;
        $modalProdEliminado = 0;

        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        //Asignar los valores de las variables para el control de los modales en la vista productos
        $data['modalAgrValid'] = $modalAgrValid;
        $data['modalModValid'] = $modalModValid;
        $data['modalProdAgregado'] = $modalProdAgregado;
        $data['modalProdModificado'] = $modalProdModificado;
        $data['modalProdEliminado'] = $modalProdEliminado;

        $session_data = $this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];

        //Asigna diferentes datos de productos desde el modelo para ser mostrado en la vista 
        $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
        $data['listaCategorias'] = $this->Model_Producto->getAllCategorias();
        $data['listaCapacidades'] = $this->Model_Producto->getAllCapacidades();
        $data['listaEstados'] = $this->Model_Producto->getAllEstados();
        $data['listaImpuestos'] = $this->Model_Producto->getAllImpuestos();

        //Reglas de validación del formulario para el ingreso de datos
        $this->form_validation->set_rules('AgrCodigoProd', 'Código', 'trim|is_natural_no_zero|required|exact_length[6]|is_unique[PRODUCTOS.CODIGO]');
        $this->form_validation->set_rules('AgrNombreProd', 'Nombre', 'trim|required|min_length[4]|max_length[25]');
        $this->form_validation->set_rules('AgrDescripProd', 'Descripcion','trim|required|min_length[5]|max_length[100]');
        $this->form_validation->set_rules('AgrDetalleProd', 'Detalle','trim|required|min_length[10]|max_length[2500]');
        $this->form_validation->set_rules('AgrPrecioProd', 'Precio', 'trim|required|is_natural_no_zero|min_length[3]|max_length[6]');
        $this->form_validation->set_rules('AgrDescuenProd', 'Descuento', 'trim|required|is_natural|min_length[1]|max_length[2]');    
        $this->form_validation->set_rules('AgrInventProd', 'Inventario', 'trim|required|is_natural|min_length[1]|max_length[2]');

        //Si los datos ingresados no cumplen la validación, se presenta el error de validación de datos
        if ($this->form_validation->run() === FALSE){

            $data['modalAgrValid'] = 0;
            $data['modalProdAgregado'] = 0;

                $loginstatus = $this->session->userdata('ax');
                if($loginstatus == NULL){
                    redirect('Ctrl_bienvenida','refresh');
                }
                else{
                    $this->load->view('templates/headerAdmin',$data);
                    $this->load->view('pages/productos/productos',$data);
                    $this->load->view('templates/footer',$data);
                }
        }
        //Si los datos se validaron correctamente, ingresar la información a la BD mediante acceso al modelo
        else{ 
            $agrCodigo = $this->input->post('AgrCodigoProd');
            $agrNombre = $this->input->post('AgrNombreProd');
            $agrDescrip = $this->input->post('AgrDescripProd');
            $agrDetalle = $this->input->post('AgrDetalleProd');
            $agrCateg = $this->input->post('AgrCategoriaProd');
            $agrPrecio = $this->input->post('AgrPrecioProd');
            $agrDesc = $this->input->post('AgrDescuenProd');
            $agrInvent = $this->input->post('AgrInventProd');
            $agrCapac = $this->input->post('AgrCapacidadProd');
            $agrEstado = $this->input->post('AgrEstadoProd');
            $agrImpuesto = $this->input->post('AgrImpuestoProd');

            $this->Model_Producto->met_addProducto($agrCodigo,$agrNombre,$agrDescrip,$agrDetalle,$agrCateg,$agrPrecio,$agrDesc,$agrInvent,$agrCapac,$agrEstado,$agrImpuesto);

            $data['modalProdAgregado'] = 1;  
            $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
            $loginstatus = $this->session->userdata('ax');
            if($loginstatus == NULL){
                redirect('Ctrl_bienvenida','refresh');
            }
            else{
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/productos/productos',$data);
                $this->load->view('templates/footer',$data);
            }
            //echo "<script type='text/javascript'>alert('Producto agregado correctamente!')</script>";
            //redirect('Ctrl_producto', 'refresh');      

        }

    }

    //Método para que el administrador pueda modificar un producto
    public function met_modificarProd(){

        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');

        //Variables para controlar los estados de los modales en la vista de productos
        $data['title'] = 'Modificar Productos';

        $estadoCambio = false;
        $modalAgrValid = 1;
        $modalModValid = 1;
        $modalProdAgregado = 0;
        $modalProdModificado = 0;
        $modalProdEliminado = 0;

        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        //Asignar los valores de las variables para el control de los modales en la vista productos
        $data['modalAgrValid'] = $modalAgrValid;
        $data['modalModValid'] = $modalModValid;
        $data['modalProdAgregado'] = $modalProdAgregado;
        $data['modalProdModificado'] = $modalProdModificado;
        $data['modalProdEliminado'] = $modalProdEliminado;

        $session_data = $this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];

        //Asigna diferentes datos de productos para ser mostrado en la vista 
        $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
        $data['listaCategorias'] = $this->Model_Producto->getAllCategorias();
        $data['listaCapacidades'] = $this->Model_Producto->getAllCapacidades();
        $data['listaEstados'] = $this->Model_Producto->getAllEstados();
        $data['listaImpuestos'] = $this->Model_Producto->getAllImpuestos();

        //Reglas de validación del formulario para el ingreso de datos
        $this->form_validation->set_rules('ModCodigoProd', 'Código', 'trim|is_natural_no_zero|required|exact_length[6]');
        $this->form_validation->set_rules('ModNombreProd', 'Nombre', 'trim|required|min_length[4]|max_length[25]');
        $this->form_validation->set_rules('ModDescripProd', 'Descripcion','trim|required|min_length[5]|max_length[100]');
        $this->form_validation->set_rules('ModDetalleProd', 'Detalle','trim|required|min_length[10]|max_length[2500]');
        $this->form_validation->set_rules('ModPrecioProd', 'Precio', 'trim|required|is_natural_no_zero|min_length[3]|max_length[6]');
        $this->form_validation->set_rules('ModDescuenProd', 'Descuento', 'trim|required|is_natural|min_length[1]|max_length[2]');    
        $this->form_validation->set_rules('ModInventProd', 'Inventario', 'trim|required|is_natural|min_length[1]|max_length[2]');
        
        //Si los datos ingresados no cumplen la validación, se presenta el error de validación de datos
        if ($this->form_validation->run() === FALSE){

            $data['modalModValid'] = 0;
            $data['modalProdModificado'] = 0;

            $loginstatus = $this->session->userdata('ax');
            if($loginstatus == NULL){
                redirect('Ctrl_bienvenida','refresh');
            }
            else{
                $this->load->view('templates/headerAdmin',$data);
                $this->load->view('pages/productos/productos',$data);
                $this->load->view('templates/footer',$data);
            }
        }
        //Si los datos se validaron correctamente, ingresar la información a la BD mediante acceso al modelo
        else{
            $modNombre = $this->input->post('ModNombreProd');
            $modDescrip = $this->input->post('ModDescripProd');
            $modDetalle = $this->input->post('ModDetalleProd');
            $modCateg = $this->input->post('ModCategoriaProd');
            $modPrecio = $this->input->post('ModPrecioProd');
            $modDesc = $this->input->post('ModDescuenProd');   
            $modInvent = $this->input->post('ModInventProd');
            $modCapac = $this->input->post('ModCapacidadProd');
            $modEstado = $this->input->post('ModEstadoProd');
            $modImpuesto = $this->input->post('ModImpuestoProd');

            $codigoProd = $this->input->post('ModCodigoProd');
            $datosProducto = $this->Model_Producto->getProductobyCodigo($codigoProd);
      
            if($modNombre != $datosProducto->NOMBRE){
                $this->Model_Producto->met_modProdNombre($codigoProd,$modNombre);
                $estadoCambio = true;
                } 
            
            if($modDescrip != $datosProducto->DESCRIPCION){
                $this->Model_Producto->met_modProdDescrip($codigoProd,$modDescrip);
                $estadoCambio = true;
                } 

            if($modCateg != $datosProducto->ID_CATEGORIA){
                $this->Model_Producto->met_modProdCategoria($codigoProd,$modCateg);
                $estadoCambio = true;
                }   

            if($modDetalle != $datosProducto->DETALLES){
                $this->Model_Producto->met_modProdDetalle($codigoProd,$modDetalle);
                $estadoCambio = true;
                }    

            if($modPrecio != $datosProducto->PRECIO){
                $this->Model_Producto->met_modProdPrecio($codigoProd,$modPrecio);
                $estadoCambio = true;
                } 
            
            if($modDesc != $datosProducto->PORCENTAJEDESCUENTO){
                $this->Model_Producto->met_modProdDescuento($codigoProd,$modDesc);
                $estadoCambio = true;
                } 
      
            if($modInvent != $datosProducto->STOCK){
                $this->Model_Producto->met_modProdStock($codigoProd,$modInvent);
                $estadoCambio = true;
                } 
            
            if($modCapac != $datosProducto->CAPACIDAD){
                $this->Model_Producto->met_modProdCapacidad($codigoProd,$modCapac);
                $estadoCambio = true;
                }    
                
            if($modEstado != $datosProducto->ID_ESTADO_PRODUCTO){
                $this->Model_Producto->met_modProdEstado($codigoProd,$modEstado);
                $estadoCambio = true;
                } 
            
            if($modImpuesto != $datosProducto->ID_ESTADO_IV){
                $this->Model_Producto->met_modProdImpuesto($codigoProd,$modImpuesto);
                $estadoCambio = true;
                } 
                
            if($estadoCambio){

                $data['modalProdModificado'] = 1;
                $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
                $loginstatus = $this->session->userdata('ax');
                if($loginstatus == NULL){
                    redirect('Ctrl_bienvenida','refresh');
                }
                else{
                    $this->load->view('templates/headerAdmin',$data);
                   $this->load->view('pages/productos/productos',$data);
                    $this->load->view('templates/footer',$data);
                }

                //echo "<script type='text/javascript'>alert('Producto modificado correctamente!');</script>";
           }else{
                $data['modalProdModificado'] = 2;
                $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
                $loginstatus = $this->session->userdata('ax');
                if($loginstatus == NULL){
                    redirect('Ctrl_bienvenida','refresh');
                }
                else{
                    $this->load->view('templates/headerAdmin',$data);
                   $this->load->view('pages/productos/productos',$data);
                    $this->load->view('templates/footer',$data);
                }

                //echo "<script type='text/javascript'>alert('No se modificó ningun dato.')</script>";
           }
           //redirect('Ctrl_producto', 'refresh'); 

        }
       
    }

    //Método para que el administrador pueda eliminar el producto
    public function met_eliminarProd(){
    
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('url_helper');

        //Variables para controlar los estados de los modales en la vista de productos
        $data['title'] = 'Eliminar Productos';

        $modalAgrValid = 1;
        $modalModValid = 1;
        $modalProdAgregado = 0;
        $modalProdModificado = 0;
        $modalProdEliminado = 0;

        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual();

        //Asignar los valores de las variables para el control de los modales en la vista productos
        $data['modalAgrValid'] = $modalAgrValid;
        $data['modalModValid'] = $modalModValid;
        $data['modalProdAgregado'] = $modalProdAgregado;
        $data['modalProdModificado'] = $modalProdModificado;
        $data['modalProdEliminado'] = $modalProdEliminado;

        $session_data = $this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];
        
        //Asignar variable del código del producto para eliminarlo
        $codProducto =$this->input->post('EliCodigoProd');
        
        //Llamar al Modelo para eliminar el producto de acuerdo al código seleccionado
        $result = $this->Model_Producto->met_delProducto($codProducto);
        $error = $this->db->error()['code'];
        if($error==1451){
            $modalProdEliminado = 2;
            $data['modalProdEliminado'] = $modalProdEliminado;

        }else{
            $modalProdEliminado = 1;
            $data['modalProdEliminado'] = $modalProdEliminado;
        }

        //Asigna diferentes datos de productos para ser mostrado en la vista 
        $data['listaProductos'] = $this->Model_Producto->getAllProductos_Detalle();
        $data['listaCategorias'] = $this->Model_Producto->getAllCategorias();
        $data['listaCapacidades'] = $this->Model_Producto->getAllCapacidades();
        $data['listaEstados'] = $this->Model_Producto->getAllEstados();
        $data['listaImpuestos'] = $this->Model_Producto->getAllImpuestos();

        $loginstatus = $this->session->userdata('ax');
        if($loginstatus == NULL){
            redirect('Ctrl_bienvenida','refresh');
        }
        else{
            $this->load->view('templates/headerAdmin',$data);
            $this->load->view('pages/productos/productos',$data);
            $this->load->view('templates/footer',$data);
        }    
     
    }
}
