<?php


if (session_status() == PHP_SESSION_NONE)
		 session_start();

include ("modelo.php");
include ("vista.php");


function selectorcategorias() { // obtener las categorias para los selectores
	$resultado = mObtenerCategorias();
	$selectores = "";
	while ($datos = $resultado->fetch_assoc()) {
		if ($datos["categoria"] != "") {
			$selectores = $selectores . "<option value='" . $datos["categoria"] . "'>". $datos["categoria"] ."</option>";
		}
	}
	return $selectores;
}

if (isset($_GET["accion"])) {
	$accion = $_GET["accion"];
}
else {
	if (isset($_POST["accion"])) {
		$accion = $_POST["accion"];
	} else {
		$accion = "index";
	}
}

if (isset($_GET["id"])) {
	$id = $_GET["id"];
}
else {
	if (isset($_POST["id"])) {
		$id = $_POST["id"];
	} else {
		$id = 1;
	}
}

if ($accion == "index") {
	switch ($id) {
		case 1:
			//Mostramos el menu
			$resultado=mMostrarIndice();
			$resultado2=mMostrarIndiceTablaProds();
			vMostrarIndice($resultado,$resultado2);
			break;
	}
}

if ($accion == "registro") {
	switch ($id) {
		case 1:
			vMostrarRegistro();
			break;

	case 2://register Failed
			vMostrarRegistroFail();
			break;
	}
}

if ($accion == "login") {
	switch ($id) {
		case 1:
			vMostrarLogin();
			break;
		case 2://login fail
			vMostrarLoginFail();
			break;
		case 3://logout
			unset($_SESSION['usuario']);
			$resultado=mMostrarIndice();
			$resultado2=mMostrarIndiceTablaProds();
			vMostrarIndice($resultado,$resultado2);
	}
}

if ($accion == "catalogo") {
	switch ($id) {
		case 1:
			vMostrarCatalogo(selectorcategorias());
			break;
	}
}

if ($accion == "localizacion") {
	switch ($id) {
		case 1:
			vMostrarLocalizacion();
			break;
	}
}

if ($accion == "servicios") {
	switch ($id) {
		case 1:
			vMostrarServicios();
			break;
	}
}

if ($accion == "usuario") {
	switch ($id) {
		case 1:
		if(isset($_SESSION["usuario"]))
			$usuario=$_SESSION["usuario"];
		$resultado=mMostrarUser($usuario);
		vMostrarUser($resultado);
		break;
	}
}

if ($accion == "admin") {
	switch ($id) {
		case 1:
			vMostrarAdmin();
			break;
	}
}

if ($accion == "producto") {
	if (isset($_GET["producto"])) {
		$producto = $_GET["producto"];
	} else {
		if (isset($_POST["producto"])) {
			$producto = $_POST["producto"];
		} else {
			$producto = 0;
		}
	}
	switch ($id) {
		case 1:
			if(isset($_SESSION["usuario"]))
				$usuario=$_SESSION["usuario"];
			vMostrarProducto($producto, mMostrarProducto($producto), mObtenerComentarios($producto), mObtenerSiFavorito($usuario, $producto));
			break;
	}
}

if ($accion == "legal") {
	switch ($id) {
		case 1:
			vMostrarLegal();
			break;
	}
}

if ($accion == "nuevo") {
	switch ($id) {
		case 1:
			vMostrarNuevo(selectorcategorias(), mObtenerMaxId());
			break;
	}
}

if ($accion == "modificar") {
	switch ($id) {
		case 1:
			vMostrarModificar();
			break;
	}
}

if ($accion == "nuevocomentario"){
	switch ($id) {
		case 1:
			if (session_status() == PHP_SESSION_NONE)
				session_start();
			if(isset($_SESSION["usuario"]))
				$usuario = $_SESSION["usuario"];
			if (isset($_POST["comentario"])&&(!empty($_POST["comentario"]))) {
			   $comentario=$_POST["comentario"];
			}else{
			   die();
			}
			if (isset($_POST["producto"])&&(!empty($_POST["producto"]))) {
			   $producto=$_POST["producto"];
			}else{
			   die();
			}
			mNuevoComentario($producto, $comentario, $usuario);
			$resultado=mMostrarProducto($producto);
			$datos=mObtenerComentarios($producto);
			vMostrarProducto($producto,$resultado,$datos);
			break;

		default:
			break;
	}
}

if ($accion == "mlogin") {
	switch ($id) {
		case 1:
			if (isset($_POST["password"])) {
			   $password = $_POST["password"];
			}else{
			   vMostrarLoginFail();

			}
			if (isset($_POST["email"])) {
				 $email = $_POST["email"];
			}else{

			}
			if (mLogin($email, $password)==0){
				$resultado=mMostrarIndice();
				$resultado2=mMostrarIndiceTablaProds();
				vMostrarIndice($resultado,$resultado2);
			}else {
				vMostrarLoginFail();
			}

			break;

		default:
			# code...
			break;
	}
}

if ($accion == "mregistro") {
	switch ($id) {
		case 1:
			if (isset($_POST["user"])) {
			   $usuario = $_POST["user"];
			}else {
			   vMostrarRegistroFail();
			}
			if (isset($_POST["password"])) {
			   $passwordnohash = $_POST["password"];
			   $password=password_hash($passwordnohash,CRYPT_BLOWFISH);
			}else{
			   vMostrarRegistroFail();
			}
			if (isset($_POST["email"])) {
			   if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
				 $email = $_POST["email"];
			   }else {
				 vMostrarRegistroFail();
			   }
			}else{
			   vMostrarRegistroFail();
			}
			if (isset($_POST["direccion"])) {
			   $direccion = $_POST["direccion"];
			}else{
			   vMostrarRegistroFail();
			}
			if (isset($_POST["nombre"])) {
			   $nombre = $_POST["nombre"];
			}else{
			   vMostrarRegistroFail();
			}
			if (mRegistro($usuario, $password, $email, $direccion, $nombre) == 0) {
				mLogin($email, $passwordnohash);
				$resultado=mMostrarIndice();
				$resultado2=mMostrarIndiceTablaProds();
				vMostrarIndice($resultado,$resultado2);
			}
			else
				vMostrarRegistroFail();
			break;

		default:
			# code...
			break;
	}
}

if ($accion == 'pdf') {
	switch ($id) {
		case 1:
			mPdf();
			break;

		default:
			# code...
			break;
	}
}

?>
