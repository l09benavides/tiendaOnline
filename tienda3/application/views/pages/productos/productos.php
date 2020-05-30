<?php
//************************************************************************************
//Vista de panel de productos para los administradores, permite listar, agregar, 
//modificar o eliminar un producto.
//Dentro del panel aparecen todos los productos agregados hasta el momento 
//con toda las descripciones de los campos de cada producto. 
//Autor: Pablo Hernández
//Fecha de creación: 08/07/2018
//Lista modificaciones
//15/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//*************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Editor de texto para los textarea de meches -->
<script type="text/javascript"  src="<?php echo base_url('assets/ckeditor/ckeditor.js')?>"></script> 

<script>

//Variables para control de modales
modalAgr = <?php echo $modalAgrValid; ?>;
modalMod = <?php echo $modalModValid; ?>;
modalProdAgregado = <?php echo $modalProdAgregado; ?>;
modalProdModificado = <?php echo $modalProdModificado; ?>;
modalProdEliminado = <?php echo $modalProdEliminado; ?>;

//Funciones para validación y control de los Modales
$(document).ready(function () {

	$('[data-toggle="tooltipMod"]').tooltip();
	$('[data-toggle="tooltipEli"]').tooltip();
	
	if(modalAgr==0){
		
		$('#modalAgregar').modal('show');
	}

	if(modalMod==0){
		$('#modalModificar').modal('show');
	}

	if(modalProdAgregado==1){
		$('#modalProdAgregado').modal('show');
	}

	if(modalProdModificado==1){
		$("#modalmodificartxt").html("Producto modificado correctamente!");
		$("#modalmodificarimg").attr('src','<?php echo base_url();?>images/modalok.JPG');
		$('#modalProdModificado').modal('show');
	}
	else if(modalProdModificado==2){
		$("#modalmodificartxt").html("No se modificó ningún dato");
		$("#modalmodificarimg").attr('src','<?php echo base_url();?>images/modalwarning.JPG');
		$('#modalProdModificado').modal('show');
	}

	if(modalProdEliminado==1){
		$("#modaleliminartxt").html("Producto Eliminado Correctamente!");
		$("#modaleliminarimg").attr('src','<?php echo base_url();?>images/modalok.JPG');
		$('#modalProdEliminado').modal('show');
	}
	else if(modalProdEliminado==2){
		$("#modaleliminartxt").html("No se puede eliminar el Producto porque está en Uso!");
		$("#modaleliminarimg").attr('src','<?php echo base_url();?>images/modalerror.JPG');
		$('#modalProdEliminado').modal('show');
	}

	//Función para buscar los elementos en la página de acuerdo a su ubicación (Fila, Columna)
	$('tr td i#mod').click(function(){
		$('#modalModificar').modal('show');

		$('#ModCodigoProd').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#ModNombreProd').val($(this).closest("tr").find('td:nth-child(2)').text());
		$('#ModDescripProd').val($(this).closest("tr").find('td:nth-child(3)').text());
        CKEDITOR.instances.ModDetalleProd.setData($('#ModDetalleProd').val($(this).closest("tr").find('td:nth-child(4)').text()));
		optCategoria = $(this).closest("tr").find('td:nth-child(5)').text();		
		$('#ModPrecioProd').val($(this).closest("tr").find('td:nth-child(6)').text().match(/\d+/));
		$('#ModDescuenProd').val($(this).closest("tr").find('td:nth-child(7)').text().match(/\d+/));
		$('#ModInventProd').val($(this).closest("tr").find('td:nth-child(8)').text());
		optCapacidad = $(this).closest("tr").find('td:nth-child(9)').text().match(/\d+/);
		optEstado = $(this).closest("tr").find('td:nth-child(10)').text();
		optImpuesto = $(this).closest("tr").find('td:nth-child(11)').text();
		$("#ModCategoriaProd option[id='"+optCategoria+"']").prop('selected',true);
		$("#ModCapacidadProd option[id='"+optCapacidad+"']").prop('selected',true);
		$("#ModEstadoProd option[id='"+optEstado+"']").prop('selected',true);
		$("#ModImpuestoProd option[id='"+optImpuesto+"']").prop('selected',true);

	});

	$('tr td i#eli').click(function(){
		$('#modalEliminar').modal('show');
			
		$('#EliCodigoProd').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#EliNombreProd').val($(this).closest("tr").find('td:nth-child(2)').text());
	});

});

</script>

<!-- Definición de estilos CSS especificos para la página -->
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

.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
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
.direccionesbuffer{
        height:260px;
}

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

}
.tablaProd{
	padding: 0 0 0 0;
	margin: 20px 30px 20px 30px;	
}

.tabladatos{
	overflow-x:auto;
	overflow-y:auto;
	height: 500px;
}

</style>


<!--Breadcrumbs o migajas para indicar al usuario dónde se encuentra en la página-->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
    <li class="breadcrumb-item active">Panel de Productos</li>
</ol>

<h2 style="text-align: center;">Productos Meche's Ferments</h2>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 " style="text-align:center;">
	<button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">Agregar Producto&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">free_breakfast</i></button>
	</div>
</div>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>

<!--Tabla para mostrar todos los productos disponibles en el sistema-->
<div class="row no-gutters direccionesbuffer tabladatos">
	<div class="col-sm-12 ">
		<div class="tablaProd" id="listaProductos">

			<table class="table table-striped table-bordered" id="tab_prod">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th hidden >Detalle</th>
						<th>Categoría</th>
						<th>Precio</th>
						<th>Descuento</th>
						<th>Inventario</th>
						<th>Capacidad</th>
						<th>Estado</th>				
						<th>Impuesto Venta</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<!--foreach para llenar la tabla con la info de productos en el sistema-->
					<?php foreach ($listaProductos as $productos_item) : ?>
						<tr>
							<td><?php echo $productos_item->CODIGO; ?></td>
							<td><?php echo $productos_item->NOMBRE; ?></td>
							<td><?php echo $productos_item->DESCRIPCION; ?></td>
							<td hidden><?php echo $productos_item->DETALLES; ?></td>
							<td><?php echo $productos_item->CATEGORIA; ?></td>
							<td>₡<?php echo $productos_item->PRECIO; ?></td>
							<td><?php echo $productos_item->PORCENTAJEDESCUENTO; ?> %</td>
							<td><?php echo $productos_item->STOCK; ?></td>
							<td><?php echo $productos_item->CAPACIDAD; ?> ml</td>
							<td><?php echo $productos_item->ESTADO; ?></td>
							<td><?php echo $productos_item->IV; ?></td>
							<td><i id="mod" class="fa fa-edit" style="font-size:20px;" data-toggle="tooltipMod" title="Modificar"></i>
							&nbsp; &nbsp; &nbsp; 
							<i id="eli" class="fa fa-trash-o" style="font-size:20px;" data-toggle="tooltipEli" title="Eliminar"></i></td>			
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!--scripts externos y referencias de estilos para formato de la página y las tablas-->
<script src="https://www.mechesferments.com/scripts/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!--scripts JS para ordenamiento y formato de los datos en las tablas-->
<script type="text/javascript">
    $(function () {
            $('#tab_prod').dataTable();
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
						<h4 class="modal-title">Agregar Producto</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">

					        <!-- Formulario para agregar un nuevo producto-->
							<?php echo form_open('Ctrl_producto/met_agregarProd'); ?>
												
								<div class="form-group">
								  <label for="AgrCodigoProd">Código:</label><?php echo form_error('AgrCodigoProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="AgrCodigoProd" value="<?php echo set_value('AgrCodigoProd'); ?>" placeholder="Ingrese un código de Producto" name="AgrCodigoProd">
								</div>

								<div class="form-group">
								  <label for="AgrNombreProd">Nombre:</label><?php echo form_error('AgrNombreProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="AgrNombreProd" value="<?php echo set_value('AgrNombreProd'); ?>" placeholder="Ingrese un nombre de Producto" name="AgrNombreProd">
								</div>
						
								<div class="form-group">
								  <label for="AgrDescripProd">Descripción:</label><?php echo form_error('AgrDescripProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="AgrDescripProd" value="<?php echo set_value('AgrDescripProd'); ?>" placeholder="Ingrese una descripción del Producto" name="AgrDescripProd">
								</div>

								<div class="form-group">
								  <label for="AgrDetalleProd">Detalle:</label><?php echo form_error('AgrDetalleProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <textarea class="form-control" id="AgrDetalleProd" name="AgrDetalleProd" rows="10" cols="50" maxlength="2500"placeholder="Ingrese un detalle del Producto" value="<?php echo set_value('CKEDITOR.instances.AgrDetalleProd.setData(data.AgrDetalleProd)'); ?>"></textarea>
						    <script>
                               CKEDITOR.replace( 'AgrDetalleProd' );
                            </script> 
								</div>

								<div class="form-group">
								  <label for="AgrCategoriaProd">Categoría:</label>
									<select class="form-control" name="AgrCategoriaProd" id="AgrCategoriaProd">
									<?php foreach($listaCategorias as $categorias_item) : ?>
										<option value="<?php echo $categorias_item->ID; ?>"><?php echo $categorias_item->NOMBRE ?> </option>
									<?php endforeach; ?>
									</select>
								</div>
						
								<div class="form-group">
								  <label for="AgrPrecioProd">Precio:</label><?php echo form_error('AgrPrecioProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="AgrPrecioProd" value="<?php echo set_value('AgrPrecioProd'); ?>" placeholder="Ingrese el precio del Producto" name="AgrPrecioProd">
								</div>

								<div class="form-group">
								  <label for="AgrDescuenProd">% Descuento:</label><?php echo form_error('AgrDescuenProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="AgrDescuenProd" value="<?php echo set_value('AgrDescuenProd'); ?>" placeholder="Ingrese el % de descuento del Producto" name="AgrDescuenProd">
								</div>

								<div class="form-group">
								  <label for="AgrInventProd">Inventario:</label><?php echo form_error('AgrInventProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="AgrInventProd" value="<?php echo set_value('AgrInventProd'); ?>" placeholder="Ingrese la cantidad del Producto" name="AgrInventProd">
								</div>

								<div class="form-group">
								  <label for="AgrCapacidadProd">Capacidad:</label>
									<select class="form-control" name="AgrCapacidadProd" id="AgrCapacidadProd">
									<?php foreach($listaCapacidades as $capacidades_item) : ?>
										<option value="<?php echo $capacidades_item->idCAPACIDADES; ?>"><?php echo $capacidades_item->CAPACIDAD ?> ml</option>
									<?php endforeach; ?>
									</select>
								</div>

								<div class="form-group">
								  <label for="AgrEstadoProd">Estado:</label>
									<select class="form-control" name="AgrEstadoProd" id="AgrEstadoProd">
									<?php foreach($listaEstados as $estados_item) : ?>
										<option value="<?php echo $estados_item->ID_ESTADO_PRODUCTO; ?>"><?php echo $estados_item->TIPO ?> </option>
									<?php endforeach; ?>
									</select>
								</div>

								<div class="form-group">
								  <label for="AgrImpuestoProd">Impuesto:</label>
									<select class="form-control" name="AgrImpuestoProd" id="AgrImpuestoProd">
									<?php foreach($listaImpuestos as $impuestos_item) : ?>
										<option value="<?php echo $impuestos_item->ID_ESTADO_IV; ?>"><?php echo $impuestos_item->TIPO ?> </option>
									<?php endforeach; ?>
									</select>
								</div>

						</div>			

						<div class="modal-footer">
							<div class="text-center">
							<!--Botón para agregar un nuevo producto-->	
							<input type="submit" id="botonAgregar" class="btn btn-primary" value="Agregar Producto"/>
							<!--Botón para cerrar el modal sin agregar el producto-->	
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
							</form>
						</div> 							

					</div> 
				</div> 
			</div>

			<!--DIV para MODAL de modificar   -->
			<div id="modalModificar" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Modificar Producto</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					         
					         
							 <!-- Formulario para modificar un producto existente-->
							 <?php echo form_open('Ctrl_producto/met_modificarProd'); ?>
							
						
								<div class="form-group">
								  <label for="ModCodigoProd">Código:</label><?php echo form_error('ModCodigoProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="ModCodigoProd" value="<?php echo set_value('ModCodigoProd'); ?>" name="ModCodigoProd" readonly>
								</div>
							
								<div class="form-group">
								  <label for="ModNombreProd">Nombre:</label><?php echo form_error('ModNombreProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="ModNombreProd" value="<?php echo set_value('ModNombreProd'); ?>" name="ModNombreProd">
								</div>

								<div class="form-group">
								  <label for="ModDescripProd">Descripción:</label><?php echo form_error('ModDescripProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="ModDescripProd" value="<?php echo set_value('ModDescripProd'); ?>" name="ModDescripProd">
								</div>

								<div class="form-group">
								  <label for="ModDetalleProd">Detalle:</label><?php echo form_error('ModDetalleProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <textarea class="form-control" id="ModDetalleProd" name="ModDetalleProd" rows="10" cols="50" maxlength="2500"placeholder="Ingrese un detalle del Producto" value="<?php echo set_value('CKEDITOR.instances.ModDetalleProd.setData(data.ModDetalleProd)'); ?>"></textarea>
								 								
							<script>
                               CKEDITOR.replace( 'ModDetalleProd' );
                            </script> 
								</div>

								<div class="form-group">
								  <label for="ModCategoriaProd">Categoría:</label>
									<select class="form-control" name="ModCategoriaProd" id="ModCategoriaProd">
									<?php foreach($listaCategorias as $categorias_item) : ?>
										<option id = "<?php echo $categorias_item->NOMBRE; ?>" value="<?php echo $categorias_item->ID; ?>"><?php echo $categorias_item->NOMBRE ?></option>
									<?php endforeach; ?>
									</select>
								</div>
						
								<div class="form-group">
								  <label for="ModPrecioProd">Precio:</label><?php echo form_error('ModPrecioProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="ModPrecioProd" value="<?php echo set_value('ModPrecioProd'); ?>" name="ModPrecioProd">
								</div>
						
								<div class="form-group">
								  <label for="ModDescuenProd">Descuento:</label><?php echo form_error('ModDescuenProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="ModDescuenProd" value="<?php echo set_value('ModDescuenProd'); ?>" name="ModDescuenProd">
								</div>
								
								<div class="form-group">
								  <label for="ModInventProd">Inventario:</label><?php echo form_error('ModInventProd','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="ModInventProd" value="<?php echo set_value('ModInventProd'); ?>" name="ModInventProd">
								</div>

								<div class="form-group">
								  <label for="ModCapacidadProd">Capacidad:</label>
									<select class="form-control" name="ModCapacidadProd" id="ModCapacidadProd">
									<?php foreach($listaCapacidades as $capacidades_item) : ?>
										<option id = "<?php echo $capacidades_item->CAPACIDAD; ?>" value="<?php echo $capacidades_item->idCAPACIDADES; ?>"><?php echo $capacidades_item->CAPACIDAD ?> ml</option>
									<?php endforeach; ?>
									</select>
								</div>

								<div class="form-group">
								  <label for="ModEstadoProd">Estado:</label>
									<select class="form-control" name="ModEstadoProd" id="ModEstadoProd">
									<?php foreach($listaEstados as $estados_item) : ?>
										<option id = "<?php echo $estados_item->TIPO; ?>" value="<?php echo $estados_item->ID_ESTADO_PRODUCTO; ?>"><?php echo $estados_item->TIPO ?></option>
									<?php endforeach; ?>
									</select>
								</div>

								<div class="form-group">
								  <label for="ModImpuestoProd">Estado:</label>
									<select class="form-control" name="ModImpuestoProd" id="ModImpuestoProd">
									<?php foreach($listaImpuestos as $impuestos_item) : ?>
										<option id = "<?php echo $impuestos_item->TIPO; ?>" value="<?php echo $impuestos_item->ID_ESTADO_IV; ?>"><?php echo $impuestos_item->TIPO ?></option>
									<?php endforeach; ?>
									</select>
								</div>
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							<!--Botón para modificar un producto existente-->	
							<input type="submit" id="botonModificar" class="btn btn-primary" value="Modificar Producto"/>
							<!--Botón para cerrar el modal sin modificar el producto-->	
							<button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
							</div>
							</form>
						</div> 
					
					</div> 
				</div> 
			</div> 	



			<!--DIV para MODAL de eliminar   -->
			<div id="modalEliminar" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">¿Desea eliminar este Producto?</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							 <!-- Formulario para eliminar un producto existente-->
							 <?php echo form_open('Ctrl_producto/met_eliminarProd'); ?>
						
								<div class="form-group">
								  <label for="EliCodigoProd">Codigo:</label><?php echo form_error('id','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" value= "" class="form-control" id="EliCodigoProd" name="EliCodigoProd" readonly>
								</div>
							
								<div class="form-group">
								  <label for="EliNombreProd">Nombre:</label><?php echo form_error('referencia','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" value= "" class="form-control" id="EliNombreProd" name="EliNombreProd" readonly>
								</div>

						</div>			
								
						<div class="modal-footer">
							<div class="text-center">
							
							<!--Botón para eliminar un producto existente-->
							<input type="submit" id="botonEliminar" class="btn btn-primary" value="Eliminar Producto"/>
							<!--Botón para cerrar el modal sin eliminar el producto-->	
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
							</form>
						</div> 
					
					</div> 
				</div> 
			</div>	


			<!--DIV MODAL Prod Agregado   -->
			<div id="modalProdAgregado" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Producto Agregado Correctamente!</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body">
							<img src="<?php echo base_url();?>images/modalok.JPG" class="center" alt="logoOk" width="240" height="150">
						</div>			

						<div class="modal-footer">
							<div class="text-center">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
							</div>
						</div> 

					</div> 
				</div> 
			</div>


			<!--DIV MODAL Prod Modificado   -->
			<div id="modalProdModificado" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="modalmodificartxt"></h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body">
							<img id="modalmodificarimg" src="" class="center" alt="logo" width="240" height="150">
						</div>			

						<div class="modal-footer">
							<div class="text-center">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
							</div>
						</div> 

					</div> 
				</div> 
			</div>


			<!--DIV MODAL Prod Eliminado   -->
			<div id="modalProdEliminado" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title" id="modaleliminartxt" ></h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body">
							<img id="modaleliminarimg" src="" class="center" alt="logo" width="240" height="150">
						</div>			

						<div class="modal-footer">
							<div class="text-center">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
							</div>
						</div> 

					</div> 
				</div> 
			</div>


		</div>    	 <!--close tag for <div class="col-sm-4 " > -->

</div>