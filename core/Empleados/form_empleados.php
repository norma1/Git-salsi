<div class="modal fade" id="modal_empleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_empleado"])?"Modificar Empleado":"Agregar Empleado";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				<form action="#!" method="post" id="form_empleado">
						<input type="hidden" value="<?php echo isset($_GET["id_empleado"])?"update":"insert"; ?>" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_empleado"]))
								echo '<input value="'.$_GET["id_empleado"].'"id="id_empleado" name="id_empleado" type="hidden">';
						?>
						
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" class="form-control" placeholder="Nombre" id="nombre" required>
						<br>
						<label for="apellido_paterno">Apellido Paterno</label>
						<input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" id="apellido_paterno" required>
						<br>
						<label for="apellido_materno">Apellido Materno</label>
						<input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" id="apellido_materno" required>
						<br>
						<label for="telefono">Telefono</label>
						<input type="text"  name="telefono" class="form-control" placeholder="telefono" id="telefono"  required>
						
				</form>			
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input>
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">

		</div > 
	</div > 
</div >
<script>
	$("#modal_empleado").modal();
	$("#aceptar").click(function()
	{
		$("#form_empleado").submit();	
	});

	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_empleado").validate({
		errorClass: "invalid",
		rules:{
			nombre:{required:true,validar_form:true},
			apellido_paterno:{required:true,validar_form:true},
			apellido_materno:{required:true,validar_form:true},
			telefono:{required:true,maxlength:10,minlength:10,number:true},
		},

		messages:{
			nombre:{
				required:"Es Necesario Escribir un nombre"
			},
			apellido_paterno:{
				required:"Es Necesario Escribir un Apellido Paterno"
			},
			apellido_materno:{
				required:"Es Necesario Escribir un Apellido Materno"
			},
			telefono:{
				required:"Es Necesario Escribir un Numero de Telefono",
				maxlength:"El numero no puede tener mas de 10 digitos",
				minlength:"El numero no puede tener menos de 10 digitos",
				number:"Favor de ingresar un numero telefonico",
			},

		},

		submitHandler:function(form){
			$.post("core/Empleados/controller_empleados.php",$("#form_empleado").serialize()
				,function(){
					get_all();
					$("#modal_empleado").modal("hide");
				});
		}
	});		
</script>
<div class="modal fade" id="Modal_vali" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
				 Esta introduciendo caracteres no validos	
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm" value="Aceptar">

		</div > 
	</div > 
</div >