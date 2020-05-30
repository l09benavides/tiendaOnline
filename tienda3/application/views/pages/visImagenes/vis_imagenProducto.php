<?php
//************************************************************************************
/*Esta vista forma parte del módulo de imágenes, se utiliza para la administración de imágenes de productos que se muestra a los usuarios y hace referencia al controlador Ctrl_panelImagenesProductos*/
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

//Esta función identifica si hace falta un dato en el form
function checkReferencia() {
	if(!$('#referenciaModIm').val()){
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
	
	$("#referenciaModIm").keyup(checkReferencia);

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

	$('tr td i#mod').click(function(){
		//alert('test');
		$('#modalPass').modal('toggle');
		$('#modalPass').modal('show');
		$('#modalPass').modal('hide');

		$('#idModPro').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#idModIm').val($(this).closest("tr").find('td:nth-of-type(2)').text());
		$('#referenciaModIm').val($(this).closest("tr").find('td:nth-of-type(5)').text());
		$('#imgPrv').attr('src','https://www.mechesferments.com/uploads/'+$(this).closest("tr").find('td:nth-of-type(6)').text());
	});
	
	$('tr td i#eli').click(function(){

		$('#modalEliImg').modal('toggle');
		$('#modalEliImg').modal('show');
		$('#modalEliImg').modal('hide');
	
		$('#idProEli').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#idImgEli').val($(this).closest("tr").find('td:nth-child(2)').text());
		$('#referenciaImgEli').val($(this).closest("tr").find('td:nth-child(5)').text());
		$('#imgPrvEli').attr('src','https://www.mechesferments.com/uploads/'+$(this).closest("tr").find('td:nth-of-type(6)').text());
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
}
*/
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


</style>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12"></div>
</div>
<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
		<li class="breadcrumb-item active">Panel de Imagenes de Productos</li>
	</ol>
	

<h2 style="text-align: center;">Imágenes de productos</h2>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 " style="text-align:center;">
	<button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">Agregar Imagen&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">add_a_photo</i></button>
	</div>
</div>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>


<div class="row no-gutters direccionesbuffer" style="overflow-x:hidden;overflow-y:scroll;">
	<div class="col-sm-12 ">
		<div class="tablaProd" id="listaImagenes">

			<table class="table table-striped table-bordered" id="tab_imag">
				<thead>
					<tr>
						<th class="infoReqEscondida">ID Producto</th>
						<th class="infoReqEscondida">ID Imagen</th>
						<th style="vertical-align:middle;text-align:center;">Código</th>
						<th style="vertical-align:middle;text-align:center;">Nombre</th>
						<th style="vertical-align:middle;text-align:center;">Referencia</th>
						<th style="vertical-align:middle;text-align:center;">Imagen</th>
						<th style="vertical-align:middle;text-align:center;">Prevista</th>
						<th style="vertical-align:middle;text-align:center;">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listaImagenes as $imagenes_item) : ?>
						<tr class="trHeight">
							<td class="infoReqEscondida tdCenter"><?php echo $imagenes_item['PROID']; ?></td>
							<td class="infoReqEscondida "><?php echo $imagenes_item['IMGPROID']; ?></td>
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['CODIGO']; ?></td>
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['NOMBRE']; ?></td>
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['REFER']; ?></td>
							<td style="vertical-align:middle;text-align:center;"><?php echo $imagenes_item['IMAGEN']; ?></td>
							<td style="vertical-align:middle;text-align:center;">
							<img src="<?php echo $imagenes_item['RUTA']; ?>" height="48px">
							</td>
							<!-- <td><?php echo $imagenes_item['RUTA']; ?>
							&nbsp; &nbsp; &nbsp;
							<img src="<?php echo $imagenes_item['RUTA']; ?>" width="20px" height="20px">
							</td> -->
							<!-- <td><img src="<?php echo $imagenes_item['RUTA']; ?>" width="48px" height="48px"></td> -->
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


<!-- seccion de codigo para formato de tablas -->

<script src="https://www.mechesferments.com/scripts/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<script type="text/javascript">
    $(function () {
            $('#tab_imag').dataTable();
        } );
</script>


<!-- seccion de modales -->

<div class="row no-gutters">
    
	<div class="col-sm-4"></div>
			
    <div class="col-sm-4 " id="idForm">
	
		<!--DIV para MODAL de agregar   -->
		<div id="modalAgregar" class="modal fade" role="dialog">
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="modal-title">Agregar Imagen</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
				
						<?php echo form_open_multipart('Ctrl_panelImagenesProductos/met_agregarImag'); ?>
					
						<div class="form-group">
						  <label for="AgProductos">Productos:</label>
							<select class="form-control" name="AgProductos" id="AgProductos">
							<?php foreach($listaProductos as $productos_item) : ?>
								<option value="<?php echo $productos_item->ID_PRODUCTO; ?>"><?php echo $productos_item->CODIGO.' - '.$productos_item->NOMBRE ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					
						<div class="form-group">
						  <label for="AgReferencia">Referencia:</label><?php echo form_error('AgReferencia','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="AgReferencia" value="<?php echo set_value('AgReferencia'); ?>" placeholder="Ingrese una referencia" name="AgReferencia">
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
				
					<?php echo form_open_multipart('Ctrl_panelImagenesProductos/met_modifImag'); ?>
					
						<div class="form-group idNone">
						  <label for="idModPro">Producto ID:</label><?php echo form_error('idModPro','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="idModPro" value="<?php echo set_value('idModPro'); ?>" placeholder="Identificador de dirección" name="idModPro" readonly>
						</div>
					
						<div class="form-group idNone">
						  <label for="idModIm">Imagen ID:</label><?php echo form_error('idModIm','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="idModIm" value="<?php echo set_value('idModIm'); ?>" placeholder="Identificador de dirección" name="idModIm" readonly>
						</div>
						
						<div class="form-group idNone">
						  <label for="referenciaComp">Referencia Comp:</label><?php echo form_error('referenciaComp','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="referenciaComp" value="<?php echo set_value('referenciaComp'); ?>" placeholder="Ingrese un nombre de referencia" name="referenciaComp" readonly>
						</div>
					
						<div class="form-group ">
						  <label for="referenciaModIm">Referencia:  <span style="color:red;" id="spanCheckReferencia"></span></label><?php echo form_error('referenciaModIm','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" class="form-control" id="referenciaModIm" value="<?php echo set_value('referenciaModIm'); ?>" placeholder="Ingrese un nombre de referencia" name="referenciaModIm">
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
				
						<?php echo form_open_multipart('Ctrl_panelImagenesProductos/met_elimImag'); ?>
					
						<div class="form-group idNone">
						  <label for="idProEli">Producto ID:</label><?php echo form_error('idProEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="idProEli" name="idProEli" readonly>
						</div>
						
						<div class="form-group idNone">
						  <label for="idImgEli">Imagen ID:</label><?php echo form_error('idImgEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="idImgEli" name="idImgEli" readonly>
						</div>
					
						<div class="form-group">
						  <label for="referenciaImgEli">Referencia:</label><?php echo form_error('referenciaImgEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						  <input type="text" value= "" class="form-control" id="referenciaImgEli" name="referenciaImgEli" readonly>
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

<!-- los siguientes divs son para agregar espacio entre este contenido y el footer -->
	
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
