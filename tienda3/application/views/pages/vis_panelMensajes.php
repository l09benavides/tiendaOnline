<?php
//************************************************************************************
// Esta pagina sirve para mostrarle al administrador todos los mensajes que han escrito
//los usuarios del sistema. Tiene la posibilidad de Marcar los mensajes como leidos
//Autor: Diego Carrillo
//Fecha de creación: 08/08/2018
//Lista modificaciones
//20/09/2018 Luis Benavides
//Cambio en los parámetros del método XXX
//**************************************************************************************

defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
$(document).ready(function () {
	//Cuando se selecciona un mensaje se carga la informacion en un div
	$('tr td a').click(function(){
		$('div.mensInd').html($(this).closest("tr").find('td:nth-child(6)').text());

	});
	//Cuando se selecciona Mostrar todos los mensajes se carga la informacion en un div
	$('tr td i#modTodos').click(function(){
		$('div.mensInd').html($(this).closest("tr").find('td:nth-child(6)').text());
		$('#modalMensajeTodos').modal('show');
	});
	
	//Cuando se selecciona el checkbox, se ejecuta un ajax que llama una funcion del controlador
	//para marcar el mensjae como leido
	$(':checkbox').click(function(e){
        	e.preventDefault();
            var cedulaJSON = $(this).closest("tr").find('td:nth-child(1)').text();
			$(this).closest("tr").hide();
            $.ajax({
					type: "POST",
					url: '<?php echo site_url();?>/Ctrl_panelMensajes/met_marcarLeido', 
					data: {'cedulaJSON': cedulaJSON},
					dataType: "json",  

					success: 
					function(result){
						if(result){
							alert("Mensaje marcado como léido.");						
						}else{
							alert("Error al cambiar estado de mensaje.");
						}

					}
                
              });
         


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


.mechesheader{
        height: 80px;
}
.imagebuffer{
        height:20px;
}
.direccionesbuffer{
        height:225px;
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
#verificador{
	text-align:center;
  display: none;
}
.direcusuar{
	padding: 0 0 0 0;
	margin: 20px 30px 20px 30px;
	
}
.infoReqEscondida{
	display:none;
}

#botNoLeidos{
  display: none;
}
.modal {
  display: none;
}
</style>

<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
		<li class="breadcrumb-item active">Panel de Mensajes</li>
</ol>

<div class="container-fluid">

	<h2 style="text-align: center;">Mensajes recibidos con el formulario</h2>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 " style="text-align:center;">
			<!--<button type="button" data-toggle="modal" data-target="#modalTodos" class="btn btn-primary" >Mostrar Todos&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">add_location</i></button>-->
			<a href="#modalTodos" data-toggle="modal">Mostrar Todos&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">add_location</i></a>
		</div>
	</div>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>
	
	<div class="row no-gutters direccionesbuffer">
		<div class="col-sm-12 ">
		
			<div class="direcusuar" id="listaDirecciones">
				<table class="table table-striped table-bordered" id="direcciones">
				<thead>
				<tr>
				<th class="infoReqEscondida">ID</th>
				<th>Tiempo</th>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Teléfono</th>
				<th class="infoReqEscondida">Mensaje</th>
				<th>Mensaje</th>
				<th>Acciones</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($queryMensajes as $mensaje_item): ?>

				<tr>
				<td class="idMenData infoReqEscondida"><?php echo $mensaje_item['MENSID']; ?></td>
				<td class="timpoData"><?php echo $mensaje_item['TIEMPO']; ?></td>
				<td class="nombreapellidoData"><?php echo $mensaje_item['NOMBREAPELLIDO']; ?></td>
				<td class="correoData"><?php echo $mensaje_item['COR']; ?></td>
				<td class="telefonoData"><?php echo $mensaje_item['TEL']; ?></td>
				<td class="mensajeData infoReqEscondida"><?php echo $mensaje_item['MEN']; ?></td>
				<td class="mensajeTestData" style="vertical-align:middle;text-align:center;">
					<!--<i id="mod" class="fa fa-comment-o" style="font-size:20px;" data-toggle="tooltipMod" title="Ver Mensaje"></i>-->
					<a href="#modalMensaje" data-toggle="modal"><i  class="fa fa-comment-o" style="font-size:20px;" data-toggle="tooltipMod" title="Ver Mensaje"></i></a>
					
					
					<div id="modalMensaje" class="modal fade" role="dialog">
						<div class="modal-dialog">

						<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
								<h4 class="modal-title">Contenido del mensaje</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body mensInd">
							
									
								
								</div>			
									
								<div class="modal-footer">
									<div class="text-center">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									</div>
								</div> 
							
							</div> 
							
						</div> 
					</div>
				</td>
				<td style="vertical-align:middle;text-align:center;">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input" value="">Marcar como leído
					</label>
				</td>
				</tr>
						
				<?php endforeach; ?>
				
				</tbody>
			    </table>



			</div>
		
		</div>
	</div>

	<div class="row no-gutters direccionesbuffer">
		
			<!--DIV para MODAL de mostrar todos los mensajes   -->
			<div id="modalTodos" class="modal fade" role="dialog" >
				<div class="modal-dialog modal-lg" >

				<!-- Modal content-->
					<div class="modal-content" style="width:800px;">
						<div class="modal-header">
						<h4 class="modal-title">Todos los mensajes</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						
						</div>
						<div class="modal-body">
		
							<div class="direcusuar" id="listaMensajesTodos">
								<table class="table table-striped table-bordered" id="mensajesTodos">
								<thead>
								<tr>
								<th class="infoReqEscondida">ID</th>
								<th>Tiempo</th>
								<th>Nombre</th>
								<th>Correo</th>
								<th>Teléfono</th>
								<th class="infoReqEscondida">Mensaje</th>
								<th>Mensaje</th>
								
								</tr>
								</thead>
								<tbody>
								<?php foreach ($queryMensajesTodos as $mensajeTodos_item): ?>

								<tr>
								<td class="idMenData infoReqEscondida"><?php echo $mensajeTodos_item['MENSID']; ?></td>
								<td class="timpoData"><?php echo $mensajeTodos_item['TIEMPO']; ?></td>
								<td class="nombreapellidoData"><?php echo $mensajeTodos_item['NOMBREAPELLIDO']; ?></td>
								<td class="correoData"><?php echo $mensajeTodos_item['COR']; ?></td>
								<td class="telefonoData"><?php echo $mensajeTodos_item['TEL']; ?></td>
								<td class="mensajeData infoReqEscondida"><?php echo $mensajeTodos_item['MEN']; ?></td>
								<td class="mensajeTestData" style="vertical-align:middle;text-align:center;">
									<!--<i id="modTodos" class="fa fa-comment-o" style="font-size:20px;" data-toggle="tooltipMod" title="Ver Mensaje"></i>-->
									<a href="#modalMensajeTodos" data-toggle="modal"><i  class="fa fa-comment-o" style="font-size:20px;" data-toggle="tooltipMod" title="Ver Mensaje"></i></a>
									
									
								</td>
								
								</tr>
										
								<?php endforeach; ?>
								
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

	<script src="https://www.mechesferments.com/scripts/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

	<script type="text/javascript">
	$(function () {
	    $('#direcciones').dataTable();
		$('#mensajesTodos').dataTable();
		

	} );
	</script>

	
	
	<div id="modalMensajeTodos" class="modal fade" role="dialog" tabindex="-1">
		<div class="modal-dialog">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">Contenido del mensaje</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				
				</div>
				<div class="modal-body mensInd">
			
					
				
				</div>			
					
				<div class="modal-footer">
					<div class="text-center">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div> 
			
			</div> 
			
		</div> 
	</div>


	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>


	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

</div>   <!--close tag for <div class="container-fluid"> -->


