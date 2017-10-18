<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Alimentos</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_all();
			$("#add_alimentos").click(function()
			{
				$("#container_modal").load("core/Alimentos/form_alimentos.php");
			});
			$("#canci").click(function(){
				$("#Modal_confirm_deleteA").modal('close');
			});


//////////////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteA").modal();
				$("#Modal_confirm_deleteA").modal('open');
				$("#btn_confirm_deleteA").data("id",$(this).data("id"));
			});

			$("#btn_confirm_deleteA").click(function(event){
				var id_alimento=$(this).data("id");
				$.post("core/Alimentos/controller_alimentos.php",{action:'delete',id_alimento:id_alimento},
					function(){
						get_all();
						$("#Modal_confirm_deleteA").modal('close');
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
					cod_html+="<tr class='"+clase+"'><td>"+info['descripcion']+"</td><td>$"+info['precio']+"</td><td>"+info['categoria']+"</td><td>"+info['existencia']+"</td><td class='centrado'><a class='waves-effect btn-flat btn_eliminar' data-id='"+info["id_alimento"]+"' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td><td class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='"+info["id_alimento"]+"' style='color: #1976d2'><span class='material-icons'  style='margin-top: 0.2em'>edit</span></a></td></tr>";
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
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu.php");
		?>
	</div>
	<!--SECCION EN LA CUAL ESTA LA TABLA EN LA CUAL SE IMPRIMEN LOS DATOS DE LA CONSULTA SQL-->
	<section class="container">
		
		<div class="card-panel z-depth-3 grey lighten-2">
			<div class="container">
				<div class="input-field align-center">
					<input type="text" id="busc" name="busc"  placeholder="Buscar">
					<label for="busc">Buscar</label>
				</div>
				<div class="text-center">
					<a class="waves-effect waves-teal btn green modal-trigger" style="width: 2em;height: 2em;padding: 0.2em;float: right;" href="#container_modal"  id="add_alimentos"><span class="material-icons">add</span></a>
				<h4>Alimentos</h4>
				</div>
				<div class="panel">
					 <table class="table responsive-table bordered">
					 	<tr>
					 		<th>Descripcion</th>
					 		<th>Precio</th>
					 		<th>Categoria</th>
					 		<th>Existencias</th>
					 		<th class='centrado'>Eliminar</th>
					 		<th class='centrado'>Editar</th>
					 	</tr>
					 	<tbody id="content_table"></tbody>
					 	
					 </table>
				</div>	
		</div>

	</section>
	<div id="container_modal" class="modal">
  	</div>

	<div id="container_modal2" class="modal">
  	</div>

<div class="modal fade" id="Modal_confirm_deleteA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >

			<div class="modal-body">
				 Seguro que desea eliminar el registro		
			</div>

			<div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal" id="canci">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteA" value="Aceptar">
			</div>
		</div > 
	</div > 
</div >

	<aside id="container_modal2">
	</aside>
</body>
<style type="text/css">
	table tr:hover
	{
		background-color: lightgray;
	}
	table .centrado
	{
		text-align: center;
	}
	table tr td
	{
		padding: 0em;
	}
</style>	
</html>