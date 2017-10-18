<?php session_start();
require_once("../conexion.php");

	$id_usuario=$_SESSION['id_usuario'];
	switch ($_POST["action"]) 
	{	/*SE CREA LA SENTENCIA SQL PARA CONSULTAR*/
		case "get_all":
			$sql="select alimentos.id_alimento,alimentos.descripcion,alimentos.precio,categorias_a.descripcion categoria,alimentos.estado as alies,categorias_a.estado as cates,alimentos.existencia from alimentos,categorias_a WHERE alimentos.id_categoria_a=categorias_a.id_categoria_a order by descripcion asc;";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
		case "get_all_id":

				$id_categoria_a=$_POST["id_categoria_a"];
				$sql="select * from alimentos where id_categoria_a='".$id_categoria_a."' and estado=1 order by descripcion asc;";
				$result=$conexion->query($sql);
				$dat=array();
				while($row=$result->fetch_array())
					$dat[]=$row;
				print_r(json_encode($dat,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "insert":
			$Des=$_POST["Des"];
			$Pre=$_POST["Pre"];
			$Cat=isset($_POST["Cat"])?$_POST["Cat"]:0;

			$sql="insert into alimentos values (null,'".$Des."','".$Pre."','".$Cat."',0,'1')";
			$conexion->query($sql);
		break;		

		case "delete":
			$sql="delete from alimentos where id_alimento='".$_POST["id_alimento"]."'";
			$conexion->query($sql);
		break;

		case "update":
			$Des=$_POST["Des"];
			$Pre=$_POST["Pre"];
			$Cat=$_POST["Cat"];
			$Est=isset($_POST["Est"])?$_POST["Est"]:0;

			$sql="update alimentos set descripcion='".$Des."',precio='".$Pre."',id_categoria_a='".$Cat."',estado='".$Est."' where id_alimento='".$_POST['id_alimento']."'";
			$result=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
		break;

		case "get_one":
			$sql="select *from alimentos where id_alimento='".$_POST["id_alimento"]."';";
			$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
			$datos=array();
			while($row=$result->fetch_array())
				$datos[]=$row;
			print_r(json_encode($datos));
		break;

		case "buscar":
			$valor='';
			if(isset($_POST['consulta']))
			{
				$c=$conexion->real_escape_string($_POST['consulta']);
				$sql="select alimentos.id_alimento,alimentos.descripcion,alimentos.precio,categorias_a.descripcion categoria,alimentos.estado as alies,categorias_a.estado as cates,alimentos.existencia from alimentos,categorias_a WHERE categorias_a.descripcion like '%".$c."%' and alimentos.id_categoria_a=categorias_a.id_categoria_a order by descripcion asc;";
			}
			$rest=$conexion->query($sql);
			if ($rest->num_rows >0)
			{
				while ($fila=$rest->fetch_assoc())
				{
					$valor.="<tr><td>".$fila['descripcion']."</td><td>".$fila['precio']."</td><td>".$fila['categoria']."</td><td>".$fila['existencia']."</td><td><a class='btn btn-danger btn_eliminar' data-id='".$fila["id_alimento"]."'><span class='glyphicon glyphicon-minus'></span></a></td><td>".$fila['existencia']."</td><td><a class='btn btn-warning btn_modificar' data-id='".$fila["id_alimento"]."'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>";
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