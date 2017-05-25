<?php
function mMostrarIndice(){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   mysqli_set_charset($con,"utf8");
   $consulta = "SELECT final_productos.idproducto, nombre, precio, min(imagen) AS imagen FROM final_productos LEFT JOIN (SELECT * FROM final_imagenes WHERE imagen like '%_grande%') a on final_productos.idproducto = a.idproducto WHERE destacado=1 GROUP BY final_productos.idproducto order by rand() limit 5";
   $resultado = $con->query($consulta);
   return $resultado;
}
function mMostrarIndiceTablaProds(){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   mysqli_set_charset($con,"utf8");
   $consulta = "select * from final_productos where destacado=1 order by rand() limit 20 offset 5";
   $resultado = $con->query($consulta);
   return $resultado;
}
?>
