<?php
if (session_status() == PHP_SESSION_NONE)
		 session_start();
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];
	else
		$usuario = "";
	$con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");

  mysqli_set_charset($con,"utf8");

	$cat = $_GET["cat"];
	$limit = 25 * $_GET["clicks"];
  if ($cat == "0") {
		$consulta="SELECT productos.idproducto, nombre, categoria, min(imagen) as imagen, count(idusuario) as cuenta from (productos LEFT JOIN (select * from favoritos where idusuario = '$usuario') a on productos.idproducto=a.idproducto) left join (select * from imagenes where imagen like '%_pequena%') b on productos.idproducto=b.idproducto group by idproducto limit $limit";
		 $consulta2 = "select count(*) as cuenta from productos";
   }
   else {
		 $consulta="SELECT productos.idproducto, nombre, categoria, min(imagen) as imagen, count(idusuario) as cuenta from (productos LEFT JOIN (select * from favoritos where idusuario = '$usuario') a on productos.idproducto=a.idproducto) left join (select * from imagenes where imagen like '%_pequena%') b on productos.idproducto=b.idproducto where categoria = '$cat' group by idproducto limit $limit";
		 $consulta2 = "select count(*) as cuenta from productos where categoria = '$cat'";
  }
	$resultado = $con->query($consulta);

	$lista = array(array());
	$i = 0;
	while ($datos = $resultado->fetch_assoc()) {
			$lista[$i][0] = $datos["idproducto"];
	    $lista[$i][1] = $datos["nombre"];
	    $lista[$i][2] = $datos["categoria"];
			$lista[$i][3] = $datos["imagen"];
			$lista[$i][4] = $datos["cuenta"];
			$i++;
	}
	$resultado = $con->query($consulta2);
	$datos = $resultado->fetch_assoc();
	$total = array();
	$total[0] = $datos["cuenta"];
	$total[1] = $lista;

	echo json_encode($total, JSON_UNESCAPED_UNICODE);

?>
