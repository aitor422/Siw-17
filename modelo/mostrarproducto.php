<?php
function mMostrarProducto($producto){
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "SELECT final_productos.idproducto, nombre, precio,descripcion  FROM final_productos WHERE final_productos.idproducto = $producto";
   $resultado = $con->query($consulta);
   return $resultado;
}

function mMostrarImagenes($producto) {
   $carouselimagenes='';
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "SELECT *  FROM final_imagenes WHERE idproducto = '$producto'";
   $resultado = $con->query($consulta);
   $fotosgrandes = array();
   while ($datos = $resultado->fetch_assoc()) {
      $img='static/images/catalogo/'.$datos["imagen"];
      $peques=strpos($img,"pequena");
      $medianas=strpos($img,"mediana");
      if ($peques === false && $medianas === false) {
         array_push($fotosgrandes, $file);
      }
   }
   $longitud = count($fotosgrandes);
   $carouselimagenes=$carouselimagenes."<script type=\"text/javascript\">var array_fotos = new Array(".$longitud.");  ";
   for ($i = 0; $i < $longitud; $i++) {
     $nombre_foto=$fotosgrandes[$i];
     $str = "\"".$nombre_foto."\"" ;
     $carouselimagenes=$carouselimagenes."array_fotos[".$i."]=[".$str."];   ";
  }
  $carouselimagenes=$carouselimagenes."
   var nombre_mediana = array_fotos[0];

   var numero_mediana = 0;

   var cadena=\"<div id='fade' class='overlay'></div><div id='ventana' class='ventana'></div><div style='text-align:center;'><img id='mediana' onclick='cambiar_a_grande()' src='upload_images/mediana_\" +nombre_mediana +\"' class='foto_mediana'></div><br/><br/><br/><br/><br/><div style='text-align:center;'>\";

   for (var i=0;i < array_fotos.length;i++){
      cadena += \"<img onclick='cambiar_a_mediana(\"+ i +\")' src='upload_images/peque_\" + array_fotos[i] + \"' class='borde_foto' >\";
   }

   cadena += \"</div>\";

   if (array_fotos.length == 0){
      cadena = \" <p style='position:absolute;top:100px;text-align:center;width:200px;'>No hay fotos que mostrar en la galeria</p> \";
   }

   document.getElementById('galeria').innerHTML= cadena;

   function cambiar_a_mediana(i){
      numero_mediana = i;
      nombre_mediana = array_fotos[i];
      document.getElementById('mediana').src = \"upload_images/mediana_\" + nombre_mediana;
   }

   function cambiar_a_grande(){
      document.getElementById('fade').style.visibility = \"visible\";
      document.getElementById('ventana').style.visibility = \"visible\";
      document.getElementById('ventana').innerHTML = \"<img id='grande' src='upload_images/\" + nombre_mediana + \"' class='foto_grande'><img id='x' onclick='close_grande()' src='static/imagenes/x.png' style='position:absolute;top:17%;width:2%;right:18%;'><img onclick='pasar_foto_izq()' src='static/imagenes/x.png' style='position:absolute;top:49%;height:2%;left:0%;'><img onclick='pasar_foto_der()' src='static/imagenes/x.png' style='position:absolute;top:49%;height:2%;right:0%;'>\";
   }

   function close_grande(){
      document.getElementById('fade').style.visibility = \"hidden\";
      document.getElementById('ventana').style.visibility = \"hidden\";
      document.getElementById('ventana').innerHTML = \"\";
   }

   function pasar_foto_der(){
      numero_mediana++;
      if(numero_mediana >= array_fotos.length){
         numero_mediana = 0;
      }
      document.getElementById('grande').src = \"upload_images/\" + array_fotos[numero_mediana];
   }

   function pasar_foto_izq(){
      numero_mediana--;
      if(numero_mediana < 0){
         numero_mediana = array_fotos.length-1;
      }
      document.getElementById('grande').src = \"upload_images/\" + array_fotos[numero_mediana];
   }
 </script>";
}
?>
