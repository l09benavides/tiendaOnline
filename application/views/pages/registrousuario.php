<?php
//************************************************
/*Esta vista es parte del módulo de login, corresponde con la página que permite a los usuarios ingresar su información personal para registrarse, se comunica con métodos en los archivos:
-Ctrl_registroUsuario.php*/
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

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>


<script>
//Esta función verifica que el usuario ingresa contraseñas iguales
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



/*    $(document).ready(function(){

    $("#botonRegistro").click(function(){

        if ($('#contrasena').val() == "") {
          $("#contrasena").addClass("alert alert-warning");
         $("#contrasena").attr("placeholder", "Ingrese una contraseña.").val("").focus().blur();
        } else if ($('#contrasena').val() !== $('#contrasenaver').val()) {
          $("#contrasenaver").addClass("alert alert-warning");
         $("#contrasenaver").attr("placeholder", "Sus contraseñas no son iguales.").val("").focus().blur();
        }

});*/








    //$("#serMemtb").attr("placeholder", "Type a Location").val("").focus().blur();

/*$("button").click(function(){
    $("h1, h2, p").toggleClass("blue");
});
*/


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
    <li class="breadcrumb-item"><a href="userAccess">Ingreso de Usuarios</a></li>
    <li class="breadcrumb-item active">Registro de Usuario</li>
</ol>

<div class="container-fluid">

  <h2 style="text-align: center;">Registro de usuario</h2>
  <div class="row no-gutters">
	<div class="col-sm-4 "   ></div>

	
	<div class="col-sm-4 " >

<?php echo form_open('Ctrl_registroUsuario'); ?>
    <div class="form-group">
      <label for="nombre">Nombre:</label><?php echo form_error('nombre','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" class="form-control" id="nombre" value="<?php echo set_value('nombre'); ?>" placeholder="Ingrese su nombre" name="nombre">
    </div>

    <div class="form-group">
      <label for="apellido_1">Primer apellido:</label><?php echo form_error('apellido_1','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" class="form-control" id="apellido_1" value="<?php echo set_value('apellido_1'); ?>" placeholder="Ingrese su primer apellido" name="apellido_1">
    </div>

    <div class="form-group">
      <label for="apellido_2">Segundo apellido:</label><?php echo form_error('apellido_2','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" class="form-control" id="apellido_2" value="<?php echo set_value('apellido_2'); ?>" placeholder="Ingrese su segundo apellido" name="apellido_2">
    </div>

    <div class="form-group">
      <label for="cedula">Cédula:</label><?php echo form_error('cedula','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" class="form-control" id="cedula" value="<?php echo set_value('cedula'); ?>" placeholder="Ingrese su cédula" name="cedula">
    </div>

    <div class="form-group">
      <label for="correo">Correo:</label><?php echo form_error('correo','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="email" class="form-control" id="correo" value="<?php echo set_value('correo'); ?>" placeholder="Ingrese su correo electrónico" name="correo">
    </div>

  <div class="form-group">
      <label for="telefono">Teléfono:</label><?php echo form_error('telefono','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" class="form-control" id="telefono" value="<?php echo set_value('telefono'); ?>" placeholder="Ingrese su teléfono" name="telefono">
    </div>

<div class="form-group">
      <label for="contrasena">Contraseña:</label><?php echo form_error('contrasena','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña" name="contrasena">
    </div>

    <div class="form-group">
      <label for="contrasenaver">Ingrese la contraseña de nuevo: <span style="color:red;" id="spanCheckPasswordMatch"></span></label><?php echo form_error('contrasenaver','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <!-- <span class="alert alert-danger" id="spanCheckPasswordMatch"></span> -->
      <input type="password" class="form-control" id="contrasenaver" placeholder="Ingrese su contraseña de nuevo" name="contrasenaver" onChange="checkPasswordMatch();">
    </div>

    <!-- Checkbox PARA TERMINOS Y CONDICIONES, JT -->

    <div class="form-group">
      <input type="checkbox" name="terminos" value="1" /> Por favor, acepte nuestros <a href="resources/TermsMeches.pdf">Términos y Condiciones</a><br><label for="terminos"></label><?php echo form_error('terminos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?><br>
    </div>
 

<div class="text-center">
    <!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
    <input type="submit" id="botonRegistro" class="btn btn-primary" value="Registrar"/>
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
	
</div>   <!--close tag for <div class="container-fluid"> -->


</body>
</html>
