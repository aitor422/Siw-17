<?php

function mNuevoComentario($id, $comentario, $usuario) {
     $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
     mysqli_set_charset($con,"utf8");
     $sql = $con->prepare("INSERT INTO final_comentarios (idproducto, comentario,idusuario) VALUES (?, ?, ?)");
     $sql->bind_param("iss", $id, $comentario,$usuario);
     if ($sql->execute() != TRUE) {
        return "NO FUNCIONA->Error al añadir comentario";
     }
     return;
}
?>
