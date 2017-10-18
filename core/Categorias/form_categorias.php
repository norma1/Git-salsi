<div class="modal-content"> 
	<div class="modal-header"
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
						<div class="input-field">
						<label for="CA" style="position: relative;">Categoria</label>	
						<input type="text" name="CA" class="form-control" placeholder="Categoria de Alimentos" id="CA" >
						</div>
						
		</form>
	</div>
	<div class="modal-footer"> 
	<input type="button" class="btn btn-danger" id="cancelar" data-dismiss="modal" value="Cancelar"></input> 
	<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
	</div >
</div > 
<script>
$(".modal").modal();
$("#container_modal").modal('open');

	$("#aceptar").click(function(){
		$("#form_c_a").submit();
	});
	$("#cancelar").click(function(){
		$("#container_modal").modal('close');
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
					$("#container_modal").modal("close");
				});
		}
	});	
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
	#CA-error{
		position: relative;
		color: red
	}
	
</style>