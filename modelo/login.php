<?php

    function fallologin() {
      header("Location: ../controlador.php?accion=login&id=2");
      die();
    }
function mLogin($email, $password) {
     $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
    if (mysqli_connect_errno()){
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
       return -1;
    }

    $sql = $conn->prepare("SELECT password, idusuario FROM final_usuario WHERE email = ? OR idusuario = ?");
    $sql->bind_param("ss", $email, $email);


    $sql->execute();
    $sql->bind_result($passhash, $idusuario);
    $sql->fetch();

    if (password_verify($password, $passhash)) {
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      $_SESSION["usuario"] = $idusuario;
    }
    else {
      return -1;
    }
    return 0;
}

 ?>
