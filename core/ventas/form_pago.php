<div class="modal fade" id="modal_f_pago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal"> 
					<span aria-hidden="true">&times;</span> 
					<span class="sr-only">Close</span> 
				</button> 
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_ticket"])?"Pagar Locacion":"Agregar Alimento";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
			<form action="#!" method="post" id="form_pagos">

						<input type="hidden" value="<?php echo isset($_GET["id_ticket"])?"call_p":"insert"; ?>" id="action" name="action" type="hidden">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->

						<?php
							if(isset($_GET["id_ticket"]))
								echo '<input value="'.$_GET["id_ticket"].'"id="id_ticket" name="id_ticket" type="hidden">';
						?>
						<?php
							if(isset($_GET["id_locacion"]))
								echo '<input value="'.$_GET["id_locacion"].'"id="id_locacion" name="id_locacion" type="hidden">';
						?>
						<?php
							if(isset($_GET["id_tipo_l"]))
								echo '<input value="'.$_GET["id_tipo_l"].'"id="id_tipo_l" name="id_tipo_l" type="hidden">';
						?>

				<label for="DES">Descuento</label>
				<select value=""  class="form-control" name="DES" id="DES" required>
					 
				</select>
				<br>

				<label for="MP">Metodo de Pago</label>
				<select value=""  class="form-control" name="MP" id="MP" required>
					 
				</select>
				<br>

				<label for="CAN">Recibido</label>
				<input type="" id="CAN" name="CAN" placeholder="Recibido" class="form-control" required>
				<br>

				<label for="EMP">Empleado que atendio</label>
				<select value=""  class="form-control" name="EMP" id="EMP" required>
					 
				</select>
				<br>

				<label for="TOT">Total</label>
				<input type="text" disabled="disabled" id="TOT" name="TOT" class="form-control">


			</form>
			</div>
			<div class="modal-footer"> 
			<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar"></input> 
			<input  type="button" class="btn btn-primary" id="Pagar" value="Pagar">
			<input  type="button" class="btn btn-primary" id="Imprimir" value="Imprimir">


			</div >
		</div > 
	</div > 
</div >
<aside id="#content">
</aside>
<script type="text/javascript">
get_all_des();
get_all_mp();
get_all_emp();

$("#modal_f_pago").modal();
$("#Pagar").click(function(){
	$("#form_pagos").submit();
});
$("#Imprimir").click(function(){
	var id_locacion=$("#id_locacion").val();
	var id_ticket=$("#id_ticket").val();
	var loc=JSON.stringify(id_locacion);
	var tic=JSON.stringify(id_ticket);

	window.open("core/pdfulti/controller_corte_ticket.php?loc="+loc+"&tic="+tic);
});

<?php
	if(isset($_GET["id_ticket"]))
		{
?>
			$.post("core/ventas/controller_ventas.php",{action:"cuenta",id_ticket:<?php echo $_GET["id_ticket"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#TOT").val(dat["subtotal"]);
				
			});
<?php
		}
?>	


	$("#form_pagos").validate({
		errorClass: "invalid",
		rules:{
			DES:{required:true},
			MP:{required:true},
			CAN:{required:true,number:true,min:1},
			EMP:{required:true},
		},

		messages:{
			DES:{
				required:"Es Necesario Seleccionar un Tipo de Descuento"
			},
			MP:{
				required:"Es Necesario Seleccionar un Metodo de Pago"
			},
			CAN:{
				required:"Es Necesario Ingresar una Cantidad de Pago",
				number:"Solo se Aceptan Caracteres Numericos",
				min:"No puede recibir menos de cero o cero"

				
			},
			EMP:{
				required:"Es Necesario Seleccionar un Empleado"
			}
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal();
			$("#btn_confirm_modificar").click(function(event){
				$("#Modal_confirm_modificar").modal("hide");
			$.post("core/ventas/controller_ventas.php",$("#form_pagos").serialize()
				,function(res){
					var datos=JSON.parse(res);
					var cod="";
					var info=datos[0];
					
						alert(info[0]);

					$("#container").html(cod);		
					get_all(<?php echo $_GET["id_tipo_l"];?>);
					
				});	
			$("#modal_f_pago").modal("hide");
			});
			
		}
	});


	function get_all_des(){
			$.post("core/Descuentos/controller_descuentos.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Cantidad de Descuento</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_descuento"]+"'>"+dat["monto"]+"</option>";
				}
				$("#DES").html(cod_html);

			});
	}


	function get_all_mp(){
			$.post("core/Metodos_pagos/controller_m_pagos.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Metodo de Pago</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_mp"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#MP").html(cod_html);

			});
	}


	function get_all_emp(){
			$.post("core/Empleados/controller_empleados.php", {action:"get_all"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona un Empleado</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_empleado"]+"'>"+dat["nombre"]+" "+dat["ap"]+" "+dat["am"]+"</option>";
				}
				$("#EMP").html(cod_html);

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
