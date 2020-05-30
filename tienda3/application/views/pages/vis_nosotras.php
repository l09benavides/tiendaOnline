<?php
//************************************************************************************
//Esta vista es parte de la pagina donde estan los indicadores dinamicos, slideshows y el 
//parrafo o descripcion sobre los clientes y su trabajo.
//Autor: Javier Trejos
//Fecha de creación: 17/07/2018
//Lista modificaciones
//11/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema
//**************************************************************************************
?>

<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item active">Nosotras</li>
</ol>

<h2 style="text-align: center;">Sobre nosotras</h2>

<div class="row no-gutters imagebuffer">
	<div class="col-sm-12 "></div>
</div>

<div class="row no-gutters">
	<div class="col-sm-1 " ></div>
	<div class="col-sm-4 " >
		<!--<img src="<?php echo base_url();?>images/logo.png" alt="logo"  height="300">-->
		<!--Carousel starts-->
		<div id="demo" class="carousel slide" data-ride="carousel" height="300px">

			<!-- Dynamic Indicators -->
			<ul class="carousel-indicators">
			<?php $countInd=0;foreach ($listaImagenesNosotras as $img_item) : ?>
				<li data-target="#CarImg-<?php echo $img_item['IMGGENID']; ?>" data-slide-to="<?php echo $countInd;?>" class="carindi"></li>
			  <?php $countInd=$countInd+1;?>
			<?php endforeach; if($countInd==0){?>
			  <li data-target="#CarImg-<?php echo $img_item['IMGGENID']; ?>" data-slide-to="<?php echo $countInd;?>" class="carindi"></li>
			<?php }?>
			</ul>
		  
			<!-- Busca las imagenes del carrusel -->
			<div class="carousel-inner" style="width=407px;height=300px;">
				<?php $count=0;foreach ($listaImagenesNosotras as $img_item) : ?>
				  
					<!--Imagen-->
					<div class="carousel-item">
					  <img src="<?php echo $img_item['RUTA']; ?>" alt="<?php echo $img_item['NOMAR']; ?>" style="width=407px;height=300px;" class="card-img-top">
					</div>
					
				  <?php $count=$count+1;?>
				<?php endforeach; if($count==0){?>
				  <!--Imagen por Defecto-->
				  <div class="carousel-item">
					<img src="<?php echo base_url();?>images/1.png" alt="Kombucha" style="width=407px;height=300px;" class="card-img-top">
				  </div>
				<?php }?>
			</div>
		  
		  
		  
			<!-- Controles derecho e izquierdo del carrusel -->
			<a class="carousel-control-prev" href="#demo" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</a>
			<a class="carousel-control-next" href="#demo" data-slide="next">
				<span class="carousel-control-next-icon"></span>
			</a>
		</div>
		<!--Carousel termina-->
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
		$("div.carousel-item:first-child").addClass('active');
		$("ul.carindi:first-child").addClass('active');
		});
	</script>
	<div class="col-sm-2 " ></div>
	<div class="col-sm-4 " >
		<p style="text-align:justify;"><!--Descripcion acerca del cliente-->
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut malesuada, libero nec ornare euismod, eros elit porta metus, ac faucibus odio lorem at dolor. Nulla eget tortor enim. Morbi odio sapien, cursus at turpis nec, tempor pulvinar dolor. Aenean posuere sollicitudin dolor quis interdum. Quisque egestas orci nulla, in viverra magna euismod non. Vestibulum elementum elit in euismod pellentesque. Ut eget enim sed eros tincidunt dapibus. Nullam bibendum sollicitudin tempor. Nam blandit eget nisl sit amet scelerisque. Quisque eget egestas ligula. Curabitur ac velit justo. In sit amet consectetur nisl. Ut vitae mi lorem. Aenean quis lorem molestie odio fringilla consectetur. Aenean maximus felis dui, at rhoncus elit sagittis quis. Interdum et malesuada fames ac ante ipsum primis in faucibus.

		

			
		</p>
	</div>     
	<div class="col-sm-1 " ></div>
</div>   <!--se cierra el tag para el <div class="row no-gutters"> -->

<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
</div>

<div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
</div>