<?php
   if (isset($_POST["user"])) {
      $usuario = $_POST["user"];
   }else {
      echo "Algo ha fallado con user <br>";
      return;
   }
   if (isset($_POST["password"])) {
      $password = $_POST["password"];
      $password=password_hash($password,CRYPT_BLOWFISH);
   }else{
      echo "Algo ha fallado con password <br>";
      return;

   }
   if (isset($_POST["email"])) {
      if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         $email = $_POST["email"];
      }else {
         echo "Formato de email incorrecto <br>";
         return;

      }
   }else{
      echo "Algo ha fallado con email <br>";
      return;
   }
   if (isset($_POST["direccion"])) {
      $direccion = $_POST["direccion"];
   }else{
      echo "Algo ha fallado con password <br>";
      return;

   }
   if (isset($_POST["nombre"])) {
      $nombre = $_POST["nombre"];
   }else{
      echo "Algo ha fallado con nombre <br>";
      return;

   }

   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }

   $sql="insert into usuario (idusuario, password, email, direccion, nombre) values (\"".$usuario."\", \"".$password."\", \"".$email."\", \"".$direccion."\", \"".$nombre."\")";

   if ($conn->query($sql) === TRUE) {
      echo "insertado usuario correctamente <br>";
   } else {
      echo "Error insertando en tabla usuario: " . $conn->error."<br>";
   }
 ?>
