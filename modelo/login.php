<?php

    function fallologin() {
      header("Location: controlador.php?accion=login&id=2");
      die();
    }

    $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
    if (mysqli_connect_errno()){
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
       fallologin();
    }

    $sql = $conn->prepare("SELECT password, idusuario FROM final_usuario WHERE email = ? OR idusuario = ?");
    $sql->bind_param("ss", $email, $email);

   if (isset($_POST["password"])) {
      $password = $_POST["password"];
      /*$password=password_hash($password,CRYPT_BLOWFISH);*/
   }else{
      fallologin();

   }
   if (isset($_POST["email"])) {
         $email = $_POST["email"];
   }else{
      fallologin();
   }

    $sql->execute();
    $sql->bind_result($passhash, $idusuario);
    $sql->fetch();

    if (password_verify($password, $passhash)) {
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      $_SESSION["usuario"] = $idusuario;
      header("Location: ../controlador.php?accion=index&id=1");
      die();
    }
    else {
      fallologin();
    }
 ?>
