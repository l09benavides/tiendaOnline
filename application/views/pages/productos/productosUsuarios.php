<?php
//************************************************************************************
//Este módulo corresponde a la vista de productos que se mostraran a los usuarios en
//un formato de tienda.
//Autor: Luis Benavides
//Fecha de creación: 30/05/2018
//Lista modificaciones
//11/10/2018 Luis Benavides
//Dcoumentacion de la vista.
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Inicio del Contenido-->
<style>


</style>
<script type="text/javascript">

modalAgr = <?php echo $modalAgrValid; ?>; //Si la validacion falla, se vuelve a presentar el modal
var dir = <?php echo json_encode($Direccones); ?>; //Lista de direcciones del usuario para validar si el usuario tiene que crear una.
  
  $(document).ready(function () {

    if(modalAgr==0){
      $('#Producto').modal('show');
      idProductoMod = <?php echo $idProductoMod ?>;
      alert("error de validacion modal, ID: " + idProductoMod);
     if ($("#CardDesc"+idProductoMod).text()){ // si existe un descuento se calcula
      pdescuento = $("#CardDesc"+idProductoMod).text().match(/\d+/);
      descuento = parseInt($("#CardPrecio"+idProductoMod).text().replace(/\,/,'').match(/\d+/)) * (parseInt($("#CardDesc"+idProductoMod).text().match(/\d+/))/100);
     }else{
      pdescuento = 0;
      descuento = 0;
     }
     subtotal = parseInt($("#CardPrecio"+idProductoMod).text().replace(/\,/,'').match(/\d+/)) - descuento;
    if($('#IV'+idProductoMod).val() == "Paga IV"){ //Si tiene impuesto se calcula
      impuestos = subtotal*0.13;
    }else{
      impuestos = 0;
    }
     total = subtotal + impuestos;
     
     //Hiden inputs para enviar la informacion por el form
     $('#InIdProducto').val(idProducto);
     $('#InProductoPrecio').val(idProducto);
     $('#InProductoPDescuento').val(idProducto);

     //Rellenamos los campos de la tabla
     $('#Modalnombre').text($("#CardNombre"+idProductoMod).text());
     $('#Modaldescripcion').text($("#CardDescripcion"+idProductoMod).text());
     $('#Modalprecio').text(parseInt($("#CardPrecio"+idProductoMod).text().replace(/\,/,'').match(/\d+/)));
     $('#Modalpdescuento').text(pdescuento);  
     $('#Modaldescuento').text(descuento);
     $('#ModalcantidadI').val(1);
     $('#ModalcantidadI').attr('max',parseInt($('#Cant'+idProductoMod).val()));
     $('#Modalcapacidad').text($("#CardCapacidad"+idProductoMod).text().match(/\d+/));
     $('#Modalimpuesto').text(impuestos.toFixed(2));
     $('#Modaltotal').text(total.toFixed(2));
    }
  } );
  //Cargar la Informacion de un producto cuando se le de click a agregar al carrito
  $(document).on("click", ".btn-outline-primary", function () {
    if(dir.length == 0){
      $('#modalAgregarDir').modal('show');
    }else{
      $('#Producto').modal('show');
     idProducto = $(this).data('id');
     document.cookie = "idProducto = " + idProducto
     if ($("#CardDesc"+idProducto).text()){
      pdescuento = $("#CardDesc"+idProducto).text().match(/\d+/);
      descuento = parseInt($("#CardPrecio"+idProducto).text().replace(/\,/,'').match(/\d+/)) * (parseInt($("#CardDesc"+idProducto).text().match(/\d+/))/100);
     }else{
      pdescuento = 0;
      descuento = 0;
     }
     subtotal = parseInt($("#CardPrecio"+idProducto).text().replace(/\,/,'').match(/\d+/)) - descuento;
     if($('#IV'+idProducto).val() == "Paga IV"){
      impuestos = subtotal*0.13;
    }else{
      impuestos = 0;
    }
     
     total = subtotal + impuestos;
     //Hiden inputs para enviar la informacion por el form
     $('#InIdProducto').val(idProducto);
     $('#InProductoPrecio').val(parseInt($("#CardPrecio"+idProducto).text().replace(/\,/,'').match(/\d+/)));
     $('#InProductoPDescuento').val(pdescuento);

     //Rellenamos los campos de la tabla
     $('#Modalnombre').text($("#CardNombre"+idProducto).text());
     $('#Modaldescripcion').text($("#CardDescripcion"+idProducto).text());
     $('#Modalprecio').text(parseInt($("#CardPrecio"+idProducto).text().replace(/\,/,'').match(/\d+/)));
     $('#Modalpdescuento').text(pdescuento);
     $('#Modaldescuento').text(descuento);
     $('#ModalcantidadI').val(1);
     $('#ModalcantidadI').attr('max',parseInt($('#Cant'+idProducto).val()));
     $('#Modalcapacidad').text($("#CardCapacidad"+idProducto).text().match(/\d+/));
     $('#Modalimpuesto').text(impuestos.toFixed(2));
     $('#Modaltotal').text(total.toFixed(2));
    }
     
    
  });

  //Cargar los detalles de un producto cuando se le de click
  $(document).on("click", ".btn-primary", function () {
     $('#ProductoDetalles').modal('show');
     idProducto = $(this).data('id');
    $('#ModalDetalles').html($("#Detalles"+idProducto).val());
     $('#ModalTituloDetalles').text($("#CardNombre"+idProducto).text());
    
  });

  //Recalcula los montos si la cantidad del producto cambia
  $(document).on("click keyup keydown", ".input-sm", function () {
  precio = parseInt($('#Modalprecio').text()) * parseInt(getinputvalue());
  descuento = parseInt($('#Modalpdescuento').text());
  subtotal = precio - descuento;
  //Solamente si el impuesto es mayor a 0 lo recalculamos
  if( parseInt($('#Modalimpuesto').text()) > 0){
    impuestos = subtotal*0.13;
  }
  total = subtotal + impuestos;
     $('#Modalimpuesto').text(impuestos.toFixed(2));
     $('#Modaltotal').text(total.toFixed(2));
  });

  function getinputvalue(){
    x = document.getElementById("ModalcantidadI").value;
    return x;
  }

</script>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
    <li class="breadcrumb-item active">Tienda</li>
  </ol>
<div class="container">
<div class="row">
<?php
//por cada uno de los productos que envia al controller creamos un card para mostrar la informacion
foreach ($lista as $productos_item) : ?>
    <div class="col col-sm-6 col-md-4 cardtest" style="margin-bottom:20px; ">
            <div class="card">
                <div id="CarImg-<?php echo $productos_item->ID_PRODUCTO; ?>" class="carousel slide" data-ride="carousel" data-interval="false">

<!-- Indicators -->
          <ul class="carousel-indicators">
            <?php $countInd=0;foreach ($productosImagenes as $imgpro_item) : ?>
              <?php if($imgpro_item['PROID']===$productos_item->ID_PRODUCTO){?>
                <li data-target="#CarImg-<?php echo $productos_item->ID_PRODUCTO; ?>" data-slide-to="<?php echo $countInd;?>" class="carindi"></li>
              <?php $countInd=$countInd+1;}?>
            <?php endforeach; if($countInd==0){?>
              <li data-target="#CarImg-<?php echo $productos_item->ID_PRODUCTO; ?>" data-slide-to="<?php echo $countInd;?>" class="carindi"></li>
            <?php }?>
          </ul>
                          <!-- The slideshow -->
                           <div class="carousel-inner" style="height:300px;">
                                <?php $count=0;foreach ($productosImagenes as $imgpro_item) : ?>
                                  <?php if($imgpro_item['PROID']===$productos_item->ID_PRODUCTO){$count=$count+1;?>
                                    <!--Imagen del producto-->
                                    <div class="carousel-item" >
                                      <img src="<?php echo $imgpro_item['RUTA']; ?>" alt="<?php echo $productos_item->NOMBRE; ?>"  style="height:300px;" class="card-img-top">
                                    </div>
                                    
                                  <?php }?>
                                <?php endforeach; if($count==0){?>
                                  <!--Imagen por Defecto-->
                                  <div class="carousel-item">
                                    <img src="<?php echo base_url();?>images/1.png" alt="Kombucha" style="height:300px;" class="card-img-top">
                                  </div>
                                <?php }?>
                          </div>
                          
                          <!-- Left and right controls -->
                          <a class="carousel-control-prev" href="#CarImg-<?php echo $productos_item->ID_PRODUCTO; ?>" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                          </a>
                          <a class="carousel-control-next" href="#CarImg-<?php echo $productos_item->ID_PRODUCTO; ?>" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                          </a>
                </div>


                <div class="card-body">
                    <div class="row">
                        <div class="col">
                          <input type="hidden" id="Detalles<?php echo $productos_item->ID_PRODUCTO; ?>" name="Detalles<?php echo $productos_item->ID_PRODUCTO; ?>" value="<?php echo $productos_item->DETALLES; ?>">
                          <input type="hidden" name="IV<?php echo $productos_item->ID_PRODUCTO; ?>" id="IV<?php echo $productos_item->ID_PRODUCTO; ?>" value="<?php echo $productos_item->IV ?>">
                          <input type="hidden" name="Cant<?php echo $productos_item->ID_PRODUCTO; ?>" id="Cant<?php echo $productos_item->ID_PRODUCTO; ?>" value="<?php echo $productos_item->STOCK ?>">
                            <h4 class="card-title" id="CardNombre<?php echo $productos_item->ID_PRODUCTO; ?>"><?php echo $productos_item->NOMBRE; ?></h4>
                            <p class="card-text" id="CardDescripcion<?php echo $productos_item->ID_PRODUCTO; ?>"><?php echo $productos_item->DESCRIPCION; ?> </p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"><p id="CardPrecio<?php echo $productos_item->ID_PRODUCTO; ?>">Precio: ₡<?php echo number_format($productos_item->PRECIO, 2, '.', ','); ?></p></div>
                        <?php if($productos_item->PORCENTAJEDESCUENTO > 0) { //Si el producto tiene descuento lo agregamos al card
                            echo "<div class='col'><p id='CardDesc".$productos_item->ID_PRODUCTO."'>Descuento: ".$productos_item->PORCENTAJEDESCUENTO." %</p></div>";
                            }
                          ?>

                        <div class="col"><p class="card-text" id="CardCapacidad<?php echo $productos_item->ID_PRODUCTO; ?>">Presentación: <?php echo $productos_item->CAPACIDAD; ?> ml</p></div>
                    </div>
                   
                    <div class="container">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ProductoDetalles" data-id="<?php echo $productos_item->ID_PRODUCTO; ?>">Detalles</button>
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#Producto-<?php echo $productos_item->ID_PRODUCTO; ?>" data-id="<?php echo $productos_item->ID_PRODUCTO; ?>"><i class="material-icons">add_shopping_cart</i></button>
                    </div>
                </div>
            </div>
        </div>
<?php endforeach;?>
</div>
<script type="text/javascript">
  $(document).ready(function () {
  $("div.carousel-item:first-child").addClass('active');
  $("ul.carindi:first-child").addClass('active');
  });
</script>

</div>


<!-- Inicio Modal para Agregar al carrito -->
  <div class="modal fade" id="Producto">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Agregar al Carrito</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <?php echo form_open("Ctrl_productosUsuarios/met_AgregarCarrito");?>
          <input  type="hidden" name="InIdProducto" id="InIdProducto">
          <input  type="hidden" name="InProductoPrecio" id="InProductoPrecio">
          <input  type="hidden" name="InProductoPDescuento" id="InProductoPDescuento">
          <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>% Desc.</th>
                        <th>Descuento</th>
                        <th>Capacidad</th>
                        <th>Cantidad</th>             
                        <th>I.V.</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td id='Modalnombre'></td>
                            <td id='Modaldescripcion'></td>
                            <td id='Modalprecio'></td>
                            <td id='Modalpdescuento'></td>
                            <td id='Modaldescuento'></td>
                            <td id='Modalcapacidad'></td>
                            <td id='cantidad'><input type="number" name="ModalcantidadI" id="ModalcantidadI" value="<?php echo set_value('ModalcantidadI'); ?>" class="input-sm form-control" min="1" ></td>
                            <td id='Modalimpuesto'></td>
                            <td id='Modaltotal'></td>
                            <td>
                                <button type="submit" id="agregarP" class="button btn-default"> <i id="agregar" class="fa fa-cart-plus" style="font-size:20px;" title="Agregar"></i></button>
                            </td>           
                        </tr>
                </tbody>
            </table>
          </div>
            
            <?php echo form_close();?>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Regresar</button>
        </div>
        
      </div>
    </div>
  </div>

  <!-- Fin Modal para Agregar al carrito-->



  <!-- Inicio Modal Detalles -->
  <div class="modal fade" id="ProductoDetalles" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="ModalTituloDetalles"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body"rows="15" cols="100" id="ModalDetalles" name="ModalDetalles">

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
        
      </div>
    </div>
  </div>

  <!--Modal para Agregar al carrito-->

  <!--DIV para MODAL de agregar   -->
      <div id="modalAgregarDir" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Agregar Dirección</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
          
              <?php echo form_open('Ctrl_direcciones/met_agregarDir'); ?>
            
              <div class="form-group">
                <label for="referenciaAg">Referencia:</label><?php echo form_error('referenciaAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="referenciaAg" value="<?php echo set_value('referenciaAg'); ?>" placeholder="Ingrese un nombre de referencia. (ej: Casa, Oficina, etc.)" name="referenciaAg">
              </div>

              <div class="form-group">
                <label for="provinciaAg">Provincia:</label><?php echo form_error('provinciaAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="provinciaAg" value="<?php echo set_value('provinciaAg'); ?>" placeholder="Ingrese su provincia" name="provinciaAg">
              </div>
          
              <div class="form-group">
                <label for="cantonAg">Cantón:</label><?php echo form_error('cantonAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="cantonAg" value="<?php echo set_value('cantonAg'); ?>" placeholder="Ingrese su cantón" name="cantonAg">
              </div>
          
              <div class="form-group">
                <label for="distritoAg">Distrito:</label><?php echo form_error('distritoAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="distritoAg" value="<?php echo set_value('distritoAg'); ?>" placeholder="Ingrese su distrito" name="distritoAg">
              </div>
              
              <div class="form-group">
                <label for="localizacionAg">Detalles de la dirección:</label><?php echo form_error('localizacionAg','&nbsp;&nbsp;&nbsp;<span style="color:red;">','</span>'); ?>
                <input type="text" class="form-control" id="localizacionAg" value="<?php echo set_value('localizacionAg'); ?>" placeholder="Ingrese detalles de la dirección" name="localizacionAg">
                <input type="hidden" name="tienda" id="tienda" value="tienda">
              </div>
            
            </div>      
              
            <div class="modal-footer">
              <div class="text-center">
              
              <input type="submit" id="botonAgregar" class="btn btn-primary" value="Agregar"/>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
              </form>
            </div> 
          
          </div> 
          
        </div> 
      </div>


<div class="row no-gutters imagebuffer">
    <div class="col-sm-12"></div>
</div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12"></div>
</div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12"></div>
</div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12"></div>
</div>
<div class="row no-gutters imagebuffer">
    <div class="col-sm-12"></div>
</div>


<!--Fin del Contenido-->