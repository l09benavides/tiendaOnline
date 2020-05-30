
<?php
//************************************************************************************
// Esta pagina sirve para mostrar el reporte de bitacora del sistema
//Autor: Luis Benavides
//Fecha de creación: 04/08/2018
//Lista modificaciones
//
//**************************************************************************************
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="homeAdmin">Inicio</a></li>
		<li class="breadcrumb-item"><a href="adminPanel">Administración</a></li>
		<li class="breadcrumb-item active">Reporte Bitacora</li>
	</ol>

<div class="container">
	
 <div class="card">
      <div class="card-header" align="center"><h1>Reporte Bitacora</h1></div>
      <div class="card-body">
      		<table class="table table-striped table-bordered" id="reporte">
					<thead>
						<tr>
							<th>
								Fecha
							</th>	
							<th>
								Usuario
							</th>
							<th>
								Accion
							</th>
							<th>
								Detalles
							</th>
						</tr>
					</thead>

					<tbody>
						<?php $queryBitacora = $lista //Se Obtiene un arreglo de entradas de la bitacora?>

						<?php foreach ($queryBitacora as $elementoBitacora) : //se realiza un ciclo para mostrar todas la entradas del arreglo?>
							<tr>
								<td><?php echo $elementoBitacora->timestamp; ?></td>
								<td><?php echo $elementoBitacora->nombre; ?></td>
								<td><?php echo $elementoBitacora->descripcion; ?></td>
								<td>
									<?php 
									// se verifica si la entrada tiene multiples registro 
									//para darles un formato de table y que la informacion
									//sea legible, si no, se imprime el elemento.
									$result = json_decode($elementoBitacora->detalles); 
									if (json_last_error() === 0){						 
										echo "<table>";									
											foreach ($result as $objecto => $item) {
												echo "<tr>";
												echo "<td>$objecto</td>";
												echo "<td>:</i></td>";
												echo "<td>$item</td>";
												echo "</tr>";
											}
										echo "</table>";
									} else {
										echo $elementoBitacora->detalles;
									}
									?>
								</td>			
							</tr>

						<?php endforeach; ?>

					</tbody>

				</table>	

      </div>
	</div>
</div>

<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

	<script type="text/javascript">
	$(function () {
	    $('#reporte').dataTable({
	   //Definicion de cantidad de registros a mostrar
	    	"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
       //Cambio de idioma Tabl
	    	 "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        
	    });
	} );
	</script>
