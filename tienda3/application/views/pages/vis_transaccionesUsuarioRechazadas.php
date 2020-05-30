<?php
//************************************************************************************
//Vista de panel de transacciones para los usuarios finales, esta permite ver las 
//transacciones rechazadas por el administrador.
//Dentro del panel aparecen todas las transacciones rechazadas del usuario.  
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

	//función para regresar al panel de transacciones general 
	$('[data-user]').click(function(e){
  	var opcion = $(this).data('user');
    //alert("si response el click");
  	switch(opcion){

  	case "Regresar":
  	window.location = "userTransactions";
  	break;
	}
  }); 
  });

</script>

<!--Breadcrumbs o migajas para indicar al usuario dónde se encuentra en la página-->
<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="userProfile">Perfil de Usuario</a></li>
		<li class="breadcrumb-item"><a href="userTransactions">Mis Transacciones</a></li>
		<li class="breadcrumb-item active">Transacciones Rechazadas</li>
</ol>

<div class="container-fluid">

	<h2 style="text-align: center;">Transacciones Rechazadas</h2>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>
	
	<!--Tabla para mostrar todas las transacciones rechazadas para el usuario-->
	<div class="row no-gutters direccionesbuffer">
		<div class="col-sm-12 ">
			<div id="listaAprobaciones">
				<table class="table table-striped table-bordered" id="Transacciones">
					<thead>
						<tr>
							<th>No. de Transacción</th>
							<th>Fecha y Hora de Transacción</th>
							<th>Cantidad Total de Productos</th>
							<th>Monto Total</th>
							<th>Banco</th>
							<th>No. de Comprobante</th>
							<th>Detalles</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$datosTransac = array();
						foreach ($Detalles as $item): ?>
						<tr>
							<!--foreach para llenar la tabla con la info de transacciones rechazadas en el sistema-->
							<?php $datosTransac = (array)$item;?>
							<td><?php echo $datosTransac['Transaccion']; ?></td>
							<td><?php echo $datosTransac['Fecha'];?> <?php echo $datosTransac['Hora'];?> </td>
							<td><?php echo $datosTransac['Cantidad Total de Productos']; ?></td>
							<td><?php echo $datosTransac['Monto Total']; ?></td>
							<td><?php echo $datosTransac['Banco']; ?></td>
							<td><?php echo $datosTransac['Comprobante del Banco']; ?></td>
							<td style="text-align: center;"><a href="#modalDetalles" data-toggle="modal" class="btn btn-outline-info btn-sm" id="detalles" name="<?php echo $datosTransac['Transaccion']; ?>"><i  class="fa fa-info" style="font-size:20px;" data-toggle="tooltipMod" title="Ver Detalles de la Transacción" ></i></a>
							</td>
						</tr>
						<?php endforeach; ?>
						
					</tbody>
			    </table>

			</div>
		
		</div>
	</div>

	<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
	</div>

	<!--Enlace para regresar al panel general de transacciones-->
	<div style="vertical-align:middle;text-align:center;">
		<button class="btn btn-outline-primary btn-lg btnOpAdm" id="Regresar" data-user="Regresar">Regresar a Transacciones</button> 
	</div>

	<div class="row no-gutters direccionesbuffer">
		<div class="col-sm-12 ">
		
			<!--DIV para MODAL de mostrar todos los detalles de las transacciones-->
			<div id="modalDetalles" class="modal fade" role="dialog" >
				<div class="modal-dialog" >

				<!-- Modal content-->
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

	<!--scripts externos y referencias de estilos para formato de la página y las tablas-->
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

<!--scripts JS para ordenamiento y formato de los datos en las tablas-->
<script type="text/javascript">
	$(function () {
	    $('#Transacciones').dataTable({
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                	n = parseFloat(data).toFixed(2)
					var withCommas = Number(n).toLocaleString('en');
                    return '¢ '+ withCommas;
                },
                "targets": 3
            }
        	]
    	});
	});

	//llamar los detalles de cada transaccion
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


</script>

	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>


	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

</div>   <!--close tag for <div class="container-fluid"> -->


