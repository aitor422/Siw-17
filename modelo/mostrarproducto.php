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
   $extension=array();
   while ($datos = $resultado->fetch_assoc()) {
      $img='static/images/catalogo/'.$datos["imagen"];
      $peques=strpos($img,"pequena");
      $medianas=strpos($img,"mediana");
      if ($peques === false && $medianas === false) {
         $output=preg_split("/[._]/",$img);
         echo "<script>console.log( '".$output[0]."');</script>";
         array_push($fotosgrandes,$output[0]);
         array_push($extension,$output[2]);
      }
   }
   $longitud = count($fotosgrandes);
   $carouselimagenes=$carouselimagenes."<script type=\"text/javascript\">var array_fotos = new Array(".$longitud."); var array_extensiones = new Array(".$longitud.");  ";
   for ($i = 0; $i < $longitud; $i++) {
     $str = "\"".$fotosgrandes[$i]."\"" ;
     $ext="\"".$extension[$i]."\"" ;
     $carouselimagenes=$carouselimagenes."array_fotos[".$i."]=[".$str."]; array_extensiones[".$i."]=[".$ext."];   ";
  }
  $carouselimagenes=$carouselimagenes."
   var nombre_foto = array_fotos[0];
   var extension_foto = array_extensiones[0];
   var numero_foto = 0;

   var cadena=\"<div id='fade' class='overlay'></div><div id='ventana' class='ventana'></div><div style='text-align:center;'><img id='mediana' onclick='cambiar_a_grande()' src='static/images/\" + nombre_foto +\"_mediana.\"+extension_foto+\" class='foto_mediana'></div><br/><br/><br/><br/><br/><div style='text-align:center'>\";

   for (var i=0;i < array_fotos.length;i++){
      cadena += \"<img onclick='cambiar_a_mediana(\"+ i +\")' src='static/images/\" + nombre_foto +\"_pequena.\"+array_extensiones[i]+\"' class='borde_foto' >\";
   }

   cadena += \"</div>\";

   if (array_fotos.length == 0){
      cadena = \" <p >No hay fotos que mostrar en la galeria</p> \";
   }

   document.getElementById('galeria').innerHTML= cadena;

   function cambiar_a_mediana(i){
      numero_foto = i;
      nombre_foto = array_fotos[i];
      extension_foto = array_extensiones[i];
      document.getElementById('mediana').src = \"static/images/\" + nombre_foto +\"_mediana.\"+extension_foto;
   }

   function cambiar_a_grande(){
      document.getElementById('fade').style.visibility = \"visible\";
      document.getElementById('ventana').style.visibility = \"visible\";
      document.getElementById('ventana').innerHTML = \"<img id='grande' src='static/images/\" + nombre_foto +\"_grande.\"+extension_foto+\"' class='foto_grande'><img id='x' onclick='close_grande()' src='static/imagenes/x.png' style='position:absolute;top:17%;width:2%;right:18%;'><img onclick='pasar_foto_izq()' src='static/imagenes/x.png' style='position:absolute;top:49%;height:2%;left:0%;'><img onclick='pasar_foto_der()' src='static/imagenes/x.png' style='position:absolute;top:49%;height:2%;right:0%;'>\";
   }

   function close_grande(){
      document.getElementById('fade').style.visibility = \"hidden\";
      document.getElementById('ventana').style.visibility = \"hidden\";
      document.getElementById('ventana').innerHTML = \"\";
   }

   function pasar_foto_der(){
      numero_foto++;
      if(numero_foto >= array_fotos.length){
         numero_foto = 0;
      }
      document.getElementById('grande').src = \"static/images/\" + array_fotos[numero_foto] +\"_grande.\"+extension_foto[numero_foto];
   }

   function pasar_foto_izq(){
      numero_foto--;
      if(numero_foto < 0){
         numero_foto = array_fotos.length-1;
      }
      document.getElementById('grande').src = \"static/images/\" + array_fotos[numero_foto] +\"_grande.\"+extension_foto[numero_foto];
   }
 </script>";
 return $carouselimagenes;
}
?>
