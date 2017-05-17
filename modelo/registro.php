<?php

  function falloreg(){
    header("Location: controlador.php?accion=registro&id=2");
    die();
  }

  $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
  if (mysqli_connect_errno()){
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
     falloreg();
  }
  $sql = $conn->prepare("INSERT INTO final_usuario (idusuario, password, email, direccion, nombre) VALUES (?, ?, ?, ?, ?)");
  $sql->bind_param("sssss", $usuario, $password, $email, $direccion, $nombre);

   if (isset($_POST["user"])) {
      $usuario = $_POST["user"];
   }else {
      falloreg();
   }
   if (isset($_POST["password"])) {
      $password = $_POST["password"];
      $password=password_hash($password,CRYPT_BLOWFISH);
   }else{
      falloreg();
   }
   if (isset($_POST["email"])) {
      if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         $email = $_POST["email"];
      }else {
         falloreg();
      }
   }else{
      falloreg();
   }
   if (isset($_POST["direccion"])) {
      $direccion = $_POST["direccion"];
   }else{
      falloreg();
   }
   if (isset($_POST["nombre"])) {
      $nombre = $_POST["nombre"];
   }else{
      falloreg();
   }

   if ($sql->execute() === TRUE) {
     header("Location: ../controlador.php?accion=login&id=1");
     die();
   } else {
     falloreg();
   }
 ?>
