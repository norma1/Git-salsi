<div class="modal fade" id="modal_usuarios_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
		
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_usuario"])?"Modificar Usuario":"Agregar Usuario";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_usuarios_u">

						<input type="hidden" value="<?php echo isset($_GET["id_usuario"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_usuario"]))
								echo '<input value="'.$_GET["id_usuario"].'"id="id_usuario" name="id_usuario" type="hidden">';
						?>


				<label for="NU">Nombre de Usuario</label>
				<input type="Text" placeholder="Nombre de Usuario" class="form-control" name="NU" id="NU" required>
				<br>

				<label for="Con">Contraseña</label>
				<input type="Text" placeholder="Contraseña" class="form-control" name="Con" id="Con" required>
				<br>

				<label for="RO">Tipo de Usuario</label>
				<select value=""  class="form-control" name="RO" id="RO" required>
					 
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
get_all_ro();
$("#modal_usuarios_u").modal();
	$("#aceptar").click(function(){
		$("#form_usuarios_u").submit();
	});
	
	<?php
	if(isset($_GET["id_usuario"]))
		{
			?>
				$.post("core/usuarios/controller_usuarios.php",{action:"get_one",id_usuario:<?php echo $_GET["id_usuario"]?>},function(res){
					var dat=JSON.parse(res);
					dat=dat[0];
					$("#NU").val(dat["nombre"]);
					$("#Con").val(dat["contraseña"]);
					$("#RO").val(dat["id_role"]);
			});
		<?php
	}
?>	



	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_usuarios_u").validate({
		errorClass: "invalid",
		rules:{
			NU:{required:true,validar_form:true},
			Con:{required:true,validar_form:true},
			RO:{required:true},
		},

		messages:{
			NU:{
				required:"Es Necesario Ingresar un Nombre de Usuario",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			Con:{
				required:"Es Necesario Ingresar una Contraseña",
				validar_form:"No se permiten ingresar caracteres especiales"
			},
			RO:{
				required:"Es Necesario Seleccionar un Tipo de Usuario"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("hide");
				$.post("core/usuarios/controller_usuarios.php",$("#form_usuarios_u").
					serialize(),function(){
					get_all();
					});
					$("#modal_usuarios_u").modal("hide");
				});
		}
	});	




	function get_all_ro(){
			$.post("core/role/controller_role.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Tipo de Usuario</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_role"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#RO").html(cod_html);
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