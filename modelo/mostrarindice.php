<?php
function mMostrarIndice(){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "SELECT final_productos.idproducto, nombre, precio, min(imagen) AS imagen FROM final_productos LEFT JOIN (SELECT * FROM final_imagenes WHERE imagen like '%_grande%') a on final_productos.idproducto = a.idproducto WHERE destacado=1 GROUP BY final_productos.idproducto limit 5";
   $resultado = $con->query($consulta);
   return $resultado;
}
function mMostrarIndiceTablaProds(){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "select * from final_productos where destacado=1 limit 20 offset 5";
   $resultado = $con->query($consulta);
   return $resultado;
}
?>
