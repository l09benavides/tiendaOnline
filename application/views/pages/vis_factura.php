<?php 

//************************************************************************************
//Vista de información de las facturas para las transacciones que fueron aprobadas por
//el administrador para cada usuario específico.
//Dentro de esta vista se muestra la información y detalles de cada transacción aprobada,
//en un formato de factura, con los datos correspondientes. 
//Autor: Pablo Hernández
//Fecha de creación: 21/07/2018
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
    window.location = "rut_transacAprobadas";
    break;
  }
  });
  });

</script>

<!--scripts externos y referencias de estilos para formato de la página y las tablas-->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

<!--Definición de estilos CSS específicos para la página-->
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
	margin-left: 0;
	margin-right: 0;
}
.no-gutters {
	margin-right: 0;
	margin-left: 0;
 > .col, > [class*="col-"] {
 padding-right: 0;
 padding-left: 0;
}
}
.glyphicon-search:before {
	content: "\e003"
}
.btn-default {
	background-color: rgba(255, 99, 71,0);
}
.mechescolors {
	background-color: rgb(246, 200, 63);
}
.navbar-dark .navbar-nav .nav-link {
	color: black;
	font-weight: bold;
}
.navbar-dark .navbar-nav .nav-link:hover {
	color: rgb(198, 74, 155);
}
.mechesheader {
	height: 80px;
}
.imagebuffer {
	height: 20px;
}
.linksmechesheader {
	line-height: 80px;
	color: black;
}
.linksmechesheader:hover {
	color: rgba(198, 74, 155);
}
</style>

<!-- llamada a archivo de estilos CSS específicos para factura -->
<link href="<?php echo base_url();?>assets/css/invoice.css" rel="stylesheet" type="text/css">

<!--Breadcrumbs o migajas para indicar al usuario dónde se encuentra en la página-->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="userProfile">Perfil de Usuario</a></li>
    <li class="breadcrumb-item"><a href="userTransactions">Mis Transacciones</a></li>
    <li class="breadcrumb-item"><a href="rut_transacAprobadas">Transacciones Aprobadas</a></li>
    <li class="breadcrumb-item active">Factura</li>
</ol>

<!--Validación de datos, para confirmar que exista el No. de factura a mostrar al usuario-->
<!--Si no existen los datos de la factura, se muestra un mensaje y una redirección-->
<?php if (!isset($Factura)){ ?>

<style type="text/css">
  .footer-distributed{
    position: absolute;
  }
</style>

    <div class="row no-gutters imagebuffer">
      <div class="col-sm-12 "></div>
    </div>

    <div class="info-header" style="text-align: center">
    <h3>Para ver una factura, por favor ingresar desde el <a href="rut_transacAprobadas">Panel de Transacciones Aprobadas.</a> Muchas gracias.</h3>
    </div>
<?php } else { ?>

<!--Sección con toda la información de la factura-->
<div id="container-fluid">
  <div class="invoice">
    <div class="invoice-header">
      <div class="invoice-content">
        <div class="content Meches">
          <div id="info-body">
            <div class="info-header">
              <h3>Meches Ferments S.A.</h3>
            </div>
            <div id="details-info">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                  <td class="td-width" valign="top"><label>Cédula Jurídica:</label></td>
                  <td><span>3-101-123456</span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Dirección:</label></td>
                  <td><span>San Pablo, Heredia</span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Télefono:</label></td>
                  <td><span>2238-5050</span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Correo:</label></td>
                  <td><span>mechesferments@gmail.com</span></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="content Factura">
          <div id="info-body">
            <div class="info-header">
              <!--Detalles de la factura, con la información correspondiente de la transacción-->
              <h3>Factura Electrónica No.</h3>
            </div>
            <div class="NoFactura">0000<?php echo $Factura->Numero_Factura ?></div>
            <div id="details-info">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                  <td class="td-width" valign="top"><label>Forma de Pago:</label></td>
                  <td><span>Contado</span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Fecha de Emisión:</label></td>
                  <td><span><?php echo $Factura->FECHA ?> , <?php echo $Factura->HORA ?></span></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="invoice-content">
        <div class="content Cliente">
          <div id="info-body">
            <div class="info-header">
              <!--Sección con toda la información del cliente de la factura-->
              <h3>Información del Cliente</h3>
            </div>
            <div id="details-info">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                  <td class="td-width" valign="top"><label>ID:</label></td>
                  <td><span><?php echo $Usuario->ID_USUARIO ?></span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Nombre:</label></td>
                  <td><span><?php echo $Usuario->NOMBRE ?> <?php echo $Usuario->APELLIDO_1 ?> <?php echo $Usuario->APELLIDO_2 ?></span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Cédula:</label></td>
                  <td><span><?php echo $Usuario->CEDULA ?></span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Dirección:</label></td>
                  <td><span><?php echo $Factura->Direccion?></span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Teléfono:</label></td>
                  <td><span><?php echo $Usuario->TELEFONO ?></span></td>
                </tr>
                <tr>
                  <td class="td-width" valign="top"><label>Correo:</label></td>
                  <td><span><?php echo $Usuario->CORREO ?></span></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="invoice-body">
      <div class="Panel-Invoice">
        <div class="info-header">
          <!--Tabla con todo el detalle de los productos y precios de la factura-->
          <h3>Detalle de la Factura</h3>
        </div>
        <table width="928" border="1" cellspacing="4" cellpadding="4" class="table_detail" id="Productos">
          <thead>
            <tr class="header-detail-invoice">
              <th width="80" align="center" >Código</th>
              <th width="350" align="center" >Producto</th>
              <th width="70" align="center" >Cantidad</th>
              <th width="100" align="center" >Precio Unitario</th>
              <th width="100" align="center" >Descuento</th> 
              <th width="100" align="center" >Subtotal</th>
              <th width="100" align="center" >Subtotal IVI</th>
            </tr>
          </thead>
          <tbody>
            <?php //for each para obtener la info de todos los productos asociados a la factura 
            foreach ($DetalleFactura as $productos) : ?>
              <tr>
                <td height="50" align="center" ><?php echo $productos->CODIGO;?></td>
                <td height="50" align="left" ><?php echo $productos->Nombre_producto;?></td>
                <td height="50" align="center" ><?php echo $productos->CANTIDAD;?></td>
                <td height="50" align="left" >₡ <?php echo number_format($productos->precio, 2 , '.' , ',');?></td>
                <td height="50" align="left" >₡ <?php echo number_format($productos->DESCUENTO, 2 , '.' , ',');?></td>
                <td height="50" align="left" >₡ <?php echo number_format($productos->subtotal, 2 , '.' , ',');?></td>
                <td height="50" align="left" >₡ <?php echo number_format($productos->TOTAL_PRODUCTO, 2 , '.' , ',');?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!--Sección con el consolidado financiero de la factura, como subtotales e impuestos totales-->
      <div class="Panel-Sub">
      <table border="1" cellspacing="4" cellpadding="4" align="right" class="table_detail">
           <tr height="50" >
            <td>Descuento:</td>
            <td class="text-right">₡ <?php echo number_format($Factura->DESCUENTO_TOTAL, 2 , '.' , ',');?></td>
          </tr>
          <tr height="50" class="gray" >
            <td><strong>Subtotal:</strong></td>
            <td class="text-right">₡ <?php echo number_format($Factura->SUBTOTAL_VENTA, 2 , '.' , ',');?></td>
          </tr>
          <tr height="50" >
            <td>Impuestos de Ventas:</td>
            <td class="text-right">₡ <?php echo number_format($Factura->IMPUESTO_VENTAS, 2 , '.' , ',');?></td>
          </tr>
          <tr height="50" class="gray">
            <td><strong>TOTAL A PAGAR:</strong></td>
            <td class="text-right">₡ <?php echo number_format($Factura->TOTAL, 2 , '.' , ',');?></td>
          </tr>
        </table>
      </div>

  <!--Sección con información legal de la factura-->
      <div class="clear"></div>
      <div class="row">
        <div class="col-xs-7">
          <div class="panel panel-default">
            <div class="panel-body"> <i>Comentarios / Notas</i>
              <hr style="margin:3px 0 5px" />
              Emitida conforme lo establecido en la resolución de factura electrónica N&deg; DGT-02-09 del nueve de enero de dos mil nueve de la Dirección General de Tributación</div>
          </div>
        </div>
      </div>
    </div>

<!--Enlace para regresar al panel de transacciones aprobadas-->
    <div style="vertical-align:middle;text-align:center;">
      <button class="btn btn-outline-primary btn-lg btnOpAdm" id="Regresar" data-user="Regresar">Regresar a Transacciones Aprobadas</button> 
    </div>

    <div class="row no-gutters imagebuffer">
      <div class="col-sm-12 "></div>
    </div>


  </div>

  <?php }?>





