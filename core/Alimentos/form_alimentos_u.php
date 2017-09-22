<div class="modal fade" id="modal_alimentos_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 

			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_alimento"])?"Modificar Alimento":"Agregar Alimento";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_alimentos_u">

						<input type="hidden" value="<?php echo isset($_GET["id_alimento"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_alimento"]))
								echo '<input value="'.$_GET["id_alimento"].'"id="id_alimento" name="id_alimento" type="hidden">';
						?>


				<label for="Des"> Descripcion</label>
				<input type="Text" placeholder="Descripcion" class="form-control" name="Des" id="Des" required>
				<br>
				<label for="Pre"> Precio</label>
				<input type="Text" placeholder="Precio" class="form-control" name="Pre" id="Pre" required>
				<br>
				<label for="Cat">Categoria</label>
				<select class="form-control" name="Cat" id="Cat" required>
				</select>
				<br>
				<label for="Est">Estado</label>
				<select value="" class="form-control" name="Est" id="Est" required>
					<option value="1">Activo</option>
					<option value="0">Desactivado</option>
				</select>

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
$("#modal_alimentos_u").modal();
	get_all_cat();
	$("#aceptar").click(function(){
		$("#form_alimentos_u").submit();
	});

	<?php
	if(isset($_GET["id_alimento"]))
		{
			?>
				$.post("core/Alimentos/controller_alimentos.php",{action:"get_one",id_alimento:<?php echo $_GET["id_alimento"]?>},function(res){
					var dat=JSON.parse(res);
					dat=dat[0];
					$("#Des").val(dat["descripcion"]);
					$("#Pre").val(dat["precio"]);
					$("#Cat").val(dat["id_categoria_a"]);
					$("#Est").val(dat["estado"]);
			});
		<?php
	}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");
	
	$("#form_alimentos_u").validate({
		errorClass: "invalid",
		rules:{
			Des:{required:true,validar_form:true},
			Pre:{required:true,number:true,min:1},
			Cat:{required:true},
			Est:{required:true},
		},

		messages:{
			Des:{
				required:"Es Necesario Ingresar el Nombre del Alimento",
				validar_form:"No se Permite Ingresar Caracteres Especiales"
			},
			Pre:{
				required:"Es Necesario Ingresar el Precio",
				number:"Es Necesario Ingresar caracteres numericos",
				min:"El precio de un Alimento no puede ser 0"
			},
			Cat:{
				required:"Es Necesario Seleccionar una Categoria"
			},
			Est:{
				required:"Es Necesario Seleccionar un Estado"
			},
		},

		submitHandler:function(form){
				$("#Modal_confirm_modificar").modal();
				$("#btn_confirm_modificar").click(function(event){
					$("#Modal_confirm_modificar").modal("hide");
					$.post("core/Alimentos/controller_alimentos.php", $('#form_alimentos_u').serialize(), function(){
				get_all();
				});
				$('#modal_alimentos_u').modal("hide");
				});
		}
	});	

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
<div class="modal fade" id="Modal_confirm_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
				 Seguro que desea modificar sus datos	
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_modificar" value="Aceptar">

		</div > 
	</div > 
</div >