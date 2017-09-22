<?php
require_once("../conexion.php");
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select entradas.id_entrada,alimentos.descripcion,entradas.cantidad,entradas.precio_u,fecha from entradas,alimentos where alimentos.id_alimento=entradas.id_alimento;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			/*SE PARSEAN LOS DATOS YA QUE SON UNA MATRIZ*/
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "insert":
			$Ali=isset($_POST["Ali"])?$_POST["Ali"]:0;
			$Can=$_POST["Can"];
			$Pre=$_POST["Pre"];

			$sql="call AGREGAR_E('".$Ali."','".$Can."','".$Pre."');";
			$conexion->query($sql);
		break;		
		case "delete":
			$sql="delete from entradas where id_entrada='".$_POST["id_entrada"]."'";
			$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
		break;

		case "buscar":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select entradas.id_entrada,alimentos.descripcion,entradas.cantidad,entradas.precio_u from entradas,alimentos where alimentos.descripcion like '%".$c."%' and alimentos.id_alimento=entradas.id_alimento group by entradas.id_entrada;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['id_entrada']."</td><td>".$fila['descripcion']."</td><td>".$fila['cantidad']."</td><td>".$fila['precio_u']."</td><td><a class='btn btn-danger btn_eliminar' data-id='".$fila["id_entrada"]."'><span class='glyphicon glyphicon-minus'></span></a></td></tr>";
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