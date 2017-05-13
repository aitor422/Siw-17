<?php
if (isset($_POST["categoria"])&&(!empty($_POST["categoria"]))) {
   $categoria=$_POST["categoria"];
}else{
   echo "NO FUNCIONA->NO hay Categoria";
   die();
}
if (isset($_POST["nombre"])&&(!empty($_POST["nombre"]))) {
   $nombre=$_POST["nombre"];
}else{
   echo "NO FUNCIONA->NO hay Nombre";
   die();
}
if (isset($_POST["precio"])&&(!empty($_POST["precio"]))) {
   $precio=$_POST["precio"];
}else{
   echo "NO FUNCIONA->NO hay Precio";
   die();
}
if (isset($_POST["nuevoid"])&&(!empty($_POST["nuevoid"]))) {
   $nuevoid=$_POST["nuevoid"];
}else{
   echo "NO FUNCIONA->NO hay nuevoid";
   die();
}
if (isset($_POST["descripcion"])&&(!empty($_POST["descripcion"]))) {
   $descripcion=$_POST["descripcion"];
}else{
   echo "NO FUNCIONA->NO hay descripcion";
   die();
}
if(isset($_FILES["file"])){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $target_dir = "static/images/catalogo/";
   $target_file = $target_dir.$_FILES["file"]["name"];
   $nombre_archivo=basename($_FILES["file"]["name"]);
   if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      echo "El fichero ".basename($target_file)." ha sido subido.";
   } else {
      echo "Error en la subida";
   }
   $consulta = "select max(idproducto) as maximo from productos";
   $resultado = $con->query($consulta);
   $datos = $resultado->fetch_assoc();
   $maximo=$datos["maximo"];
   if($maximo!=$nuevoid){
      $sql = $con->prepare("INSERT INTO productos (idproducto, categoria, nombre, precio,descripcion) VALUES (?, ?, ?, ?, ?)");
      $sql->bind_param("issis", $nuevoid, $categoria, $nombre, $precio, $descripcion);
      if ($sql->execute() != TRUE) {
         echo "NO FUNCIONA->Error al añadir producto";
      }
   }
   $consulta="INSERT INTO imagenes (idproducto, imagen) VALUES ($nuevoid,'$nombre_archivo')";
   if ($con->query($consulta) != TRUE){
      echo "NO FUNCIONA->Error al añadir Imagenes";
   }
}else{
   echo "NO FUNCIONA->No hay archivos que subir";
   die();
}
?>
