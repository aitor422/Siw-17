<?php


  $producto = $_GET['idprod'];
  if (session_status() == PHP_SESSION_NONE)
       session_start();
  $usuario = $_SESSION["usuario"];

  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");

  $sql = $con->prepare("SELECT COUNT(*) AS cuenta FROM final_favoritos WHERE idusuario=? AND idproducto=?");
  $sql->bind_param("si", $usuario, $producto);
  $sql->execute();
  $sql->bind_result($cuenta)
  if($cuenta == "1") {
    $sql = $con->prepare("DELETE FROM final_favoritos WHERE idusuario=? AND idproducto=?");
    $sql->bind_param("si", $usuario, $producto);
    if ($sql->execute()) == TRUE) {
      echo "2";
    } else {
      echo "-1";
    }
  }
  else {
       $sql = $con->prepare("INSERT INTO final_favoritos (idusuario, idproducto) VALUES (?, ?)");
      $sql->bind_param("si", $usuario, $producto);
      if ($sql->execute() == TRUE) {
           echo "1";
         } else {
           echo "-1";
         }
  }

 ?>
