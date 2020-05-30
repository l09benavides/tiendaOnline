<?php
//************************************************************************************
//Este módulo corresponde a la vista de direcciones que se muestra a los usuarios,
// y que además provee la funcionalidad CRUD para las direcciones del usuario
//Autor: Diego Carillo
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Luis Benavides
// Se corriguen algunas etiquetas html que estaba haciendo overlap
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>

varCV = <?php echo $verificador;  ?>;
varMo = <?php echo $modalValid;  ?>;
varAg = <?php echo $modalAgregValid;  ?>;

$(document).ready(function () {

	//Tooltip para guiar al usuario
	$('[data-toggle="tooltipMod"]').tooltip();
	$('[data-toggle="tooltipEli"]').tooltip();
	
	if(varCV==0){
		$('#verificador').show();
	}

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
	
	/* $('i').click(function(){ -->
		
		<!-- $('#modalEliDir').modal('toggle'); -->
		<!-- $('#modalEliDir').modal('show'); -->
		<!-- $('#modalEliDir').modal('hide'); -->

		<!-- $('#idEli').val($(this).find('td:nth-child(1)').text()); -->
		<!-- $('#referenciaEli').val($(this).find('td:nth-child(2)').text()); -->
		
	<!-- }); */
	//Carga la informacion del modal para las direcciones
	$('tr td i#mod').click(function(){
		//alert('test');
		$('#modalPass').modal('toggle');
		$('#modalPass').modal('show');
		$('#modalPass').modal('hide');

		$('#id').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#referencia').val($(this).closest("tr").find('td:nth-of-type(2)').text());
		$('#localizacion').val($(this).closest("tr").find('td:nth-of-type(3)').text());
		$('#distrito').val($(this).closest("tr").find('td:nth-of-type(4)').text());
		$('#canton').val($(this).closest("tr").find('td:nth-of-type(5)').text());
		$('#provincia').val($(this).closest("tr").find('td:nth-of-type(6)').text());
	});
	
	$('tr td i#eli').click(function(){

		$('#modalEliDir').modal('toggle');
		$('#modalEliDir').modal('show');
		$('#modalEliDir').modal('hide');
	
		$('#idEli').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#referenciaEli').val($(this).closest("tr").find('td:nth-child(2)').text());
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
        height:225px;
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
.direcusuar{
	padding: 0 0 0 0;
	margin: 20px 30px 20px 30px;
	
}

</style>

<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="userProfile">Perfil de Usuario</a></li>
		<li class="breadcrumb-item active">Direcciones de Usuario</li>
</ol>
<div class="container-fluid">
	
	

	<h2 style="text-align: center;">Direcciones de usuario</h2>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 " style="text-align:center;">
			<button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">Agregar dirección&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">add_location</i></button>
		</div>
	</div>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>
	
	<div class="row no-gutters direccionesbuffer">
		<div class="col-sm-12 ">
		<div class="direcusuar" id="verificador"><h6>No existen direcciones registradas.</h6></div>
			<div class="direcusuar" id="listaDirecciones">
				<table class="table table-striped table-bordered" id="direcciones">
				<thead>
				<tr>
				<th>ID</th>
				<th>Referencia</th>
				<th>Detalle</th>
				<th>Distrito</th>
				<th>Cantón</th>
				<th>Provincia</th>
				<th>Acciones</th>
				</tr>
				</thead>
				<tbody>
				<?php 
				// Ciclo para recorrer la informacion enviada por el controlador y mostrar las direcciones.
				foreach ($queryDirecciones as $direccion_item): 

				?>

				<tr>
				<td class="idData"><?php echo $direccion_item['DIRECCIONID']; ?></td>
				<td class="referData"><?php echo $direccion_item['REFER']; ?></td>
				<td class="detData"><?php echo $direccion_item['LOCA']; ?></td>
				<td class="disData"><?php echo $direccion_item['DIST']; ?></td>
				<td class="canData"><?php echo $direccion_item['CANT']; ?></td>
				<td class="proData"><?php echo $direccion_item['PROV']; ?></td>
				<td><i id="mod" class="fa fa-edit" style="font-size:20px;" data-toggle="tooltipMod" title="Modificar"></i>
					&nbsp; &nbsp; &nbsp;
				<i id="eli" class="fa fa-trash-o" style="font-size:20px;" data-toggle="tooltipEli" title="Eliminar"></i>
			</td>
				</tr>
						
				<?php 
				// Fin del ciclo
				endforeach; ?>
				
				</tbody>
			    </table>



			</div>
		
		</div>
	</div>


	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

	<script type="text/javascript">
	$(function () {
		//Dar formato de tabla
	    $('#direcciones').dataTable();
	} );
	</script>

	
	
	<div class="row no-gutters">
        
		<div class="col-sm-4"></div>
				
        <div class="col-sm-4 " id="idForm">
		
			<!--DIV para MODAL de agregar   -->
			<div id="modalAgregar" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Agregar Dirección</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_direcciones/met_agregarDir'); ?>
						
							<div class="form-group">
							  <label for="referenciaAg">Referencia:</label><?php echo form_error('referenciaAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="referenciaAg" value="<?php echo set_value('referenciaAg'); ?>" placeholder="Ingrese un nombre de referencia. (ej: Casa, Oficina, etc.)" name="referenciaAg">
							</div>

							<div class="form-group">
							  <label for="provinciaAg">Provincia:</label><?php echo form_error('provinciaAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="provinciaAg" value="<?php echo set_value('provinciaAg'); ?>" placeholder="Ingrese su provincia" name="provinciaAg">
							</div>
					
							<div class="form-group">
							  <label for="cantonAg">Cantón:</label><?php echo form_error('cantonAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="cantonAg" value="<?php echo set_value('cantonAg'); ?>" placeholder="Ingrese su cantón" name="cantonAg">
							</div>
					
							<div class="form-group">
							  <label for="distritoAg">Distrito:</label><?php echo form_error('distritoAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="distritoAg" value="<?php echo set_value('distritoAg'); ?>" placeholder="Ingrese su distrito" name="distritoAg">
							</div>
							
							<div class="form-group">
							  <label for="localizacionAg">Detalles de la dirección:</label><?php echo form_error('localizacionAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="localizacionAg" value="<?php echo set_value('localizacionAg'); ?>" placeholder="Ingrese detalles de la dirección" name="localizacionAg">
							</div>
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							
							<input type="submit" id="botonAgregar" class="btn btn-primary" value="Agregar"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
							</form>
						</div> 
					
					</div> 
					
				</div> 
			</div>
		
		
			<!--DIV para MODAL de modificar   -->
			<div id="modalPass" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Cambiar Dirección</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_direcciones/met_modifDir'); ?>
						
							<div class="form-group">
							  <label for="id">ID:</label><?php echo form_error('id','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="id" value="<?php echo set_value('id'); ?>" placeholder="Identificador de dirección" name="id" readonly>
							</div>
						
							<div class="form-group">
							  <label for="referencia">Referencia:</label><?php echo form_error('referencia','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="referencia" value="<?php echo set_value('referencia'); ?>" placeholder="Ingrese un nombre de referencia" name="referencia">
							</div>

							<div class="form-group">
							  <label for="provincia">Provincia:</label><?php echo form_error('provincia','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="provincia" value="<?php echo set_value('provincia'); ?>" placeholder="Ingrese su provincia" name="provincia">
							</div>
					
							<div class="form-group">
							  <label for="canton">Cantón:</label><?php echo form_error('canton','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="canton" value="<?php echo set_value('canton'); ?>" placeholder="Ingrese su cantón" name="canton">
							</div>
					
							<div class="form-group">
							  <label for="distrito">Distrito:</label><?php echo form_error('distrito','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="distrito" value="<?php echo set_value('distrito'); ?>" placeholder="Ingrese su distrito" name="distrito">
							</div>
							
							<div class="form-group">
							  <label for="localizacion">Detalles de la dirección:</label><?php echo form_error('localizacion','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="localizacion" value="<?php echo set_value('localizacion'); ?>" placeholder="Ingrese detalles de la dirección" name="localizacion">
							</div>
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							
							<input type="submit" id="botonModificar" class="btn btn-primary" value="Guardar Cambios"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
							</form>
						</div> 
					
					</div> 
					
				</div> 
			</div> 	


			<!--DIV para MODAL DE BORRADO   -->
			<div id="modalEliDir" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">¿Desea eliminar esta dirección?</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_direcciones/met_elimDir'); ?>
						
							<div class="form-group">
							  <label for="idEli">ID:</label><?php echo form_error('idEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" value= "" class="form-control" id="idEli" name="idEli" readonly>
							</div>
						
							<div class="form-group">
							  <label for="referenciaEli">Referencia:</label><?php echo form_error('referenciaEli','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" value= "" class="form-control" id="referenciaEli" name="referenciaEli" readonly>
							</div>

							
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							<!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
							<input type="submit" id="botonEliminar" class="btn btn-primary" value="Eliminar Dirección"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
							</form>
						</div> 
					
					</div> 
					
				</div> 
			</div>		
 
		</div>     <!--close tag for <div class="col-sm-4 " > -->

		<!-- <div class="col-sm-1 " ></div>
		<div class="col-sm-2 " >
			<div class="btn-group-vertical mechesGrupoBotones">
				<button type="button" id="" class="btn btn-primary">Agregar</button>
				<button type="button" id="" class="btn btn-primary">Modificar</button>
				<button type="button" id="" class="btn btn-primary">Eliminar</button>
			</div>
		</div>
	

		<div class="col-sm-1 " ></div>  -->
		
		<div class="col-sm-4 "></div>



	</div>   <!--close tag for <div class="row no-gutters"> -->



	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>


	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

</div>   <!--close tag for <div class="container-fluid"> -->


