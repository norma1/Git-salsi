<div class="modal fade" id="modal_f_complementos_u" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<form action="#!" method="post" id="form_ventas_c_u">

						<input type="hidden" value="<?php echo isset($_GET["id_complemento"])?"cancelar_com":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_complemento"]))
								echo '<input value="'.$_GET["id_complemento"].'"id="id_complemento" name="id_complemento" type="hidden">';
						?>

						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>
						<?php
						if(isset($_GET["id_tipo_l"]))
						echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>

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
	$("#modal_f_complementos_u").modal();
	$("#VENDER").click(function(){
		$("#form_ventas_c_u").submit();
	});

	<?php
	if(isset($_GET["id_complemento"]))
		{
?>
			$.post("core/ventas/controller_ventas.php",{action:"get_one_c",id_complemento:<?php echo $_GET["id_complemento"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#CAN").val(dat["cantidad"]);
				
			});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_ventas_c_u").validate({
		errorClass: "invalid",
		rules:{

			CAN:{required:true,number:true,max:99,min:1,maxlength:2},
		},

		messages:{
			CAN:{
				required:"Es Necesario Ingresar una Cantidad",
				max:"No puede vender mas de 99 prodcutos",
				min:"No puede vender menos de un producto",
				maxlength:"Esta excediento la cantidad permitida para vender",
				number:"Solo se Permiten Numeros"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("hide");
				$.post("core/ventas/controller_ventas.php",$("#form_ventas_c_u").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					alert(info[0]);
					get_all_com();	
					get_all(<?php echo $_GET["id_tipo_l"];?>);

			});
			$("#modal_f_complementos_u").modal("hide");
		});
	}
});
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
				 Seguro que desea cancelar esta cantidad de alimentos	
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_modificar" value="Aceptar">

		</div > 
	</div > 
</div >