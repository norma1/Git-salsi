<div class="modal fade" id="modal_descuentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_empleado"])?"Modificar Empleado":"Agregar Descuento";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_descuentos">
						<input type="hidden" value="<?php echo isset($_GET["id_descuento"])?"update":"insert"; ?>" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_descuento"]))
								echo '<input value="'.$_GET["id_descuento"].'"id="id_descuento" name="id_descuento" type="hidden">';
						?>
						
						<label for="Porce">Porcentaje</label>
						<input type="text" name="Porce" class="form-control" placeholder="Porcentaje" id="Porce" >
						
				</form>			
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">

		</div > 
	</div > 
</div >
<script>
	$("#modal_descuentos").modal();

	$("#aceptar").click(function()
	{
		$("#form_descuentos").submit();	
	});

	
	$("#form_descuentos").validate({
		errorClass: "invalid",
		rules:{
			Porce:{required:true,number:true,max:100,min:1,maxlength:2},
		},

		messages:{
			Porce:{
				required:"Es Necesario Ingresar un Porcentaje de Descuento",
				number:"Es Necesario que sea un valor numerico",
				max:"No puede Registrar un % mayor a 100",
				min:"No puede Registrar un % menor a 0",
				maxlength:"Esta excediendo el Porcentaje de Parametro permitido"
			},
		},

		submitHandler:function(form){
			$.post("core/Descuentos/controller_descuentos.php",$("#form_descuentos").serialize()
				,function(){
					get_all();
					$("#modal_descuentos").modal("hide");
				});
		}
	});	
</script>