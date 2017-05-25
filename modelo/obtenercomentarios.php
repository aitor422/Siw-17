<?php
function mObtenerComentarios($producto){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   mysqli_set_charset($con,"utf8");
   $consulta="select comentario,idusuario from final_comentarios where final_comentarios.idproducto = $producto";
   $datos = $con->query($consulta);
   return $datos;
}
?>
