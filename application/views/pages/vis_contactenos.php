<?php
//************************************************************************************
///Vista de Contactenos contiene los metodos para cargar el formulario que se enviara al administrador 
//se comunica con métodos en los archivos:
//vis.contactenos.php
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Se agrego la documentacion interna necesaria para la correcta descripcion de metodos.
//************************************************************************************** 
?>

<script>
//VARIABLE PARA LEVANTAR EL MODAL DESPUÉS DE ALGUN ERROR
$varCV = <?php echo $modalValid  ?>;

$(document).ready(function () {
//VALIDA CAMBIO DE CONTRASEÑA Y LEVANTA EL MODAL

if($varCV == 0){
    $('#modalSug').modal('show');
  }


  
});

</script>

<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item active">Contactenos</li>
</ol>

<h2 style="text-align: center;">Contacta a Meche´s Ferments</h2>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>

<div class="row no-gutters">
	<div class="col-sm-1 " ></div>
	<div class="col-sm-4 " id="googleMap" style="height:400px;"></div>
	
	<script>
	//Carga el mapa de Google con la localizacion de la tienda 
	function myMap() {
	var mapProp= {lat:9.991606,lng:-84.143299};
	var map=new google.maps.Map(document.getElementById("googleMap"),{zoom:15,center:mapProp});
	var marker = new google.maps.Marker({position:mapProp,map:map,animation: google.maps.Animation.BOUNCE});
	}
	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdjiutXIiGUMhSZEJqUiygfmz0TWm_u08
&callback=myMap"></script>

	<div class="col-sm-2 " ></div>
	<div class="col-sm-4 " >
		<p style="text-align:justify;">
			<strong>¿Necesitas soporte con una orden?</strong>
			<br>
			<br>
			Contáctanos a mechesferments@gmail.com y recibirás una respuestas en menos de 48 horas.
			<br>
			<br>
			<strong>¿Cuál es nuestra ubicación?</strong>
			<br>
			<br>
			Puedes encontrarnos en Google Maps y Waze como Meches Ferments.
			<br>
			<br>
			<strong>¿Tienes preguntas o sugerencias?</strong>
			<br>
			<br>
			Envíanos tus preguntas o comentarios a mechesferments@gmail y recibirás una respuesta lo más pronto posible o de manera alternativa llena el formulario que aparece en el siguiente botón.<br><br>
			<button type="button" id="botonSugerencias" data-toggle="modal" data-target="#modalSug" class="btn btn-primary" data-backdrop="static">Formulario</button>
		</p>
	</div>     
	<div class="col-sm-1 " ></div>
</div>   <!--close tag for <div class="row no-gutters"> -->

<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
</div>

<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
</div>

	<div class="row no-gutters">
        
		<div class="col-sm-4"></div>
				
        <div class="col-sm-4 " id="idForm">
		
			<!--DIV para MODAL de sugerencias   -->
			<div id="modalSug" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Contenido del formulario -->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Formulario</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_contactenos/met_agregarSugComPre'); ?>
						
							<div class="form-group">
							  <label for="nombreSug">Nombre:</label><?php echo form_error('nombreSug','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="nombreSug" value="<?php echo set_value('nombreSug'); ?>" placeholder="Ingrese su nombre" name="nombreSug">
							</div>

							<div class="form-group">
							  <label for="apellidoSug">Apellido:</label><?php echo form_error('apellidoSug','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="apellidoSug" value="<?php echo set_value('apellidoSug'); ?>" placeholder="Ingrese su apellido" name="apellidoSug">
							</div>
					
							<div class="form-group">
							  <label for="emailSug">Email:</label><?php echo form_error('emailSug','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="emailSug" value="<?php echo set_value('emailSug'); ?>" placeholder="Ingrese su email" name="emailSug">
							</div>
					
							<div class="form-group">
							  <label for="telefonoSug">Teléfono:</label><?php echo form_error('telefonoSug','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="telefonoSug" value="<?php echo set_value('telefonoSug'); ?>" placeholder="Ingrese su teléfono" name="telefonoSug">
							</div>
							
							<div class="form-group">
							  <label for="comPreSug">Comentario/Pregunta/Sugerencia:</label><?php echo form_error('comPreSug','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <textarea class="form-control" id="comPreSug" value="<?php echo set_value('comPreSug'); ?>" placeholder="Ingrese su comentario, pregunta o sugerencia" name="comPreSug" rows="10">
							  </textarea>
							</div>
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							
							<input type="submit" id="botonEnviar" class="btn btn-primary" value="Enviar"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
							</form>
						</div> 
					
					</div> 
					
				</div> 
			</div>
		</div>	
		
		<div class="col-sm-4"></div>
			
	</div>

<div class="row no-gutters imagebuffer">
<div class="col-sm-12 "></div>
</div>

<br>
<br>
<br>

<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
</div>
