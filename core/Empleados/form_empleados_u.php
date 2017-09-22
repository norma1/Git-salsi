<div class="modal fade" id="modal_empleado_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
				<form action="#!" method="post" id="form_empleado_u">
						<input type="hidden" value="<?php echo isset($_GET["id_empleado"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
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
						<input type="text" name="telefono" class="form-control" placeholder="telefono" id="telefono" required>
						
				</form>			
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input>
			<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
			</div>
		</div > 
	</div > 
</div >
<script type="text/javascript">
	$("#modal_empleado_u").modal();
	$("#aceptar").click(function(){
		$("#form_empleado_u").submit();	
	});

<?php
	if(isset($_GET["id_empleado"]))
		{
			?>
				$.post("core/Empleados/controller_empleados.php",{action:"get_one",id_empleado:<?php echo $_GET["id_empleado"]?>},function(res){
						var dat=JSON.parse(res);
						dat=dat[0];
						$("#nombre").val(dat["nombre"]);
						$("#apellido_paterno").val(dat["ap"]);
						$("#apellido_materno").val(dat["am"]);
						$("#telefono").val(dat["telefono"]);

				});
			<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_empleado_u").validate({
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
			$("#Modal_confirm_modificar_e").modal();
				$("#btn_confirm_modificar_e").click(function(event){
					$("#Modal_confirm_modificar_e").modal("hide");
					$.post("core/Empleados/controller_empleados.php", $('#form_empleado_u').serialize(), function(){
				get_all();
				});
				$('#modal_empleado_u').modal("hide");
				});
		}
	});		
</script>
<div class="modal fade" id="Modal_confirm_modificar_e" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_modificar_e" value="Aceptar">

		</div > 
	</div > 
</div >