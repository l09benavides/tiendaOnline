<?php
//************************************************
//Vista de perfil de usuarios para recibir y enviar información a la Base de Datos
//
//Autor: Diego Carrillo
//Fecha de Creación: 27/05/2018
//Lista de Modificaciones:
//20/07/2018 Javier Trejos
//Se agregaron Metodos para el panel de usuarios (Traer Usuarios, Opciones de Rol y Validaciones)
//29/09/2018 Diego Carrillo/Berny Hernandez
//Se agrego la documentacion interna necesaria para la correcta descripcion de funciones.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perfil de Usuario</title>

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

<script>

//Función para validar que las contraseñas ingresadas sean las mismas
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

// Variable para levantar el modal despues de algun error
$varCV = <?php echo $validacionPass  ?>

$(document).ready(function () {
//Valida cambio de contraseña y levanta el modal
  //$varCV = <?php echo $validacionPass  ?>;
  if($varCV == 0){
    $('#modalPass').modal('show');
  }

   //Deshabilita el form al cargar la página
    // $('#idForm').find(':input').prop('disabled', true);
  $('.form-group').find(':input').prop('disabled', true);
  $('#botonModificar').hide();


   //Botón para habilitar el form y poder modificar
   $("#editar").click(function(e){
    //$('#idForm').find(':input').prop('disabled', false);
    $('.form-group').find(':input').prop('disabled', false);
      $("#noEditar").show();
      $('#botonModificar').show();
      $("#editar").hide();

   });

   //botón para deshabilitar de nuevo el form
   $("#noEditar").click(function(e){
    //$('#idForm').find(':input').prop('disabled', true);
    $('.form-group').find(':input').prop('disabled', true);
      $("#editar").show();
      $("#noEditar").hide();
      $('#botonModificar').hide();
   });

//Función que detecta cambios y hace refencia a la función de revisión
   $("#contrasena, #contrasenaver").keyup(checkPasswordMatch);

//Función para redireccionar
$('[data-user]').click(function(e){

      var opcion = $(this).data('user');
      //alert("si response el click");
      switch(opcion){

        case "revisarDirecciones":
        window.location = "checkAddress";
        break;

        case "verTransacciones":
        window.location = "userTransactions";
        break;
        
        /*case "cambiarContrasena":
        window.location = "changePassword";
        break;*/
        
      }



    });   
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
#noEditar{
  display: none;
}

  </style>


</head>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item active">Perfil de Usuario</li>
</ol>
<body>

<div class="container-fluid">
        <div class="row no-gutters imagebuffer">
                <div class="col-sm-12 "></div>
        </div>

  <h2 style="text-align: center;">Perfil de usuario</h2>
  <div class="row no-gutters">
        <div class="col-sm-1 " ></div>
          <div class="col-sm-2 " >
          <div class="btn-group-vertical mechesGrupoBotones">
            <button type="button" id="editar" class="btn btn-primary">Editar mis Datos Personales</button>
            <button type="button" id="noEditar" class="btn btn-primary">Cancelar Edición</button>
            <button data-user="revisarDirecciones" type="button" id="direcciones" class="btn btn-primary">Revisar mis Direcciones</button>
            <button data-user="verTransacciones" type="button" id="transacciones" class="btn btn-primary">Revisar mis Transacciones</button>
            <button type="button" id="cambiarContrasena" data-toggle="modal" data-target="#modalPass" class="btn btn-primary" data-backdrop="static">Cambiar mi Contraseña</button>
          </div>
</div>

<div class="col-sm-1 " ></div>
        <div class="col-sm-4 " id="idForm">


        
        <?php echo form_open('Ctrl_perfilUsuario'); ?>
    <div class="form-group">
      <label for="nombre">Nombre:</label><?php echo form_error('nombre','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" value= <?php echo $infoUser ?> class="form-control" id="nombre" placeholder="Ingrese su nombre" name="nombre">

    </div>

    <div class="form-group">
      <label for="apellido_1">Primer apellido:</label><?php echo form_error('apellido_1','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" value= <?php echo $infoapellido1 ?> class="form-control" id="apellido_1" placeholder="Ingrese su primer apellido" name="apellido_1">
    </div>

    <div class="form-group">
      <label for="apellido_2">Segundo apellido:</label><?php echo form_error('apellido_2','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" value= <?php echo $infoapellido2 ?> class="form-control" id="apellido_2" placeholder="Ingrese su segundo apellido" name="apellido_2">
    </div>

    <div class="form-group">
      <label for="cedula">Cédula:</label><?php echo form_error('cedula','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" value= <?php echo $infocedula ?> class="form-control" id="cedula" placeholder="Ingrese su cédula" name="cedula">
    </div>

    <div class="form-group">
      <label for="correo">Correo:</label><?php echo form_error('correo','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="email" value= <?php echo $infocorreo ?> class="form-control" id="correo" placeholder="Ingrese su correo electrónico" name="correo">
    </div>

  <div class="form-group">
      <label for="telefono">Teléfono:</label><?php echo form_error('telefono','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
      <input type="text" value= <?php echo $infotelefono ?> class="form-control" id="telefono" placeholder="Ingrese su teléfono" name="telefono">
    </div>




<div class="text-center">
    <!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
    <input type="submit" id="botonModificar" class="btn btn-primary" value="Guardar Cambios"/>
    </div>
  </form>

  <!--DIV para MODAL    -->
    <div id="modalPass" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cambiar Contraseña</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <!--FORM PASS
          <p>Some text in the modal.</p>-->  

          <?php echo validation_errors(); ?>
            <?php echo form_open('Ctrl_cambioContrasena'); ?>
            <div> <!-- class="form-group" -->
      <label for="contrasenaActual">Contraseña Actual:</label>
      <input type="password" class="form-control" id="contrasenaActual" placeholder="Ingrese su contraseña actual" name="contrasenaActual">
    </div>
            <div> <!-- class="form-group" -->
      <label for="contrasena">Nueva Contraseña:</label>
      <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su nueva contraseña" name="contrasena">
    </div>

    <div> <!-- class="form-group" -->
      <label for="contrasenaver">Confirmar Nueva Contraseña: <span style="color:red;" id="spanCheckPasswordMatch"></span></label>
      <!-- <span class="alert alert-danger" id="spanCheckPasswordMatch"></span> -->
      <input type="password" class="form-control" id="contrasenaver" placeholder="Ingrese su contraseña de nuevo" name="contrasenaver" onChange="checkPasswordMatch();">
    </div>

        </div>
        <div class="modal-footer">
          <!--BOTON SUBMIT FORM-->
          <input type="submit" id="savePass" value="Guardar" class="btn btn-primary">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </from>
      </div>
    </div>
    </div>


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
