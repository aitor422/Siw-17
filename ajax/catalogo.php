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
	  $comienzo=$comienzo.'%';
  } else {
	  $comienzo = "%";
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
		$consulta="SELECT final_productos.idproducto, nombre, categoria, min(imagen) as imagen, count(idusuario) as cuenta, destacado from (final_productos LEFT JOIN (select * from final_favoritos where idusuario = ?) a on final_productos.idproducto=a.idproducto) left join (select * from final_imagenes where imagen like '%_pequena%') b on final_productos.idproducto=b.idproducto where nombre like ? group by idproducto";
		$consulta2="SELECT count(final_productos.idproducto) from final_productos where nombre like ?";
   }
   else {
		 $consulta="SELECT final_productos.idproducto, nombre, categoria, min(imagen) as imagen, count(idusuario) as cuenta, destacado from (final_productos LEFT JOIN (select * from final_favoritos where idusuario = ?) a on final_productos.idproducto=a.idproducto) left join (select * from final_imagenes where imagen like '%_pequena%') b on final_productos.idproducto=b.idproducto where categoria like ? and nombre like ? group by idproducto";
		 $consulta2="SELECT count(final_productos.idproducto) from final_productos where nombre like ? AND categoria like ?";
  }
switch ($orden) {
	case 'precioup':
		$consulta = $consulta . " ORDER BY precio";
		break;
	case 'preciodown':
		$consulta = $consulta . " ORDER BY precio DESC";
		break;
	case 'destacado':
		$consulta = $consulta . " ORDER BY destacado DESC";
		break;
	default:
		$consulta = $consulta . " ORDER BY $orden";
		break;
}
  	$consulta = $consulta . " LIMIT $limit";
  	$stmt = $con->prepare($consulta);
	if ($cat == "0") {
  		$stmt->bind_param("ss", $usuario,$comienzo);
	}else{
		$stmt->bind_param("sss", $usuario,$cat,$comienzo);
	}
  	$stmt->execute();
  	$stmt->bind_result($idproducto, $nombre, $categoria, $imagen, $cuenta, $destacado);
	$filas = $stmt->num_rows;
	$lista = array(array());
	$i = 0;
	while ($stmt->fetch()) {
			$lista[$i][0] = $idproducto;
		    	$lista[$i][1] = $nombre;
		    	$lista[$i][2] = $categoria;
			$lista[$i][3] = $imagen;
			$lista[$i][4] = $cuenta;
			$lista[$i][5] = $destacado;
			$i++;
	}
	$stmt = $con->prepare($consulta2);
	if ($cat == "0") {
  		$stmt->bind_param("s",$comienzo);
	}else{
		$stmt->bind_param("ss",$comienzo,$cat);
	}
	$stmt->execute();
	$stmt->bind_result($cuenta);
	$stmt->fetch();
	$total = array();
	$total[0] = $cuenta;
	$total[1] = $lista;
	echo json_encode($total, JSON_UNESCAPED_UNICODE);

?>
