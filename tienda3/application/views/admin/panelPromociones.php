<?php
//************************************************
//Este módulo sirve para crear promociones en la página (ADMIN)
//Utiliza controller Ctrl_panelPromociones.php
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//16/07/2018 Javier Trejos
//Optimización de estilos para usarse del css de la base de datos
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Meches Ferments</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

<script>

function checkPasswordMatch() {
    var password = $("#contrasena").val();
    var confirmPassword = $("#contrasenaver").val();

   if (password != confirmPassword){
    $("#spanCheckPasswordMatch").html("¡Contraseñas distintas!");
    document.getElementById("spanCheckPasswordMatch").style["color"] = "red";
  }else{
    $("#spanCheckPasswordMatch").html("¡Contraseñas iguales!");
    document.getElementById("spanCheckPasswordMatch").style["color"] = "green";
  }

        


}


$(document).ready(function () {
   $("#contrasena, #contrasenaver").keyup(checkPasswordMatch);
   
   
});



</script>

<style>
  /* Make the image fully responsive */
  .container {
      width: 407px;
      height: 300px;
      	display: block;
    	margin-left: auto;
   		margin-right: auto;
      	
	}   
  .container form{
      width: 407px;
      height: 300px;
      	display: block;
    	margin-left: auto;
   		margin-right: auto;
      	
	}      	

.nopadding {
   padding: 0 !important;
   margin: 0 !important;
}	

.no-marginLR {
    margin-left:0;
    margin-right:0;
}	
  


  .no-gutters {
  margin-right: 0;
  margin-left: 0;

  > .col,
  > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
  }
}
.glyphicon-search:before{content:"\e003"}

.btn-default{
	background-color: rgba(255, 99, 71,0);
}


.mechesheader{
	height: 80px;
}
.imagebuffer{
	height:20px;
}

.opciones-login{
	display: table-cell;
    vertical-align: middle;
}
.alertaContrasena{
  height:24px;
  line-height: 24px;
  padding: 0 0 0 0;
  margin: 0 0 0 0;
}

  </style>


</head>
<body>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
    <li class="breadcrumb-item active">Panel de Promociones</li>
</ol>

<div class="container-fluid">
  <h2 style="text-align: center;">Crear Nueva Promoción</h2>
  <h5 style="text-align: center;">Ingrese la promoción en la sección de abajo</h5>

  <div class="col-sm-12 ">
    
  <!--FORM ENVIAR NUEVA PROMO  -->
  
  <?php echo form_open('Ctrl_panelPromociones/met_creaPromo'); ?>
            
              <div class="form-group">
                <label for="titulo">Título:</label><?php echo form_error('titulo','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="titulo" value="<?php echo set_value('titulo'); ?>" placeholder="Ingrese Título de la Promoción" name="titulo">
              </div>
              <div class="form-group">
                <label for="contenido">Contenido:</label><?php echo form_error('contenido','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <textarea class="form-control" id="contenido" value="<?php echo set_value('conteindo'); ?>" placeholder="Ingrese el contenido de la Promoción" name="contenido"></textarea>
              </div>

          
              <div style="text-align: center;">
              <input type="submit" id="botonAgregar" class="btn btn-primary" value="Cambiar Promoción"/></div>
              </form>

              <div><a href="promo"><button class="btn btn-primary">Ver Promoción Actual</button></a></div>
  





  <div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>


<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>
	
</div>   <!--close tag for <div class="container-fluid"> -->


</body>
</html>
