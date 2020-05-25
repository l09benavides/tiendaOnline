<?php
//************************************************************************************
/*Esta vista forma parte del módulo de imágenes, se utiliza para la administración de imágenes generales que se muestra a los usuarios y hace referencia al controlador Ctrl_panelImagenesGenerales*/
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>

//Variables utilizadas para identificar errores ingresados en el form
varMo = <?php echo $modalValid;  ?>; 
varAg = <?php echo $modalAgregValid;  ?>;
varMoNos = <?php echo $modalValidNosotras;  ?>; 
varAgNos = <?php echo $modalAgregValidNosotras;  ?>;

//Esta función identifica si hace falta un dato en el form
function checkReferencia() {
	if(!$('#descripcionModIm').val()){
		$('#btnModImg').hide();
		$("#spanCheckReferencia").html("¡El sistema requiere este dato!");
		document.getElementById("spanCheckReferencia").style["color"] = "red";
	}else{
		$('#btnModImg').show();
		$("#spanCheckReferencia").html("");
		document.getElementById("spanCheckReferencia").style["color"] = "red";
	}
	
	/* var ref = $("#referenciaModIm").val();

	if (ref == "" || ref == NULL) {
		$('#btnModImg').hide();
	}
	if(ref != "" || ref != NULL){
		$('#btnModImg').show();
	} */
}


$(document).ready(function () {
	
	

	$('[data-toggle="tooltipMod"]').tooltip();
	$('[data-toggle="tooltipEli"]').tooltip();

	/* if(varCV==0){
		$('#verificador').show();
	}*/
	
	$("#descripcionModIm").keyup(checkReferencia);
	$("#descripcionModImNos").keyup(checkReferencia);

	//verificadores de error para abrir modal de imágenes de inicio
	if(varMo==0){
		$('#modalPass').modal('toggle');
		$('#modalPass').modal('show');
		$('#modalPass').modal('hide');
	}
	
	if(varAg==0){
		$('#modalAgregar').modal('toggle');
		$('#modalAgregar').modal('show');
		$('#modalAgregar').modal('hide');
	}
	
	//verificadores de error para abrir modal de imágenes de nosotras
	if(varMoNos==0){
		$('#modalPassNos').modal('toggle');
		$('#modalPassNos').modal('show');
		$('#modalPassNos').modal('hide');
	}
	
	if(varAgNos==0){
		$('#modalAgregarNos').modal('toggle');
		$('#modalAgregarNos').modal('show');
		$('#modalAgregarNos').modal('hide');
	}

	
	//script para llenar campos de modificación de imagen de inicio
	$('tr td i#mod').click(function(){
		//alert('test');
		$('#modalPass').modal('toggle');
		$('#modalPass').modal('show');
		$('#modalPass').modal('hide');

		$('#idModGen').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#idModIm').val($(this).closest("tr").find('td:nth-of-type(2)').text());
		$('#descripcionComp').val($(this).closest("tr").find('td:nth-of-type(3)').text());
		$('#descripcionModIm').val($(this).closest("tr").find('td:nth-of-type(3)').text());
		$('#imgPrv').attr('src','https://www.mechesferments.com/uploads/generales/'+$(this).closest("tr").find('td:nth-of-type(4)').text());
	});
	
	//script para llenar campos de eliminación de imagen de inicio
	$('tr td i#eli').click(function(){

		$('#modalEliImg').modal('toggle');
		$('#modalEliImg').modal('show');
		$('#modalEliImg').modal('hide');
	
		$('#idGenEli').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#idImgEli').val($(this).closest("tr").find('td:nth-child(2)').text());
		$('#descripcionImgEli').val($(this).closest("tr").find('td:nth-child(3)').text());
		$('#imgPrvEli').attr('src','https://www.mechesferments.com/uploads/generales/'+$(this).closest("tr").find('td:nth-of-type(4)').text());
	});

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
.direccionesbuffer{
        height:260px;
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
#verificador{
	text-align:center;
  display: none;
}
.tablaProd{
	padding: 0 0 0 0;
	margin: 20px 30px 20px 30px;
	
}
.infoReqEscondida{
	display:none;
}
.idNone{
	display:none;
}
.trHeight{
	height: 80px;
}
.pointer {cursor: pointer;}

</style>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12"></div>
</div>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
		<li class="breadcrumb-item active">Panel de Imagenes Generales</li>
	</ol>


<!--Elementos para imágenes de inicio-->

<h2 style="text-align: left;border-bottom-style:solid;" id="imagenesInicio" class="pointer">Imágenes de Inicio</h2>



<div class="row no-gutters imagebuffer elementoColapsable">
	<div class="col-sm-12 " style="text-align:center;">
	<button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">Agregar Imagen&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">add_a_photo</i></button>
	</div>
</div>

<div class="row no-gutters imagebuffer elementoColapsable">
	<div class="col-sm-12 "></div>
</div>


<div class="row no-gutters direccionesbuffer elementoColapsable" style="overflow-x:hidden;overflow-y:scroll;">
	<div class="col-sm-12 ">
		<div class="tablaProd" id="listaImagenes">

			<table class="table table-striped table-bordered" id="tab_imag">
				<thead>
					<tr>
						<th class="infoReqEscondida">ID General</th>
						<th class="infoReqEscondida">ID Imagen</th>
						<th style="vertical-align:middle;text-align:center;">Descripción</th>
						<th style="vertical-align:middle;text-align:center;">Nombre</th>
						<th style="vertical-align:middle;text-align:center;">Prevista</th>
						<th style="vertical-align:middle;text-align:center;">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listaImagenesInicio as $imagenes_item) : ?>
						<tr class="trHeight">
							<td class="infoReqEscondida tdCenter"><?php echo $imagenes_item['GENID']; ?></td>
							<td class="infoReqEscondida "><?php echo $imagenes_item['IMGGENID']; ?></td>
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['DES']; ?></td>
							
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['NOMAR']; ?></td>
							<td style="vertical-align:middle;text-align:center;">
							<img src="<?php echo $imagenes_item['RUTA']; ?>" height="48px">
							</td>
							<td style="vertical-align:middle;text-align:center;"><i id="mod" class="fa fa-edit" style="font-size:20px;" data-toggle="tooltipMod" title="Modificar"></i>
							&nbsp; &nbsp; &nbsp; 
							<i id="eli" class="fa fa-trash-o" style="font-size:20px;" data-toggle="tooltipEli" title="Eliminar"></i></td>			
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>





<!-- seccion de modales para imágenes de inicio-->

<div class="row no-gutters">
    
	<div class="col-sm-4"></div>
			
    <div class="col-sm-4 " id="idForm">
	
		<!--DIV para MODAL de agregar   -->
		<div id="modalAgregar" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">Agregar Imagen de Inicio</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
						<?php echo form_open_multipart('Ctrl_panelImagenesGenerales/met_agregarImagIni'); ?>
					
						<div class="form-group">
						  <label for="AgDescripcion">Descripción:</label><?php echo form_error('AgDescripcion','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="AgDescripcion" value="<?php echo set_value('AgDescripcion'); ?>" placeholder="Ingrese una referencia" name="AgDescripcion">
						</div>

						<div class="modal-footer">
							<div class="text-center">
							<?php echo form_upload(['name'=>'userfile', 'value'=>'Save']); ?>
								<?php echo form_error('userfile', '<div class="text-danger">','</div>'); ?>
								<?php echo form_submit(['class'=>'btn btn-primary', 'name'=>'submit', 'value'=>'Subir Imagen']); ?>
							<?php echo form_close(); ?>
							</div>
						</div>
						
					</div>			
						
					<!-- <div class="modal-footer">
						<div class="text-center">
						<input type="submit" id="botonAgregar" class="btn btn-primary" value="Agregar"/>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
						</form>
					</div>  -->
				</div> 
			</div> 
		</div>
		
		<!--DIV para MODAL de modificar   -->
		<div id="modalPass" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">Cambiar Imagen</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
					<?php echo form_open_multipart('Ctrl_panelImagenesGenerales/met_modifImagIni'); ?>
					
						<div class="form-group idNone">
						  <label for="idModGen">Producto ID:</label><?php echo form_error('idModGen','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="idModGen" value="<?php echo set_value('idModGen'); ?>" placeholder="Identificador de sitio" name="idModGen" readonly>
						</div>
					
						<div class="form-group idNone">
						  <label for="idModIm">Imagen ID:</label><?php echo form_error('idModIm','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="idModIm" value="<?php echo set_value('idModIm'); ?>" placeholder="Identificador de imagen" name="idModIm" readonly>
						</div>
						
						<div class="form-group idNone">
						  <label for="descripcionComp">Descripción Comp:</label><?php echo form_error('descripcionComp','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="descripcionComp" value="<?php echo set_value('descripcionComp'); ?>" placeholder="Ingrese una descripción" name="descripcionComp" readonly>
						</div>
					
						<div class="form-group ">
						  <label for="descripcionModIm">Descripción:  <span style="color:red;" id="spanCheckReferencia"></span></label><?php echo form_error('descripcionModIm','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="descripcionModIm" value="<?php echo set_value('descripcionModIm'); ?>" placeholder="Ingrese una descripción" name="descripcionModIm">
						</div>

						<div class="form-group" style="vertical-align:middle;text-align:center;">
						  <img id ="imgPrv" src="" height="200px"/>
						</div>
					
					</div>			
						
					<div class="modal-footer">
						<div class="text-center">
							<?php echo form_upload(['name'=>'userfile', 'value'=>'Save']); ?>
								<?php echo form_error('userfile', '<div class="text-danger">','</div>'); ?>
								<?php echo form_submit(['class'=>'btn btn-primary', 'id'=>'btnModImg','name'=>'submit', 'value'=>'Cambiar Imagen']); ?>
							<?php echo form_close(); ?>
						</div>
					</form>
					</div> 
				
				</div> 
				
			</div> 
		</div> 	
		
		<!--DIV para MODAL DE BORRADO   -->
		<div id="modalEliImg" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">¿Desea eliminar esta imagen?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
						<?php echo form_open_multipart('Ctrl_panelImagenesGenerales/met_elimImagIni'); ?>
					
						<div class="form-group idNone">
						  <label for="idGenEli">Producto ID:</label><?php echo form_error('idGenEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="idGenEli" name="idGenEli" readonly>
						</div>
						
						<div class="form-group idNone">
						  <label for="idImgEli">Imagen ID:</label><?php echo form_error('idImgEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="idImgEli" name="idImgEli" readonly>
						</div>
					
						<div class="form-group">
						  <label for="descripcionImgEli">Descripción:</label><?php echo form_error('descripcionImgEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="descripcionImgEli" name="descripcionImgEli" readonly>
						</div>

						<div class="form-group" style="vertical-align:middle;text-align:center;">
						  <img id ="imgPrvEli" src="" height="200px"/>
						</div>
					
					</div>			
						
					<div class="modal-footer">
						<div class="text-center">
						<!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
						<input type="submit" id="botonEliminar" class="btn btn-primary" value="Eliminar Imagen"/>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
						</form>
					</div> 
				
				</div> 
				
			</div> 
		</div>
		
		
		
		
		
		
		
	</div>    	 <!--close tag for <div class="col-sm-4 " > -->

</div>

<!-- los siguientes divs son para agregar espacio entre este imagenes de carrusel y de nosotras -->
	
<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>
<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>

<!--Elementos para imágenes de nosotras-->

<h2 style="text-align: left;border-bottom-style:solid;" id="imagenesNosotras" class="pointer">Imágenes de Nosotras</h2>

<div class="row no-gutters imagebuffer elementoColapsableNos">
	<div class="col-sm-12 " style="text-align:center;">
	<button type="button" id="botAgregarNos" data-toggle="modal" data-target="#modalAgregarNos" class="btn btn-primary" data-backdrop="static">Agregar Imagen&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">add_a_photo</i></button>
	</div>
</div>

<div class="row no-gutters imagebuffer elementoColapsableNos">
	<div class="col-sm-12 "></div>
</div>


<div class="row no-gutters direccionesbuffer elementoColapsableNos" style="overflow-x:hidden;overflow-y:scroll;">
	<div class="col-sm-12 ">
		<div class="tablaProd" id="listaImagenesNos">

			<table class="table table-striped table-bordered" id="tab_imag_nos">
				<thead>
					<tr>
						<th class="infoReqEscondida">ID General</th>
						<th class="infoReqEscondida">ID Imagen</th>
						<th style="vertical-align:middle;text-align:center;">Descripción</th>
						<th style="vertical-align:middle;text-align:center;">Nombre</th>
						<th style="vertical-align:middle;text-align:center;">Prevista</th>
						<th style="vertical-align:middle;text-align:center;">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listaImagenesNosotras as $imagenes_item) : ?>
						<tr class="trHeight">
							<td class="infoReqEscondida tdCenter"><?php echo $imagenes_item['GENID']; ?></td>
							<td class="infoReqEscondida "><?php echo $imagenes_item['IMGGENID']; ?></td>
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['DES']; ?></td>
							
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['NOMAR']; ?></td>
							<td style="vertical-align:middle;text-align:center;">
							<img src="<?php echo $imagenes_item['RUTA']; ?>" height="48px">
							</td>
							<td style="vertical-align:middle;text-align:center;"><i id="modNos" class="fa fa-edit" style="font-size:20px;" data-toggle="tooltipMod" title="Modificar"></i>
							&nbsp; &nbsp; &nbsp; 
							<i id="eliNos" class="fa fa-trash-o" style="font-size:20px;" data-toggle="tooltipEli" title="Eliminar"></i></td>			
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- seccion de modales para imágenes de nosotras-->

<div class="row no-gutters">
    
	<div class="col-sm-4"></div>
			
    <div class="col-sm-4 " id="idFormNos">
	
		<!--DIV para MODAL de agregar   -->
		<div id="modalAgregarNos" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">Agregar Imagen de Nosotras</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
						<?php echo form_open_multipart('Ctrl_panelImagenesGenerales/met_agregarImagNos'); ?>
					
						<div class="form-group">
						  <label for="AgDescripcionNos">Descripción:</label><?php echo form_error('AgDescripcionNos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="AgDescripcionNos" value="<?php echo set_value('AgDescripcionNos'); ?>" placeholder="Ingrese una referencia" name="AgDescripcionNos">
						</div>

						<div class="modal-footer">
							<div class="text-center">
							<?php echo form_upload(['name'=>'userfile', 'value'=>'Save']); ?>
								<?php echo form_error('userfile', '<div class="text-danger">','</div>'); ?>
								<?php echo form_submit(['class'=>'btn btn-primary', 'name'=>'submit', 'value'=>'Subir Imagen']); ?>
							<?php echo form_close(); ?>
							</div>
						</div>
						
					</div>			
						
					<!-- <div class="modal-footer">
						<div class="text-center">
						<input type="submit" id="botonAgregar" class="btn btn-primary" value="Agregar"/>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
						</form>
					</div>  -->
				</div> 
			</div> 
		</div>
		
		<!--DIV para MODAL de modificar   -->
		<div id="modalPassNos" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">Cambiar Imagen</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
					<?php echo form_open_multipart('Ctrl_panelImagenesGenerales/met_modifImagNos'); ?>
					
						<div class="form-group idNone">
						  <label for="idModGenNos">Producto ID:</label><?php echo form_error('idModGenNos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="idModGenNos" value="<?php echo set_value('idModGenNos'); ?>" placeholder="Identificador de sitio" name="idModGenNos" readonly>
						</div>
					
						<div class="form-group idNone">
						  <label for="idModImNos">Imagen ID:</label><?php echo form_error('idModImNos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="idModImNos" value="<?php echo set_value('idModImNos'); ?>" placeholder="Identificador de imagen" name="idModImNos" readonly>
						</div>
						
						<div class="form-group idNone">
						  <label for="descripcionCompNos">Descripción Comp:</label><?php echo form_error('descripcionCompNos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="descripcionCompNos" value="<?php echo set_value('descripcionCompNos'); ?>" placeholder="Ingrese una descripción" name="descripcionCompNos" readonly>
						</div>
					
						<div class="form-group ">
						  <label for="descripcionModImNos">Descripción:  <span style="color:red;" id="spanCheckReferencia"></span></label><?php echo form_error('descripcionModImNos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="descripcionModImNos" value="<?php echo set_value('descripcionModImNos'); ?>" placeholder="Ingrese una descripción" name="descripcionModImNos">
						</div>

						<div class="form-group" style="vertical-align:middle;text-align:center;">
						  <img id ="imgPrv" src="" height="200px"/>
						</div>
					
					</div>			
						
					<div class="modal-footer">
						<div class="text-center">
							<?php echo form_upload(['name'=>'userfile', 'value'=>'Save']); ?>
								<?php echo form_error('userfile', '<div class="text-danger">','</div>'); ?>
								<?php echo form_submit(['class'=>'btn btn-primary', 'id'=>'btnModImg','name'=>'submit', 'value'=>'Cambiar Imagen']); ?>
							<?php echo form_close(); ?>
						</div>
					</form>
					</div> 
				
				</div> 
				
			</div> 
		</div> 	
		
		<!--DIV para MODAL DE BORRADO   -->
		<div id="modalEliImgNos" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">¿Desea eliminar esta imagen?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
						<?php echo form_open_multipart('Ctrl_panelImagenesGenerales/met_elimImagNos'); ?>
					
						<div class="form-group idNone">
						  <label for="idGenEli">Producto ID:</label><?php echo form_error('idGenEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="idGenEli" name="idGenEli" readonly>
						</div>
						
						<div class="form-group idNone">
						  <label for="idImgEli">Imagen ID:</label><?php echo form_error('idImgEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="idImgEli" name="idImgEli" readonly>
						</div>
					
						<div class="form-group">
						  <label for="descripcionImgEli">Descripción:</label><?php echo form_error('descripcionImgEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="descripcionImgEli" name="descripcionImgEli" readonly>
						</div>

						<div class="form-group" style="vertical-align:middle;text-align:center;">
						  <img id ="imgPrvEli" src="" height="200px"/>
						</div>
					
					</div>			
						
					<div class="modal-footer">
						<div class="text-center">
						<!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
						<input type="submit" id="botonEliminar" class="btn btn-primary" value="Eliminar Imagen"/>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
						</form>
					</div> 
				
				</div> 
				
			</div> 
		</div>
		
		
		
		
		
		
		
	</div>    	 <!--close tag for <div class="col-sm-4 " > -->

</div>


<!-- seccion de codigo para formato de tablas -->

<script src="https://www.mechesferments.com/scripts/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<script type="text/javascript">
    $(function () {
		
		$('#tab_imag').dataTable();
		$(".elementoColapsable").hide();
		$("#imagenesInicio").click(function(){
			$(".elementoColapsable").toggle();
		});
		
		$('#tab_imag_nos').dataTable();
		$(".elementoColapsableNos").hide();
		$("#imagenesNosotras").click(function(){
			$(".elementoColapsableNos").toggle();
		});
	});
</script>




<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>
<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>
<!-- <div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>
<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div> -->
<!-- <div class="row no-gutters imagebuffer">
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
</div> -->
