<?php
//************************************************************************************
//Vista de panel de transacciones para los usuarios finales, esta permite ver las 
//transacciones aprobadas, en proceso o rechazadas.
//Dentro del panel aparecen todas las transacciones del usuario en cualquiera de esos  
//tres estatus. 
//Autor: Pablo Hernández
//Fecha de creación: 18/07/2018
//Lista modificaciones
//15/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//*************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>

$(document).ready(function () {

	//función para redireccionar al panel correspondiente ("Aprobado, En Proceso, Rechazado")
	$('[data-user]').click(function(e){
  	var opcion = $(this).data('user');
    //alert("si response el click");
  	switch(opcion){

  	case "transacProceso":
  	window.location = "rut_transacProceso";
  	break;

  	case "transacAprobadas":
  	window.location = "rut_transacAprobadas";
  	break;

   	case "transacRechazadas":
    window.location = "rut_transacRechazadas";
    break;
	}
  }); 
  });

</script>

<!-- Definición de estilos CSS especificos para la página -->
<style>
  /* Make the image fully responsive */
.carousel-inner img {
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
.panelbuffer{
	height:500px;
}

.buttonPanel{
      width: 407px;
      height: 300px;
      	display: block;
    	margin-left: auto;
   		margin-right: auto;
   		text-align: center;
}     

.btnOpAdm{
	text-align: left;
}	

footer{
  position: fixed !important;
}

</style>


<!--Breadcrumbs o migajas para indicar al usuario dónde se encuentra en la página-->
<body>


<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="userProfile">Perfil de Usuario</a></li>
    <li class="breadcrumb-item active">Mis Transacciones</li>
</ol>

	<div id="container-fluid">

<h4 style="text-align: center;">Transacciones del Usuario:</h4>

		<div class="row no-gutters imagebuffer">
			<div class="col-sm-12 "></div>
		</div>
		
    <!--Enlaces para ingresar a los paneles de transacciones correspondientes-->
		<div class="row no-gutters panelbuffer">
			<div class="col-sm-4 " ></div>
			<div class="col-sm-4 buttonPanel">
				<div class="btn-group-vertical" >
          <button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="transacAprobadas"><i class="material-icons">assignment</i>Transacciones Aprobadas</button>
          <button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="transacProceso"><i class="material-icons">assignment</i>Transacciones en Proceso</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="transacRechazadas"><i class="material-icons">assignment</i>Transacciones Rechazadas</button>
				</div>
			</div>

    <div class="col-sm-4" ></div>



	
