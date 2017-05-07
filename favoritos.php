<?php


  $producto = $_GET['idprod'];
  if (session_status() == PHP_SESSION_NONE)
       session_start();
  $usuario = $_SESSION["usuario"];

  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
  $consulta = "insert into favoritos (idusuario, idproducto) values ('$usuario', $producto)";
  if ($con->query($consulta) === TRUE) {
    echo "1";
} else {
    echo "-1";
}

 ?>
