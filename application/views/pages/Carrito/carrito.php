<?php
//************************************************
//Vista de productos en el carrito de usuarios, permite modificar las cantidades
//y cambiar la direccion. Cuando el cliente deposita el pago tiene una opcion que 
//permite ingresar la informacion y el carrito se enviara a revision de los 
//administradores. El carrito sera vaciado en el momento de ingresar la informacion
//Autor: Luis Benavides
//Fecha de Creación: 27/05/2018
//Lista de Modificaciones:
//05/10/2018 Luis Benavides
//Se agrego la documentacion interna necesaria para la correcta descripcion de funciones.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<script>

	modalRegistroValid = <?php echo $modalRegistroValid; ?>; //Valor de verdad para la validacion de informacion de pago
	modalConfirmar = <?php echo $modalConfirmar; ?>; //valor de verdad para mostrar confirmacion 
	idTransac = <?php if(isset($idTransac->ID_TRANSACCION)) {echo $idTransac->ID_TRANSACCION;} else  {echo 0;} ?>; //Numero de transaccion para cargar la direccion.

$(document).ready(function () {
	//Error de Validacion en los datos del Banco
	if(modalRegistroValid==0){
		$('#modalRegistroPago').modal('show');
	}
	//Mensaje de datos Correctos
	if(modalConfirmar==1){
		$("#modalConfirmaciontxt").html("Ha realizado el pedido correctamente. <br>Su número de transacción es: "+idTransac+" <br> Su pedido se encuentra en proceso de autorización. <br> Será notificado en cuanto sea procesado. <br> Muchas gracias!");
		$("#modalConfirmacionimg").attr({src:"<?php echo base_url();?>images/ok.gif",style:"text-align:center"});
		$('#modalConfirmacion').modal('show');
	}


	//Si tenemos datos cargamos las direcciones
	if(idTransac > 0){
		CargarDireccones($('#idDetalles'));
	}
	
	//Actualizamos la direccion si se cambia
  	$('#idDetalles').change(function(){
		var idDireccion = $(this).find('option:selected').attr('value') ;
		var param = {
					idTrans: idTransac,
					idDir:idDireccion
					};
		$.ajax({
		            type: "POST",
		            dataType: "JSON",
		            data: param ,
		            url: '<?php echo site_url('Ctrl_Carrito/ajax_actualizarDirCarrito/');?>', 
		            success: function (data) {
		            	$("#modalConfirmaciontxt").html("Direccion Actualidad correctamente");
						$("#modalConfirmacionimg").attr({src:"<?php echo base_url();?>images/ok.gif",style:"text-align:center"});
						$('#modalConfirmacion').modal('show');	
		                Console.log(data);
		            },
		            error: function(error){
		            	console.log(error);
		            }
		        })

	});

	//Actualizar el carrito si la cantida cambia
	$('.input-sm').on("click keyup keydown",function(){
		var idProd = $(this).attr('id');
		var param = {
			idProd: $('#idprod-'+idProd).val(),
			idTrans: $('#idTrans-'+idProd).val(),
			nuevaCant : $(this).val()
		}
		$.ajax({
		            type: "POST",
		            dataType: "JSON",
		            data: param ,
		            url: '<?php echo site_url('Ctrl_Carrito/ajax_actualizarCantCarrito/');?>',
		            success: function (data) {	
		                Console.log(data);
		                
		            },
		            error: function(error){
		            	console.log(error);
		            }
		        });
		refrescarPagina();

	});
	

});

function refrescarPagina() {
    location.reload(true);
}


//cargar direcciones del cliente

var Direccones = []
//Obtener las direcciones de la base de datos
function CargarDireccones(element) {
    if (Direccones.length == 0) {
        //ajax para obtener la informacion
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: '<?php echo site_url('Ctrl_Carrito/ajax_direcciones/'); if(isset($infoId)){echo $infoId;} ?>',
            success: function (data) {
                Direccones = data;
                //crearLista
                crearLista(element);
            },
            error: function(error){
            	console.log(error);
            }
        })
    }
    else {
        //crear los elementos de las direcciones disponiles
        crearLista(element);
    }
}

function crearLista(element) {
    var $ele = $(element);
    var cant = 0;
    //si el usuario no tiene direccion se muestra el modal para que cree una
    if(Direccones.length == 0){
    	$ele.html('<a href="<?php echo base_url(); ?>.checkAddress" data-target="#agregarDireccions" data-toggle="modal">Agregar Direccion</a>')
    }else{
    	$ele.empty();
    	$.each(Direccones, function (i, val) {
    		if(val.DIRECCIONID==$('#idDir').val()){
				$ele.append($('<option/>').val(val.DIRECCIONID).text(val.LOCA).attr('selected',true));
    		}else{
    			$ele.append($('<option/>').val(val.DIRECCIONID).text(val.LOCA));
    		}
       	 	
    	})
    }
    
  }




</script>



<?php 
//Pagina a mostrar si no hay datos para el carrito y no hay usuario logeado
if (!isset($detalles) && (!isset($infoUser) || $infoUser == null)){ 
	?>
	
<style type="text/css">
	.footer-distributed{
		position: absolute;
	}
</style> 
<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="home">Inicio</a></li>
		<li class="breadcrumb-item active">Carrito</li>
	</ol>
<div class="container">
	
	<br>
	<h2>Estimado Invitado,</h2>
	<br>
	<br>
	<h2>Por favor <a href="<?php echo base_url(); ?>.userAccess"> ingresa al sitio </a> o <a href= "<?php echo base_url(); ?>.userRegistration"> crea una nueva cuenta</a> para utilizar el carrito</h2>
	<br>
	<br>
</div>

<?php
//Pagina a mostrar si no hay datos para el carrito y el usuario esta logeado

 } else if (!isset($detalles) && $infoUser != null || $detalles == null) { ?>
	<style type="text/css">
	.footer-distributed{
		position: absolute;
	}
</style>

<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="productosUsuarios">Productos</a></li>
		<li class="breadcrumb-item active">Carrito</li>
	</ol>
<div class="container">
	
	<br>
	<h1>Hola <?php echo $infoUser ;?>  no tienes ningun producto en tu carrito</h1>
	<br>
	<br>
</div>

<?php 
//Pagina a mostrar si existe informacion para el carrito
} else { ?>
<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="productosUsuarios">Productos</a></li>
		<li class="breadcrumb-item active">Carrito</li>
	</ol>
<div class="container">
	
	<br>
	<h1>Hola <?php echo $infoUser ;?> tienes <?php echo $carrito;?> productos en tu carrito</h1>
	<br>
	<br>
	<div class="row">
		
	
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-3"><b>Nombre Del Producto</b></div>
			<div class="col-sm-2"><b>Precio</b></div>
			<div class="col-sm-2"><b>Descuento</b></div>
			<div class="col-sm-1"><b>Cantidad</b></div>
			<div class="col-sm-1"><b>Subtotal</b></div>
		</div>

		<?php 
		$subtotal=0;
		$total=0;
		setlocale(LC_MONETARY, 'en_US');
		foreach ($detalles as $producto): ?>
			<div class="row">
				<input type="hidden" name="idDir" id="idDir" value="<?php echo $producto->ID_DIRECCION;?>">
				<div class="col-sm-2" style="text-align:center">
					<!--<img src="<?php echo base_url().$producto->imagen;?>" alt="<?php echo $producto->Nombre_producto;?>" width="50" height="50">-->
					   <?php $count=0;foreach ($productosImagenes as $imgpro_item) : ?>
                                  <?php if($imgpro_item['PROID']===$producto->ID){
                                  	$count=$count+1;
                                  	if($count==1){
                                  	?>
                                    <!--Imagen del producto-->

                                      <img src="<?php echo $imgpro_item['RUTA']; ?>" alt="<?php echo $producto->Nombre_producto; ?>"  width="60" height="60" class="card-img-top">

                                    
                                  <?php  }
                              		}?>
                                <?php endforeach; if($count==0){?>
                                  <!--Imagen por Defecto-->
                                  <div class="carousel-item">
                                    <img src="<?php echo base_url();?>images/1.png" alt="Kombucha" style="height:300px;" class="card-img-top">
                                  </div>
                                <?php }?>

				</div>
				<div class="col-sm-3"><?php echo $producto->Nombre_producto;?></div>
				<div class="col-sm-2"><?php echo number_format($producto->precio, 2, '.', ',');?></div>
				<div class="col-sm-2"><?php echo number_format($producto->DESCUENTO, 2, '.', ',');?></div>
				<div class="col-sm-1"><input type="number" width="100" min="1" max="99" value="<?php echo $producto->CANTIDAD;?>" class="input-sm form-control" id='<?php echo $producto->ID;?>'></input></div>
				<div class="col-sm-1" style="text-align:right;"><?php echo number_format($producto->subtotal, 2, '.', ',');?></div>
				<div class="col-sm-1" style="text-align:right;">
					<?php echo form_open("Ctrl_Carrito/met_BorrarCarrito");?>
					<input type="hidden" name="idprod" id="idprod-<?php echo $producto->ID;?>" value="<?php echo $producto->ID;?>">
					<input type="hidden" name="idTrans" id="idTrans-<?php echo $producto->ID;?>" value="<?php echo $producto->ID_TRANSACCION;?>">

				    <button class="btn btn-light"><i class="fa fa-times"></i></button>
					<?php echo form_close();?>
				</div>
			</div>
		<?php 
		$subtotal+=$producto->subtotal;
		$total+=$producto->TOTAL_PRODUCTO;
		endforeach; ?>
		
		

		<div class="row">
				<div class="col-sm-9" style="text-align:right; "></div>
				<div class="col-sm-3" style="text-align:right; "><hr></div>
			</div>
			<div class="row">
				<div class="col-sm-8" style="text-align:right; ">Subtotal</div>
				<div class="col-sm-4" style="text-align:right; "><?php echo number_format($subtotal, 2, '.', ',');?></div>
			</div>
			<div class="row">
				<div class="col-sm-8" style="text-align:right; ">Impuestos</div>
				<div class="col-sm-4" style="text-align:right; "><?php echo number_format($subtotal*0.13, 2, '.', ',');?></div>
			</div>
			<div class="row">
				<div class="col-sm-8" style="text-align:right; ">Total</div>
				<div class="col-sm-4" style="text-align:right; "><?php echo number_format($total, 2, '.', ',');?></div>
			</div>
				<div class="row no-gutters imagebuffer">
			<div class="col-sm-12 "></div>
			</div>
			<div class="row">
				<div class="col-sm-8"></div>
				<div class="col-sm-2">
					<button class="btn btn-primary" data-toggle="modal" data-target="#modalRegistroPago">Registrar Pago</button>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
		<div class="col-sm-2">
			<label>La Direccion Seleccionada: </label>
			<select id="idDetalles">
				
			</select>
		</div>
</div>


  <div class="row no-gutters imagebuffer">
        <div class="col-sm-12 "></div>
  </div>


<!-- seccion de modales -->

<div class="row no-gutters">
    
	<div class="col-sm-4"></div>
			
	    <div class="col-sm-4 " id="idForm">

		
			<!--DIV para MODAL Registro Pago  -->
			<div id="modalRegistroPago" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Indicar Transferencia y Confirmar Pedido</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_Carrito/met_ConfirmarCarrito'); ?>
						
								<div class="form-group">
									<input type="hidden" name="idTrans" value="<?php echo $producto->ID_TRANSACCION;?>">
								    <label for="SelectBanco">Indicar el banco para la transferencia:</label>
									<select class="form-control" name="SelectBanco" id="SelectBanco">
									<?php foreach($bancos as $bancos_item) : ?>
										<option value="<?php echo $bancos_item->ID_BANCO; ?>"><?php echo $bancos_item->NOMBRE_BANCO ?> </option>
									<?php endforeach; ?>
									</select>
								</div> 
							    <div class="form-group">
								  <label for="SelectCodigo">Indicar el código de la transferencia:</label><?php echo form_error('SelectCodigo','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
								  <input type="text" class="form-control" id="SelectCodigo" value="<?php echo set_value('SelectCodigo'); ?>" placeholder="Ingrese un código de Transferencia" name="SelectCodigo">
								</div>
						</div>			

						<div class="modal-footer">
							<div class="text-center">
							<input type="submit" id="botonConfirmar" class="btn btn-primary" value="Confirmar Pedido"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
							</form>
						</div> 			
					</div>
				</div> 
			</div> 


			<!--DIV MODAL Confirmacion   -->
			<div id="modalConfirmacion" class="modal fade" role="dialog">
				<div class="modal-dialog" style="text-align:center">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header" style="text-align:center">
						<h6 class="modal-title" id="modalConfirmaciontxt"></h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body" style="text-align:center">
							<img id="modalConfirmacionimg" src="" class="center" alt="logo" width="240" height="150">
						</div>			

						<div class="modal-footer">
							<div class="text-center">
							<button type="button" onclick="refrescarPagina()" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
							</div>
						</div> 

					</div> 
				</div> 
			</div>


		</div>
	</div>    	 <!--close tag for <div class="col-sm-4 " > -->
		

</div>
<div class="modal fade text-center" id="agregarDireccions">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>

<?php 
// Cierrre if para cargar diferentes paginas dependiendo de los datos de session.
}?>

