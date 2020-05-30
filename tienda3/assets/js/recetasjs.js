$(document).on("ready", main);

function main(){
	
	$("#msg-error").hide();
	mostrarDatos("");

    $("#buscar").keyup(function(){
		buscar = $("#buscar").val();
		mostrarDatos(buscar);
	});

	$("#btnbuscar").click(function(){
		mostrarDatos("");
		$("#buscar").val("");
	});


	$("#btnactualizar").click(actualizar); // Defino el boton del formulario y el evento o funcion del js a utilizar

//----------------------------------------------------------------------------------------------------------------------

	$("#form-create-receta").submit(function(event){ // evento sobre el formulario from-create-usuario
		event.preventDefault();
		var formData = new FormData($("#form-create-receta")[0]);
		$.ajax({
			url:$(this).attr('action'),
			type:$(this).attr('method'),
			data: formData,
            cache: false,
            contentType: false,
            processData: false,
			success:function(resp){
				alert(resp);
				mostrarDatos(""); // actualizar refrescar lista en tabla



			}

		});

	});

//----------------------------------------------------------------------------------------------------------------


$("body").on("click","#listaRecetas a",function(event){ // selecciono el body de nuestro documento y le digo que se cargue los elemntos cuando haga click en la etiqueta a 
		event.preventDefault(); // metodo que previena la accion del href
		idedit = $(this).attr("href"); // voy a capturar el valor  varible href que esta del lado del formulario en la etiqueta <a> en la pagina(value se puede observar inspeccionando el formulario de la pagina con click drecho inspeccionar debe de tener un valor no puede estar null) de la etiqueta a con la varible idselec 
		nombreedit = $(this).parent().parent().children("td:eq(1)").text(); // como el boton esta dentro de una columna o TD coloco varibke nombresele = me dirijo a su td y luego a su tr para que busque a sus hijos que van a ser los td pero quiero saber el valor td con indice (1) y coloco el metodo .text para obtener el valor de dicho td 
		detalleedit = $(this).parent().parent().children("td:eq(2)").text();
		alert(nombreedit);// msj de Usuario seleccionado a actualizar
		

		$("#idedit").val(idedit); // imprime valor de la varible idedit al los campos del formulario en la pagina usuarios.
		$("#nombreedit").val(nombreedit);
		$("#detalleedit").val(detalleedit); 
		mostrarDatos(""); // actualizar refrescar lista en tabla
	
	});

//----------------------------------------------------------------------------------------------------------------------


$("body").on("click","#listaRecetas button",function(event){ // selecciono el body de nuestro documento y le digo que se cargue los elemntos cuando haga click en el boton 
		//"#listaUsuarios HACE REFERENCIA A FORMULARIO A UTILIZAR DEL BODY DE LA PAGINA
		//button refiere al elemento que voy a hacer click utilizar para realizar una accion
		idedit = $(this).attr("value"); // voy a capturar el valor  href(value se puede observar inspeccionando el formulario de la pagina con click drecho inspeccionar debe de tener un valor no puede estar null) de la etiqueta a con la varible idselec 
		//value es el atributo que esta dentro de nuestro boton que contiene el id de la receta... se observa presionado el elemento con click derecho y luego inspecciono
		eliminar(idedit); //idedit guarda valor del id de la receta y lo pasa como parametro a la funcion eliminar del js que tengo mas abajo para que el id de este sea igual al idsele 
		//y le envie el valor del id de esta funcion a la funcion del controlador usuario y metodo eliminar para que este utilice
		// 

	});


} //fin funcion main

//---------------------------------------------------------------------------------------------------------------------


function mostrarDatos(valor){
	$.ajax({
		//url:"http://localhost/meches/Ctrl_panelRecetas/met_mostrarReceta",
		//url:"http://localhost/meches/MostrarReceta", //ROUTE
		url:"https://www.mechesferments.com/Ctrl_panelRecetas/met_mostrarReceta", //llamado control y metodo directo
		//url:"https://www.mechesferments.com/rut_panelRecetas/MostrarReceta", //ROUTE 
		//url:"https://www.mechesferments.com/rut_panelRecetas/met_mostrarReceta", //

		type:"POST",
		data:{buscar:valor},
		success:function(respuesta){
        //alert(respuesta); // me tira un msj con todos los valores a pasar
		var registros = eval(respuesta);


//            html ="<table class='table table-responsive table-striped'><thead>";
            html ="<table class='table table-responsive table table-bordered table-striped'><thead>"; //"table table-bordered table-striped"
 			html +="<tr><th>Id</th><th>Titulo</th><th>Descripcion</th><th>Foto</th><th>Accion</th></tr>";
			html +="</thead><tbody>";
			for (var i = 0; i < registros.length; i++) {
				html +="<tr><td>"+registros[i]["ID"]+"</td><td>"+registros[i]["NOMBRE"]+"</td><td>"+registros[i]["DETALLE"]+"</td><td><img src='https://www.mechesferments.com/assets/images/uploads/"+registros[i]["IMAGEN"]+"' style='width:50px; height:25px;'/></td><td><a href='"+registros[i]["ID"]+"' class='btn btn-warning' data-toggle='modal' data-target='#myModal'><span class='glyphicon glyphicon-pencil'></a> <button class='btn btn-danger' type='button' value='"+registros[i]["ID"]+"'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
			};
			html +="</tbody></table>";
			$("#listaRecetas").html(html);
		}			
	});
}

//----------------------------------------------------------------------------------------------------------------------------------

function actualizar(){ 
	var formData = new FormData($("#form-actualizar-recetas")[0]); //es el id del formulario de la vista que quiero actualizar
	$.ajax({ //utilizo metodo  ajax para enviar los datos a mi controlador

	   // url:"http://localhost/meches/Ctrl_panelRecetas/met_actualizarReceta", //raizdelproyecto/controlador/funcion
		//url:"http://localhost/meches/ActualizarReceta", //ROUTE
	//	url:"https://www.mechesferments.com/Ctrl_panelRecetas/met_actualizarReceta", //llamado control y metodo directo
	   url:"https://www.mechesferments.com/Ctrl_panelRecetas/met_actualizarReceta",
		//url: '<?php echo base_url()."Ctrl_panelRecetas/met_actualizarReceta";?>',
		//url:"https://www.mechesferments.com/rut_panelRecetas/ActualizarReceta", //ROUTE
		//url:"https://www.mechesferments.com/rut_panelRecetas/met_actualizarReceta", //ROUTE
		//<?php base_url();?>/Ctrl_panelRecetas/met_actualizarReceta
		
		type:"POST", // tipo de metodo de envio post y coloco la info a enviar
		data:formData, //envio de datos
		cache:false,
		processData:false,
		contentType:false,
		success:function(respuesta){ //funcion de exito
		alert(respuesta); // imprime la respuesta de la funcion success del valor que esta retornando
		mostrarDatos(""); // actualizar refrescar lista en tabla
		}
	});
}


//----------------------------------------------------------------------------------------------------------------------------

function eliminar(idedit){
	$.ajax({

	   // url:"http://localhost/meches/Ctrl_panelRecetas/met_eliminarReceta", //raizdelproyecto/controlador/funcion
		//url:"http://localhost/meches/EliminarReceta", //ROUTE
		url:"https://www.mechesferments.com/Ctrl_panelRecetas/met_eliminarReceta", //llamado control y metodo directo
		//url:"https://www.mechesferments.com/rut_panelRecetas/EliminarReceta", //ROUTE
		//url:"https://www.mechesferments.com/rut_panelRecetas/met_eliminarReceta", //
		type:"POST",
		data:{id:idedit}, //envio de datos como parametros digo que el id:(id es igual) ala varible obtenida de la accion del boton
		//se debe utilizar del lado del controlador $this->input->is_ajax_request()) para poder obtener valor del id 
		//mas $idedit = $this->input->post("id"); del lado de controlador para poder definirle valor de la varible a otra varible que va ser utilizada como parametro 
		//para un metodo eliminar del modelo que esta dentro de la funcion elimnar del controlador receta 
		success:function(respuesta){ //funcion de exito
			alert(respuesta); // imprime la respuesta de la funcion success del valor que esta retornando
			mostrarDatos(""); // actualizar refrescar lista en tabla
		}
	});
}





