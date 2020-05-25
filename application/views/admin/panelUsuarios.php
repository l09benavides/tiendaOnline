<?php
//************************************************
//Este módulo sirve para el manejo de usuarios en el sitio, enfocado a creación de administradores (ADMIN)
//Utiliza controller Ctrl_panelUsuarios.php
//
//Autor: Javier Trejos
//Fecha de Creación: 27/06/2018
//Lista de Modificaciones:
//20/07/2018 Luis Benavides
//Se agrega estilo de tabla autogenerado por un Javascript
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>

function checkPasswordMatch() { //Cuando se crea un administrador este método valida las cotraseñas del form
    var password = $("#contrasena").val();
    var confirmPassword = $("#contrasenaver").val();

   if (password != confirmPassword){
    $("#spanCheckPasswordMatch").html("¡Contraseñas distintas!");
    document.getElementById("spanCheckPasswordMatch").style["color"] = "red";
  }else{
    $("#spanCheckPasswordMatch").html("¡Contraseñas iguales!");
    document.getElementById("spanCheckPasswordMatch").style["color"] = "green";
  }

}

varCV = <?php echo $verificador;  ?>;
// variable para mostrar error si no hay datos para mostrar
varMo = <?php echo $modalValid;  ?>;
// variable para mostrar el modal de modificación y recargarlo si hubieron errores
varAg = <?php echo $modalAgregValid;  ?>;
// variable para mostrar el modal de agregar y recargarlo si hubieron errores
verRol = <?php echo $verificadorRol ?>;
// variable para mostrar el modal para confirmar el cambio de rol
rolAV = <?php echo $rolAV ?>;
// variable para validar si el usuario a modificar es actualmente usuario normal o admin
idUC = <?php echo $idUC ?>;
// variable para manejar el id del usuario a modificar.
propioPerf = <?php echo $propioPerfil ?>;
//variable para ver si es el perfil del administrador logeado que se va a modificar

$(document).ready(function () {



	$("#contrasena, #contrasenaver").keyup(checkPasswordMatch);

	//alert(varCV);
	$('[data-toggle="tooltipMod"]').tooltip();
	$('[data-toggle="tooltipEli"]').tooltip();

	if(propioPerf == 1){
		$('#modalValRolPerf').modal('toggle');
		$('#modalValRolPerf').modal('show');
		$('#modalValRolPerf').modal('hide');
		$('#idModValPerf').val(idUC);
		$('#rolModValPerf').val(rolAV);

	}

	if(verRol == 1){
		$('#modalValRol').modal('toggle');
		$('#modalValRol').modal('show');
		$('#modalValRol').modal('hide');
		$('#idModVal').val(idUC);
		$('#rolModVal').val(rolAV);

	}


	
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
	
	<!-- $('i').click(function(){ -->
		
		<!-- $('#modalEliDir').modal('toggle'); -->
		<!-- $('#modalEliDir').modal('show'); -->
		<!-- $('#modalEliDir').modal('hide'); -->

		<!-- $('#idEli').val($(this).find('td:nth-child(1)').text()); -->
		<!-- $('#referenciaEli').val($(this).find('td:nth-child(2)').text()); -->
		
	<!-- }); -->
	
	$('tr td i#mod').click(function(){
		// alert('test');
		$('#modalPass').modal('toggle');
		$('#modalPass').modal('show');
		$('#modalPass').modal('hide');

		$('#id').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#rolact').val($(this).closest("tr").find('td:nth-child(2)').text());
		$('#nombreMod').val($(this).closest("tr").find('td:nth-of-type(3)').text() + 
			" " + $(this).closest("tr").find('td:nth-child(4)').text() +
			" " + $(this).closest("tr").find('td:nth-child(5)').text() );
		$('#correoMod').val($(this).closest("tr").find('td:nth-of-type(7)').text());
	});
	
	$('tr td i#eli').click(function(){

		$('#modalEliDir').modal('toggle');
		$('#modalEliDir').modal('show');
		$('#modalEliDir').modal('hide');
	
		$('#idEli').val($(this).closest("tr").find('td:nth-child(1)').text());
		$('#nombreEli').val($(this).closest("tr").find('td:nth-of-type(3)').text() + 
			" " + $(this).closest("tr").find('td:nth-child(4)').text() +
			" " + $(this).closest("tr").find('td:nth-child(5)').text() );
		$('#correoEli').val($(this).closest("tr").find('td:nth-child(7)').text());
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
.usuariosbuffer{
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
.usuariostabla{
	padding: 0 0 0 0;
	margin: 20px 30px 20px 30px;
}

.tabladatos{
	overflow-x:hidden;
	overflow-y:auto;
	height: 500px;
}

</style>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
    <li class="breadcrumb-item active">Panel de Usuarios</li>
</ol>

<div class="container-fluid">

	<h2 style="text-align: center;">Panel de Roles y Usuarios</h2>
	<!--  boton agregar ahora antes del div usuario tabla
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 " style="text-align:center;">
			<button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">Agregar Usuario&nbsp;&nbsp;<i class="material-icons" style="font-size:15px">person_add</i></button>
		</div>
	</div>
	
	<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div> -->
	
	<div class="row no-gutters usuariosbuffer tabladatos">
		<div class="col-sm-12 ">
			<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 " style="text-align:center;">
			<button type="button" id="botAgregar" data-toggle="modal" data-target="#modalAgregar" class="btn btn-primary" data-backdrop="static">Agregar Administrador&nbsp;&nbsp;<i class="material-icons" style="font-size:20px">person_add</i></button>
			</div>
		</div>

		<div class="usuariostabla" id="verificador"><h6>Error al mostrar usuarios.</h6></div>
			<div class="usuariostabla" id="listaUsuarios">
				<table class="table table-striped table-bordered" id="usuarios">
				<thead>
				<tr>
				<th hidden>ID</th>
				<th>Tipo de Rol</th>
				<th>Nombre</th>
				<th>Primer Apellido</th>
				<th>Segundo Apellido</th>
				<th>Cédula</th>
				<th>Correo</th>
				<th>Teléfono</th>
				<th>Acciones</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($queryUsuarios as $todos_usuarios): ?>
				<tr>
				<td class="idUsuarioData" hidden><?php echo $todos_usuarios['IDUS']; ?></td>
				<td class="tipoData"><?php echo $todos_usuarios['TIPO']; ?></td>
				<td class="nomData"><?php echo $todos_usuarios['NOM']; ?></td>
				<td class="ap1Data"><?php echo $todos_usuarios['AP1']; ?></td>
				<td class="ap2Data"><?php echo $todos_usuarios['AP2']; ?></td>
				<td class="cedData"><?php echo $todos_usuarios['CED']; ?></td>
				<td class="correoData"><?php echo $todos_usuarios['COR']; ?></td>
				<td class="telData"><?php echo $todos_usuarios['TEL']; ?></td>
				<td><i id="mod" class="fa fa-edit" style="font-size:20px;" data-toggle="tooltipMod" title="Modificar Rol"></i>
					&nbsp; &nbsp; &nbsp;
				<i id="eli" class="fa fa-trash-o" style="font-size:20px;" data-toggle="tooltipEli" title="Eliminar Usuario"></i>
			</td>
				</tr>
						
				<?php endforeach; ?>
				
				</tbody>
			    </table>



			</div>
		
		</div>
	</div>


	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>  <!--AGREGAR LINK PABLO-->
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

	<script type="text/javascript">
	$(function () {
	    $('#usuarios').dataTable({
	   //Definicion de cantidad de registros a mostrar
	    	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
       //Cambio de idioma Tabl
	    	 "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        
	    });
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
						<h4 class="modal-title">Agregar Administrador</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_panelUsuarios/met_agregarUsuario'); ?>
						
							<div class="form-group">
							  <label for="nombre">Nombre:</label><?php echo form_error('nombreAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="nombre" value="<?php echo set_value('nombre'); ?>" placeholder="Ingrese Nombre" name="nombre">
							</div>

							<div class="form-group">
						      <label for="apellido_1">Primer apellido:</label><?php echo form_error('apellido_1','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						      <input type="text" class="form-control" id="apellido_1" value="<?php echo set_value('apellido_1'); ?>" placeholder="Ingrese su primer apellido" name="apellido_1">
						    </div>
					
							<div class="form-group">
						      <label for="apellido_2">Segundo apellido:</label><?php echo form_error('apellido_2','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						      <input type="text" class="form-control" id="apellido_2" value="<?php echo set_value('apellido_2'); ?>" placeholder="Ingrese su segundo apellido" name="apellido_2">
						    </div>
					
							    <div class="form-group">
							      <label for="cedula">Cédula:</label><?php echo form_error('cedula','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							      <input type="text" class="form-control" id="cedula" value="<?php echo set_value('cedula'); ?>" placeholder="Ingrese su cédula" name="cedula">
							    </div>

							<div class="form-group">
							      <label for="correo">Correo:</label><?php echo form_error('correo','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							      <input type="email" class="form-control" id="correo" value="<?php echo set_value('correo'); ?>" placeholder="Ingrese su correo electrónico" name="correo">
						    </div>

							<div class="form-group">
							  <label for="telefono">Teléfono:</label><?php echo form_error('telefonoAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  <input type="text" class="form-control" id="telefono" value="<?php echo set_value('telefono'); ?>" placeholder="Ingrese su teléfono" name="telefono">
							</div>

							<div class="form-group">
						      <label for="contrasena">Contraseña:</label><?php echo form_error('contrasena','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						      <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña" name="contrasena">
						    </div>
							
							<div class="form-group">
						      <label for="contrasenaver">Ingrese la contraseña de nuevo: <span style="color:red;" id="spanCheckPasswordMatch"></span></label><?php echo form_error('contrasenaver','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
						      <!-- <span class="alert alert-danger" id="spanCheckPasswordMatch"></span> -->
						      <input type="password" class="form-control" id="contrasenaver" placeholder="Ingrese su contraseña de nuevo" name="contrasenaver" onChange="checkPasswordMatch();">
						    </div>

							<!-- <div class="form-group">
						      <input type="checkbox" name="terminos" value="1" /> Por favor, acepte nuestros <a href="resources/TermsMeches.pdf">Términos y Condiciones</a><br><label for="terminos"></label><?php echo form_error('terminos','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?><br>
						    </div> -->
						
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
						<h4 class="modal-title">Cambiar Rol de Usuario</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_panelUsuarios/met_valRolActual'); ?>

							<div class="form-group" hidden>
							  <label for="id">ID:</label>
							  <input type="text" class="form-control" id="id" value="<?php echo set_value('id'); ?>" placeholder="Identificador de Usuario" name="id" readonly>
							</div>
						
							<div class="form-group">
							  <label for="rolact">Rol Actual:</label>
							  <input type="text" class="form-control" id="rolact" value="<?php echo set_value('rolact'); ?>" placeholder="Identificador de Usuario" name="rolact" readonly>
							</div>
						
							<div class="form-group">
							  <label for="nombre">Nombre Completo:</label>
							  <input type="text" class="form-control" id="nombreMod" value="<?php echo set_value('referencia'); ?>" placeholder="Nombre" name="nombre" readonly>
							</div>

							<div class="form-group">
							  <label for="correo">Correo:</label>
							  <input type="text" class="form-control" id="correoMod" value="<?php echo set_value('correo'); ?>" placeholder="Correo" name="correo" readonly>
							</div>
					
							<div class="form-group">
							  <label for="rol">Nuevo Rol:</label><?php echo form_error('rol','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
							  
							  <select name="rol" class="form-control" id="rol">
							  		<option value=0>Escoga el Tipo de Rol</option>
							  		<?php foreach ($queryRoles as $roles): ?>
					                <option value=<?php echo $roles['ID_ROL']; ?>><?php echo $roles['TIPO']; ?></option>
					                <?php endforeach; ?>
						       </select>
						       
							  

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

			<!--DIV para MODAL de validarRol   -->
			<div id="modalValRol" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Confirmación de Cambio de Rol</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_panelUsuarios/met_editarRol'); ?>

							<div class="form-group" hidden>
							  <label for="idModVal">ID:</label>
							  <input type="text" class="form-control" id="idModVal" value="<?php echo set_value('idModVal'); ?>" placeholder="Identificador de Usuario" name="idModVal" readonly>
							</div>

							<div class="form-group" hidden>
							  <label for="rolModVal">Rol Actual:</label>
							  <input type="text" class="form-control" id="rolModVal" value="<?php echo set_value('rolModVal'); ?>" placeholder="Identificador de Usuario" name="rolModVal" readonly>
							</div>
						
							<div class="form-group">
							  <h6 class="modal-body">Por favor confirme que desea cambiar el tipo de acceso de un Usuario Regular o un Invitado</h3>
							</div>
							
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							
							<input type="submit" id="botonValidarRolPerf" class="btn btn-primary" value="Continuar"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							</div>
							</form>
						</div> 
					
					</div> 
					
				</div> 
			</div> 	

			<!--DIV para MODAL de validarCambioDePropioPerfil   -->
			<div id="modalValRolPerf" class="modal fade" role="dialog">
				<div class="modal-dialog">

				<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title">Confirmación de Cambio en su Perfil</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_panelUsuarios/met_editarRolPerf'); ?>

							<div class="form-group" hidden>
							  <label for="idModValPerf">ID:</label>
							  <input type="text" class="form-control" id="idModValPerf" value="<?php echo set_value('idModValPerf'); ?>" placeholder="Identificador de Usuario" name="idModValPerf" readonly>
							</div>

							<div class="form-group" hidden>
							  <label for="rolModValPerf">Rol Actual:</label>
							  <input type="text" class="form-control" id="rolModValPerf" value="<?php echo set_value('rolModValPerf'); ?>" placeholder="Identificador de Usuario" name="rolModValPerf" readonly>
							</div>
						
							<div class="form-group">
							  <h6 class="modal-body">Por favor confirme que desea cambiar el tipo de acceso de su perfil, por favor tome en consideración que los cambios tomarán efecto cuando vuelva a logearse</h3>
							</div>
							
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							
							<input type="submit" id="botonValidarRol" class="btn btn-primary" value="Continuar"/>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
						<h4 class="modal-title">¿Desea eliminar este Usuario?</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
					
							<?php echo form_open('Ctrl_panelUsuarios/met_elimUsuario'); ?>
						
							<div class="form-group" hidden>
							  <label for="idEli">ID:</label>
							  <input type="text" value= "" class="form-control" id="idEli" name="idEli" readonly>
							</div>
						
							<div class="form-group">
							  <label for="nombreEli">Nombre Completo:</label>
							  <input type="text" value= "" class="form-control" id="nombreEli" name="nombreEli" readonly>
							</div>

							<div class="form-group">
							  <label for="correoEli">Correo:</label>
							  <input type="text" value= "" class="form-control" id="correoEli" name="correoEli" readonly>
							</div>

							
						
						</div>			
							
						<div class="modal-footer">
							<div class="text-center">
							<!--<button type="submit" class="btn btn-primary">Ingresar</button>-->
							<input type="submit" id="botonEliminar" class="btn btn-primary" value="Eliminar Usuario"/>
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