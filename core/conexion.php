<?php
	$conexion=new mysqli("localhost","root","","salsi");
	if ($conexion->connect_errno) 
	{
		echo "no se pudo";
		exit();
	}
	$conexion->set_charset("utf8");
	//else
	//	echo "si se pudo";
	

?>