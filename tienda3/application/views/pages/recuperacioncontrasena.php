<?php
//************************************************
//Esta vista es parte del módulo de cambio de contraseña, 
//corresponde con la página que permite a los usuarios ingresar 
//su correo para iniciar el proceso de recuperación de contraseña, 
//se comunica con métodos en los archivos:
//-Ctrl_recupcontra.php
//Autor: Diego Carrillo
//Fecha de Creación: 17/06/2018
//Lista de Modificaciones:
//20/06/2018 Diego Carrillo
//Se cambio el modo de verificación de nombre de usuario a correo en los text boxes.
//26/07/2018
//Se remueve la opción de recordar contraseña.
//************************************************

defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to CodeIgniter</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

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

/*.mechescolors{
	background-color: rgba(246, 200, 63);
}
.navbar-dark .navbar-nav .nav-link {
    color: black;
    font-weight: bold;
}

.navbar-dark .navbar-nav .nav-link:hover {
    color: rgba(198, 74, 155);
}*/

.mechesheader{
	height: 80px;
}
.imagebuffer{
	height:20px;
}
/*.linksmechesheader{
	line-height: 80px;
	color:black;
}

.linksmechesheader:hover {
    color: rgba(198, 74, 155);
}*/
.opciones-login{
	display: table-cell;
    vertical-align: middle;
}

  </style>


</head>
<body>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="userAccess">Ingreso de Usuarios</a></li>
    <li class="breadcrumb-item active">Recuperación de Contraseña</li>
</ol>

<div class="container-fluid">

  <h2 style="text-align: center;">Recuperación de contraseña</h2>
  <div class="row no-gutters">
	<div class="col-sm-4 "   ></div>

	
	<div class="col-sm-4 " >

 
	<?php echo validation_errors(); ?>
   	<?php echo form_open('Ctrl_recupcontra'); ?>
    <div class="form-group">
      <label for="correo">Por favor ingrese su correo registrado con nosotros:</label>
      <input type="email" class="form-control" id="correo" placeholder="Ingrese su correo" name="correo">
    </div>

    
<div class="text-center">
    <!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
    <input type="submit" class="btn btn-primary" value="Enviar correo"/>
    </div>
  </form>


  </div>     <!--close tag for <div class="col-sm-4 " > -->



  <div class="col-sm-4 "   ></div>



  </div>   <!--close tag for <div class="row no-gutters"> -->



  <div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
  <div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
  <div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
  <div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
  </div>

<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>
<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>
	
</div>   <!--close tag for <div class="container-fluid"> -->


</body>
</html>