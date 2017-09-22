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
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.es.js"></script>

	

	<title>Consultas</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#cor").click(function(){
					$("#container_modal").load("core/Consultas/form_corte.php");
			});
			$("#Bvm").click(function(){
					$("#container_modal").load("core/Consultas/form_Bvm.php");
			});
			$("#Bvc").click(function(){
					$("#container_modal").load("core/Consultas/form_Bvc.php");
			});
			$("#Bcm").click(function(){
					$("#container_modal").load("core/Consultas/form_Bcm.php");
			});
			$("#Bcc").click(function(){
					$("#container_modal").load("core/Consultas/form_Bcc.php");
			});

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
		<div class="row" id="divp">
			<div class="container col-md-12 col-md-offset-0 panel panel-default" style="background:white;">
				<div class="col-md-12 col-md-offset-0" style="background: #F5F5F5;">
					<center><h1>Consultas</h1></center>	
				</div>

				<div class="col-md-4 cons panel-heading"><center><h3 class="panel-title">Bitacora de Corte de Caja</h3></center>
					<div class="panel-body">
						<a href="#!" id="cor" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="glyphicon glyphicon-search"></center></span></a>
					</div>
				</div>
				
				<div class="col-md-4 cons panel-heading"><center><h3 class="panel-title">Bitacora de Venta Modificada</h3></center>
					<div class="panel-body">
						<a href="#!" id="Bvm" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="glyphicon glyphicon-search"></center></span></a>
					</div>
				</div>
				
				<div class="col-md-4 cons panel-heading"><center><h3 class="panel-title">Bitacora de Venta Cancelada</h3></center>
					<div class="panel-body">
						<a href="#!" id="Bvc" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="glyphicon glyphicon-search"></center></span></a>
					</div>
				</div>
				<br><br><br><br><br><br><br>
				<div class="col-md-4 cons panel-heading"><center><h3 class="panel-title">Bitacora de Complementos Modificada</h3></center>
					<div class="panel-body">
						<a href="#!" id="Bcm" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="glyphicon glyphicon-search"></center></span></a>
					</div>
				</div>
				
				<div class="col-md-4 cons panel-heading"><center><h3 class="panel-title">Bitacora de Complementos Cancelada</h3></center>
					<div class="panel-body">
						<a href="#!" id="Bcc" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="glyphicon glyphicon-search"></center></span></a>
					</div>
				</div>

			</div>
		</div>
	</section>

	<aside id="container_modal">
		
	</aside>
</body>
</html>