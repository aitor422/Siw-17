<?php
function mModificarProducto($producto){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   mysqli_set_charset($con,"utf8");
   $consulta = "SELECT final_productos.idproducto, nombre, precio,categoria,descripcion FROM final_productos WHERE final_productos.idproducto = $producto";
   $resultado = $con->query($consulta);
   return $resultado;
}
?>
