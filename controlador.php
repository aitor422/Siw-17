<?php

if (session_status() == PHP_SESSION_NONE)
		 session_start();
		 
	//include ("modelo.php");
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
			case 2:
				//logout
				break;
		}
	}

?>
