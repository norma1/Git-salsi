<nav class="sidenav align-center" id="nav_p" style="padding-left: 1em;padding-right: 1em;">
	<div>
		<ul>
			<li style="float: left; margin-right: 10%"><a id="salir" class="waves-effect waves-teal" href="index.php">Salir</a></li>		<!-- Dropdown Trigger -->
			<li style="float: center">
				<a class="dropdown-button" data-activates='dropdown2'>Control de alimentos</a>
				<ul id="dropdown2" class="dropdown-content">
					<li><a href="alimentos.php">Alimentos</a></li>
					<li><a href="Existencias.php">Surtido</a></li>
				   	<li><a href="categorias.php">Categoria de Alimentos</a></li>
				</ul>
			</li>
			<li style="float: center"> 
				<a class="dropdown-button" data-activates='dropdown3'>Control Locacional</a>
				<ul id="dropdown3" class="dropdown-content">
					<li><a href="locaciones.php">Locaciones</a></li>
					<li><a href="tipos_locacion.php">Tipos de Locaciones</a></li>
				</ul>
			</li>
			<li style="float: center">
				<a class="dropdown-button" data-activates='dropdown4'>Control Administrativo</a>
				<ul id="dropdown4" class="dropdown-content">
					<li><a href="usuarios.php">Usuarios</a></li>
					<li><a href="empleados.php">Empleados</a></li>
					<li><a href="metodos_pago.php">Metodos de Pago</a></li>
					<li><a href="descuentos.php">Descuentos</a></li>	
					<li><a href="consultas.php">Consultas</a></li>
				</ul>
			</li>	
			<li style="float: right;">
				<div class="row">
					<div  class="col s0 m1 l2">
						<a href="alimentos.php">
						<img src="img/logo.png" width="100px" style="margin-bottom: -1em">
						</a>
					</div>
				</div>
				
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
		$(".dropdown-button").dropdown({
	      inDuration: 300,
	      outDuration: 225,
	      constrainWidth: false, // Does not change width of dropdown to that of the activator
	      hover: true, // Activate on hover
	      gutter: 0, // Spacing from edge
	      belowOrigin: false, // Displays dropdown below the button
	      alignment: 'left', // Displays dropdown with edge aligned to the left of button
	      stopPropagation: false // Stops event propagation
	    }
	  	);

	</script>
	<style type="text/css">
		.dropdown-content {
   			overflow-y: visible;
   			border-radius: 3px;
   			margin-top: 4em;
		}
		.dropdown-content li a{
			color: black;
		}
	</style>