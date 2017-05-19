<?php


  $producto = $_GET['idprod'];
  if (session_status() == PHP_SESSION_NONE)
       session_start();
  $usuario = $_SESSION["usuario"];

  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
  if ($con->connect_error) {
    echo "-1";
    return;
  }
  $con->autocommit(FALSE);

  $sql = $con->prepare("SELECT COUNT(*) FROM final_favoritos WHERE idusuario=? AND idproducto=?");
  $sql->bind_param("si", $usuario, $producto);
  if ($sql->execute() == TRUE) {
    $sql->bind_result($cuenta);
    $sql->fetch();
    if($cuenta == "1") {
      $sql->close();
      $sql = $con->prepare("DELETE FROM final_favoritos WHERE idusuario=? AND idproducto=?");
      $sql->bind_param("si", $usuario, $producto);
      if ($sql->execute() == TRUE) {
        echo "2";
      } else {
        echo "-1";
      }
      $sql->close();
      $con->commit();
      $con->close();
    }
    else {
      $sql->close();
         $sql = $con->prepare("INSERT INTO final_favoritos (idusuario,idproducto) VALUES (?,?)");
        $sql->bind_param("si", $usuario, $producto);
        if ($sql->execute() == TRUE) {
           echo "1";
         }
         else {
           echo "-1";
         }
         $sql->close();
         $con->commit();
         $con->close();
    }

  }
  else {
    $con->close();
    echo "-1";
  }

 ?>
