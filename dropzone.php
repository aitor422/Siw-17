<?php
if(isset($_FILES["file"])){
   echo "FUNCIONA";
   $target_dir = "static/images/catalogo/";
   $target_file = $target_dir . basename($_FILES["file"]["name"]);
   if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$_FILES['file']['name'])) {
      echo "El fichero ". basename( $_FILES["file"]["name"]). " ha sido subido.";
   } else {
      echo "Error en la subida";
   }
}else{
   echo "NO FUNCIONA";
}
?>
