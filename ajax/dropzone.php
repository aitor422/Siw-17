<?php
function generate_uuid() {//para generar nombres de archivo únicos.
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
		mt_rand( 0, 0xffff ),
		mt_rand( 0, 0x0fff ) | 0x4000,
		mt_rand( 0, 0x3fff ) | 0x8000,
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}


function redimensionarimagenes($grande, $mediana, $pequena) {
	$info = getimagesize($grande);
	$mime = $info['mime'];
	switch ($mime) {
	       case 'image/jpeg':
	               $image_create_func = 'imagecreatefromjpeg';
	               $image_save_func = 'imagejpeg';
	               break;

	       case 'image/png':
	               $image_create_func = 'imagecreatefrompng';
	               $image_save_func = 'imagepng';
	               break;

	       case 'image/gif':
	               $image_create_func = 'imagecreatefromgif';
	               $image_save_func = 'imagegif';
	               break;

	       default:
	               throw new Exception('Unknown image type.');
	}
  $height_g = 300;
  $height_m = 150;
  $height_p = 80;
  list($width_orig, $height_orig) = getimagesize($grande);
  $ratio_orig = $width_orig/$height_orig;
  $width_g = $height_g * $ratio_orig;
  $width_m = $height_m * $ratio_orig;
  $width_p = $height_p * $ratio_orig;
  $image_g = imagecreatetruecolor($width_g, $height_g);
  $image_m = imagecreatetruecolor($width_m, $height_m);
  $image_p = imagecreatetruecolor($width_p, $height_p);
  $image = $image_create_func($grande);
  imagecopyresampled($image_g, $image, 0, 0, 0, 0, $width_g, $height_g, $width_orig, $height_orig);
  imagecopyresampled($image_m, $image, 0, 0, 0, 0, $width_m, $height_m, $width_orig, $height_orig);
  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_p, $height_p, $width_orig, $height_orig);
  $image_save_func($image_g, $grande);
  $image_save_func($image_m, $mediana);
  $image_save_func($image_p, $pequena);
}


if (isset($_POST["categoria"])) {
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
if (isset($_POST["descripcion"])) {
   $descripcion=$_POST["descripcion"];
}else{
   echo "NO FUNCIONA->NO hay descripcion";
   die();
}
if(isset($_FILES["file"])){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
	 mysqli_set_charset($con,"utf8");
   $target_dir = "../static/images/catalogo/";
   $extension = end(explode('.', $_FILES["file"]["name"]));
   $nombre_archivo = generate_uuid();
   while (file_exists ($nombre_archivo . "_pequena." . $extension)) {
     $nombre_archivo=generate_uuid();
   }
   $target_file_pequena = $target_dir . $nombre_archivo . "_pequena." . $extension;
   $target_file_mediana = $target_dir . $nombre_archivo . "_mediana." . $extension;
   $target_file_grande = $target_dir . $nombre_archivo . "_grande." . $extension;

   if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_grande)) {
      redimensionarimagenes($target_file_grande, $target_file_mediana, $target_file_pequena);
      echo "El fichero ".basename($target_file)." ha sido subido.";
   } else {
      echo "Error en la subida";
   }
   $consulta = "select max(idproducto) as maximo from final_productos";
   $resultado = $con->query($consulta);
   $datos = $resultado->fetch_assoc();
   $maximo=$datos["maximo"];
   if($maximo!=$nuevoid){
      $sql = $con->prepare("INSERT INTO final_productos (idproducto, categoria, nombre, precio,descripcion) VALUES (?, ?, ?, ?, ?)");
      $sql->bind_param("issss", $nuevoid, $categoria, $nombre, $precio, $descripcion);
      if ($sql->execute() != TRUE) {
         echo "NO FUNCIONA->Error al añadir producto";
			die();
      }
   }
   $g = $nombre_archivo . '_grande.' . $extension;
   $m = $nombre_archivo . '_mediana.' . $extension;
   $p = $nombre_archivo . '_pequena.' . $extension;
   $consulta="INSERT INTO final_imagenes (idproducto, imagen) VALUES ($nuevoid, '$g')";
   if ($con->query($consulta) != TRUE){
      echo "NO FUNCIONA->Error al añadir Imagenes";
		die();
   }
   $consulta="INSERT INTO final_imagenes (idproducto, imagen) VALUES ($nuevoid, '$m')";
   if ($con->query($consulta) != TRUE){
      echo "NO FUNCIONA->Error al añadir Imagenes";
		die();
   }
   $consulta="INSERT INTO final_imagenes (idproducto, imagen) VALUES ($nuevoid, '$p')";
   if ($con->query($consulta) != TRUE){
      echo "NO FUNCIONA->Error al añadir Imagenes";
		die();
   }
}else{
   echo "NO FUNCIONA->No hay archivos que subir";
   die();
}
?>
