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
	<title>Locaciones</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_tl();
			$("#cont_nav_tabs").on("click", "li a",function(){
				var id=$(this).data("id");
				get_all(id);
			});
//////////////////////////////AGREGAR LOCACIONES//////////////////////////////////////////			
			$("#cont_info_nav_tabs").on("click","div div div a.button_add",function()
			{
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_modal").load("core/Locaciones/form_locaciones.php?id_tipo_l="+id_tipo_l);
			});
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////ELIMINAR LOCACION///////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_eliminar",function(){
				$("#btn_confirm_deleteL").data("id",$(this).data("id"));
				$("#btn_confirm_deleteL").data("id_tipo_l",$(this).data("id_tipo_l"));

				$("#Modal_confirm_deleteL").modal();
			});

			$("#btn_confirm_deleteL").click(function(event){
				var id_locacion=$(this).data("id");
				var id=$(this).data("id_tipo_l");
				$.post("core/Locaciones/controller_locaciones.php",{action:'delete',id_locacion:id_locacion},
					function(){
						get_all(id);
						$("#Modal_confirm_deleteL").modal("hide");
					});
			});
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////MODIFICAR LOCACION////////////////////////////////////			
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_modificar",function(){
				var id_locacion=$(this).data("id");
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_modal").load("core/Locaciones/form_locaciones_u.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l);
			});

		});
///////////////////////////////////////////////////////////////////////////////////////
		function get_all(id_tipo_l)
		{
			$.post("core/Locaciones/controller_locaciones.php",{action:"get_all","id_tipo_l":id_tipo_l},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					if(info["estado"]==1){
							clase="libre";
						}
						else{
							clase="fueraser";
						}
					    cod_html+="<center><div id='div_loc' class='"+clase+" col-md-4' style='margin-left:10%;'><br/><label>Numero de locacion:"+info["numero"]+"<br>Locacion: "+info["descripcion"]+"<center></label><div id='btn_div'>  <a href='#!' style='padding: 18px 27px;' class='btn btn-warning btn_modificar' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> <a href='#!' style='padding: 18px 27px' class='btn btn-danger btn_eliminar' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-minus' aria-hidden='true'></span></a></div></center></div></center>";
						
				}
				$("#content_tab"+id_tipo_l).html(cod_html);		
			});
		}
/////////////////////////////////////////////////////////////////////////////////////////////
		function get_tl()
		{
			$.post("core/Tipos_locaciones/controller_t_l.php",{action:"get_all"},
				function(res)
				{
					var datos=JSON.parse(res);
					var cod_title="";
					var cod_cont="";
					for (var i=0;i<datos.length;i++)
					{
						var info=datos[i];
						cod_title+="<li><a data-toggle='tab' data-id='"+info["id_tipo_l"]+"' href='#target"+info["id_tipo_l"]+"'>"+info["descripcion"]+"</a><li>";

						cod_cont+="<div id='target"+info["id_tipo_l"]+"'class=tab-pane fade><div class='panel panel-default'><div class='panel-heading text-center'>Seccion de "+info["descripcion"]+"<a href='#!' class='button_add btn btn-success' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-plus'></span></a> </div><div class='panel-body' id='content_tab"+info["id_tipo_l"]+"'></div></div></div>";
					}
					$("#cont_nav_tabs").html(cod_title);
					$("#cont_info_nav_tabs").html(cod_cont);

				$('#cont_nav_tabs.nav-tabs a:first').tab('show');
				get_all($('#cont_nav_tabs.nav-tabs a:first').data("id"));	
				});
		}
//////////////////////////////////////////////////////////////////////////////////////////////
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
		<ul id="cont_nav_tabs" class="nav nav-tabs" style="background: #F5F5F5;">
			
		</ul>
			
		<div class="tab-content" id="cont_info_nav_tabs">
			
		</div>	
	</section>

	<aside id="container_modal">
	</aside>

	<aside id="container_modal2l">
	</aside>


	<div class="modal fade" id="Modal_confirm_deleteL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
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
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteL" value="Aceptar">

		</div > 
	</div > 
</div >

</body>
</html>