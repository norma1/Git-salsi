<?php
	$conexion=new mysqli("localhost","root","Puchito56","salsi");
	if ($conexion->connect_errno) 
	{
		echo "no se pudo";
		exit();
	}
	$conexion->set_charset("utf8");
	//else
	//	echo "si se pudo";
	

?>