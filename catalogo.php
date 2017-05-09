<?php

	$con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");

  mysqli_set_charset($con,"utf8");

  if (isset($_GET["cat"])) {
		$cat = $_GET["cat"];
	} else {
		$cat = 0;
	}

	$limit = 25 * $_GET["clicks"];

  if ($cat == 0) {
	   $consulta = "select * from productos limit $limit";
		 $consulta2 = "select count(*) as cuenta from productos";
   }
   else {
     $consulta = "select * from productos where categoria = $cat limit $limit";
		 $consulta2 = "select count(*) as cuenta from productos where categoria = $cat";
  }
	$resultado = $con->query($consulta);

	$lista = array(array());
	$i = 0;
	while ($datos = $resultado->fetch_assoc()) {
	    $lista[$i][0] = $datos["idproducto"];
	    $lista[$i][1] = $datos["nombre"];
	    $lista[$i][2] = $datos["categoria"];
		$lista[$i][3] = $datos["imagen"];
		$i++;
	}
	$resultado = $con->query($consulta2);
	$datos = $resultado->fetch_assoc();
	$total = array();
	$total[0] = $datos["cuenta"];
	$total[1] = $lista;

	echo json_encode($total);

?>
