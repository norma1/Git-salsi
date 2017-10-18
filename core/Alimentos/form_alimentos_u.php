<div class="modal-content"> 
	<div class="modal-header">
		<h4 class="modal-title" id="myModalLabel">
		<?php
			echo isset($_GET["id_alimento"])?"Modificar Alimento":"Agregar Alimento";
		?></h4> <!-- se especifica el titulo del modal para diferenciarlos-->
	</div >
	<div class="modal-body">
	<form action="#!" method="post" id="form_alimentos_u">

				<input type="hidden" value="<?php echo isset($_GET["id_alimento"])?"update":"insert"; ?>" id="action" name="action" type="hidden">
				<!-- se especifica el valor del value para que ejecute el case correspondiente-->

				<?php
					if(isset($_GET["id_alimento"]))
						echo '<input value="'.$_GET["id_alimento"].'"id="id_alimento" name="id_alimento" type="hidden">';
				?>


		<div class="input-field">
      <label for="Des" id="desi">Descripcion</label>
			<input type="text"  class="validate" name="Des" id="Des" required>
		</div>
		<div class="input-field">
      <label for="Pre" id="p">Precio</label>
			<input type="text"  class="validate" name="Pre" id="Pre" required>
		</div>
		<div class="input-field">
      <label for="Cat" id="cati">Categoria</label>
			<select value=""  class="validate" name="Cat" id="Cat" required>
			</select>
		</div>
		<div class="input-field">
          <label for="Est" id="esti">Estado</label>
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
get_all_cat();
$(".modal").modal();
$("#container_modal").modal('open');

	$("#aceptar").click(function(){
		$("#form_alimentos_u").submit();
	});

	$("#cancelar").click(function(){
		$("#container_modal").modal('close');
	});
	
  $("#canci").click(function(){
    $("#Modal_confirm_modificar").modal('close')
  });
	 <?php


  if(isset($_GET["id_alimento"]))
    {
      ?>
        $.post("core/Alimentos/controller_alimentos.php",{action:"get_one",id_alimento:<?php echo $_GET["id_alimento"]?>},function(res){
          var dat=JSON.parse(res);
          dat=dat[0];
          $("#Des").val(dat["descripcion"]);
          $("#Pre").val(dat["precio"]);
          $("#Cat").val(dat["id_categoria_a"]);
          $("#Est").val(dat["estado"]);
          $('select').material_select();

      });
    <?php
  }
?>  

  jQuery.validator.addMethod("validar_form", function(value, element) {
   return this.optional(element) || /^[a-z 0-9 á é í ó ú ñ ]+$/i.test(value);
  }, "Porfavor de Ingresar solo letras");
  
  $("#form_alimentos_u").validate({
    errorClass: "invalid",
    rules:{
      Des:{required:true,validar_form:true},
      Pre:{required:true,number:true,min:1},
      Cat:{required:true},
      Est:{required:true},
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
          $.post("core/Alimentos/controller_alimentos.php", $('#form_alimentos_u').serialize(), function(){
        get_all();
        });
        $('#container_modal').modal("close");
        });
    }
  }); 

  function get_all_cat(){
      $.post("core/Categorias/controller_categorias.php", {action:"get_all"}, function(res){
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
  #esti{
    position: relative;
  }
  #p{
    position: relative;
  }
  #desi{
    position: relative;
  }
  #Modal_confirm_modificar
  {
    z-index: 1000;
  }
  .invisible{
    display: none;
  }
</style>
