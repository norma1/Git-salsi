<div class="modal fade" id="modal_f_ventas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_locacion"])?"Agregar venta":"Venta";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_ventas">

						<input type="hidden" name="action" value="<?php echo isset($_GET["id_locacion"])?"AGREGARV":"insert"; ?>">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>

				<label for="Cat">Categoria de Alimento</label>
				<select value=""  class="form-control" name="Cat" id="Cat" required>
					 
				</select>
				<br>

				<label for="Ali">Producto</label>
				<select value=""  class="form-control" name="Ali" id="Ali" required>
					 
				</select>
				<br>

				<label for="Can">Cantidad</label>
				<input type="text" name="Can" id="Can" placeholder="Cantidad de Productos" class="form-control" required>
				
			</form>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="Vender" name="Vender" value="Aceptar">
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


	$("#modal_f_ventas").modal();
	$("#Vender").click(function(){
		$("#form_ventas").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[1-9]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ventas").validate({
		errorClass: "invalid",
		rules:{
			Cat:{required:true},
			Ali:{required:true},
			Can:{required:true,number:true,max:99,min:1,maxlength:2},
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
				max:"No puede vender mas de 99 prodcutos",
				min:"No puede vender menos de un producto",
				maxlength:"Esta excediento la cantidad permitida para vender",
				number:"Solo se aceptan caracteres numericos"
				
			},
		},

		submitHandler:function(form){
			$.post("core/ventas/controller_ventas.php",$("#form_ventas").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					alert(info[0]);
					get_all_v();
					$("#modal_f_ventas").modal("hide");
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
			$.post("core/Categorias/controller_categorias.php", {action:"get_all_alac"}, function(res){
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
