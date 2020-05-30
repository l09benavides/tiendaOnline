<?php
//************************************************
/*Esta vista es parte del módulo de acceso de usuarios, corresponde con la página que permite a los usuarios ingresar sus credenciales, se comunica con métodos en los archivos:
-Ctrl_verificacionUsuarios.php*/
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
    <li class="breadcrumb-item"><a href="home">Inicio</a></li>
    <li class="breadcrumb-item active">Ingreso de Usuarios</li>
  </ol>

<div class="container-fluid">

  <h2 style="text-align: center;">Ingreso de usuarios</h2>
  <div class="row no-gutters">
	<div class="col-sm-4 "   ></div>

	
	<div class="col-sm-4 " >

 
	<?php echo validation_errors(); ?>
   	<?php echo form_open('Ctrl_verificacionUsuarios'); ?>
    <div class="form-group">
      <label for="correo">Correo:</label>
      <input type="email" class="form-control" id="correo" placeholder="Ingrese su correo" name="correo">
    </div>

    <div class="form-group">
      <label for="contrasena">Contraseña:</label>
      <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña" name="contrasena">
    </div>

    <!-- <div class="form-group form-check opciones-login">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> Recordar
      </label>
		</div> -->
<div class="text-center">
    <!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
    <input type="submit" class="btn btn-primary" value="Ingresar"/>
    </div>
  </form>


  </div>     <!--close tag for <div class="col-sm-4 " > -->



  <div class="col-sm-4 "   ></div>



  </div>   <!--close tag for <div class="row no-gutters"> -->



  <div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

<div class="row no-gutters">
	<div class="col-sm-4 "   ></div>
		<div class="col-sm-4" style="border-bottom-style: groove;border-width:1px;border-color: #F5F5F5;"></div>
	<div class="col-sm-4 "   ></div>	
	</div>


<div class="row no-gutters">
	<div class="col-sm-4 "   ></div>
		<div class=" col-sm-4 mechesheader align-items-centers" style="text-align: center;">
			<a class="btn btn-default mechesheader linksmechesheader" href="forgotPass" ><i class="fa fa-key" style="font-size:30px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Recuperar contraseña</a>
			<a class="btn btn-default mechesheader linksmechesheader" href="userRegistration" ><i class="fa fa-user-plus" style="font-size:30px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Crear cuenta</a>
		</div>
	<div class="col-sm-4 "   ></div>	
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
