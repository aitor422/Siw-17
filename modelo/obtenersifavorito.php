<?php

  function mObtenerSiFavorito($usuario, $producto) {

    $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
    mysqli_set_charset($con,"utf8");
    $consulta = "select count(*) as cuenta from final_favoritos where idusuario='$usuario' and idproducto=$producto";
    $resultado = $con->query($consulta);
    $resultado = $resultado->fetch_assoc();
    return $resultado['cuenta'];

  }

 ?>
