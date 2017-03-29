<?php
   if (isset($_POST["user"])) {
      $usuario = $_POST["user"];
   }else {
      echo "Algo ha fallado con user <br>";
   }
   if (isset($_POST["password"])) {
      $password = $_POST["password"];
      $password=password_hash($password,CRYPT_BLOWFISH);
   }else{
      echo "Algo ha fallado con password <br>";
   }
   if (isset($_POST["email"])) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $email = $_POST["email"];
      }else {
         echo "Formato de email incorrecto <br>";
      }
   }else{
      echo "Algo ha fallado con email <br>";
   }
   if (isset($_POST["direccion"])) {
      $direccion = $_POST["direccion"];
   }else{
      echo "Algo ha fallado con password <br>";
   }
   if (isset($_POST["nombre"])) {
      $nombre = $_POST["nombre"];
   }else{
      echo "Algo ha fallado con nombre <br>";
   }

 ?>
