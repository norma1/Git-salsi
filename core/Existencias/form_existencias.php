<div class="modal fade" id="modal_entradas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_entrada"])?"Modificar Alimento":"Agregar Entrada";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_entradas">

						<input type="hidden" value="<?php echo isset($_GET["id_entrada"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_entrada"]))
								echo '<input value="'.$_GET["id_entrada"].'"id="id_entrada" name="id_entrada" type="hidden">';
						?>


				<label for="Cat">Categoria de Alimento</label>
				<select value=""  class="form-control" name="Cat" id="Cat" required>
					 
				</select>
				<br>

				<label for="Ali">Producto</label>
				<select value=""  class="form-control" name="Ali" id="Ali" required>
					 
				</select>
				<br>

				<label for="Can"> Cantidad</label>
				<input type="Text" placeholder="Cantidad" class="form-control" name="Can" id="Can" required>
				<br>

				<label for="Pre">Precio Unitario</label>
				<input type="Text" placeholder="Precio Unitario" class="form-control" name="Pre" id="Pre" required>
				<br>
				
			</form>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
			</div >
		</div > 
	</div > 
</div >
<script type="text/javascript">
get_all_cat();

$("#Cat").change(function(){
	var id_categoria_a=$(this).val();
	get_all_ali(id_categoria_a);
});

$("#modal_entradas").modal();
	$("#aceptar").click(function(){
		$("#form_entradas").submit();
	});
	
	

	
	$("#form_entradas").validate({
		errorClass: "invalid",
		rules:{
			Cat:{required:true},
			Ali:{required:true},
			Can:{required:true,number:true,max:99,min:1,maxlength:2},
			Pre:{required:true,number:true,min:1},
			
		},

		messages:{
			Cat:{
				required:"Es Necesario Seleccionar una Categoria"
			},
			Ali:{
				required:"Es Necesario Seleccionar un Producto"
			},
			Can:{
				required:"Es Necesario Ingresar una Cantidad",
				max:"Cantidad Maxima de Surtido Alcanzada",
				min:"No puede Surtir  Menos de 1 unidad",
				maxlength:"Esta excediento la cantidad permitida para Surtir",
				number:"Es Necesario Ingresar caracteres numericos"
			},
			Pre:{
				required:"Es Necesario Ingresar el Precio",
				min:"Un precio no puede ser 0",
				number:"Es Necesario Ingresar caracteres numericos"
			},
			
		},

		submitHandler:function(form){
			$.post("core/Existencias/controller_existencias.php",$("#form_entradas").serialize()
				,function(){
					get_all();
					$("#modal_entradas").modal("hide");
				});
		}
	});	

	function get_all_ali(id_categoria_a){
		$.post("core/Alimentos/controller_alimentos.php",{action:"get_all_id",id_categoria_a:id_categoria_a},function(res){
			var datos=JSON.parse(res);
			var html="<option disabled='true' selected>Seleciona un producto</option>";
			for(var i=0;i<datos.length;i++)
			{
				dato=datos[i];
				html+="<option value='"+dato["id_alimento"]+"'>"+dato["descripcion"]+"</option>";
			}
			$("#Ali").html(html);
		});
	}

	function get_all_cat(){
			$.post("core/Categorias/controller_categorias.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Categoria de Alimentos</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_categoria_a"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#Cat").html(cod_html);

			});
		}


</script>