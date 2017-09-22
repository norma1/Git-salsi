<div class="modal fade" id="modal_Bvm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content" id="MoBv"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button>
				<div class="panel-body"> 
				<h4 class="modal-title" id="myModalLabel">
				Bitacora de Ventas Modificadas
				</h4> 
			</div >
			<div class="modal-body">
				<div class="panel panel-default">
				<div class="panel-body">
				<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
				</div>
					<div class="panel-heading text-center">
						Bitacora de Ventas Modificadas
					</div>

					<div class="panel-body table-responsive">
							<table class="table">
							 	<tr>
							 		<th>Numero de venta</th>
							 		<th>Nueva Cantidad</th>
							 		<th>Cantidad Modificada</th>
							 		<th>Nuevo Alimento</th>
							 		<th>Alimento Modificado</th>
							 		<th>Nueva Locacion</th>
							 		<th>Locacion Modificada</th>
							 		<th>Nuevo Subtotal</th>
							 		<th>Antiguo Subtotal</th>
							 		<th>Fecha</th>
							 	</tr>
							 	<tbody id="content_table"></tbody>	
							 </table>
					</div>	
				</div>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar"></input> 
			</div >
		</div > 
	</div > 
</div >
<script type="text/javascript">
$("#modal_Bvm").modal();
get_all_Bvm();
function get_all_Bvm()
		{
			$.post("core/Consultas/controller_consulta.php",{action:"get_all_Bvm"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['id_ventaN']+"</td><td>"+info['cantidadN']+"</td><td>"+info['cantidadO']+"</td><td>"+info['id_alimentoN']+"</td><td>"+info['id_alimentoO']+"</td><td>"+info['id_locacionN']+"</td><td>"+info['id_locacionO']+"</td><td>"+info['subtotalN']+"</td><td>"+info['subtotalO']+"</td><td>"+info['fecha']+"</td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_Bvm(consulta)
		{
			$.post("core/Consultas/controller_consulta.php",{action:"buscar_Bvm",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_Bvm(da);
				}
				else
				{
					get_all_Bvm();
				}
		});

</script>
