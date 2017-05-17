<?php
include 'vista.php';
if(isset($_SESSION["usuario"]))
     $usuario = $_SESSION["usuario"];
if (isset($_POST["comentario"])&&(!empty($_POST["comentario"]))) {
   $comentario=$_POST["comentario"];
}else{
   echo "NO FUNCIONA->NO hay Comentario";
   die();
}
if (isset($_POST["id"])&&(!empty($_POST["id"]))) {
   $id=$_POST["id"];
}else{
   echo "NO FUNCIONA->NO hay id";
   die();
}
$con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
$sql = $con->prepare("INSERT INTO final_comentarios (idproducto, comentario,idusuario) VALUES (?, ?, ?)");
$sql->bind_param("iss", $id, $comentario,$usuario);
if ($sql->execute() != TRUE) {
   echo "NO FUNCIONA->Error al añadir comentario";
}
vMostrarProducto($id);
?>
