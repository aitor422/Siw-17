<?php
function mMostrarProducto($producto){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "SELECT final_productos.idproducto, nombre, precio,descripcion  FROM final_productos WHERE final_productos.idproducto = $producto";
   $resultado = $con->query($consulta);
   return $resultado;
}

function mMostrarImagenes($producto) {
     $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
     $consulta = "SELECT *  FROM final_imagenes WHERE idproducto = '$producto' and imagen LIKE '%_mediana%'";
     $resultado = $con->query($consulta);
     return $resultado;
}
?>
