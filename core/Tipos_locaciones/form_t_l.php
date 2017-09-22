<div class="modal fade" id="modal_t_l" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_mp"])?"Modificar Empleado":"Agregar Metodo de Pago";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_t_l">
						<input type="hidden" value="<?php echo isset($_GET["id_tipo_l"])?"update":"insert"; ?>" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_tipo_l"]))
								echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>
						
						<label for="TL">Descripcion</label>
						<input type="text" name="TL" class="form-control" placeholder="Tipo de locacion" id="TL" >
						
				</form>			
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input>
			<input  type="button" class="btn btn-primary" id="aceptar_tl" value="Aceptar">

		</div > 
	</div > 
</div >
<script>
	$("#modal_t_l").modal();
	$("#aceptar_tl").click(function()
	{
		$("#form_t_l").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_t_l").validate({
		errorClass: "invalid",
		rules:{
			TL:{required:true,validar_form:true},
		},

		messages:{
			TL:{
				required:"Es Necesario Ingresar un Tipo de Locacion"
			},
		},

		submitHandler:function(form){
			$.post("core/Tipos_locaciones/controller_t_l.php",$("#form_t_l").serialize()
				,function(){
					get_all();
					$("#modal_t_l").modal("hide");
				});
		}
	});	
</script>