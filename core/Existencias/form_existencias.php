<div class="modal-content"> 
	<div class="modal-header">
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

					<div class="input-field">
						<label for="Cat" style="position: relative;">Categoria de Alimento</label>
						<select value=""  class="validate" name="Cat" id="Cat" required> 
						</select>
					</div>

					<div class="input-field">
						<label for="Ali" style="position: relative;">Producto</label>
						<select value=""  class="validate" name="Ali" id="Ali" required>	 
						</select>
					</div>

					<div class="input-field">
						<label for="Can" style="position: relative;"> Cantidad</label>
						<input type="Text" placeholder="Cantidad" class="form-control" name="Can" id="Can" required>
					</div>

					<div class="input-field">
						<label for="Pre" style="position: relative;">Precio Unitario</label>
						<input type="Text" placeholder="Precio Unitario" class="form-control" name="Pre" id="Pre" required>
					</div>

				</form>
			</div>
		<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" id="cancelar" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
		</div>
</div > 
<script type="text/javascript">
get_all_cat();
$(".modal").modal();
$("#container_modal").modal('open');

$("#aceptar").click(function(){
		$("#form_entradas").submit();
		$("#container_modal").modal('close');
	});
	$("#cancelar").click(function(){
		$("#container_modal").modal('close');
	});

$("#Cat").change(function(){
	var id_categoria_a=$(this).val();
	get_all_ali(id_categoria_a);
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
			$("#Ali").material_select();
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
				$("#Cat").material_select();

			});
		}


</script>
<style type="text/css">
	input-field.select-dropdown
	{
		color: black;
		overflow-y: visible;
		border-radius: 3px;
		margin-top: 4em;
	}
	input-field.dropdown-content{
		color: black;
		overflow-y: visible;
		border-radius: 3px;
		margin-top: 4em;
	}
	#Cat-error{
		position: relative;
		color: red
	}
	#Can-error{
		position: relative;
		color: red
	}
	#Pre-error{
		position: relative;
		color: red
	}
</style>