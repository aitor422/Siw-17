<?php

if (session_status() == PHP_SESSION_NONE)
		 session_start();

	include ("modelo.php");
	include ("vista.php");

	if (isset($_GET["accion"])) {
		$accion = $_GET["accion"];
	} else {
		if (isset($_POST["accion"])) {
			$accion = $_POST["accion"];
		} else {
			$accion = "index";
		}
	}

	if (isset($_GET["id"])) {
		$id = $_GET["id"];
	} else {
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
				vMostrarIndice();
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
				vMostrarIndice();
		}
	}

	if ($accion == "catalogo") {
		switch ($id) {
			case 1:
				vMostrarCatalogo();
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
				vMostrarUser();
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
				vMostrarProducto($producto);
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
				vMostrarNuevo();
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

?>
