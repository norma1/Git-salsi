<?php

require_once("../conexion.php");

	
	switch ($_POST["action"]) 
	{	
		case "get_all_Corte":
			$sql="select id_bitacora, total_c,total_in,c_efectivo,c_credito,c_efectivo_i,c_credito_i,cantidad_i,desfase,fecha_corte,usuarios.nombre from bitacoracor , usuarios where usuarios.id_usuario=bitacoracor.id_usuario group by id_bitacora order by fecha_corte desc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;

		case "get_all_Bvm":
			$sql="select Bventas.id_ventaN as id_ventaN,Bventas.cantidadN as cantidadN,Bventas.cantidadO as cantidadO,alimentos.descripcion as id_alimentoN,alimentos.descripcion as id_alimentoO,locaciones.numero as id_locacionN,locaciones.numero as id_locacionO,subtotalN,subtotalO,fecha from alimentos,locaciones,Bventas,ventas where alimentos.id_alimento=Bventas.id_alimentoN and alimentos.id_alimento=Bventas.id_alimentoO and locaciones.id_locacion=Bventas.id_locacionN and locaciones.id_locacion=Bventas.id_locacionO and ventas.id_venta=Bventas.id_Bventa group by id_Bventa;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));	 
		break;

		case "buscar_Bvm":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select Bventas.id_ventaN as id_ventaN,Bventas.cantidadN as cantidadN,Bventas.cantidadO as cantidadO,alimentos.descripcion as id_alimentoN,alimentos.descripcion as id_alimentoO,locaciones.numero as id_locacionN,locaciones.numero as id_locacionO,subtotalN,subtotalO,fecha from alimentos,locaciones,Bventas,ventas where fecha like '%".$c."%' and alimentos.id_alimento=Bventas.id_alimentoN and alimentos.id_alimento=Bventas.id_alimentoO and locaciones.id_locacion=Bventas.id_locacionN and locaciones.id_locacion=Bventas.id_locacionO and ventas.id_venta=Bventas.id_Bventa group by id_Bventa;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['id_ventaN']."</td><td>".$fila['cantidadN']."</td><td>".$fila['cantidadO']."</td><td>".$fila['id_alimentoN']."</td><td>".$fila['id_alimentoO']."</td><td>".$fila['id_locacionN']."</td><td>".$fila['id_locacionO']."</td><td>".$fila['subtotalN']."</td><td>".$fila['subtotalO']."</td><td>".$fila['fecha']."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;

		case "get_all_Bvc":
			$sql="select BventasC.id_ventaN as id_ventaN,BventasC.cantidadN as cantidadN,alimentos.descripcion as id_alimentoN,BventasC.subtotalN as subtotalN,BventasC.id_locacionN as id_locacionN,BventasC.fecha as fecha from BventasC,alimentos,ventas,locaciones where ventas.id_venta=BventasC.id_BventasC and alimentos.id_alimento=BventasC.id_alimentoN and locaciones.id_locacion=BventasC.id_locacionN group by id_BventasC;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));	 
		break;
		case "buscar_Bvc":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select BventasC.id_ventaN as id_ventaN,BventasC.cantidadN as cantidadN,alimentos.descripcion as id_alimentoN,BventasC.subtotalN as subtotalN,BventasC.id_locacionN as id_locacionN,BventasC.fecha as fecha from BventasC,alimentos,ventas,locaciones where fecha like '%".$c."%' and ventas.id_venta=BventasC.id_BventasC and alimentos.id_alimento=BventasC.id_alimentoN and locaciones.id_locacion=BventasC.id_locacionN group by id_BventasC;
";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['id_ventaN']."</td><td>".$fila['cantidadN']."</td><td>".$fila['id_alimentoN']."</td><td>".$fila['subtotalN']."</td><td>".$fila['id_locacionN']."</td><td>".$fila['fecha']."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;
		case "get_all_Bcm":
				$sql="select * from Bcom;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));	
		break;
		case "buscar_Bcm":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select *from Bcom where fecha like '%".$c."%' group by id_Bcom;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['id_complementoN']."</td><td>".$fila['descripcionN']."</td><td>".$fila['descripcionO']."</td><td>".$fila['precioN']."</td><td>".$fila['precioO']."</td><td>".$fila['cantidadN']."</td><td>".$fila["cantidadO"]."</td><td>".$fila["subtotalN"]."</td><td>".$fila["subtotalO"]."</td><td>".$fila["fecha"]."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;
		case "get_all_Bcc":
				$sql="select * from BcomC;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));	
		break;
		case "buscar_Bcc":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select * from BcomC where fecha like '%".$c."%' group by id_BcomC;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['id_complementoN']."</td><td>".$fila['id_locacion']."</td><td>".$fila['descripcion']."</td><td>".$fila['precio']."</td><td>".$fila['cantidad']."</td><td>".$fila['subtotal']."</td><td>".$fila['fecha']."</td></tr>";
				}
			}
			else
			{
				$valor.="<br><div class='alert alert-warning col-md-12'><h4>No hay datos que coincidan con los criterios de busqueda.</h4></div>";
			}
			echo $valor;
		break;
	}
	$conexion->close();
?>