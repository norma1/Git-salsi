<div class="modal fade" id="modal_corte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_locacion"])?"Agregar alimento":"Realizar Corte";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_corte">

						<input type="hidden" value="<?php echo isset($_GET["id_locacion"])?"insert":"CORTE"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>


				

				<label for="Can">Cantidad Inicial</label>
				<input type="text" name="Can" id="Can" placeholder="Cantidad Inicial" class="form-control" required>
				<br>

				<label for="CanE">Cantidad en Efectivo</label>
				<input type="text" name="CanE" id="CanE" placeholder="Cantidad en Efectivo" class="form-control" required>
				<br>

				<label for="CanD">Cantidad en Credito</label>
				<input type="text" name="CanD" id="CanD" placeholder="Cantidad en Credito" class="form-control" required>
				<br>
				
			</form>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar"></input> 
			<input type="button" class="btn btn-primary" data-dismiss="modal" id="Corte" name="Corte" value="Registrar"></input> 
			</div >
		</div > 
	</div > 
</div >
<script>
	$("#modal_corte").modal();
	$("#Corte").click(function()
	{
		$("#form_corte").submit();	
	});

	$("#form_corte").validate({
		errorClass: "invalid",
		rules:{
			Can:{required:true,number:true,min:0},
			CanE:{required:true,number:true,min:0},
			CanD:{required:true,number:true,min:0},
		},

		messages:{
			Can:{
				required:"Es Necesario Escribir una Cantidad Inicial",
				number:"Por favor de Escribir caracteres Numericos",
				min:"No puede iniciar con una cantidad menor a 0"

			},
			CanE:{
				required:"Es Necesario Escribir una Cantidad en Efectivo",
				number:"Por favor de Escribir caracteres Numericos",
				min:"No puede registrar una cantidad en efectivo menor a 0"

			},
			CanD:{
				required:"Es Necesario Escribir una Cantidad en credito",
				number:"Por favor de Escribir caracteres Numericos",
				min:"No puede registrar una cantidad de credito menor a 0"


			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar_Ca").modal();
				$("#btn_confirm_modificar_Ca").click(function(event){
					$("#Modal_confirm_modificar_Ca").modal("hide");
					$.post("core/ventas/controller_ventas.php", $('#form_corte').serialize(), function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					alert(info[0]);
				});
					$("#modal_corte").modal("hide");
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
				 Seguro que desea realizar el corte	
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_modificar_Ca" value="Aceptar">

		</div > 
	</div > 
</div >