	<nav class="navbar navbar-default" id="nav_p">
	<!-- MENU DE NAVEGACION DE LAS PAGINAS-->
	<div class="navbar-header">
	<a id="salirv" class="btn btn-info" href="index.php" >Salir</a>
	<!--MENU HAMBURGUESA PARA PANTALLAS PEQUEÑAS-->
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mi_primer_menu" aria-expanded="false"> 
			<span class="sr-only"></span> 
			<span class="icon-bar"></span> 
			<span class="icon-bar"></span> 
			<span class="icon-bar"></span> 
		</button>
	</div>
	<a class="navbar-brand" href="ventas.php">Sal si puedes</a>
	<!--NOMBRE DE LAS DIFERENTES SECCIONES DEL MENU DEL ADMINISTRADOR-->
	<div class="collapse navbar-collapse" id="mi_primer_menu_v">
		<ul class="nav navbar-nav">
			<li><a href="ventas.php">Ventas</a></li>
			<li><a href="consultas_v.php">Consultas</a></li>
		</ul>
	</div>
	</nav>
	<script>
		$("#salir").click(function()
		{
			$.post("core/Login/controller_login.php",{action:'destruir'},
				function()
				{

				});
		});

	</script>