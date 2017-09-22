<div class="modal fade" id="modal_f_complementos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_locacion"])?"Agregar alimento":"Agregar Venta";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_ventas_c">

						<input type="hidden" value="<?php echo isset($_GET["id_locacion"])?"AGREGARC":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>

				<label for="DES">Descripcion</label>
				<input type="text" name="DES" id="DES" placeholder="Descripcion de producto" class="form-control" required>
				<br>

				<label for="PRE">Precio</label>
				<input type="text" name="PRE" id="PRE" placeholder="Precio" class="form-control" required>
				<br>

				<label for="CAN">Cantidad</label>
				<input type="text" name="CAN" id="CAN" placeholder="Cantidad" class="form-control" required>
				<br>
				
			</form>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="VENDER" name="VENDER" value="Aceptar">
			</div >
		</div > 
	</div > 
</div >
<script type="text/javascript">
	$("#modal_f_complementos").modal();
	$("#VENDER").click(function(){
		$("#form_ventas_c").submit();
	});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ventas_c").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true,validar_form:true},
			PRE:{required:true,number:true},
			CAN:{required:true,number:true,max:99,min:1,maxlength:2},
		},

		messages:{
			DES:{
				required:"Es Necesario Ingresar un Descripcion",
				validar_form:"No se permiten caracteres especiales"
			},
			PRE:{
				required:"Es Necesario Ingresar solo Numeros",
				number:"Solo se Permiten Numeros"
			},
			CAN:{
				required:"Es Necesario Ingresar una Cantidad",
				max:"No puede vender mas de 99 prodcutos",
				min:"No puede vender menos de un producto",
				maxlength:"Esta excediento la cantidad permitida para vender",
				number:"Solo se Permiten Numeros"
			},
		},

		submitHandler:function(form){
			$.post("core/ventas/controller_ventas.php",$("#form_ventas_c").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					alert(info[0]);
					get_all_com();
					$("#modal_f_complementos").modal("hide");
				});
		}
	});
</script>
