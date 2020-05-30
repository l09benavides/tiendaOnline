<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  </div> 
      <br>
      <br>
      <div class="row no-gutters imagebuffer">
    <div class="col-sm-12 "></div>
</div>   
        <!-- CREACION FOOTER PARA ALMACENAR CADA UNO DE LOS LOGOS SOCIAL -->
        <footer class="footer-distributed mechescolors">
            <div class="footer-right"> <!--CLASE DECLARADA PARA DAR CSS A CONTENEDOR-FOOTER-->
                <a href="https://www.facebook.com/Mechess-Ferments-426680497743058/" target="_blank"><i class="fa fa-facebook"></i></a>
                <a href="https://www.instagram.com/mechesferments/" target="_blank"><i class="fa fa-instagram"></i></a>
                <a href="https://plus.google.com/u/1/108214386849219549662" target="_blank"><i class="fa fa-google"></i></a>
            </div>

            <div class="footer-left">   <!--CREACION FOOTER PARA ALMACENAR LABELS/TEXTOS-->
                <p class="footer-links">
                    <a href="rut_Nosotras">Nosotras</a>
                   
                    ·
                    <a href="rut_Contactenos">Contáctenos</a>·
                </p>
                <p id="copyright" style="text-align:center;">Copyright © Web Center S.A. - Costa Rica 2018</p>
            </div>

        </footer>



        <style>
ol{
    display:inline-flex !important;
    left: 0px !important;
}

        .footer-distributed{
    /*background-color: rgb(246, 201, 83); este es aplicado por el panel de temas en resources/css/default.css en mechescolors*/
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
    box-sizing: border-box;
    width: 100%;
    text-align: left;
    font: normal 16px sans-serif;
    padding: 45px 50px;
    margin-top: 40px;
	bottom:0px;
}

.footer-distributed .footer-left p{
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: 14px;
    margin: 0;
}



.footer-distributed p.footer-links{
    font-size:18px;
    font-weight: bold;
    color:  #ffffff;
    margin: 0 0 10px;
    padding: 0;
}

.footer-distributed p.footer-links a{
    display:inline-block;
    line-height: 1.8;
    text-decoration: none;
    color:  black;
}
.footer-distributed p.footer-links a:hover{
   
    color: white;
}

.footer-distributed .footer-right{
    float: right;
    margin-top: 6px;
    max-width: 180px;
}
.footer-distributed .footer-right a:hover{
    color: white;
}
.footer-distributed .footer-right a{
    display: inline-block;
    width: 35px;
    height: 35px;
    font-size: 30px;
    /*color: black;*/
    text-align: center;
    line-height: 35px;

    margin-left: 3px;
}


@media (max-width: 600px) {

    .footer-distributed .footer-left,
    .footer-distributed .footer-right{
        text-align: center;
    }

    .footer-distributed .footer-right{
        float: none;
        margin: 0 auto 20px;
    }

    .footer-distributed .footer-left p.footer-links{
        line-height: 1.8;
    }
}

/*ESTILOS PARA FOOTER RESPONSIVE

SE AGREGÓ UN ESTILO DIRECTO A UN DIV "slider" en recetausuario.php con lo siguiente:

position: relative;
    margin: 0;
    padding-bottom: 6rem;
    min-height: 100%;

    ------------------------------------------------
conflicto en el paneltransaccionesdeusuario.php el position:absolute no responde como debería.
Se agregó directamente en los estilos de la vista un position fixed, sin embargo, el footer se pondría encima del contenido cuando este se agrupa.

*/

footer.footer-distributed{
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    /*padding: 1rem;*/
}

body{
    position: relative;
    margin: 0;
    padding-bottom: 6rem;
    min-height: 100%;
}

html{
    height: 100%;
    box-sizing: border-box;
}

div.container-fluid{
    position: relative;
    margin: 0;
    padding-bottom: 6rem;
    min-height: 100%;
}

div.container{
    position: relative;
    padding-bottom: 6rem;
    min-height: 100%;
}

#container-fluid{
    position: relative;
    margin: 0;
    padding-bottom: 6rem;
    min-height: 100%;
}


/*ESTILOS PARA FOOTER RESPONSIVE FIN*/
        </style>

        <!--CSS PARA TEMAS-->
<link class="pruebaAjax" rel="stylesheet" type="text/css" href="<?php echo base_url().'resources/css/';
echo $Tema[0]['CSS'];?>">

    </body>

</html>
	

