
<?php
//***************************************************************************************
//Esta vista es la cabecera de las paginas web en este caso el de un usuario no logueado.  
// Es total mente responsive y cambia de color de acuerdo al tema.
//Autor: Akzel Novoa
//Fecha de creación: 17/07/2018
//Lista modificaciones
//01/08/2018 AKzel Novoa
//Se crea el diseno responsive
//15/08/2018 Javier Trejos
//Se ingresa la carga del Tema en base a la configuracion del sistema.
//14/10/2018 Akzel Novoa
//Se Ingresa comentarios en el codigo
//*****************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


<head>
    <title>Meche's Ferments</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/iconoNuevo.png">
</head>
<body>
<script>
  (function() {//Es un script que corre el ajax de el search
    var cx = '009969701752880351821:tdmd_ijyvmo';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
  window.onload = function(){
    document.getElementById('gsc-i-id1').placeholder = 'Buscar';
  };
</script>




    <!-- temp -->

    <!-- Empieza el codigo de html del header y varias classes de css que lo hacen resposive -->
    <nav  class="justify-content-start align-items-center navbar navbar-expand-lg navbar-light navbar-fixed-top col-md-12 mechescolors navbar-dark">


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="NavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div  class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand" href="http://www.mechesferments.com">
                    <img src="<?php echo base_url(); ?>images/nuevologo.png" alt="logo" width="90" height="90" >
                </a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"> <!--removed active-->
                    <a class="nav-link" href="home">Inicio <!-- <span class="sr-only">(current)</span> --></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="productosUsuarios">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rut_Categorias">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rut_RecetasUsuarios">Recetas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="promo">Promociones</a>
                </li>


            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a id="iconoUser" href="userAccess" class="btn btn-default mechesheader linksmechesheader"> <span class="fa fa-user"  style="font-size: 30px; height:30px; margin-right: 10px;" > </span></a>
                <a id="iconoCarrito" href="carrito" class="btn btn-default mechesheader linksmechesheader"> <span class="fa fa-shopping-cart" style="font-size: 30px;  margin-right: 10px;"></span><span class="badge badge-notify"><?php if(isset($session_data['carrito'])) {echo $session_data['carrito'];}?></span></a>
                       <!--  <input class="form-control mr-sm-2"  type="search" placeholder="Search" aria-label="Search"> 
                        estilo de los span ante style="font-size: 30px;  margin-right: 30px;"-->
                        </form>
                            <div class="mechesheader col-md-3">
                                <gcse:search style="border-color: #ffc107;
                                background-color: #ffc107; ">Buscar...</gcse:search> <!--EL GCSE utiliza un JavaScript que esta al principio del header FYI-->
                            </div>
                        </div>
                        </nav><!-- Termina el codigo de html del header -->




                        <!-- Latest compiled and minified CSS -->
                        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

                        <!-- Add icon library -->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                        <!-- jQuery library -->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                        <!-- Popper JS -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

                        <!-- Latest compiled JavaScript 
                        <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->

                        <!-- Agarra el icono para el tab del browser -->
                        <link rel="shortcut icon" href="images/icono.ico">
                         <link rel="shortcut icon" href="icono.ico"/>
						 <link rel="shortcut icon" href="icono.ico" type="image/x-icon" />



                         <!-- Estilos para el cambio de colores de los temas de la pagina-->
                        <style type="text/css">
                         /*   a:link {color:#000000;}
                            a:visited {color:#000000;}
                            a:active {color:#000000;}
                            a:hover {color:#000000;}*/
                            .h6meches{
                                vertical-align: middle;
                                margin:0 0 0 0;
                                line-height: 70px;
                            }

                            .cse .gsc-control-cse,
                                .gsc-control-cse {
                                  border-color: transparent !important;
                                  background-color:transparent !important;
                                  margin-top: 12px !important;
                                }

                        </style>

