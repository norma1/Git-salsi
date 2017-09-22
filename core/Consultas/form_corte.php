<div class="modal fade" id="modal_Cor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content" id="MoBv"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button>
				<div class="panel-body"> 
				<h4 class="modal-title" id="myModalLabel">
				Bitacora de Corte
				</h4> 
			</div >
			<div class="modal-body">
				<div class="panel panel-default">
				<div class="panel-body">
				<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
				</div>
					<div class="panel-heading text-center">
						Bitacora de Corte
					</div>

					<div class="panel-body table-responsive">
							<table class="table">
							 	<tr>
							 		<th>Total en el Sistema</th>
							 		<th>Total ingresado</th>
							 		<th>Efectivo en el Sistema</th>
							 		<th>Credito en el Sistema</th>
							 		<th>Efectivo Ingresado</th>
							 		<th>Credito Ingresado</th>
							 		<th>Cantidad Iniciada</th>
							 		<th>Desfase</th>
							 		<th>Fecha de corte</th>
							 		<th>Usuario</th>
							 		<th>Generar PDF</th>
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
$("#modal_Cor").modal();
$(document).ready(function(){
	get_all_corte();

			$("#content_table").on("click","a.btn_pdf", function(){	
				var id=$(this).data("id");
				var pdf=JSON.stringify(id);
				window.open("core/pdfulti/controller_corte_con.php?pdf="+pdf);
			});
});

function get_all_corte()
		{
			$.post("core/Consultas/controller_consulta.php",{action:"get_all_Corte"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['total_c']+"</td><td>"+info['total_in']+"</td><td>"+info['c_efectivo']+"</td><td>"+info['c_credito']+"</td><td>"+info['c_efectivo_i']+"</td><td>"+info['c_credito_i']+"</td><td>"+info['cantidad_i']+"</td><td>"+info['desfase']+"</td><td>"+info['fecha_corte']+"</td><td>"+info['nombre']+"</td><td><a class='btn btn-danger btn_pdf' data-id='"+info["id_bitacora"]+"'><span class='glyphicon glyphicon-print'></span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_corte(consulta)
		{
			$.post("core/Consultas/controller_consulta.php",{action:"buscar_corte",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_corte(da);
				}
				else
				{
					get_all_corte();
				}
		});

</script>