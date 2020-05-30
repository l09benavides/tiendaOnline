<?php
//************************************************************************************
//Este modulo sirve para realizar todas las transacciones de base de datos relacionadas
//con una trasnaccion en sus diferentes estados hasta llegar a convertirse en una factura.
//Autor: Luis Benavides
//Fecha de creación: 21/07/2018
//Lista modificaciones:
//
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

Class Model_Transaccion extends CI_Model{


	public Function __constructor(){
	}

	public Function CrearTransaccion($datos){
		//Crea una transaccion nueva
		try 
		{
			$this->db->insert('TRANSACCIONES',$datos);
		} 
		catch (Exception $e) 
		{
			return $e;
		}
		
	}

	public Function VerificarTransaccion($userID){
		//Esta funcion verifica si ya existe una transaccion "PENDIENTE" para el usuario
		//De existir una transaccion retornara un TRUE, de lo contrario retornara un FALSE
		try 
		{
			$this->db->where('ID_ESTADO_COMPRA',1);
			$this->db->where('ID_USUARIO',$userID);
			$query = $this->db->get('TRANSACCIONES');
			if($query->num_rows() < 1){
				return false;
			}else {
				return true;
			}
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}

	public Function TraerIdTransaccion($userID){
		//Esta funcion trae el Id de la transaccion pendiente que tiene el usuarios
		try 
		{
			$this->db->where('ID_ESTADO_COMPRA',1);
			$this->db->where('ID_USUARIO',$userID);
			$this->db->select('ID_TRANSACCION');
			$query = $this->db->get('TRANSACCIONES');
			return $query->row();
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}


	public Function TraerFactura($idTrans){
		//Esta funcion trae la informacion de una factura segun el  Id de la transaccion
		try 
		{
			$this->db->where('ID_TRANSACCION',$idTrans);
			$query = $this->db->get('vFacturas');
			return $query->row();
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}


	public Function ObtenerInfoCarrito($UserId)
	{
		//Obtiene la informacion basica de una transaccion, en el controlador se toma la informacion que se necesita
		try 
		{
			$this->db->where('Estado','Carrito');
			$this->db->where('ID_USUARIO',$UserId);
			$trans = $this->db->get('AllTransactions');
			return $trans->result();
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}

	public Function ConsultaGenerica($busqueda, $atributo){
		//Funcion para realizar consultas genericas pasando un parametro de busqueda y la columna de busqueda
		try 
		{
			$sql = "SELECT * FROM AllTransactions WHERE ".$this->db->escape_like_str($atributo)." LIKE '%" .
    		$this->db->escape_like_str($busqueda)."%';";	
    		$query = $this->db->query($sql);
    		return $query->result();
		} 
		catch (Exception $e)
		{
			return $e;
		}
		
	}


	public Function CantidadCarrito($UserId)
	{
		//Funcion para devolver la cantidad total de los articulos que tiene el carrito
		try 
		{
			$this->db->select_sum('CANTIDAD');
			$this->db->where('Estado','Carrito');
			$this->db->where('ID_USUARIO',$UserId);
			$trans = $this->db->get('AllTransactions');
			if($trans->num_rows() < 1){
				return 0;
			}else {
				return $trans->row();
			}
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}

	public Function AgregarDetallesTransaccion($detalles)
	{
		//Funcion para agregar los detalles a una transaccion ya existente
		try 
		{
			$this->db->insert('DETALLE_TRANSACCIONES',$detalles);
		} 
		catch (Exception $e) 
		{
			return $e;
		}
	}

	public Function ObtenerDetallesTransaccion($transID)
	{
		//Funcion para obtener los detalles de una transaccion
		$this->db->where('ID_TRANSACCION',$transID);
		$detalles = $this->db->get('AllTransactions');
		return $detalles->result();
	}

	public Function ObtenerDetallesTransaccionProducto($transID,$idProd)
	{
		//Funcion para obtener los detalles especificos de un producto en una transaccion
		$this->db->where('ID_TRANSACCION',$transID);
		$this->db->where('ID',$idProd);
		$detalles = $this->db->get('AllTransactions');
		return $detalles->row();
	}

	public Function removerDelCarrito($idTrans,$idProd){
		//Funcion para remover un producto del carrito.
		$this->db->where('ID_TRANSACCION',$idTrans);
		$this->db->where('ID_PRODUCTO',$idProd);
		$this->db->delete('DETALLE_TRANSACCIONES');


		//Chequeamos que si se borran todos los detalles eliminaremos la transaccion
		$this->db->select_sum('CANTIDAD');
		$this->db->where('ID_TRANSACCION',$idTrans);
		$trans = $this->db->get('AllTransactions');
		if($trans->row()->CANTIDAD < 1){
			$this->db->where('ID_TRANSACCION',$idTrans);
			$this->db->delete('TRANSACCIONES');
		}
	}

    public function getAllBancos()
    {
    	//funcion para obtener la lista de los bancos, para crear la lista a la hora de confirmar el carrito
    	$data = $this->db->get('BANCOS');
    	return $data->result();
    }

    public function registrarPagoCarrito($idTrans, $idBanco, $codTrans)
    {
    	//Funcion para guardar los detalles de un pago a la transaccion
    	$this->db->where('ID_TRANSACCION',$idTrans);
    	$this->db->set('ID_BANCO',$idBanco);
    	$this->db->set('NUM_COMPROBANTE',$codTrans);
    	$this->db->set('ID_ESTADO_COMPRA',6);
    	$this->db->update('TRANSACCIONES');

    }

    public function crearFactura($idTrans){
    	//Funcion para crear una factura.
    	//En Base a una Transaccion se crea una factura, los datos FECHA y HORA se asignan al momento que se ingresa la informacion
    	//se hace una sumatoria de cada una de las lineas del detalle de los productos.
    	$detalles = $this->ObtenerDetallesTransaccion($idTrans);
    	$FECHA = date("Y-m-d");
    	$HORA = date("H:i:s");
    	$ID_TRANSACCION = $detalles[0]->ID_TRANSACCION;
    	$ID_USUARIO = $detalles[0]->ID_USUARIO;
    	$ID_DIRECCION = $detalles[0]->ID_DIRECCION;
    	$DESCUENTO_TOTAL = 0;
    	$SUBTOTAL_VENTA = 0;
    	$IMPUESTO_VENTAS = 0;
    	$TOTAL =0;
    	foreach ($detalles as $linea) {
    		$DESCUENTO_TOTAL += $linea->DESCUENTO;
    		$SUBTOTAL_VENTA += $linea->subtotal;
    		$IMPUESTO_VENTAS += (($linea->subtotal)*0.13);
    		$TOTAL += $linea->TOTAL_PRODUCTO;
    	}
    	//informacion para agregar a la tabla
    	$factura = array(
    		'FECHA' => $FECHA,
    		'HORA' => $HORA,
    		'DESCUENTO_TOTAL' => $DESCUENTO_TOTAL,
    		'SUBTOTAL_VENTA' => $SUBTOTAL_VENTA,
    		'IMPUESTO_VENTAS' => $IMPUESTO_VENTAS,
    		'TOTAL' => $TOTAL,
    		'ID_TRANSACCION' => $ID_TRANSACCION,
    		'ID_USUARIO' => $ID_USUARIO,
    		'ID_DIRECCION' => $ID_DIRECCION
    	);

    	try {
    		$this->db->insert('FACTURAS',$factura);
    		//rebajamos cada uno de los detalles de la cantidad que tiene el producto
    		foreach ($detalles as $productos) {
    			$tempid = $productos->ID;
    			$tempProd = $this->getProductobyCodigo($tempid);
    			$tempCant = $tempProd->STOCK - $productos->STOCK;
    			$this->met_modProdStock($tempid,$tempCant);
    		}
    	} catch (Exception $e) {
    		return $e;	
    	}
    }


    public function decidirPagoCarrito($idTrans, $desicion)
    {
    	//Funcion para establecer el estado de una transaccion dependiendo de la desicion que tome un administrador
    	if($desicion == 'true'){
	    	try {
	    		$this->db->where('ID_TRANSACCION',$idTrans);
	    		$this->db->set('ID_ESTADO_COMPRA',4);
	    		$this->db->update('TRANSACCIONES');
	    		if($this->db->affected_rows() > 0){
	    			$this->crearFactura($idTrans);
	    			}
		    	} catch (Exception $e) {
		    		return $e;
		    	}
	    	

	    	}else{
	    		try {
	    			$this->db->where('ID_TRANSACCION',$idTrans);
		    		$this->db->set('ID_ESTADO_COMPRA',2);
		    		$this->db->update('TRANSACCIONES');
		    		} catch (Exception $e) {
		    			return $e;
		    		}
			    	
		    	}
    }


    public function transaccionesPendientes($estado)
    {
		//Funcion que devulve un lista de las transacciones que estan pendientes
		$this->db->where('Estado',$estado);
   		$data = $this->db->get('decisionTransacciones');
    	return $data->result();
    }


    public function transaccionesPendientesUsuario($idCliente, $estado)
    {
    	//Funcion que devulve un lista de las transacciones que estan pendientes de un usuario determinado
		$this->db->where('IdCliente',$idCliente);
		$this->db->where('Estado',$estado);
	    $data = $this->db->get('decisionTransacciones');
	    return $data->result();
    }


    public function actualizarCarrito($idTrans,$field,$value){
    	//Funcion para actualizar los datos del carrito
    	try {
	    			$this->db->where('ID_TRANSACCION',$idTrans);
		    		$this->db->set($field,$value);
		    		$data = $this->db->update('TRANSACCIONES');
		    		return $data;
		    		} catch (Exception $e) {
		    			return $e;
		    		}
    }

    public  function actualizarDetallesCarrito($idTrans,$idProd,$field,$value)
    {
    	//Funcion que actualiza dos detalles de un carrito cuando se cambia un detalle existente
    	try {
	    			$this->db->where('ID_TRANSACCION',$idTrans);
	    			$this->db->where('ID_PRODUCTO',$idProd);
		    		$this->db->set($field,$value);
		    		$data = $this->db->update('DETALLE_TRANSACCIONES');
		    		return $data;
		    		} catch (Exception $e) {
		    			return $e;
		    		}
    }
	
	function met_traerUsuarioPorTransaccion($idTrans){
		//Funcion que devulve el usuario relacionado a una transaccion.
		$query = $this->db->query('SELECT NOMBRE AS NOM, APELLIDO_1 AS APE, CORREO AS COR, ID_TRANSACCION AS IDT, NUM_COMPROBANTE AS COMP  
		FROM USUARIOS AS U JOIN TRANSACCIONES AS T
		ON U.ID_USUARIO = T.ID_USUARIO
		WHERE T.ID_TRANSACCION = ?',array($idTrans));
		return $query->row();	
	}

	function getProductobyCodigo($codigo)
    {
    	//Funcion que devuelve lso detalles de un prodcuto en base al codigo
	    $this->db->where('CODIGO',$codigo);
	    $data = $this->db->get('PRODUCTOS');
	    return $data->row();
    }

    function met_modProdStock($codProducto,$stock){
    	//Funcion que modifica la cantidad de un producto.
        $data = array('STOCK' => $stock);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    }

}