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
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Tipos de Locaciones</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_all();
			$("#add_t_l").click(function()
			{
				$("#container_modal").load("core/Tipos_locaciones/form_t_l.php");
			});

			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteTl").modal();
				$("#btn_confirm_deleteTl").data("id",$(this).data("id"));
			});
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_tipo_l=$(this).data("id");
				$("#container_modal").load("core/Tipos_locaciones/form_t_l_u.php?id_tipo_l="+id_tipo_l);
			})

		});
		function get_all()
		{

			$.post("core/Tipos_locaciones/controller_t_l.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['descripcion']+"</td><td><a class='btn btn-danger btn_eliminar' data-id='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-minus'></span></a></td><td><a class='btn btn-warning btn_modificar' data-id='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
			$("#btn_confirm_deleteTl").click(function(event){
				var id_tipo_l=$(this).data("id");
				$.post("core/Tipos_locaciones/controller_t_l.php",{action:'delete',id_tipo_l:id_tipo_l},
					function(){
						get_all();
						$("#Modal_confirm_deleteTl").modal("hide");
					});
			});
		}
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu.php");
		?>
	</div>

	<section class="container">
		
		<div class="panel panel-default">
			<div class="panel-heading text-center"><a class="btn btn-success" id="add_t_l" ><span class="glyphicon glyphicon-plus"></span></a>
			
				Tipos de Locaciones
			</div>
			<div class="panel-body table-responsive">
				 <table class="table">
				 	<tr>
				 		<th>Descripcion</th>
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

	<div class="modal fade" id="Modal_confirm_deleteTl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteTl" value="Aceptar">

		</div > 
	</div > 
</div >

</body>
</html>