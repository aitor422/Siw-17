<?php

function mObtenerCategorias(){
  $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
  mysqli_set_charset($con,"utf8");
  $consulta = "select distinct(categoria) as categoria from final_productos";
  $resultado = $con->query($consulta);
  return $resultado;
}

 ?>
