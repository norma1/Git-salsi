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
	<title>Locaciones</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			get_tl();
			$("#cont_nav_tabs").on("click", "li a",function(){
				var id=$(this).data("id");
				get_all(id);
			});
//////////////////////////////Bloquear//////////////////////////////////////////			
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_reservar",function(){
				
				$("#btn_confirm_deleteL").data("id",$(this).data("id"));
				$("#btn_confirm_deleteL").data("id_tipo_l",$(this).data("id_tipo_l"));

				$("#Modal_confirm_deleteL").modal();

				
			});

			$("#btn_confirm_deleteL").click(function(event){
				var id_locacion=$(this).data("id");
				var id=$(this).data("id_tipo_l");
				$.post("core/ventas/controller_ventas.php",{action:'reserva',
				id_locacion:id_locacion},
				function(res){
					var datos=JSON.parse(res);
					var info=datos[0];
					alert(info[0]);
					get_all(id);
					$("#Modal_confirm_deleteL").modal("hide");
				});
			});
			
/////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////Pagar////////////////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_pagar",function(){
				var id_ticket=$(this).data("id_ticket");
				var id_tipo_l=$(this).data("id_tipo_l");
				var id_locacion=$(this).data("id");
				$("#container_v").load("core/ventas/form_pago.php?id_ticket="+id_ticket+"&id_tipo_l="+id_tipo_l+"&id_locacion="+id_locacion);
				
			});
////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////modal ventas////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_venta",function(){
				var id_locacion=$(this).data("id");
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_v").load("core/ventas/window_venta.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l);
			});
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////modal ventas_c////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div div a.btn_comple",function(){
				var id_locacion=$(this).data("id");
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_v").load("core/ventas/window_complementos.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l);
			});
//////////////////////////////////////////Form corte/////////////////////////////////////////
			$("#cont_info_nav_tabs").on("click","div div div a.button_cort",function(){
				$("#container_v").load("core/ventas/form_corte.php");
			});
///////////////////////////////////////////////////////////////////////////////////////

////////////////////////////ELIMINAR LOCACION///////////////////////////////////////////
			/*$("#cont_info_nav_tabs").on("click","div div div div a.btn_reservar",function(){
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
			});*/
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////MODIFICAR LOCACION////////////////////////////////////			
			/*$("#cont_info_nav_tabs").on("click","div div div div a.btn_modificar",function(){
				var id_locacion=$(this).data("id");
				var id_tipo_l=$(this).data("id_tipo_l");

				$("#container_modal").load("core/Locaciones/form_locaciones_u.php?id_locacion="+id_locacion+"&id_tipo_l="+id_tipo_l);
			});*/
});
///////////////////////////////////////////////////////////////////////////////////////
		function get_all(id_tipo_l)
		{
			$.post("core/ventas/controller_ventas.php",{action:"get_all","id_tipo_l":id_tipo_l},
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

						cod_html+="<div id='div_loc_v' class='"+clase+" col-md-4' style='margin-left:2.5%;'><br/><label>"+info["numero"]+"<br>Locacion: "+info["descripcion"]+"<center></label><div id='btn_div'>  <a href='#!' style='padding: 18px 27px;' class='btn btn-warning btn_comple' title='Menu de ventas fuera de catalogo' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-cutlery' aria-hidden='true'></span></a><a href='#!' style='padding: 18px 27px' class='btn btn-primary btn_venta' title='Menu de ventas de catalogo' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-cutlery' aria-hidden='true'></span></a><a href='#!' style='padding: 18px 27px' class='btn btn-success btn_pagar' title='Boton para cobrar cuenta de la locacion' data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"' data-id_ticket='"+info["id_ticket"]+"'><span class='glyphicon glyphicon' aria-hidden='true'>$</span></a><a href='#!' style='padding: 18px 27px' title='Boton para reservar' class='btn btn-info btn_reservar'  data-id='"+info["id_locacion"]+"' data-id_tipo_l='"+info["id_tipo_l"]+"'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span></a></div></center></div>";
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
						var clase="";

						

						cod_title+="<li class=''><a data-toggle='tab' data-id='"+info["id_tipo_l"]+"' href='#target"+info["id_tipo_l"]+"'>"+info["descripcion"]+"</a><li>";

						cod_cont+="<div id='target"+info["id_tipo_l"]+"'class='tab-pane fade'><div class='panel panel-default'><div class='panel-heading text-center'>Seccion de "+info["descripcion"]+"<a href='#!' class='button_cort btn btn-success'><span class='glyphicon glyphicon-book'></span></a></div> <div class='panel-body' id='content_tab"+info["id_tipo_l"]+"'></div></div></div>";
					}
					$("#cont_nav_tabs").html(cod_title);
					$("#cont_info_nav_tabs").html(cod_cont);

	$('#cont_nav_tabs.nav-tabs a:first').tab('show');
	get_all($('#cont_nav_tabs.nav-tabs a:first').data("id"));
//	console.log($('#cont_nav_tabs.nav-tabs a:first').html());
				});
		}
//////////////////////////////////////////////////////////////////////////////////////////////
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu_v.php");
		?>
	</div>
	
	<section class="container">
		<ul id="cont_nav_tabs" class="nav nav-tabs" style="background: #F5F5F5;">
			
		</ul>
			
		<div class="tab-content" id="cont_info_nav_tabs" >
			
		</div>	
	</section>

	<aside id="container_v">
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
				 Seguro que desea realizar esta reservacion		
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> 
			<input  type="button" class="btn btn-primary" id="btn_confirm_deleteL" value="Aceptar">

		</div > 
	</div > 
</div >


</body>
</html>