<?php
	require_once('../mpdf/mpdf.php');
	require_once("../conexion.php");
 
   $loc=json_decode($_GET["loc"]);
   $tic=json_decode($_GET["tic"]);


	$sqlp="select subtotal from tickets where id_ticket='".$tic."';";
  $result=$conexion->query($sqlp);
      $datosd=array();
      while ($row=$result->fetch_array()) 
      {
        $datosd[]=$row;
      }
    
  $sqlt="select alimentos.descripcion,alimentos.precio,ventas.cantidad,ventas.subtotal from alimentos,ventas,locaciones where alimentos.id_alimento=ventas.id_alimento and ventas.id_locacion=locaciones.id_locacion and ventas.id_locacion='".$loc."' and locaciones.id_ticket='".$tic."' and ventas.estado=1 union select descripcion,precio,cantidad,subtotal from complementos,locaciones where complementos.id_locacion=locaciones.id_locacion and complementos.id_locacion='".$loc."' and locaciones.id_ticket='".$tic."' and complementos.estado=1";
  $result=$conexion->query($sqlt);
      $datosb=array();
      while ($row=$result->fetch_array()) 
      {
        $datosb[]=$row;
      }
    $conexion->close(); 
	$html.='<body>

    <header class="clearfix">
      <div id="logo" class="text-center">
        <img src="../../img/logo.png" width="40%" class="img-rounded">
      </div>
      <br>
      <br>
      <h1 class="text-center" style="background:#D3D3D3;">SNACK BAR SAL SI PUEDES</h1>
      <div class="clearfix">
      <br>
      <br>
    		<h3 class="text-center" style="background:#F5F5F5;">TICKET</h3>
      </div>
      
    </header>
    <main>
    <div class="panel-body table-responsive">
    <br>
    <br>
    <br>
      <table class="table table-bordered">
       
          <tr>
            <th>Productos</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        
        <tbody>';
        foreach ($datosb as $datosb) 
        {
        	$html.='<tr ><td>'.$datosb['descripcion'].'</td><td>'.$datosb['precio'].'</td><td>'.$datosb['cantidad'].'</td><td>'.$datosb['subtotal'].'</td><tr>';
        }
    $html.='</tbody>
      </table>
      <div id="project">';
      foreach ($datosd as $datosd) 
        {
          $html.='<tr><strong>Total:</strong> '.$datosd["subtotal"].' ';
        }
    $html.='</div>
    </main>
    </div>
    <footer  style="text-align: center; padding: 1em; margin: 1em 0em; top:90%; position:absolute; width:92%; background-color: #ecf0f1">
            TESVB POWER BY PROGRAMMING
    </footer>
  </body>';

	$mpdf=new mPDF('c','A4');
  $css= file_get_contents('../../css/bootstrap.css');
	$mpdf->writeHTML($css, 1);
	$mpdf->writeHTML($html);
  $mpdf->Output('ticket.pdf','I');
?>