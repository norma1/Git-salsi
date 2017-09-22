<div class="modal fade" id="modal_mp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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

				<form action="#!" method="post" id="form_mp">
						<input type="hidden" value="<?php echo isset($_GET["id_mp"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_mp"]))
								echo '<input value="'.$_GET["id_mp"].'"id="id_mp" name="id_mp" type="hidden">';
						?>
						

						<label for="MP">Metodo de Pago</label>
						<input type="text" name="MP" class="form-control" placeholder="Metodo de Pago" id="MP" required>
						
				</form>			
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar"/>
			</div > 
		</div > 
	</div > 
</div >
<script type="text/javascript">
	$("#modal_mp").modal();
	$("#aceptar").click(function(){
		$("#form_mp").submit();
	});


	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");
	$("#form_mp").validate({
		errorClass: "invalid",
		rules:{
			MP:{required:true,validar_form:true},
		},

		messages:{
			MP:{
				required:"Es Necesario Ingresar el Metodo de Pago"
			},
		},

		submitHandler:function(form){
			$.post("core/Metodos_pagos/controller_m_pagos.php",$("#form_mp").serialize()
				,function(){
					get_all();
					$("#modal_mp").modal("hide");
				});
		}
	});	
</script>