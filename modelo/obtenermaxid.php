<?php

function mObtenerMaxId() {
  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
  mysqli_set_charset($con,"utf8");
  $consulta = "select max(idproducto) as maximo from final_productos";
  $resultado = $con->query($consulta);
  $datos = $resultado->fetch_assoc();
  $nuevoid=$datos["maximo"]+1;
  return $nuevoid;
}
 ?>
