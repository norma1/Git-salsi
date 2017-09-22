<nav class="navbar navbar-default" id="nav_p">
	<div class="navbar-header">
		<a id="salir" class="btn btn-info" href="index.php" >Salir</a>

		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mi_primer_menu" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="alimentos.php">Sal si puedes</a>
	</div >
	<div class="collapse navbar-collapse" >
		<ul class="nav navbar-nav" id="mi_primer_menu">

			<li class="dropdown">
				<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-hanspopup="true" aria-expanded="false">Control de alimentos<span class="caret"></span></a>
				<ul class="dropdown-menu">
				  <li><a href="alimentos.php">Alimentos</a></li>
				  <li><a href="Existencias.php">Surtido</a></li>
			   	  <li><a href="categorias.php">Categoria de Alimentos</a></li>
				</ul>
			</li>

			<li class="dropdown">
				<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-hanspopup="true" aria-expanded="false">Control Locacional<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="locaciones.php">Locaciones</a></li>
					<li><a href="tipos_locacion.php">Tipos de Locaciones</a></li>
				</ul>
			</li>

			<li class="dropdown">
				<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-hanspopup="true" aria-expanded="false">Control Administrativo<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="usuarios.php">Usuarios</a></li>
					<li><a href="empleados.php">Empleados</a></li>
					<li><a href="metodos_pago.php">Metodos de Pago</a></li>
					<li><a href="descuentos.php">Descuentos</a></li>								 <li><a href="consultas.php">Consultas</a></li>
				</ul>
			</li>		
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