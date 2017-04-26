<?php
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

   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }

   $sql="select count(*) as cuenta from usuario where email = \"".$email."\"and password = \"".$password."\"";

   if ($conn->query($sql) === TRUE) {
      if($cuenta)
   } else {
      echo "login okno: " . $conn->error."<br>";
   }
 ?>
