<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<title>Descuentos</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_all();
			$("#add_descuentos").click(function()
			{
				$("#container_modal").load("core/Descuentos/form_descuentos.php");
			});
///////////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteD").modal();
				$("#btn_confirm_deleteD").data("id",$(this).data("id"));
			});
			$("#btn_confirm_deleteD").click(function(event){
				var id_descuento=$(this).data("id");
				$.post("core/Descuentos/controller_descuentos.php",{action:'delete',id_descuento:id_descuento},
					function(){
						get_all();
						$("#Modal_confirm_deleteD").modal("hide");
					});
			});
/////////////////////////////////////////////////////////////////////////////////////////	
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_descuento=$(this).data("id");
				$("#container_modal").load("core/Descuentos/form_descuentos_u.php?id_descuento="+id_descuento);
			})

		});
/////////////////////////////////////////////////////////////////////////////////////////		
		function get_all()
		{
			$.post("core/Descuentos/controller_descuentos.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>%"+info['monto']+"</td><td><a class='btn btn-danger btn_eliminar' data-id='"+info["id_descuento"]+"'><span class='glyphicon glyphicon-minus'></span></a></td><td><a class='btn btn-warning btn_modificar' data-id='"+info["id_descuento"]+"'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);	
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Descuentos/controller_descuentos.php",{action:"buscar",consulta:consulta}, function(res)
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
	
	<nav class="navbar navbar-dafault">
		<?php
			require_once("menu.php");
		?>
	</nav>

	<section class="container">
		
		<div class="panel panel-default">
		<div class="panel-body">
			<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
		</div>
			<div class="panel-heading text-center"><a class="btn btn-success" id="add_descuentos" ><span class="glyphicon glyphicon-plus"></span></a>
			
				Descuentos
			</div>
			<div class="panel-body table-responsive">
				 <table class="table">
				 	<tr>
				 		<th>Porcentaje</th>
				 		<th>Eliminar</th>
				 		<th>Editar</th>
				 	</tr>
				 	<tbody id="content_table"></tbody>
				 	
				 </table>
			</div>
		</div>

	</section>
	<aside id="container_modal">
	</aside>

	<div class="modal fade" id="Modal_confirm_deleteD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteD" value="Aceptar">

		</div > 
	</div > 
</div >
</body>
</html>