<div class="modal fade" id="modal_c_a" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_categoria_a"])?"Modificar Empleado":"Agregar Categoria de Alimento";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_c_a">
						<input type="hidden" value="<?php echo isset($_GET["id_categoria_a"])?"update":"insert"; ?>" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_categoria_a"]))
								echo '<input value="'.$_GET["id_categoria_a"].'"id="id_categoria_a" name="id_categoria_a" type="hidden">';
						?>
						
						<label for="CA">Descripcion</label>
						<input type="text" name="CA" class="form-control" placeholder="Categoria de Alimentos" id="CA" >
						
				</form>			
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input>
			<input  type="button" class="btn btn-primary" id="aceptar2" value="Aceptar">

		</div > 
	</div > 
</div >
<script>
	$("#modal_c_a").modal();

	$("#aceptar2").click(function()
	{
		$("#form_c_a").submit();	
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_c_a").validate({
		errorClass: "invalid",
		rules:{
			CA:{required:true,validar_form:true},
		},

		messages:{
			CA:{
				required:"Es Necesario Escribir Una Categoria de Alimento"
			},
		},

		submitHandler:function(form){
			$.post("core/Categorias/controller_categorias.php",$("#form_c_a").serialize()
				,function(){
					get_all();
					$("#modal_c_a").modal("hide");
				});
		}
	});	
</script>