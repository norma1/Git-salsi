<div class="modal fade" id="modal_c_a_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_categoria_a"])?"Modificar Categoria":"Agregar Categoria de Alimento";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_c_a_u">
						<input type="hidden" value="<?php echo isset($_GET["id_categoria_a"])?"update":"insert"; ?>" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_categoria_a"]))
								echo '<input value="'.$_GET["id_categoria_a"].'"id="id_categoria_a" name="id_categoria_a" type="hidden">';
						?>
						
						<label for="CA">Descripcion</label>
						<input type="text" name="CA" class="form-control" placeholder="Categoria de Alimentos" id="CA" >
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
			</div>
		</div > 
	</div > 
</div >
<script>
	$("#modal_c_a_u").modal();

	$("#aceptar").click(function()
	{
		$("#form_c_a_u").submit();	
	});

	<?php
	if(isset($_GET["id_categoria_a"]))
		{
?>
		$.post("core/Categorias/controller_categorias.php",{action:"get_one",id_categoria_a:
			<?php echo $_GET["id_categoria_a"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#CA").val(dat["descripcion"]);
				$("#Est").val(dat["estado"]);
	});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_c_a_u").validate({
		errorClass: "invalid",
		rules:{
			CA:{required:true,validar_form:true},
			Est:{required:true},
		},

		messages:{
			CA:{
				required:"Es Necesario Escribir Una Categoria de Alimento"
			},
			Est:{
				required:"Es Necesario Seleccionar un Estado"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar_Ca").modal();
				$("#btn_confirm_modificar_Ca").click(function(event){
					$("#Modal_confirm_modificar_Ca").modal("hide");
					$.post("core/Categorias/controller_categorias.php", $('#form_c_a_u').serialize(), function(){
				get_all();
				});
					$("#modal_c_a_u").modal("hide");
				});
		}
	});	
</script>
<div class="modal fade" id="Modal_confirm_modificar_Ca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_modificar_Ca" value="Aceptar">

		</div > 
	</div > 
</div >