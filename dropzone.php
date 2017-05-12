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
if(isset($_FILES["file"])){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "select max(idproducto) as maximo from productos ";
   $resultado = $con->query($consulta);
   $datos = $resultado->fetch_assoc();
   $id=$datos["maximo"]+1;
   $target_dir = "static/images/catalogo/";
   $target_file = $target_dir .strval($id).$_FILES["file"]["name"];
   $nombre_archivo=basename($_FILES["file"]["name"]);
   if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      echo "El fichero ".basename($target_file)." ha sido subido.";
   } else {
      echo "Error en la subida";
   }
   $sql = $con->prepare("INSERT INTO productos (idproducto, categoria, nombre, precio) VALUES (?, ?, ?, ?)");
   $sql->bind_param("issi", $id, $categoria, $nombre, $precio);
   if ($sql->execute() != TRUE) {
      echo "NO FUNCIONA->Error al añadir producto";
   }
   $consulta="INSERT INTO imagenes (idproducto, imagen) VALUES ($id,'$nombre_archivo')";
   if ($con->query($consulta) != TRUE){
      echo "NO FUNCIONA->Error al añadir Imagenes";
   }
}else{
   echo "NO FUNCIONA->No hay archivos que subir";
   die();
}
?>
