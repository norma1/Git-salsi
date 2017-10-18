<div class="modal-content"> 
	<div class="modal-header">
		<h4 class="modal-title" id="myModalLabel">
		<?php
			echo isset($_GET["id_alimento"])?"Modificar Alimento":"Agregar Alimento";
		?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
	</div >
	<div class="modal-body">
	<form action="#!" method="post" id="form_alimentos">

				<input type="hidden" value="<?php echo isset($_GET["id_alimento"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
				<!-- se especifica el valor del value para que ejecute el case correspondiente-->

				<?php
					if(isset($_GET["id_alimento"]))
						echo '<input value="'.$_GET["id_alimento"].'"id="id_alimento" name="id_alimento" type="hidden">';
				?>


		<div class="input-field">
			<label for="Des">Descripcion</label>
			<input type="text" placeholder="Descripcion" class="validate" name="Des" id="Des" required>
		</div>
		<div class="input-field">
			<label for="Pre">Precio</label>
			<input type="text" placeholder="Precio" class="validate" name="Pre" id="Pre" required>
		</div>
		<div class="input-field">
			<label for="Cat" id="cati">Categoria</label>
			<select value=""  class="validate" name="Cat" id="Cat" required>
			</select>
		</div>
		<div class="input-field">
		
		<label style="float: left; position: relative;">Añadir una nueva categoria</label>
		<a class="waves-effect waves-teal btn green" style="width: 2em;height: 2em;padding: 0.2em;float:left; left:5%; position: relative; " href="#container_modal2" id="add_categoria"><span class="material-icons">add</span></a>
		</div>

	</form>
	</div>
	<div class="modal-footer"> 
	<input type="button" class="btn btn-danger" id="cancelar" data-dismiss="modal" value="Cancelar"></input> 
	<input  type="button" class="btn btn-primary" id="aceptar" value="Aceptar">
	</div >
</div > 
<script type="text/javascript">
get_all_cat();
$(".modal").modal();
$("#container_modal").modal('open');

	$("#aceptar").click(function(){
		$("#form_alimentos").submit();
	});
	$("#cancelar").click(function(){
		$("#container_modal").modal('close');
	});
	
	$("#add_categoria").click(function()
		{	
			$("#container_modal2").modal('open');
		});

	jQuery.validator.addMethod("validar_form", function(value, element) {
 	 return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#form_alimentos").validate({
		errorClass: "invalid",
		rules:{
			Des:{required:true,validar_form:true},
			Pre:{required:true,number:true,min:1},
			Cat:{required:true},
		},

		messages:{
			Des:{
				required:"Es Necesario Ingresar el Nombre del Alimento",
				validar_form:"No se Permite Ingresar Caracteres Especiales"
			},
			Pre:{
				required:"Es Necesario Ingresar el Precio",
				number:"Es Necesario Ingresar caracteres numericos",
				min:"El precio de un Alimento no puede ser 0"
			},
			Cat:{
				required:"Es Necesario Seleccionar una Categoria"
			},
		},

		submitHandler:function(form){
			$.post("core/Alimentos/controller_alimentos.php",$("#form_alimentos").serialize()
				,function(){
					get_all();
					$("#container_modal").modal('close');
				});
		}
	});	



	function get_all_cat(){
			$.post("core/Categorias/controller_categorias.php", {action:"get_all_alac"}, function(res){
				var datos=JSON.parse(res);
				var cod_html="<option disabled='true' selected>Selecciona una Categoria de Alimentos</option>";
				for (var i=0; i<datos.length;i++)
				{
					dat=datos[i];
					cod_html+="<option value='"+dat["id_categoria_a"]+"'>"+dat["descripcion"]+"</option>";
				}
				$("#Cat").html(cod_html);
				$('select').material_select();
			});
		}

</script>
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
	#Des-error{
		position: relative;
		color: red
	}
	#Pre-error{
		position: relative;
		color: red
	}
	#cati{
		position: relative;
	}
</style>
