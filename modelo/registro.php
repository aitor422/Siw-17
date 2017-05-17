<?php
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
 ?>
