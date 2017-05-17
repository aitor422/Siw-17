<?php
if (session_status() == PHP_SESSION_NONE)
		 session_start();
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];
	else
		$usuario = "";
	$con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");

  mysqli_set_charset($con,"utf8");

  if (isset($_GET["comienzo"])) {
	  $comienzo = $_GET["comienzo"];
  } else {
	  $comienzo = "";
  }
  if (isset($_GET["cat"])) {
	  $cat = $_GET["cat"];
  } else {
	  $cat = "0";
  }
  if (isset($_GET["orden"])) {
	  $orden = $_GET["orden"];
  } else {
	  $orden = "nombre";
  }
  if (isset($_GET["clicks"])) {
	  $limit =25 *  $_GET["clicks"];
  } else {
	  $limit= 25;
  }
  if ($cat == "0") {
		$consulta="SELECT final_productos.idproducto, nombre, categoria, min(imagen) as imagen, count(idusuario) as cuenta from (final_productos LEFT JOIN (select * from final_favoritos where idusuario = '$usuario') a on final_productos.idproducto=a.idproducto) left join (select * from final_imagenes where imagen like '%_pequena%') b on final_productos.idproducto=b.idproducto where nombre like '$comienzo%' group by idproducto";
		 $consulta2 = "select count(*) as cuenta from final_productos where nombre like '$comienzo%'";
   }
   else {
		 $consulta="SELECT final_productos.idproducto, nombre, categoria, min(imagen) as imagen, count(idusuario) as cuenta from (final_productos LEFT JOIN (select * from final_favoritos where idusuario = '$usuario') a on final_productos.idproducto=a.idproducto) left join (select * from final_imagenes where imagen like '%_pequena%') b on final_productos.idproducto=b.idproducto where categoria = '$cat' and nombre like '$comienzo%' group by idproducto";
		 $consulta2 = "select count(*) as cuenta from final_productos where categoria = '$cat' and nombre like '$comienzo%'";
  }
switch ($orden) {
	case 'nombre':
		$consulta = $consulta . " ORDER BY $orden";
		break;
	case 'precioup':
		$consulta = $consulta . " ORDER BY precio";
		break;
	case 'preciodown':
		$consulta = $consulta . " ORDER BY precio DESC";
		break;

	default:
		$consulta = $consulta . " ORDER BY $orden";
		break;
}
  $consulta = $consulta . " LIMIT $limit";
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
