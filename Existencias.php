<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<title>Surtido</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_all();
			/*EJECUTA EL MODAL DEL FORMULARIO DE ALIMENTOS*/
			$("#add_entradas").click(function()
			{
				$("#container_modal").load("core/Existencias/form_existencias.php");
			});
//////////////////////////////////////////////////////////////////////////////////////		
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteE").modal();
				$("#btn_confirm_deleteE").data("id",$(this).data("id"));
			});

			$("#btn_confirm_deleteE").click(function(event){
				var id_entrada=$(this).data("id");
				$.post("core/Existencias/controller_existencias.php",{action:'delete',id_entrada:id_entrada},
					function(){
						get_all();
						$("#Modal_confirm_deleteE").modal("hide");
					});
			});
		});	
////////////////////////////////////////////////////////////////////////////////////////////
		function get_all()
		{

			$.post("core/Existencias/controller_existencias.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['descripcion']+"</td><td>"+info['cantidad']+"</td><td>$"+info['precio_u']+"</td><td>"+info['fecha']+"</td><td><a class='btn btn-danger btn_eliminar' data-id='"+info["id_entrada"]+"'><span class='glyphicon glyphicon-minus'></span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Existencias/controller_existencias.php",{action:"buscar",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_d(da);
				}
				else
				{
					get_all();
				}
		});
/////////////////////////////////////////////////////////////////////////////////////////////
	jQuery.validator.addMethod("validar_inp", function(value, element) {
 	 return this.optional(element) || /^[a-z ]+$/i.test(value);
	}, "Porfavor de Ingresar solo letras");

	$("#div_bus").validate({
		errorClass: "invalid",
		rules:{
			busc:{validar_inp:true},
		},

		messages:{
				busc:{
					validar_inp:"No se Permiten Caracteres Especiales"
			},
		},
	});			
	</script>
</head>
<body>
<span id="logoN" ><img src="img/logo.png" id="logo"></img></span>
		
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<nav class="navbar navbar-dafault">
		<?php
			require_once("menu.php");
		?>
	</nav>
	<!--SECCION EN LA CUAL ESTA LA TABLA EN LA CUAL SE IMPRIMEN LOS DATOS DE LA CONSULTA SQL-->
	<section class="container">
		
		<div class="panel panel-default">
		<div class="panel-body" id="div_bus">
			<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
		</div>
			<div class="panel-heading text-center"><a class="btn btn-success" id="add_entradas"  ><span class="glyphicon glyphicon-plus"></span></a>
			
				Surtido
			</div>
			<div class="panel-body table-responsive">
				 <table class="table">
				 	<tr>
				 		<th>Producto</th>
				 		<th>Cantidad</th>
				 		<th>Precio Unitario</th>
				 		<th>Fecha</th>
				 		<th>Eliminar</th>
				 	</tr>
				 	<tbody id="content_table"></tbody>
				 	
				 </table>
			</div>
		</div>

	</section>
	<aside id="container_modal">	
	</aside>
	<aside id="container_modal2">	
	</aside>
	<div class="modal fade" id="Modal_confirm_deleteE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
				 Seguro que desea eliminar el registro		
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteE" value="Aceptar">

		</div > 
	</div > 
</div >

	<aside id="container_modal2">
	</aside>
</body>
</html>