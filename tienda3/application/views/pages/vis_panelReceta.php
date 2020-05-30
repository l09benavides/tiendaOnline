<!DOCTYPE html>
<!--//************************************************************************************
//Este módulo corresponde a la vista de Recetas que se muestra a los usuarios con rol de
//administrador y provee la funcionalidad CRUD para los registro de Recetas.
//Autor: Gabriel Aleman
//Fecha de creación: 04/8/2018
//Lista modificaciones
//24/08/2018 Gabriel Aleman
//Se agrega a los textarea el editor de text CKEDIT
//************************************************************************************** -->
    <style type="text/css">
    </style>

    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/ckeditor/ckeditor.js')?>"></script> 

 <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
        <li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
        <li class="breadcrumb-item active">Panel de Recetas</li>
</ol> 
    <div class="container">
        <h1 style="font-size:20pt">PANEL RECETAS</h1>

        <h3>Recetas</h3>
        <br />
        <button class="btn btn-success" onclick="add_receta()"><i class="glyphicon glyphicon-plus"></i> Agregar Recetas</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Actualizar</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Detalle Receta</th>
                    <th>Imagen</th>
                    <th style="width:150px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

 <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
 <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
 <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script> 
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript">

var save_method;//Esta variable guarda el tipo de metodo que se va a llamar
var table;//Esta variable guarda los datos que se carga de la base de datos
var base_url = '<?php echo base_url();?>';// Esta variable hace referencia al URL del Sitio Web www.mechesferments.com

// Funcion JavaScrip que permite llamar y utilizar los metodos del controller Cntrl_panelReceta.php
$(document).ready(function() {

    // Define el formato de la tabla recetas
    table = $('#table').DataTable({ 

        "processing": true,//Función de control del indicador de procesamiento
        "serverSide": true,//Modo de procesamiento del lado del servidor del DataTables de control de características.
        "order": [],//Inicia sin orden

       //Definicion de cantidad de registros a mostrar
       "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],

       //Cambio de idioma Table
        "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            },

        //Carga los datos a la tabla desde una fuente de Ajax 
        "ajax": {
            "url": "<?php echo site_url('Ctrl_panelReceta/ajax_list')?>",
           // "url": "www.mechesferments.com/Ctrl_panelReceta/ajax_list",
            "type": "POST"
        },

        //Establece las propiedades de inicialización de definición de columna.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -2 ], //2 last column (photo)
                "orderable": false, //set not orderable
            },
        ],

    });

    //datepicker(Definicion de fechas para imagenes)
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //Selecciona el evento cuando cambia el valor en el input, textarea, select y elimina el error de la clase 
    //y elimina el text help 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});


//Método ajax que permite agregar nuevas recetas por medio de la funcion save al utilizar la el valor almacenado
//en la variable save_method que define la condicion de lo que realiza la funcion save() que posteriormente llamara el //controlador //Ctrl_panelReceta/ajax_add 
function add_receta() 
{
    CKEDITOR.instances.Detalle.setData('');
    save_method = 'add';
    $('#form')[0].reset(); //Restablecer formulario en modal
    $('.form-group').removeClass('has-error'); //Limpiar error class
    $('.help-block').empty(); //Limpiar error string
    $('#modal_form').modal('show'); //Muestra bootstrap modal
    $('.modal-title').text('Agregar Receta'); //Establecer el título en el título modal Bootstrap

    $('#photo-preview').hide(); //Ocultar la vista previa de la foto en la vista modal

    $('#label-photo').text('Cargar Imagen'); //Etiqueta de carga de fotos
}

//Método ajax que permite editar las recetas al pasar el parametro id al controlador Ctrl_panelReceta/ajax_edit.
function edit_receta(id)
{
    save_method = 'update';
    $('#form')[0].reset(); //Restablecer formulario en modal
    $('.form-group').removeClass('has-error'); //Limpiar error class
    $('.help-block').empty(); //Limpiar error string


    //Carga de datos desde Ajax 
    $.ajax({
        url : "<?php echo site_url('Ctrl_panelReceta/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="Id"]').val(data.ID);
            $('[name="Nombre"]').val(data.NOMBRE);
            //$('[name="Detalle"]').val(data.DETALLE); //No eliminar habilitar cuando se quite la etiqueta CKEDITOR
            CKEDITOR.instances.Detalle.setData(data.DETALLE);
            $('#modal_form').modal('show'); //Muestra bootstrap modal cuando completa la carga
            $('.modal-title').text('Editar Receta'); //Establecer título al modal de Bootstrap

            $('#photo-preview').show(); //Muestrar la vista previa de la foto modal

            if(data.IMAGEN)
            {
                $('#label-photo').text('Cambiar Imagen'); //Etiqueta de carga de fotos
                $('#photo-preview div').html('<img src="'+base_url+'./assets/images/uploads/'+data.IMAGEN+'" class="img-responsive">'); //Mostrar Foto
                $('#photo-preview div').append('<input type="checkbox" name="remove_imagen" value="'+data.IMAGEN+'"/> Borrar Imagen Anterior al Guardar'); //Remover Foto

            }
            else
            {
                $('#label-photo').text('Cargando Imagen'); //Etiqueta de carga de fotos
                $('#photo-preview div').text('(Imagen no Disponible)');
            }


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error al obtener datos de Ajax');
        }
    });
}

//Método ajax que permite cargar de nuevo el datatable refrescando, actualizando y mostrando cualquier cambio de 
//en un registro de Recetas.
function reload_table()
{
    table.ajax.reload(null,false); //Recargar datatable ajax 
}

//Método ajax que permite guardar registros nuevos o actualizar las recetas al llamar el controlador //Ctrl_panelReceta/ajax_add - Ctrl_panelReceta/ajax_update
function save()
{
    //$variable = CKEDITOR.instances.Detalle.getData(); --> Pruebas para Debugear y Testear si llegaba el dato
    //alert(CKEDITOR.instances.Detalle.getData()); --> Pruebas para Debugiar y Testear si llegaba el dato
    $('#Detalle').val(CKEDITOR.instances.Detalle.getData());
    $('#btnSave').text('Guardando Espere...'); //Cambio el texto o etiqueta del button que ve el usuario cuando se guarda
    $('#btnSave').attr('disabled',true); //Habilito el button  
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('Ctrl_panelReceta/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Ctrl_panelReceta/ajax_update')?>";
    }

    //Esta variable almacena los datos que envio el formulario llamado #form a travéz del boton submit
    var formData = new FormData($('#form')[0]);

    // Ajax agregar datos a la base de datos
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //Si es correcto cierre el modal y cargue la tabla con reload ajax table 
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {

                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    //permite seleccionar el padre dos veces para seleccionar la clase div form-group y agregar la clase //has-error
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
            $('#btnSave').text('Guardar'); //Cambio el texto o etiqueta del button que ve el usuario
            $('#btnSave').attr('disabled',false); //Habilito el button


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Guardar'); //Cambio el texto o etiqueta del button que ve el usuario
            $('#btnSave').attr('disabled',false); //Habilito el button  

        }

    });

   //Me permite limpiar los campos textarea del formulario cuando seguardan los datos en la base de datos.
    CKEDITOR.instances.Detalle.setData('');
}

//Método ajax que permite borrar las recetas al pasar el parametro id al controlador Ctrl_panelReceta/ajax_delete.
function delete_receta(id)
{
    if(confirm('Esta seguro que desea Eliminar está Receta?'))
    {
        //Ajax borrar datos a la base de datos
        $.ajax({
            url : "<?php echo site_url('Ctrl_panelReceta/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //Si es correcto elimina y carga de nuevo la tabla
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error No se Elimino Receta');
            }
        });

    }
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Receta Formulario</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>      
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="Id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nombre</label>
                            <div class="col-md-12">
                                <input name="Nombre" placeholder="Nombre" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Detalle</label>
                            <div class="col-md-12">
                                <textarea id="Detalle" name="Detalle" placeholder="Detalle" class="form-control" rows="10" cols="50" maxlength="2500"></textarea>
                            <script>
                               //Aplica el metodo ckedit al <textarea id="Detalle">
                               CKEDITOR.replace( 'Detalle' );
                               var data = CKEDITOR.instances.Detalle.getData();
                            </script> 
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="photo-preview">
                            <label class="control-label col-md-5">Imagen</label>
                            <div class="col-md-7">
                                 <--Imagen no Disponible-->
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-5" id="label-photo">Cargar Imagen </label>
                            <div class="col-md-7">
                                <input name="Imagen" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</html>