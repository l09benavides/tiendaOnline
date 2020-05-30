<?php 
//************************************************************************************
//Este módulo corresponde a la vista de Recetas que se muestra a los usuarios
//Autor: Gabriel Aleman
//Fecha de creación: 10/08/2018
//Lista modificaciones
//28/08/2018 Gabriel Aleman
//Se agrega el estilo CSS al carrusel 
//************************************************************************************** 
    require('assets/conexion/conexion.php');
    
    //Variable receta almacena la consulta a la base de datos.
    $receta= "SELECT * FROM RECETAS ORDER BY id DESC";
        
    //Variable recetas almacena la informacion de la consulta a la base de datos (traer todos los registros de //Categorias)  
    $recetas=$mysqli->query($receta);

    //Método ajax que permite limitar el texto a mostrar al usuario en la vista receta recetausuario.php
    function recortar_texto($texto, $limite=100){  
    $texto = trim($texto);
    $texto = strip_tags($texto);
    $tamano = strlen($texto);
    $resultado = '';
    if($tamano <= $limite){
        return $texto;
    }else{
        $texto = substr($texto, 0, $limite);
        $palabras = explode(' ', $texto);
        $resultado = implode(' ', $palabras);
        $resultado .= '...';
    }  
    return $resultado;
    }
?>


<link rel="stylesheet" href="<?=base_url()?>assets/css/style.css" media="screen">
<link rel="stylesheet" href="<?=base_url()?>assets/css/grid.css" media="screen">
<link rel="stylesheet" href="<?=base_url()?>assets/fonts/fonts.css" media="screen">
<!-- Defino estilo y tipo de carrusel en la carpeta Assets -->
<link href="<?=base_url()?>assets/css/owl.carousel.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/owl.theme.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/jquery-1.7.1.min.js"></script>
<!--Añadir fancyBox main JS y archivos CSS -->
<script type="text/javascript" src="<?php echo base_url()?>assets/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox();
    });
</script>

<!-- Muestro la ubicacion e informacion al usuario sobre su navegacion en el sitio web -->
<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
        <li class="breadcrumb-item active">Recetas</li>
</ol>

<div class="slider" style="position: relative;
    margin: 0;
    padding-bottom: 6rem;
    min-height: 100%;">
    <div class="text_center"><h2>Recetas Meche's</h2></div>
    <div class="noticias">
        <div class="container">
            <div class="grid_12">
            <div>
            <!-- <h1>Recetas Meches</h1>  -->
            </div>
            </div>
            <div class="grid_12">
                <div id="owl-demo" class="owl-carousel">
                <?php
                while ($not=$recetas->fetch_assoc()) {  $cadena= $not['DETALLE']; $titulo= $not['NOMBRE'];?>
                    <div class="item">
                        <div class="img_noticias" style="background-image:url(<?=base_url()?>assets/images/uploads/<?php echo $not['IMAGEN'];?>);">
                        </div>
                        <div class="text_noticias">
                            <!-- Secciones de Carousel !-->
                            <!--<div class="span"><?php //echo $not['fecha'];?></div>-->
                            <h3><?php echo recortar_texto($titulo, 54);?></h3>
                            <!-- fancybox permite ampliar y mostrar el contenido en una caja !-->
                            <p><?php echo recortar_texto($cadena, 150);?></p>
                            <a  class="fancybox" href="#inline<?php echo $not['ID'];?>" >Ver más >></a>
                            <!-- LigthBox de Categorias permite construir una galería !-->
                            <div id="inline<?php echo $not['ID'];?>" style="width:500px;display: none;">
                            <h3 style="margin-bottom:2px;"><?php echo $not['NOMBRE'];?></h3>
                            <img src="<?=base_url()?>assets/images/uploads/<?php echo $not['IMAGEN'];?>" style="width:50%; margin-bottom:10px;">
                            <?php echo $not['DETALLE'];?>         
                        </div>          
                    </div>  
                    </div>
                <?php } ?>
                
                </div>
            </div>
        
        <script src="<?php echo base_url('assets/js/owl.carousel.js')?>"></script>

        <!-- Control de Responsive Design !-->
        <script>
        $(document).ready(function() {
        $("#owl-demo").owlCarousel({
        autoPlay: 7000,
        items : 2,
        itemsDesktop : [1199,1],
        itemsDesktopSmall : [979,1],
        itemsTablet: [768,1],
        itemsTabletSmall: [568,1],
        itemsMobile: [0,1], 
        });
        });
        </script>
        
        </div>
    </div>
    <div class="text_center"><a href=>Recetas Meches Ferment's</a></div>

</div>
    <br>
    <br>
    
</body>
</html>

