<?php
function mMostrarProducto($producto){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "SELECT final_productos.idproducto, nombre, precio,descripcion, min(imagen) AS imagen FROM final_productos LEFT JOIN (SELECT * FROM final_imagenes WHERE imagen like '%_mediana%') a ON final_productos.idproducto = a.idproducto WHERE final_productos.idproducto = $producto GROUP BY final_productos.idproducto";
   $resultado = $con->query($consulta);
   return $resultado;
}
?>
