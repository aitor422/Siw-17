<?php


  $producto = $_GET['idprod'];
  if (session_status() == PHP_SESSION_NONE)
       session_start();
  $usuario = $_SESSION["usuario"];

  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
  $consulta = "SELECT COUNT(*) AS cuenta FROM final_favoritos WHERE idusuario='$usuario' AND idproducto=$producto";
  $resultado = $con->query($consulta);
  $resultado = $resultado->fetch_assoc();
  if($resultado["cuenta"] == "1") {
    $consulta = "DELETE FROM final_favoritos WHERE idusuario='$usuario' AND idproducto=$producto";
    if ($con->query($consulta) === TRUE) {
      echo "2";
    } else {
      echo "-1";
    }
  }
  else {
    $consulta = "insert into final_favoritos (idusuario, idproducto) values ('$usuario', $producto)";
    if ($con->query($consulta) === TRUE) {
      echo "1";
    } else {
      echo "-1";
    }
  }

 ?>
