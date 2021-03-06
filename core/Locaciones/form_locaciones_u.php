<div class="modal fade" id="modal_locaciones_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 

				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_locacion"])?"Modificar Locacion":"Agregar Locaciones";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">
				<form action="#!" method="post" id="form_locaciones_u">
						<input type="hidden" name="action" value="<?php echo isset($_GET["id_locacion"])?"update":"insert"; ?>">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>
						
						<label for="NL">Numero de Locacion</label>
						<input type="text" name="NL" class="form-control" placeholder="Numero de locacion" id="NL" >
						<br>
						
						<?php
							if(!isset($_GET["id_locacion"]))
							{
						?>
						<input type="hidden" name="tipo_l" value="<?php echo $_GET["id_tipo_l"]?>" id="tipo_l">
						<?php
							}else
							{
						?>
						<label for="TL">Descripcion</label>
						<select class="form-control" name="TL" id="TL" required>
						</select>
						<br>

						<label for="EST">ESTADO</label>
						<select class="form-control" name="EST" id="EST" required>
						<option value="1">Activo</option>
						<option value="3">Fuera de Servicio</option>
						</select>
						<?php
							}
						?>	
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
	get_all_TL();
	$("#modal_locaciones_u").modal();
	$("#aceptar").click(function()
	{
		$("#form_locaciones_u").submit();	
	});

	<?php
		if(isset($_GET["id_locacion"]))
		{
	?>
		$.post("core/Locaciones/controller_locaciones.php",{action:"get_one",id_locacion:
			<?php echo $_GET["id_locacion"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#NL").val(dat["numero"]);
				$("#TL").val(dat["id_tipo_l"]);
				$("#EST").val(dat["estado"]);
		});
	<?php
		}
	?>

	$("#form_locaciones_u").validate({
		errorClass: "invalid",
		rules:{
			NL:{required:true,number:true},
			TL:{required:true},
			EST:{required:true},
		},

		messages:{
			NL:{
				required:"Es Necesario Ingresar un Numero de Locacion",
				number:"Solo se pueden caracteres numericos"
			},
			TL:{
				required:"Es Necesario Ingresar un Tipo de Locacion"
			},
			EST:{
				required:"Por favor seleccione un estado"
			},
		},

		submitHandler: function(form){
				$("#Modal_confirm_modificar_u").modal();
				$("#btn_confirm_modificar_u").click(function(event){
					$("#Modal_confirm_modificar_u").modal("hide");
					$.post("core/Locaciones/controller_locaciones.php", $('#form_locaciones_u').serialize(), function(){
					get_all(<?php echo $_GET["id_tipo_l"];?>);
				});
			$('#modal_locaciones_u').modal("hide");
		});
	}
});		

	function get_all_TL(){
			$.post("core/Tipos_locaciones/controller_t_l.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Tipo de Locacion</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_tipo_l"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#TL").html(cod_html);

			});
		}
</script>
<div class="modal fade" id="Modal_confirm_modificar_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_modificar_u" value="Aceptar">

		</div > 
	</div > 
</div >