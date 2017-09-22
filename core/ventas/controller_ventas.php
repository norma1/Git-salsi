<?php session_start();
require_once("../conexion.php");

	$id_usuario=$_SESSION['id_usuario'];
	
	switch ($_POST["action"]) 
	{
		case "get_all":
			
			$id_tipo_l=$_POST["id_tipo_l"];
			$sql="select locaciones.id_locacion,locaciones.numero,tipos_l.descripcion,tipos_l.id_tipo_l,locaciones.id_ticket,locaciones.estado from locaciones,tipos_l where locaciones.estado >0 and locaciones.estado<3 and locaciones.id_tipo_l=tipos_l.id_tipo_l and tipos_l.id_tipo_l='".$id_tipo_l."' group by id_locacion,id_tipo_l;";

			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));			
		break;

		case "get_all_ven":
			$id_locacion=$_POST["id_locacion"];
			$sql="select id_venta,cantidad,alimentos.descripcion,locaciones.numero,subtotal,ventas.id_locacion,ventas.id_alimento from ventas,alimentos,locaciones where alimentos.id_alimento=ventas.id_alimento and locaciones.id_locacion=ventas.id_locacion and ventas.estado=1 and ventas.estado=1 and ventas.id_locacion='".$id_locacion."';";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_all_comple":
			$id_locacion=$_POST["id_locacion"];
			$sql=" select id_complemento,locaciones.numero,descripcion,precio,cantidad,subtotal,complementos.id_locacion from complementos,locaciones where locaciones.id_locacion=complementos.id_locacion and  complementos.estado=1 and complementos.id_locacion='".$id_locacion."';";
			$result=$conexion->query($sql);
			$datos=array();
			while ($row=$result->fetch_array())
				$datos[]=$row;
			//print_r($datos);
			print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "reserva":
				$sql="CALL RESERVA_C('".$_POST["id_locacion"]."');";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "cuenta":
				
			$sqlp="select subtotal from tickets where id_ticket='".$_POST["id_ticket"]."';";
				$resultado=$conexion->query($sqlp)or trigger_error($conexion->error."[$sqlp]");
				$datosp=array();
				while($rowp=$resultado->fetch_array())
				$datosp[]=$rowp;
				print_r(json_encode($datosp));
	
		break;

		case "call_p":
				$MP=isset($_POST["MP"])?$_POST["MP"]:0;
				$DES=isset($_POST["DES"])?$_POST["DES"]:0;
				$EMP=isset($_POST["EMP"])?$_POST["EMP"]:0;
				$CAN=$_POST["CAN"];

				$sql="CALL PAGO_TICKET('".$_POST["id_ticket"]."','".$DES."','".$MP."','".$CAN."','".$EMP."')";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
				
		break;
		
		case "CORTE":
			$Can=$_POST["Can"];
			$CanE=$_POST["CanE"];
			$CanD=$_POST["CanD"];
			$sql="CALL CIERRE_S('".$id_usuario."','".$Can."','".$CanE."','".$CanD."');";
			$resultado=$conexion->query($sql);
			$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

		break;
		

		case "AGREGARV":
				$Cat=isset($_POST["Cat"])?$_POST["Cat"]:0;
				$Ali=isset($_POST["Ali"])?$_POST["Ali"]:0;
				$Can=$_POST["Can"];
				$sql="CALL AGREGAR_V('".$Can."','".$Ali."','".$_POST["id_locacion"]."','".$id_usuario."')";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_one_v":
				$sql="select ventas.cantidad from ventas where id_venta='".$_POST["id_venta"]."';";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
					$datos[]=$row;
				print_r(json_encode($datos));
		break;

		case "cancelar_v":

				$Can=$_POST["Can"];
				$sql="CALL CAN_V('".$_POST["id_venta"]."','".$_POST["id_alimento"]."','".$_POST["id_locacion"]."','".$Can."');";
				$resultado=$conexion->query($sql);
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "AGREGARC":
				$DES=$_POST["DES"];
				$PRE=$_POST["PRE"];
				$CAN=$_POST["CAN"];

				$sql="CALL AGREGAR_C('".$_POST["id_locacion"]."','".$DES."','".$PRE."','".$CAN."','".$id_usuario."');";
				$resultado=$conexion->query($sql) or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;

		case "get_one_c":
				$sql="select cantidad from complementos where id_complemento='".$_POST["id_complemento"]."';";
				$result=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$result->fetch_array())
					$datos[]=$row;
				print_r(json_encode($datos));
		break;

		case "cancelar_com":

				$CAN=$_POST["CAN"];
				$sql="CALL CAN_C('".$_POST["id_complemento"]."','".$_POST["id_locacion"]."','".$CAN."','".$id_usuario."');";
				$resultado=$conexion->query($sql)or trigger_error($conexion->error."[$sql]");
				$datos=array();
				while($row=$resultado->fetch_array())
				$datos[]=$row;
				print_r(json_encode($datos,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		break;
	}
	$conexion->close();
?>