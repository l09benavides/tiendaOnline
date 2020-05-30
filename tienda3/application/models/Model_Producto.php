<?php
//************************************************************************************
//Este módulo sirve para realizar todos los llamados a la BD relacionados con productos,  
//como obtener datos de productos, agregar, modificar o eliminar datos de productos.
//Autor: Pablo Hernández
//Fecha de creación: 02/07/2018
//Lista modificaciones:
///15/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');

Class Model_Producto extends CI_Model
{
    //Esta función obtiene los datos de un producto existente por su identificador    
    function getProductobyId($id)
    {
    $this->db->where('ID_PRODUCTO',$id);
    $data = $this->db->get('PRODUCTOS');
    return $data->row();
    }

    //Esta función obtiene los datos de un producto existente por su código 
    function getProductobyCodigo($codigo)
    {
    $this->db->where('CODIGO',$codigo);
    $data = $this->db->get('PRODUCTOS');
    return $data->row();
    }


    //Esta función obtiene los datos de la vista vProductos _Detalle que están activos
    function getProductobyActivos()
    {
    $this->db->where('ESTADO','Activo');
    $data = $this->db->get('vPRODUCTOS_DETALLE');
    return $data->result();
    }

    //Esta función obtiene los datos de la vista vProductos 
    function getAllProductos()
    {
    $data = $this->db->get('vPRODUCTOS');
    return $data->result();
    }


    //Esta función obtiene los datos de la vista vProductos _Detalle 
    function getAllProductos_Detalle()
    {
    $data = $this->db->get('vPRODUCTOS_DETALLE');
    return $data->result();
    }


    //Esta función obtiene los datos de la tabla categorías para asociarle a un producto posteriormente
    function getAllCategorias()
    {
    $data = $this->db->get('CATEGORIAS');
    return $data->result();
    }


    //Esta función obtiene los datos de la tabla capacidades para asociarle a un producto posteriormente
    function getAllCapacidades()
    {
    $data = $this->db->get('CAPACIDADES');
    return $data->result();
    }


    //Esta función obtiene los datos de la tabla de estado de productos para asociarle a un producto posteriormente
    function getAllEstados()
    {
    $data = $this->db->get('ESTADO_PRODUCTOS');
    return $data->result();
    }


    //Esta función obtiene los datos de la tabla de impuestos de venta para asociarle a un producto posteriormente
    function getAllImpuestos()
    {
    $data = $this->db->get('ESTADO_IV');
    return $data->result();
    }

    //Esta función permite agregar un nuevo producto con todos los parámetros correspondientes
    function met_addProducto($Codigo,$Nombre,$Descrip,$Detalle,$Categ,$Precio,$Desc,$Invent,$Capac,$Estado,$Impuesto){
    $data = array(
            'CODIGO' => $Codigo,
            'NOMBRE' => $Nombre,
            'DESCRIPCION' => $Descrip,
            'DETALLES' => $Detalle,
            'ID_CATEGORIA' => $Categ,
            'PRECIO' => $Precio,
            'PORCENTAJEDESCUENTO' => $Desc,
            'STOCK' => $Invent,
            'CAPACIDAD' => $Capac,
            'ID_ESTADO_PRODUCTO' => $Estado,
            'ID_ESTADO_IV' => $Impuesto
    );
    return $this->db->insert('PRODUCTOS', $data);
    }

    //Esta función permite modificar el nombre de un producto utilizando el código como referencia
    function met_modProdNombre($codProducto,$nombre){
        $data = array('NOMBRE' => $nombre);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    }

    //Esta función permite modificar la descripción de un producto utilizando el código como referencia
    function met_modProdDescrip($codProducto,$descrip){
        $data = array('DESCRIPCION' => $descrip);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    }


    //Esta función permite modificar el detalle de un producto utilizando el código como referencia
    function met_modProdDetalle($codProducto,$detalle){
        $data = array('DETALLES' => $detalle);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    }

    //Esta función permite modificar la categoría de un producto utilizando el código como referencia
    function met_modProdCategoria($codProducto,$categoria){
        $data = array('ID_CATEGORIA' => $categoria);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    }

    //Esta función permite modificar el precio de un producto utilizando el código como referencia
    function met_modProdPrecio($codProducto,$precio){
        $data = array('PRECIO' => $precio);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    } 

    //Esta función permite modificar el porcentaje de descuento de un producto utilizando el código como referencia
    function met_modProdDescuento($codProducto,$descuento){
        $data = array('PORCENTAJEDESCUENTO' => $descuento);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    } 

    //Esta función permite modificar la cantidad de inventario de un producto utilizando el código como referencia
    function met_modProdStock($codProducto,$stock){
        $data = array('STOCK' => $stock);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    } 

    //Esta función permite modificar la capacidad de un producto utilizando el código como referencia
    function met_modProdCapacidad($codProducto,$capacidad){
        $data = array('CAPACIDAD' => $capacidad);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    } 

    //Esta función permite modificar el estado de un producto utilizando el código como referencia
    function met_modProdEstado($codProducto,$estado){
        $data = array('ID_ESTADO_PRODUCTO' => $estado);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    } 

    //Esta función permite modificar el impuesto de venta de un producto utilizando el código como referencia
    function met_modProdImpuesto($codProducto,$impuesto){
        $data = array('ID_ESTADO_IV' => $impuesto);
        $this->db->where('CODIGO',$codProducto);
        return $this->db->update('PRODUCTOS', $data);
    } 


    //Esta función permite eliminar un producto utilizando el código como referencia
    function met_delProducto($codProducto){
        $data = array('CODIGO'=>$codProducto);
        return $query = $this->db->delete('PRODUCTOS',$data);
    }

}