<?php
//************************************************************************************
//Este módulo corresponde a la vista del panel del adminisrtador donde va a tener acceso
//a las diferentes herramientas que ofrece el sistema.
//Autor: Javier Trejos
//Fecha de creación: 05/08/2018
//Lista modificaciones
//11/10/2018 Luis Benavides
//Dcoumentacion de la vista.
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
$(document).ready(function () {

	//función para redireccionar
	$('[data-user]').click(function(e){

	var opcion = $(this).data('user');
	//alert("si response el click");
	switch(opcion){

	case "panelUsuarios":
	window.location = "rut_panelUsuarios";
	break;
	case "panelProductos":
	window.location = "rut_panelProductos";
	break;
	/* case "panelImagenes":
	window.location = "rut_panelImagenes";
	break; */
		case "panelCategorias":
	window.location = "rut_panelCategorias";
	break;
	/*case "panelTemas":
	window.location = "rut_panelTemas";
	break;*/
	case "panelRecetas":
	window.location = "rut_panelReceta"; 
	break;
	case "panelTransacciones":
	window.location = "rut_panelTransacciones";
	break;
	case "panelBitacora":
	window.location = "rut_panelBitacora";
	break;
	case "panelPromociones":
	window.location = "rut_panelPromociones";
	break;
	case "panelMensajes":
	window.location = "rut_panelMensajes";
	}

	}); 

	//BOTÓN PARA PANEL DE TEMA
	$(".spainer_button").click(function(event){event.preventDefault(); if($(this).hasClass("inOut")){
		$(".demo_panel_box").stop().animate({left:"-215px"},500);
	}else{
		$(".demo_panel_box").stop().animate({left:"0px"},500);
	}
	$(this).toggleClass("inOut");
	return false;
	});  
});
</script>


<style>
  /* Make the image fully responsive */
  .carousel-inner img {
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
.panelbuffer{
	height:500px;
}

.buttonPanel{
      width: 407px;
      height: 300px;
      	display: block;
    	margin-left: auto;
   		margin-right: auto;
   		text-align: center;
      	
	}   
.btnOpAdm{
	text-align: left;
}	



/*PANEL DE TEMAS*/
body{position: relative;}
.demo_panel_box{position: fixed;width: 215px; height: 210px; display: block; top: 180px; left: -215px;
background: #e6e6e6; text-align: center; z-index: 9999;}
.color_panel_box{ margin-top: 10px;
padding: 5px;
text-align: center; }
.color_panel_box span{width: 42px; height: 33px; display: block; margin-left: 20px; border-radius: 50%; float: left;margin-bottom: 33px;}

.color_panel_box img{
    width: 45px;
    height: 42px;
    display: block;
    margin-left: 0px;
    border-radius: 50%;
    float: left;
    margin-bottom: -30px;
}


.spainer_button{width: 50px; height: 85px; background:#5a9ba6; display: block; position: absolute;
right: -50px; top: 0px; font-size: 12px; z-index: 999; text-align: center; color: #FFF; padding-top: 5px; border-radius: 0px 10px 10px 0px; cursor: pointer;}
.opcionTema{
	margin-top: 36px;
}

  </style>



<body>
	<!--AJAX PANEL TEMAS-->
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
var temaEnUso = $('.pruebaAjax').attr('href');
var save_method;

function aplicarTema(){
	$('#modalConfirm').modal('show');
	var cssSelected = $('input[name=temas]:checked').val();

	$('.pruebaAjax').attr("href", "<?php echo base_url().'resources/css/';?>"+cssSelected)
}

function cancelarCambio(){
	$('.pruebaAjax').attr("href", temaEnUso)
}


function save()
{
	var cssSelected = $('input[name=temas]:checked').val();
    $('#btnSave').text('Cambiando Tema...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url = "<?php echo site_url('Ctrl_panelTemas/ajax_update')?>/"+cssSelected;

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: cssSelected,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modalConfirm').modal('hide');
                $('#modalSalida').modal('show');
                
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert("Ocurrió un error al guardar el tema, por favor refresque la página e intente de nuevo");
            $('#btnSave').text('Guardar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }

    });

    
}	
</script>
<!--AJAX PANEL TEMAS-->

	<div id="container-fluid">



    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
      
      <li class="breadcrumb-item active">Administración</li>
  </ol>


<h6 style="text-align: center;">Opciones de administración:</h6>

		<div class="row no-gutters imagebuffer">
			<div class="col-sm-12 "></div>
		</div>
		

		<div class="row no-gutters panelbuffer">
			<div class="col-sm-4 " ></div>
			<div class="col-sm-4 buttonPanel">
				<div class="btn-group-vertical" >
					<button  type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelUsuarios"><i class="fa fa-users"></i>  Panel de Usuarios</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelProductos"><i class="material-icons">store</i>  Panel de Productos</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelCategorias"><i class="material-icons">style</i>  Panel de Categorias</button>
					<div class="btn-group">
						<button type="button" class="btn btn-outline-primary dropdown-toggle btn-lg btnOpAdm" data-toggle="dropdown"><i class="fa fa-image"></i>  Panel de Imágenes
						</button>
						<div class="dropdown-menu">
						<a class="dropdown-item" href="rut_panelImagenesGenerales">Imágenes Generales</a>
						<a class="dropdown-item" href="rut_panelImagenesProductos">Imágenes de Productos</a>
						</div>
					</div>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm"  data-user="panelRecetas"><i class="material-icons">kitchen</i>  Panel de Recetas</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelTransacciones"><i class="material-icons">assessment</i>  Panel de Transacciones</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelBitacora"><i class="material-icons">assignment</i>  Bitácora de Eventos</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelPromociones"><i class="material-icons">assignment</i>  Crear Promoción</button>
					<button type="button" class="btn btn-outline-primary btn-lg btnOpAdm" data-user="panelMensajes"><i class="material-icons">inbox</i>  Revisar Mensajes</button>
				</div>


			</div>
			<div class="col-sm-4 " ></div>

		</div>

		<div class="row no-gutters imagebuffer">
			<div class="col-sm-12 "></div>
		</div>
		<div class="row no-gutters imagebuffer">
			<div class="col-sm-12 "></div>
		</div>

		<!--PANEL DE TEMAS-->
 		<div class="demo_panel_box">
 			<div class="color_panel_box">
 				<div class="spainer_button inOut"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i>Panel de Temas</div>

 				
 				<span><img src="<?php echo base_url().'images/nuevologo2.png';?>"><input type="radio" class="opcionTema" name="temas" value="default.css" checked></span>
 				<span><img src="<?php echo base_url().'images/TemasThumbnails/halloween.png';?>"><input type="radio" class="opcionTema" name="temas" value="halloween.css"></span>
 				<span><img src="<?php echo base_url().'images/TemasThumbnails/navidad.png';?>"><input type="radio" class="opcionTema" name="temas" value="navidad.css"></span>

 				<span><img src="<?php echo base_url().'images/TemasThumbnails/stpatricio.png';?>"><input type="radio" class="opcionTema" name="temas" value="stpatricio.css"></span>
 				<span><img src="<?php echo base_url().'images/TemasThumbnails/15septiembre.png';?>"><input type="radio" class="opcionTema" name="temas" value="15septiembre.css"></span>
 				<span><img src="<?php echo base_url().'images/TemasThumbnails/valentin.png';?>"><input type="radio" class="opcionTema" name="temas" value="sanvalentin.css"></span>

 				<div style="text-align: center; width: 100%;">
 				<button type="button" class="btn btn-primary" style="margin-top: 10px;" onclick="aplicarTema()">Aplicar Tema</button>
 				</div>
 				
 				
 			</div>
 		</div>

 		<!--DIV para MODAL DE CONFIRMACIÓN DE TEMA   -->
      <div id="modalConfirm" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Confirmación de Cambio de Tema</h4>
            <button type="button" class="close" onclick="cancelarCambio()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <p class="modal-body">Por favor, haga click en "Cambiar Tema" para establecer el tema que escogió (que esta de fondo) como el tema actual de la página, o bien puede hacer click en "Cancelar"</p>
            
            </div>      
              
            <div class="modal-footer">
              <div class="text-center">
              <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Cambiar Tema</button>
              <button type="button" class="btn btn-secondary" onclick="cancelarCambio()" data-dismiss="modal">Cancelar</button>
              </div>
              </form>
            </div> 
          
          </div> 
          
        </div> 
      </div>

      <!--DIV para MODAL DE SALIDA DE TEMA   -->
      <div id="modalSalida" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Tema Cambiado</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <p class="modal-body">El Tema seleccionado se aplicó correctamente</p>
            
            </div>      
              
            <div class="modal-footer">
              <div class="text-center">
              <!--<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Cambiar Tema</button>-->
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
              </form>
            </div> 
          
          </div> 
          
        </div> 
      </div>


		



	</div>

