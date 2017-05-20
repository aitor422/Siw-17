<?php
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
    } else {
      return -1;
   }
   return 0;
}
function mRegistro($usuario, $password, $email, $direccion, $nombre){
   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      return -1;
   }
   $sql = $conn->prepare("INSERT INTO final_usuario (idusuario, password, email, direccion, nombre) VALUES (?, ?, ?, ?, ?)");
   $sql->bind_param("sssss", $usuario, $password, $email, $direccion, $nombre);
   if ($sql->execute() == TRUE) {
      return 0;
   } else {
      return -1;
   }
}
function mEliminarCuenta($usuario){
   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
     return -1;
   }
   $consulta = "DELETE from final_usuario where idusuario='$usuario'";
   if ($conn->query($consulta) === TRUE) {
      return 1;
   } else {
      return -1;
   }
}
 ?>
