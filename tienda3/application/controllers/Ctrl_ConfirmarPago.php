<?php
//************************************************************************************
//Este módulo se encarga de definir los métodos utilizados para la autorización o
//rechazo de pedidos en el carrito de compras de los usuarios, así como proveer una
//interfaz para utilizar el Modelo para cargar la informacion de pedidos en el sistema
//Autor: Pablo Hernández
//Fecha de creación: 26/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//06/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//31/10/2018 Luis Benavides
// Correccion de error a la hora de aprobar o rechazar una transaccion, se estaba inten-
//tando enviar el correo antes de procesar la transaccion.
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_ConfirmarPago extends CI_Controller {

	//Método constructor que inicializa la clase
    public function __construct()
    {
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('url_helper');
		$this->load->helper('form'); 

		$this->load->model('Model_Usuario','',TRUE); //carga el modelo de usuarios
		$this->load->model('Model_Transaccion','',TRUE); //carga el modelo de transacciones
		$this->load->model('Model_TemaActual','',TRUE); //PARA TENER EL TEMA EN USO
		
		//ejecuta la validación del rol del usuario y asigna el acceso correspondiente
		$loginstatus = $this->session->userdata('ax');
		if($loginstatus == NULL){
			redirect('Ctrl_bienvenida','refresh');
		}else{
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
        $this->load->library('form_validation');
        $data['title'] = 'Mensajes';
        $data['Tema'] = $this->Model_TemaActual->met_traerTemaActual(); //PARA TENER EL TEMA EN USO
        $estadoCambio = false;       
		
        $session_data=$this->session->userdata('ax');
        $data['infoId'] = $session_data['idUsuario'];
        $data['infoUser'] = $session_data['nombre'];

		//asigna datos a variable de las transacciones que están en estado de "Revision"
		$data['Detalles'] = $this->Model_Transaccion->transaccionesPendientes('Revision');

		//ejecuta la validación del rol del usuario y asigna el acceso correspondiente
		$loginstatus = $this->session->userdata('ax');
		$rolechecker = $loginstatus['idRol'];
		$buscaRol = $this->Model_Usuario->met_searchrolname($rolechecker);
		$rolUsuario = $buscaRol->TIPO;
		if($rolUsuario=="ADMIN"){
			$this->load->view('templates/headerAdmin',$data);
		}else{
			$this->load->view('templates/headerUsuario',$data);
		}
		$this->load->view('pages/vis_panelTransacciones',$data);
		$this->load->view('templates/footer',$data);
    }

    //Método para que el administrador pueda aprobar o rechazar una transacción de pedido
	public function met_DecidirTransaccion(){
		if ($this->input->is_ajax_request()) {//retorno de valores input de un javascripts(js)
			$idTransaccion = $_POST['idTrans'];
			$accion = $_POST['id'];
			
			$this->Model_Transaccion->decidirPagoCarrito($idTransaccion,$accion);// se procesa la transaccion en base a la accion (true = Aceptada, False = Rechazada)
				
			$queryUsuarioPorTrans = $this->Model_Transaccion->met_traerUsuarioPorTransaccion($idTransaccion); //trae datos del usuario por id de una transacción 
			$varCorreo = $queryUsuarioPorTrans->COR;
			$varNombreCompleto = $queryUsuarioPorTrans->NOM." ".$queryUsuarioPorTrans->APE;
			$varComprobante = $queryUsuarioPorTrans->COMP;

			if($accion=='true'){
				
			
				$queryDetalleFactura = $this->Model_Transaccion->ObtenerDetallesTransaccion($idTransaccion); //trae datos de de detalle de una transacción por id
				
				$queryFinalFactura = $this->Model_Transaccion->TraerFactura($idTransaccion); //trae datos de de factura de una transacción por id
				
				$varDescuentoTotal = number_format($queryFinalFactura->DESCUENTO_TOTAL, 2 , '.' , ',');
				$varSubtotalVenta = number_format($queryFinalFactura->SUBTOTAL_VENTA, 2 , '.' , ',');
				$varImpuestoVentas = number_format($queryFinalFactura->IMPUESTO_VENTAS, 2 , '.' , ',');
				$varTotal = number_format($queryFinalFactura->TOTAL, 2 , '.' , ',');
				
							

				//Métodos de enviar correo de confirmación al usuario luego de un pedido
				$this->load->library('email');
				$this->email->from('mechesferments@gmail.com', 'Meches Ferments');
				$this->email->to($varCorreo);
				$this->email->subject('Meches Ferments: '.$varNombreCompleto.', ¡Gracias por tu compra!');
				$this->email->set_mailtype("html");
				
				$msg='Hemos procesado tu orden '.$idTransaccion.' asociada al comprobante '.$varComprobante.' los productos solicitados se encuentran en inventario y puedes coordinar con nosotras para la entrega.<br/><br/>Puedes consultar tu factura electrónica en tu perfil. Estamos trabajando para que pronto la recibas automáticamente.
					<br/><br/><table width="928" border="1" cellspacing="4" cellpadding="4">
					          <thead>
					            <tr>
					              <th width="80" align="center" >Código</th>
					              <th width="350" align="center" >Producto</th>
					              <th width="70" align="center" >Cantidad</th>
					              <th width="100" align="center" >Precio Unitario</th>
					              <th width="100" align="center" >Descuento</th> 
					              <th width="100" align="center" >Subtotal</th>
					              <th width="100" align="center" >Subtotal IVI</th>
					            </tr>
					          </thead>
					          <tbody>
				';

				foreach($queryDetalleFactura as $productos){
					$msg.='<tr><td height="50" align="center" >';
					$msg.=$productos->CODIGO;
					$msg.='</td><td height="50" align="left" >';
					$msg.=$productos->Nombre_producto;
					$msg.='</td><td height="50" align="center" >';
					$msg.=$productos->CANTIDAD;
					$msg.='</td><td height="50" align="left" >₡ ';
					$msg.=number_format($productos->precio, 2 , '.' , ',');
					$msg.='</td><td height="50" align="left" >₡ ';
					$msg.=number_format($productos->DESCUENTO, 2 , '.' , ',');
					$msg.='</td><td height="50" align="left" >₡ ';
					$msg.=number_format($productos->subtotal, 2 , '.' , ',');
					$msg.='</td><td height="50" align="left" >₡ ';
					$msg.=number_format($productos->TOTAL_PRODUCTO, 2 , '.' , ',');
					$msg.='</td></tr>';
				};
				$msg.='</tbody></table>';
				
				$this->email->message($msg);
				if($this->email->send()){
					echo "<script type='text/javascript'>alert('¡Correo enviado!')</script>";
				}else{
					show_error($this->email->print_debugger());
				} 
	    	}else{
	    		$this->load->library('email');
				$this->email->from('mechesferments@gmail.com', 'Meches Ferments');
				$this->email->to($varCorreo);
				$this->email->subject('Meches Ferments: '.$varNombreCompleto.', ¡Tenemos un problema con tu compra!');
				$this->email->set_mailtype("html");
				
				$msg='Hemos tenido un problema procesando tu orden '.$idTransaccion.' asociada al comprobante '.$varComprobante.'. Por favor comunicate con nosotros para resolver el problema';
				$this->email->message($msg);
				if($this->email->send()){
					echo "<script type='text/javascript'>alert('¡Correo enviado!')</script>";
				}else{
					show_error($this->email->print_debugger());
				} 
	    	}

	    }else{
	            show_404();
	        }
	}

    //Método para obtener la información del detalle de un pedido, por el id de la transacción
	public function obtenerDetalles($id){
		if ($this->input->is_ajax_request()) {//retorno de valores input de un javascripts(js)
            $data = $this->Model_Transaccion->ObtenerDetallesTransaccion($id);
            echo json_encode($data);
        }else{
            show_404();
        }
	}
} 
	