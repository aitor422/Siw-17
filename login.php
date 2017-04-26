<?php
   if (isset($_POST["password"])) {
      $password = $_POST["password"];
      /*$password=password_hash($password,CRYPT_BLOWFISH);*/
   }else{
      echo "Algo ha fallado con password <br>";
      return;

   }
   if (isset($_POST["email"])) {
         $email = $_POST["email"];
   }else{
      echo "Algo ha fallado con email <br>";
      return;
   }

   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }

   $sql="select password from usuario where email like \"".$email."\" or idusuario like \"".$email."\"";
    $resultado = $conn->query($sql);
    $datos = $resultado->fetch_assoc();
    $passhash = $datos["password"];
    if (password_verify($password, $passhash)) {
      header("Location: controlador.php?accion=index&id=1");
      die();
    }
    else {
      header("Location: controlador.php?accion=login&id=2");
      die();
    }
 ?>
