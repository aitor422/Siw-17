<?php
   if (isset($_GET["user"])) {
      $usuario = $_GET["user"];
   }else {
      echo "Algo ha fallado con user";
   }
   if (isset($_GET["password"])) {
      $password = $_GET["password"];
      $password=password_hash($password,CRYPT_BLOWFISH);
   }else{
      echo "Algo ha fallado con password";
   }
   if (isset($_GET["email"])) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $email = $_GET["email"];
      }else {
         echo "Formato de email incorrecto";
      }
   }else{
      echo "Algo ha fallado con email";
   }
   if (isset($_GET["direccion"])) {
      $direccion = $_GET["direccion"];
   }else{
      echo "Algo ha fallado con password";
   }
   if (isset($_GET["nombre"])) {
      $nombre = $_GET["nombre"];
   }else{
      echo "Algo ha fallado con nombre";
   }

 ?>
