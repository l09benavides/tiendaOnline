<?php
//************************************************
/*Esta vista es parte del módulo de bienvenida, corresponde con la página de inicio que permite a los usuarios observar las opciones generales e iniciales del sistema, se comunica con métodos en los archivos:
-Ctrl_bienvenida.php
-Ctrl_bienvenidaAdmin.php
-Ctrl_bienvenidaUsuario.php*/
//Autor: Diego Carrillo
//Fecha de Creación: 17/06/2018
//Lista de Modificaciones:
//20/06/2018 Diego Carrillo
//Se cambio el modo de verificación de nombre de usuario a correo en los text boxes.
//26/07/2018
//Se remueve la opción de recordar contraseña.
//************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>


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

/*.mechescolors{
	background-color: rgb(246, 200, 63);
}
.navbar-dark .navbar-nav .nav-link {
    color: black;
    font-weight: bold;
}*/

.navbar-dark .navbar-nav .nav-link:hover {
    color: rgb(198, 74, 155);
}

.mechesheader{
	height: 80px;
}
.imagebuffer{
	height:20px;
}
/*.linksmechesheader{
	line-height: 80px;
	color:black;
}

.linksmechesheader:hover {
    color: rgba(198, 74, 155);
}*/


  </style>


<body>

<ol class="breadcrumb">
		<li class="breadcrumb-item active">Inicio</li>
</ol>

<div id="container-fluid">

	<!--HEADER-->


<div class="row no-gutters">

	<div class="col-sm-4 "   ></div>

	
	<div class="col-sm-4 " >	
		<!--Carousel starts-->
		<div id="demo" class="carousel slide" data-ride="carousel">

			<!-- Indicators -->
			<!--<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<li data-target="#demo" data-slide-to="1"></li>
			<li data-target="#demo" data-slide-to="2"></li>
			</ul>-->
		  
			<!-- Dynamic Indicators -->
			<ul class="carousel-indicators">
			<?php $countInd=0;foreach ($listaImagenesInicio as $img_item) : ?>
				<li data-target="#CarImg-<?php echo $img_item['IMGGENID']; ?>" data-slide-to="<?php echo $countInd;?>" class="carindi"></li>
			  <?php $countInd=$countInd+1;?>
			<?php endforeach; if($countInd==0){?>
			  <li data-target="#CarImg-<?php echo $img_item['IMGGENID']; ?>" data-slide-to="<?php echo $countInd;?>" class="carindi"></li>
			<?php }?>
			</ul>
		  
		  
		  
		  
		  <!-- The slideshow -->
		  <!--<div class="carousel-inner">
		    <div class="carousel-item active">
		      <img src="<?php echo base_url();?>images/1.png" alt="Kombucha" width="407" height="300">
		    </div>
		    <div class="carousel-item ">
		      <img src="<?php echo base_url();?>images/2.png" alt="Kombucha" width="407" height="300">
		    </div>
		    <div class="carousel-item">
		      <img src="<?php echo base_url();?>images/4.png" alt="Te Negro" width="407" height="300">
		    </div>
		  </div>-->
		  
			<!-- The slideshow -->
			<div class="carousel-inner" style="width=407px;height=300px;">
				<?php $count=0;foreach ($listaImagenesInicio as $img_item) : ?>
				  
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
		  
		  
		  
		  <!-- Left and right controls -->
		  <a class="carousel-control-prev" href="#demo" data-slide="prev">
		    <span class="carousel-control-prev-icon"></span>
		  </a>
		  <a class="carousel-control-next" href="#demo" data-slide="next">
		    <span class="carousel-control-next-icon"></span>
		  </a>
		</div>
		<!--Carousel ends-->
	</div>
	<script type="text/javascript">
  $(document).ready(function () {
  $("div.carousel-item:first-child").addClass('active');
  $("ul.carindi:first-child").addClass('active');
  });
</script>
	<div class="col-sm-4 "  ></div>
</div>

<div class="row no-gutters imagebuffer">
		<div class="col-sm-12 "></div>
	</div>

<div class="row no-gutters ">
	<div class="col-sm-12 d-flex flex-column " >
		<div class="p-2 d-flex justify-content-center"><p>En Meche's Ferments estamos inspiradas en la creencia y vivencia de que la “digestión es la cuestión”.</p></div>
		<div class="p-2 d-flex justify-content-center"><p> Ofrecemos productos fermentados hechos con amor para la salud de las personas.</p></div>

		
	</div>
</div>




<!--Footer-->

	

</div>

</body>