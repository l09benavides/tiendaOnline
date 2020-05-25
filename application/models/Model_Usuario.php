<?php
//************************************************
//Modelo de Usuarios para recibir y enviar información a la Base de Datos
//
//Autor: Diego Carrillo
//Fecha de Creación: 27/05/2018
//Lista de Modificaciones:
//20/07/2018 Javier Trejos
//Se agregaron Metodos para el panel de usuarios (Traer Usuarios, Opciones de Rol y Validaciones)
//29/09/2018 Diego Carrillo/Berny Hernandez
//Se agregó la docuemntacion interna necesaria para la correcta descripcion de los métodos.
//************************************************
Class Model_Usuario extends CI_Model{

  //Método se utiliza para verificar que el correo y la contraseña que se indican la vista accesousuario.php y procesado mediante el Ctrl_verficacionUsuarios.php

 function met_login($correo, $contrasena){ 

   $this -> db -> select('ID_USUARIO,ID_ROL,NOMBRE,APELLIDO_1,APELLIDO_2,CEDULA,CORREO,TELEFONO,PASSWORD,PASSFORGOT,CADUCAREC');
   $this -> db -> from('USUARIOS');
   $this -> db -> where('CORREO', $correo);
   $this -> db -> where('PASSWORD', $contrasena);
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1){

     return $query->result();

   }else{

     return false;

   }
 }

  //Método se utiliza para verificar el usuario. Aqui mismo se verifica el rol, es decir el sistema le muestra el panel de usuario en caso de tener rol = 2 y si es rol = 1 le redirige al panel de administrador.

 function met_rolid($correo, $contrasena){
  $this -> db -> select('ID_ROL');
   //$this -> db -> from('tbl_usuario');
   $this -> db -> where('CORREO', $correo);
   $this -> db -> where('PASSWORD', $contrasena);
   $this -> db -> limit(1);

   $query = $this -> db -> get('USUARIOS');
   $data = $query -> row();
   return $data;
 }

function met_searchrolname($varRol){
  $this->db->select('TIPO');
  $this -> db -> where('ID_ROL', $varRol);
  $this -> db -> limit(1);

   $query = $this -> db -> get('ROLES');
   $data = $query -> row();
   return $data;
}
  //Método se utiliza para agregar un usuario nuevo a la base datos
function met_setuser(){


            $data = array(

                'ID_ROL' => 2,
                'NOMBRE' => $this->input->post('nombre'),
                'APELLIDO_1' => $this->input->post('apellido_1'),
                'APELLIDO_2' => $this->input->post('apellido_2'),
                'CEDULA' => $this->input->post('cedula'),
                'CORREO' => $this->input->post('correo'),
                'TELEFONO' => $this->input->post('telefono'),
                'PASSWORD' => $this->input->post('contrasena'),
                'PASSFORGOT' => 0
                
            );

            return $this->db->insert('USUARIOS', $data);
        }       

//Método se utiliza para validar duplicados en los campos de cédula y correo electrónico

function met_checkduplicates($cedula,$correo){
  $data1 = array('CEDULA'=>$cedula);
  $query1 = $this->db->get_where('USUARIOS',$data1);
  $arrayTest['ceTest']=$query1->row_array();


  $data3 = array('CORREO'=>$correo);
  $query3 = $this->db->get_where('USUARIOS',$data3);
	$arrayTest['coTest']=$query3->row_array();

	if(empty($arrayTest['ceTest'])){
	return false;
	}elseif(empty($arrayTest['coTest'])){
	return false;
	}else{
  	return true;
	}
	}

//Método se utiliza para verificar el duplicaciones de números de cédula
function met_checkduplicatesCedula($cedula){
  $data1 = array('CEDULA'=>$cedula);
  $query1 = $this->db->get_where('USUARIOS',$data1);
  $arrayTest['ceTest']=$query1->row_array();



if(empty($arrayTest['ceTest'])){
return false;
}else{
  return true;
}
}

//Método se utiliza para verificar el duplicaciones de números de correo electrónico
function met_checkduplicatesCorreo($correo){
  $data3 = array('CORREO'=>$correo);
  $query3 = $this->db->get_where('USUARIOS',$data3);
  $arrayTest['coTest']=$query3->row_array();
  
if(empty($arrayTest['coTest'])){
return false;
}else{
  return true;
}
}

function met_checkCorreoExista($correo){
  $data2 = array('CORREO'=>$correo);
  $query2 = $this->db->get_where('USUARIOS',$data2);
  $arrayTest['coExist']=$query2->row_array();



if(empty($arrayTest['coExist'])){
return false;
}else{
  return true;
}
}
//Método se utiliza para generar una contraseña temporal al usuario. Esta nueva contraseña tiene una vigencia de 3 horas.
function met_guardarPassTemp($correo,$tempPass,$timePlus3Hr){
  $data = array('PASSWORD' => $tempPass,
                'PASSFORGOT' =>1,
                'CADUCAREC' => $timePlus3Hr);
            $this->db->where('CORREO',$correo);
            return $this->db->update('USUARIOS', $data);
        }   

function met_resetFlag($correo){
  $data = array('PASSFORGOT' =>0);
            $this->db->where('CORREO',$correo);
            return $this->db->update('USUARIOS', $data);
}

function met_busUsuarioPorId($varId){
            $data = array('ID_USUARIO'=>$varId);
            $query = $this->db->get_where('USUARIOS',$data);
                return $query->result();
}


  function met_infoUsuario($varId){
    $this->db->where('ID_USUARIO',$varId);
    $data = $this->db->get('USUARIOS');
    return $data->row();
    }


function met_modNombre($varId,$varNombre){
           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'NOMBRE' => $varNombre
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        }

function met_modApellido_1($varId,$varApellido1){
           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'APELLIDO_1' => $varApellido1
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        }   

function met_modApellido_2($varId,$varApellido2){
           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'APELLIDO_2' => $varApellido2
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        } 

function met_modCedula($varId,$varCedula){
           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'CEDULA' => $varCedula
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        }    

function met_modCorreo($varId,$varCorreo){
           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'CORREO' => $varCorreo
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        }    

function met_modTelefono($varId,$varTelefono){
           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'TELEFONO' => $varTelefono
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        }                       

  //Metodo para cambiar la contraseña
  //Recibe los datos del ID del usuario y la contraseña nueva por medio del Control: Ctrl_cambioContrasena.php
  //Este actualiza la contraseña directamente en la Base de Datos
function met_modContrasena($varId,$varContrasena){

           /* $this->load->helper('url');

            $slug = url_title($this->input->post('title'), 'dash', TRUE);*/

           $data = array(
                
                //'nombre' => $this->input->post('nombre'),
                'PASSWORD' => $varContrasena
            );
            $this->db->where('ID_USUARIO',$varId);
            return $this->db->update('USUARIOS', $data);
        }    

         //----------------------METODOS PARA PANEL DE ADMINISTRADOR-----------------------//

  function met_setadmin(){


      $data = array(

          'ID_ROL' => 1,
          'NOMBRE' => $this->input->post('nombre'),
          'APELLIDO_1' => $this->input->post('apellido_1'),
          'APELLIDO_2' => $this->input->post('apellido_2'),
          'CEDULA' => $this->input->post('cedula'),
          'CORREO' => $this->input->post('correo'),
          'TELEFONO' => $this->input->post('telefono'),
          'PASSWORD' => $this->input->post('contrasena'),
          'PASSFORGOT' => 0
          
      );

      return $this->db->insert('USUARIOS', $data);
  }       
  //Metodo para traer toda la data de la lista de usuarios de la base de datos, utilizada en el controller de Panel de Usuarios
  function met_traerUsuarios(){
    
    $query = $this->db->query('
    SELECT 
    USUARIOS.ID_USUARIO AS IDUS,
    ROLES.TIPO  AS TIPO,
    USUARIOS.NOMBRE AS NOM,
    USUARIOS.APELLIDO_1 AS AP1,
    USUARIOS.APELLIDO_2 AS AP2,
    USUARIOS.CEDULA AS CED,
    USUARIOS.CORREO AS COR,
    USUARIOS.TELEFONO AS TEL
      FROM USUARIOS,ROLES
      WHERE USUARIOS.ID_ROL=ROLES.ID_ROL');
    return $query->result_array();
  } 
  //Metodo para traer todos los roles disponibles de la base de datos
  function met_opcionesRol(){ 
    $query = $this->db->query('
      SELECT
      ID_ROL,TIPO
      FROM ROLES'
    );

    return $query->result_array();
  }   

  //Metodo usuado para cambiar el rol a un usuario normal
  function met_cambioRol(){ 
      $this->db->set('ID_ROL',$this->input->post('rol'));
      $this->db->where('ID_USUARIO', $this->input->post('id'));
    return  $this->db->update('USUARIOS');
  }
  //Metodo usuario para cambiar el rol si no es usuario normal y no es el propio administrador
  function met_cambioRolVal(){
    
      $this->db->set('ID_ROL',$this->input->post('rolModVal'));
      $this->db->where('ID_USUARIO', $this->input->post('idModVal'));
    return  $this->db->update('USUARIOS');
  }
  //Metodo para cambiar el rol si es del administrador logeado
  function met_cambioRolPerfil(){
      $this->db->set('ID_ROL',$this->input->post('rolModValPerf'));
      $this->db->where('ID_USUARIO', $this->input->post('idModValPerf'));
    return  $this->db->update('USUARIOS');
  }
  //eliminar usuario seleccionado
  function met_borUsuario(){
    
    $this->db->delete('USUARIOS', array('ID_USUARIO' => $this->input->post('idEli')));
  }
}
?>
