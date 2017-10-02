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
	<title>Categorias</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_all();
			$("#add_categoria").click(function()
			{
				$("#container_modal").load("core/Categorias/form_categorias.php");
			});
/////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteCa").modal();
				$("#btn_confirm_deleteCa").data("id",$(this).data("id"));
			});
			$("#btn_confirm_deleteCa").click(function(event){
				var id_categoria_a=$(this).data("id");
				$.post("core/Categorias/controller_categorias.php",{action:'delete',id_categoria_a:id_categoria_a},
					function(){
						get_all();
						$("#Modal_confirm_deleteCa").modal("hide");
					});
			});
/////////////////////////////////////////////////////////////////////////////////////		
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_categoria_a=$(this).data("id");
				$("#container_modal").load("core/Categorias/form_categorias_u.php?id_categoria_a="+id_categoria_a);
			})

		});
////////////////////////////////////////////////////////////////////////////////////		
		function get_all()
		{

			$.post("core/Categorias/controller_categorias.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					if(info["estado"]==1){
						clase="libre";
					}else{
						clase="ocupado";
					}	
					cod_html+="<tr class='"+clase+"'><td>"+info['descripcion']+"</td><td><a class='btn btn-danger btn_eliminar' data-id='"+info["id_categoria_a"]+"'><span class='glyphicon glyphicon-minus'></span></a></td><td><a class='btn btn-warning btn_modificar' data-id='"+info["id_categoria_a"]+"'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Categorias/controller_categorias.php",{action:"buscar",consulta:consulta}, function(res)
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
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu.php");
		?>
	</div>

	<section class="container">
		
		<div class="panel panel-default">
		<div class="panel-body">
			<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
		</div>
			<div class="panel-heading text-center"><a class="btn btn-success add" id="add_categoria" ><span class="glyphicon glyphicon-plus"></span></a>
			
				Categorias
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

	<div class="modal fade" id="Modal_confirm_deleteCa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteCa" value="Aceptar">

		</div > 
	</div > 
</div >
</body>
</html>