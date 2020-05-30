<?php
//************************************************************************************
//Vista de panel de transacciones para los administradores, permite aprobar o rechazar
//un pedido en proceso, con los criterios del administrador, como espera de recibo de 
//transferencia por ejemplo, o denegar el pedido por inventario o problemas con el cliente.
//Dentro del panel aparecen todos los pedidos en proceso, donde el administrador puede 
//aprobarlos o rechazarlos mediante botones. Se brinda un diálogo de confirmación antes
 //de ejecutar la acción final del proceso.
//Autor: Pablo Hernández
//Fecha de creación: 26/07/2018
//Lista modificaciones
//06/10/2018 Pablo Hernández
//Se agregó la documentación interna necesaria para la correcta descripcion del código.
//*************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--Breadcrumbs o migajas para indicar al usuario dónde se encuentra en la página-->
<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
        <li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
        <li class="breadcrumb-item active">Panel de Transacciones</li>
</ol>

<div class="container-fluid">
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

	<h2 style="text-align: center;">Gestión de Transacciones</h2>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>	
	
	<!--Tabla para mostrar todas las transacciones en proceso en el sistema-->
	<div class="row no-gutters direccionesbuffer">
		<div class="col-sm-12 ">
			<div id="listaAprobaciones">
				<table class="table table-striped table-bordered" id="Transacciones">
					<thead>
						<tr>
							<th>Transaccion</th>
							<th>Cliente</th>
							<th>Cantidad Total de Productos</th>
							<th>Monto Total</th>
							<th>Banco</th>
							<th>Comprobante del Banco</th>
							<th>Detalles</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php //foreach para llenar la tabla con la info de transacciones en proceso o pendientes
						$pendientes = array();
						foreach ($Detalles as $item): ?>
						<tr>
							<?php $pendientes = (array)$item;?>
							<td><?php echo $pendientes['Transaccion']; ?></td>
							<td><?php echo $pendientes['Cliente']; ?></td>
							<td><?php echo $pendientes['Cantidad Total de Productos']; ?></td>
							<td><?php echo $pendientes['Monto Total']; ?></td>
							<td><?php echo $pendientes['Banco']; ?></td>
							<td><?php echo $pendientes['Comprobante del Banco']; ?></td>
							<td style="text-align: center;"><a href="#modalDetalles" data-toggle="modal" class="btn btn-outline-info btn-sm" id="detalles" name="<?php echo $pendientes['Transaccion']; ?>"><i  class="fa fa-info" style="font-size:20px;" data-toggle="tooltipMod" title="Ver Detalles de la Transacción" ></i></a>
							</td>
							<td style="vertical-align:middle;text-align:center;">
								<button class="btn btn-outline-success" id="Aprobar" name="<?php echo $pendientes['Transaccion']; ?>"><i  class="fa fa-check" style="font-size:20px;" data-toggle="tooltipMod" title="Aprobar Transaccion">
								<!--Botón para aprobar la transacción correspondiente de la tabla-->	
								</i> Aprobar</button>   
								<button class="btn btn-outline-danger" id="Rechazar" name="<?php echo $pendientes['Transaccion']; ?>"><i  class="fa fa-times" style="font-size:20px;" data-toggle="tooltipMod" title="Rechazar Transaccion">
								<!--Botón para rechazar la transacción correspondiente de la tabla-->	
								</i> Rechazar</button>
							</td>
						</tr>
								
						<?php endforeach; ?>
						
					</tbody>
			    </table>

			</div>
		
		</div>
	</div>

	<div class="row no-gutters direccionesbuffer">
		<div class="col-sm-12 ">
		
			<!--DIV para MODAL de mostrar todos los mensajes   -->
			<div id="modalDetalles" class="modal fade" role="dialog" >
				<div class="modal-dialog" >

				<!-- Modal content-->  <!--Modal para mostrar la información detallada del pedido-->
					<div class="modal-content" style="width:800px;">
						<div class="modal-header">
						<h4 class="modal-title">Detalles de la Transacción:</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						
						</div>
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-sm">
								<thead>
									<th><b>Nombre Del Producto</b></th>
									<th><b>Precio</b></th>
									<th><b>Descuento</b></th>
									<th><b>Cantidad</b></th>
									<th><b>Subtotal</b></th>
								</thead>
								<tbody  id="ContenidoDetalles">
									<tr>
										<td colspan="5">
											<img src="<?php echo base_url();?>images/load.gif">
										</td>
									</tr>
								</tbody>
								</table>
							</div>
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
						</div> 
					
					</div> 
					
				</div> 
			</div>	
		
		</div>
	</div>



			<div id="confirmacion" class="modal fade" role="dialog" >
				<div class="modal-dialog modal-sm" >

				<!-- Modal content--> <!--Modal para mostrar diálogo de confirmación para aprobar o rechazar pedido-->
					<div class="modal-content" style="width:800px;">
						<div class="modal-header">
						<h4 class="modal-title">Confirmar Transacción</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						
						</div>
						<div class="modal-body">
							<div style="text-align: center;">
								<h3 id="Mensaje"></h3>
								<button class="btn btn-success" id="desicion">Aceptar</button>
								<button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							</div>
					</div> 
					
				</div> 
			</div>	

	<!--scripts externos y referencias de estilos para formato de la página y las tablas-->
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!--scripts JS para ordenamiento y formato de los datos en las tablas-->
<script type="text/javascript">
	$(function () {
	    $('#Transacciones').dataTable({
	    //Definicion de cantidad de registros a mostrar
	    	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
       //Cambio de idioma de la Tabla
	    	 "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },

        "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
                	n = parseFloat(data).toFixed(2)
					var withCommas = Number(n).toLocaleString('en');
                    return '₡ '+ withCommas;
                },
                "targets": 3
            }
        	]
    	});
	});

	//llamar los detalles de cada transacción, de acuerdo a la entrada seleccionada en la tabla
	$('#Transacciones  tr  td a').click(function () {
			var id = $(this).attr('name');
			$('#ContenidoDetalles').empty();
			$('#ContenidoDetalles').append("<tr><td colspan='5'><img src='<?php echo base_url();?>images/load.gif'></td><tr>");
			$.ajax({
	            type: "POST",
	            dataType: "JSON",
	            url: '<?php echo site_url('Ctrl_ConfirmarPago/obtenerDetalles/')?>'+id,
	            success: function (data) {
	                creardetalles(data);
	            },
	            error: function(error){
	            	alert(error);
	            	console.log(JSON.stringify(error))
	            }
        	})
	});

	//cargar los datos en el body del table
	function creardetalles(detalles) {
		$('#ContenidoDetalles').empty();
		var subtotal = 0;
		var descuento = 0;
		var total =0;
		var Impuesto =0;
		$.each(detalles, function(index,value) {
			subtotal = subtotal + parseFloat(value.subtotal);
			descuento = descuento + parseFloat(value.DESCUENTO);
			Impuesto = Impuesto + parseFloat((value.subtotal*0.13));
			total = total + parseFloat(value.TOTAL_PRODUCTO);
					$('#ContenidoDetalles').append("<tr><td>"+value.Nombre_producto+"</td><td>¢ "+Number(parseFloat(value.precio).toFixed(2)).toLocaleString('en')+"</td><td>¢ "+Number(parseFloat(value.DESCUENTO).toFixed(2)).toLocaleString('en')+"</td><td>"+value.CANTIDAD+"</td><td>¢ "+Number(parseFloat(value.subtotal).toFixed(2)).toLocaleString('en')+"</td></tr>");
		});
		$('#ContenidoDetalles').append("<tr><td colspan='3'></td><td colspan='2'><hr/></td></tr>");
		$('#ContenidoDetalles').append("<tr><td colspan='3' style='border:0; boder-top:0'></td><td style='border:0; boder-top:0'><b>Subtotal</b></td><td style='border:0; boder-top:0'>¢ "+Number(parseFloat(subtotal).toFixed(2)).toLocaleString('en')+"</td></tr>");
		$('#ContenidoDetalles').append("<tr><td colspan='3' style='border:0; boder-top:0'></td><td style='border:0; boder-top:0'><b>Descuento</b></td><td style='border:0; boder-top:0'>¢ "+Number(parseFloat(descuento).toFixed(2)).toLocaleString('en')+"</td></tr>");
		$('#ContenidoDetalles').append("<tr><td colspan='3' style='border:0; boder-top:0'></td><td style='border:0; boder-top:0'><b>Impuesto</b></td><td style='border:0; boder-top:0'>¢ "+Number(parseFloat(Impuesto).toFixed(2)).toLocaleString('en')+"</td></tr>");
		$('#ContenidoDetalles').append("<tr><td colspan='3' style='border:0; boder-top:0'></td><td style='border:0; boder-top:0'><b>Total</b></td><td style='border:0; boder-top:0'><b>¢ "+Number(parseFloat(total).toFixed(2)).toLocaleString('en')+"</b></td></tr>");
	}

var accion = null; //indicar la acción con el pedido: aprobar o rechazar
var idTrans = null; // indicar el id de la transacción

	$('#Transacciones  tr  td button').click(function () {
		//alert("Click");
			accion = $(this).attr('id');
			idTrans = $(this).attr('name');
			var mensaje = "¿Está seguro que desea "+accion+" la Transacción?";
			$('#Mensaje').text(mensaje);
			//alert(idTrans);
			$('#confirmacion').modal('show');
	});
	//función para aprobar o rechazar transacción
	$('#desicion').click(function () {
		//alert(idTrans);
			var idAccion;
			var transaccion = idTrans;
		        if(accion == 'Aprobar'){
		        	idAccion = true;
		        }else{
		        	idAccion = false;
		        }
		        var parameter = {
		        	idTrans: transaccion,
		        	id: idAccion
		        }
			        $.ajax({
				            type: "POST",
				            dataType: "JSON",
				            data: parameter,
				            url: '<?php echo site_url('Ctrl_ConfirmarPago/met_DecidirTransaccion')?>',
				            success: function (data) {
				                console.log("data");
				                refrescar();
				                $('#confirmacion').modal('hide');

				            },
				            error: function(error){
				            	console.log(JSON.stringify(error));
				            	refrescar();
				            	$('#confirmacion').modal('hide');
				            }
	        		});
		  });		

// función para refrescar la página luego de realizar los procesos
function refrescar(){
	location.reload(true);
}
</script>

<!--DIVs adicionales para dejar márgenes al final de la pagina y cerrar los DIVs del inicio-->

	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>


	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

</div>   <!--close tag for <div class="container-fluid"> -->


