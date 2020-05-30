<?php
//************************************************
//Este módulo sirve para ver las promociones de la página
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//16/07/2018 Javier Trejos
//Se comentan los estilos para utilizar los estilos provenientes del css del tema actual y los predeterminados que se colocaron en el header
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Meches Ferments</title>


<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

<script>

function checkPasswordMatch() {
  //modulo para verificar que las contraseñas son iguales en el formulario de #modalAgregar
  //devuelve un estilo rojo y un texto (¡Contraseñas distintas! o ¡Contraseñas iguales!)
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

$varModalP = <?php echo $modalP;  ?>;
//trae la variable del Ctrl_promociones para saber si tiene que abrir el modal o no, #modalAgregar
$varGracias = <?php echo $modalGracias;  ?>;
//trae la variable del Ctrl_promociones para saber si tiene que abrir el modal o no, #modalGra

$(document).ready(function () {
 

   $("#contrasena, #contrasenaver").keyup(checkPasswordMatch);
   
   if($varModalP == 1){
    $('#modalAgregar').modal('show');
  }

  if($varGracias == 1){
    $('#modalGra').modal('show');
  }
  
});



</script>

<!-- <style>
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

  </style> -->


</head>
<body>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item active">Promociónes</li>
</ol>
<div class="container-fluid">

  <!--<h2 style="text-align: center;">¡Promociones!</h2>-->

  <div id="imagenPromo" style="text-align: center;"><img src="<?php echo base_url();?>images/promocionesHeader.png" height="120px"
    width="359px"><br><br></div>

  <div class="col-sm-12 " style="text-align:center;">
    <div id="contenidoPromo">
      <h4><?php echo $promocionContenido[0]['TITULO_PROMO']; ?></h4>
      <p><?php echo $promocionContenido[0]['CONTENIDO_PROMO']; ?></p>
    </div>
      <button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">¡Participar!</button><br><br>
      <p><i>Promoción válida solo para usuarios registrados. Si previamente se registró, ya está participando, de lo contrario puede registrarse presionando el botón de "¡Participar!"</i></p><p><i>El ganador será contactado por medio de la dirección de e-mail ingresada en el formulario de registro.</i></p>
      </div>
  <!--DIV para MODAL de agregar   -->
      <div id="modalAgregar" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Formulario para Participar</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>Para participar por la promoción, nada más tienes que registrarte con tus datos.</p><br>
              <p>¡Si ya estás registrado en la página, ya estás participando!</p>
          
              <?php echo form_open('Ctrl_promociones/met_participa'); ?>
            
              <div class="form-group">
                <label for="nombre">Nombre:</label><?php echo form_error('nombreAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="nombre" value="<?php echo set_value('nombre'); ?>" placeholder="Ingrese Nombre" name="nombre">
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
                <label for="telefono">Teléfono:</label><?php echo form_error('telefonoAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
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

              <div class="form-group">
                  <input type="checkbox" name="terminos" value="1" /> Por favor, acepte nuestros <a href="resources/TermsMeches.pdf">Términos y Condiciones</a><br><label for="terminos"></label><?php echo form_error('terminos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?><br>
                </div>
            
            </div>      
              
            <div class="modal-footer">
              <div class="text-center">
              
              <input type="submit" id="botonAgregar" class="btn btn-primary" value="Registrar y Participar"/>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
              </form>
            </div> 
          
          </div> 
          
        </div> 
      </div>

      <!--DIV para MODAL DE GRACIAS   -->
      <div id="modalGra" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Gracias por Participar</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <h5 class="modal-body">¡Tu registro se ha completado con éxito!</h6><br>
              <h6 class="modal-body">Has sido registrado en nuestro sitio, puedes volver y acceder con tu correo y contraseña dando click en el ícono:</h6><div style="text-align: center;"><i class="fa fa-user" style="font-size:30px;"></i></div><br>
              <p class="modal-body">Te contactaremos pronto en caso de ser el ganador</p>
            
            </div>      
              
            <div class="modal-footer">
              <div class="text-center">
              <!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
              </form>
            </div> 
          
          </div> 
          
        </div> 
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
