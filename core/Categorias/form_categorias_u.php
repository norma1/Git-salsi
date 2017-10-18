<div class="modal-content"> 
	<div class="modal-header"
				<h4 class="modal-title" id="myModalLabel">
				<?php
					echo isset($_GET["id_categoria_a"])?"Modificar Empleado":"Agregar Categoria de Alimento";
				?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
	</div >
	<div class="modal-body">
		<form action="#!" method="post" id="form_c_a_u">
						<input type="hidden" value="<?php echo isset($_GET["id_categoria_a"])?"update":"insert"; ?>" name="action">
						<!-- se especifica el valor del value para que ejecute el case correspondiente-->
						<?php
							if(isset($_GET["id_categoria_a"]))
								echo '<input value="'.$_GET["id_categoria_a"].'"id="id_categoria_a" name="id_categoria_a" type="hidden">';
						?>
						<div class="input-field">
							<label for="CA" style="position: relative;">Categoria</label>	
							<input type="text" name="CA" class="validate"  id="CA" >
						</div>

						<div class="input-field">
				          <label for="Est" id="esti" style="position: relative;">Estado</label>
					        <select value="" class="validate" name="Est" id="Est" required>
					          <option value="1">Activo</option>
					          <option value="0">Desactivado</option>
					        </select>
						</div>
						
		</form>
	</div>
	<div class="modal-footer"> 
	<input type="button" class="btn btn-danger" id="cancelar" data-dismiss="modal" value="Cancelar"></input> 
	<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
	</div >
</div > 
<script type="text/javascript">
$(".modal").modal();
$("#container_modal").modal('open');

	$("#aceptar").click(function(){
		$("#form_c_a_u").submit();
	});
	$("#cancelar").click(function(){
		$("#container_modal").modal('close');
	});

	$("#canci").click(function(){
    	$("#Modal_confirm_modificar").modal('close')
  	});

<?php

	if(isset($_GET["id_categoria_a"]))
		{
?>
		$.post("core/Categorias/controller_categorias.php",{action:"get_one",id_categoria_a:<?php echo $_GET["id_categoria_a"]?>},function(res){
				var dat=JSON.parse(res);
				dat=dat[0];
				$("#CA").val(dat["descripcion"]);
				$("#Est").val(dat["estado"]);
				$('select').material_select();

	});
<?php
		}
?>	

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_c_a_u").validate({
		errorClass: "invalid",
		rules:{
			CA:{required:true,validar_form:true},
			Est:{required:true},
		},

		messages:{
			CA:{
				required:"Es Necesario Escribir Una Categoria de Alimento"
			},
			Est:{
				required:"Es Necesario Seleccionar un Estado"
			},
		},

		submitHandler:function(form){
			$("#Modal_confirm_modificar").modal('open');
			var length=$(".modal-overlay").length-1;
	        $(".modal-overlay")[1].style.opacity="0";
	        $(".modal-overlay")[1].style.zIndex="0";
				$("#btn_confirm_modificar").click(function(event){
					$("#Modal_confirm_modificar").modal("close");
					$.post("core/Categorias/controller_categorias.php", $('#form_c_a_u').serialize(), function(){
				get_all();
				});
					$("#container_modal").modal("close");

				});
		}
	});	
</script>
<div class="modal fade" id="Modal_confirm_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-header"> 
        <h4 class="modal-title" id="myModalLabel">
        </h4> <!-- se especifica el titulo del modal para diferenciarlos-->
      </div >

      <div class="modal-body">
         Seguro que desea modificar el registro    
      </div>

      <div class="modal-footer"> 
      <button type="button" class="btn btn-default" data-dismiss="modal" id="canci">Cancelar</button> 
      <input  type="button" class="btn btn-primary" id="btn_confirm_modificar" value="Aceptar">
      </div>
    </div > 
  </div > 
</div >
<style type="text/css">
	input-field.select-dropdown
	{
		color: black;
		overflow-y: visible;
		border-radius: 3px;
		margin-top: 4em;
	}
	input-field.dropdown-content{
		color: black;
		overflow-y: visible;
		border-radius: 3px;
		margin-top: 4em;
	}
	#CA-error{
		position: relative;
    	color: red
	}
  
</style>