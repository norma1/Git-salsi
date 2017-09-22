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
	<title>Alimentos</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_all();
			$("#add_alimentos").click(function()
			{
				$("#container_modal").load("core/Alimentos/form_alimentos.php");
			});
//////////////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteA").modal();
				$("#btn_confirm_deleteA").data("id",$(this).data("id"));
			});

			$("#btn_confirm_deleteA").click(function(event){
				var id_alimento=$(this).data("id");
				$.post("core/Alimentos/controller_alimentos.php",{action:'delete',id_alimento:id_alimento},
					function(){
						get_all();
						$("#Modal_confirm_deleteA").modal("hide");
					});
			});
//////////////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_alimento=$(this).data("id");
				$("#container_modal").load("core/Alimentos/form_alimentos_u.php?id_alimento="+id_alimento);
			});		
		});
		/*IMPRIME LA CONSULTA SQL EN UNA TABLA QUE SE LLEVA ACABO EN EL CONTROLLER DE LOS ALIMENTOS*/
		function get_all()
		{
			$.post("core/Alimentos/controller_alimentos.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					if(info["cates"]==0){
						clase="ocupadoF";
					}else{
						if(info["alies"]==1){
						clase="libre";
						}else{
							clase="ocupado";
						}
					}	
					cod_html+="<tr class='"+clase+"'><td>"+info['descripcion']+"</td><td>$"+info['precio']+"</td><td>"+info['categoria']+"</td><td>"+info['existencia']+"</td><td><a class='btn btn-danger btn_eliminar' data-id='"+info["id_alimento"]+"'><span class='glyphicon glyphicon-minus'></span></a></td><td><a class='btn btn-warning btn_modificar' data-id='"+info["id_alimento"]+"'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Alimentos/controller_alimentos.php",{action:"buscar",consulta:consulta}, function(res)
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
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<nav class="navbar navbar-dafault">
		<?php
			require_once("menu.php");
		?>
	</nav>
	<!--SECCION EN LA CUAL ESTA LA TABLA EN LA CUAL SE IMPRIMEN LOS DATOS DE LA CONSULTA SQL-->
	<section class="container">
		
		<div class="panel panel-default">
			<div class="panel-body">
			<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar">
			</div>
				<div class="panel-heading text-center"><a class="btn btn-success" id="add_alimentos"  ><span class="glyphicon glyphicon-plus"></span></a>
					Alimentos
				</div>
				<div class="panel-body table-responsive">
					 <table class="table">
					 	<tr>
					 		<th>Descripcion</th>
					 		<th>Precio</th>
					 		<th>Categoria</th>
					 		<th>Existencias</th>
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
	<aside id="container_modal2">	
	</aside>
<div class="modal fade" id="Modal_confirm_deleteA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteA" value="Aceptar">
			</div>
		</div > 
	</div > 
</div >

	<aside id="container_modal2">
	</aside>
</body>
</html>