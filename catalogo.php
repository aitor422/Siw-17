<?php

	$con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");

  mysqli_set_charset($con,"utf8");

  if (isset($_GET["numreg"])) {
		$numreg = $_GET["numreg"];
	} else {
		$numreg = 0;
	}
  if (isset($_GET["cat"])) {
		$cat = $_GET["cat"];
	} else {
		$cat = 0;
	}

  if ($cat == 0) {
	   $consulta = "select * from productos limit $numreg";
   }
   else {
     $consulta = "select * from productos where categoria = $cat limit $numreg";
  }
	$resultado = $con->query($consulta);

	$lista = array(array());
	$i = 0;
	while ($datos = $resultado->fetch_assoc()) {
    $lista[$i][0] = $datos["idproducto"];
    $lista[$i][1] = $datos["nombre"];
    $lista[$i][2] = $datos["categoria"];
		$i++;
	}

	echo json_encode($lista);

?>
