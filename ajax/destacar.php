<?php

  $producto = $_GET['idprod'];
  $destacado = $_GET['destacado'];

  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
  if ($con->connect_error) {
    echo "-1";
    return;
  }

  if ($destacado == 1) {
       $sql = "select count(*) as cuenta from final_productos where destacado=1";
       $resultado = $con->query($sql);
      $resultado = $resultado->fetch_assoc();
      if ($resultado["cuenta"] <= 5) {
           echo -1;
      }
      else {
           $sql = $con->prepare("UPDATE final_productos SET destacado=0 where idproducto=?");
          $sql->bind_param("s", $producto);
          $sql->execute();
          echo 1;
      }
 }
 else {
      $sql = "select count(*) as cuenta from final_productos where destacado=1";
      $resultado = $con->query($sql);
     $resultado = $resultado->fetch_assoc();
     if ($resultado["cuenta"] < 25) {
          $sql = $con->prepare("UPDATE final_productos SET destacado=1 where idproducto=?");
          $sql->bind_param("s", $producto);
          $sql->execute();
          echo 1;
     }
     else {
          $sql = "UPDATE final_productos SET destacado=0 where destacado=1 limit 1";
          $resultado = $con->query($sql);
          $sql = $con->prepare("UPDATE final_productos SET destacado=1 where idproducto=?");
          $sql->bind_param("s", $producto);
          $sql->execute();
          echo 1;
     }
}

 ?>
