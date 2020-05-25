<?php
//************************************************
//Este Modelo sirve para llamar a la tabla de Temas para ya sea cambiar el tema actual del sitio o aplicar el tema a todas las páginas.
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//21/07/2018 Javier Trejos
//Se actializa el metodo actualizarTema al igual que en su respectivo controller el parámetro para actualizar el tema en la base de datos.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');

Class Model_TemaActual extends CI_Model
{

    function actualizarTema($css)//Este método sirve para actualizar el tema en la BD
    //recibe el css del controller
    //Actualiza la base de datos con un query
    {
    $data = array('CSS' => $css);
            $this->db->where('id', 1);
            return $this->db->update('TEMAACTUAL',$data);
    }

    function met_traerTemaActual()
    {
       //Este método envía el css que esta en uso
      //Se obtiene con un query
        $query = $this->db->query('
          SELECT 
          CSS
            FROM TEMAACTUAL
            WHERE ID=1');
          return $query->result_array();
    }


}