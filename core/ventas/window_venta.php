<section>	
	<div class="modal fade" id="modal_v" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
		<div class="modal-dialog"> 
			<div class="modal-content" id="MoBcc"> 
				<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal"> 
						<span aria-hidden="true">&times;</span> 
						<span class="sr-only">Close</span> 
					</button> 
					<h4 class="modal-title" id="myModalLabel">
					Catalogo de Ventas
					</h4> 
				</div >
				<div class="modal-body">
					<div class="panel panel-default">
					<div class="panel-body">
					
					</div>
						<div class="panel-heading text-center"><a class="btn btn-success" id="add_ventas" data-id_locacion="<?php echo $_GET["id_locacion"];?>"><span class="glyphicon glyphicon-plus"></span></a>
							Ventas
						</div>
						
						<div class="panel-body table-responsive">
								<table class="table">
								 	<tr>
								 		<th>Numero de venta</th>
								 		<th>Cantidad</th>
								 		<th>Producto</th>
								 		<th>Locacion</th>
								 		<th>Subtotal</th>
								 		<th>Cancelaciones</th>
								 	</tr>
								 	<tbody id="content_table"></tbody>	
								 </table>
						</div>	
					</div>
				</div>
				<div class="modal-footer"> 
				<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar"></input> 
				<?php
						if(isset($_GET["id_locacion"]))
						echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';

						if(isset($_GET["id_tipo_l"]))
						echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
				?>

				</div >
			</div > 
		</div > 
	</div>
</section>
<aside id="container_modal">	
</aside>	
<div class="modal fade" id="Modal_confirm_deleteV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">
				 Seguro que desea cancelar la venta		
			</div>

			<div class="modal-footer"> 
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteV" value="Aceptar">
			</div>
		</div > 
	</div > 
</div >
<script type="text/javascript">
$(document).ready(function(){

	get_all_v();

	$("#modal_v").modal();	
	$("#add_ventas").click(function(){
		var id_locacion=$(this).data("id_locacion");
		$("#container_modal").load("core/ventas/form_ventas.php?id_locacion="+id_locacion);
	});	
////////////////////////////////////////////////////////////////////////
	$("#content_table").on("click","a.btn_eliminar",function(){
		var id_venta=$(this).data("id");
		var id_locacion=$(this).data("id_locacion");
		var id_alimento=$(this).data("id_alimento");
		var id_tipo_l=$("#id_tipo_l").val();


		$("#container_modal").load("core/ventas/form_cancelaciones_v.php?id_venta="+id_venta+"&id_locacion="+id_locacion+"&id_alimento="+id_alimento+"&id_tipo_l="+id_tipo_l);
	});	
////////////////////////////////////////////////////////////////////////
});

<?php
	if(isset($_GET["id_locacion"]))
	{
?>
function get_all_v()
{
	$.post("core/ventas/controller_ventas.php",{action:"get_all_ven",id_locacion:<?php echo $_GET["id_locacion"];?>},
		function(res){
			var datos=JSON.parse(res);
			var cod_html="";
			for (var i=0;i<datos.length;i++)
			{
				var info=datos[i];
				cod_html+="<tr><td>"+info['id_venta']+"</td><td>"+info['cantidad']+"</td><td>"+info['descripcion']+"</td><td>"+info['numero']+"</td><td>"+info['subtotal']+"</td><td><a class='btn btn-danger btn_eliminar' data-id='"+info["id_venta"]+"' data-id_locacion='"+info["id_locacion"]+"' data-id_alimento='"+info["id_alimento"]+"'><span class='glyphicon glyphicon-minus'></span></a></td></tr>"
			}
			$("#content_table").html(cod_html);
		});
}
<?php
	}
?>	
</script>