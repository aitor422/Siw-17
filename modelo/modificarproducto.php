<?php
function mModificarProducto($producto){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   mysqli_set_charset($con,"utf8");
   $consulta = "SELECT final_productos.idproducto, nombre, precio,categoria,descripcion FROM final_productos WHERE final_productos.idproducto = $producto";
   $resultado = $con->query($consulta);
   return $resultado;
}
function mEliminarProducto($producto){
   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
     return -1;
   }
   $consulta = "SELECT imagen from final_imagenes where final_imagenes.idproducto=$producto";
   if ($resultado=$conn->query($consulta) === TRUE) {
      if ($resultado->num_rows!=0) {
         while ($datos = $resultado->fetch_assoc()) {
            unlink("static/images/catalogo/".$datos['imagen']);
         }
      }
   }
   $consulta = "DELETE from final_productos where idproducto=$producto";
   if ($conn->query($consulta) === TRUE) {
      return 1;
   } else {
      return -1;
   }
}
?>
