<?php
function mnuevocomentario() {
   /****************************************************
	Función encargada de añadir un comentario
	Devuelve:
		 1 --> En caso de inserción correcta
		-1 --> NO hay comentario
		-2 --> NO hay id
      -3 --> Error al añadir producto
	****************************************************/
   if (session_status() == PHP_SESSION_NONE)
   		 session_start();
   if(isset($_SESSION["usuario"]))
   	$usuario = $_SESSION["usuario"];
   if (isset($_POST["comentario"])&&(!empty($_POST["comentario"]))) {
      $comentario=$_POST["comentario"];
   }else{
      return -1;
   }
   if (isset($_POST["id"])&&(!empty($_POST["id"]))) {
      $id=$_POST["id"];
   }else{
      return -2;
   }
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $sql = $con->prepare("INSERT INTO final_comentarios (idproducto, comentario,idusuario) VALUES (?, ?,?)");
   $sql->bind_param("iss", $id, $comentario,$usuario);
   if ($sql->execute() != TRUE) {
      $con->close;
      return -3;
   }
   $con->close;
   return 1;
}
function mfavoritos(){
   /**************************************************************
	Función encargada de añadir o elimenar un producto de favoritos
	Devuelve:
		 1 --> Producto añadido correctamente
       2 --> Producto eliminado correctamente
		-1 --> Error añadir
      -2 --> Error eliminar
	****************************************************************/
   $producto = $_GET['idprod'];
   if (session_status() == PHP_SESSION_NONE)
        session_start();
   $usuario = $_SESSION["usuario"];
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "SELECT COUNT(*) AS cuenta FROM final_favoritos WHERE idusuario='$usuario' AND idproducto=$producto";
   $resultado = $con->query($consulta);
   $resultado = $resultado->fetch_assoc();
   if($resultado["cuenta"] == "1") {
     $consulta = "DELETE FROM final_favoritos WHERE idusuario='$usuario' AND idproducto=$producto";
     if ($con->query($consulta) === TRUE) {
        $con->close;
        return 2;
     } else {
        $con->close;
        return -2;
     }
   }else {
     $consulta = "insert into final_favoritos (idusuario, idproducto) values ('$usuario', $producto)";
     if ($con->query($consulta) === TRUE) {
       $con->close;
       return 1;
     } else {
        $con->close;
        return -1;
     }
   }
}
function mregistrar(){
   /**************************************************************
	Función encargada de registrar a un usuario
	Devuelve:
		 1 --> Registrado correctamente
		-1 --> Error conexión bbdd
      -2 --> NO hay user
      -3 --> NO hay password
      -4 --> Email no valido
      -5 --> NO hay email
      -6 --> NO hay direccion
      -7 --> NO hay nombre
      -8 --> Error al añadir al usuario
   Si <0 --> falloreg
	****************************************************************/
   // function falloreg(){
   //   header("Location: controlador.php?accion=registro&id=2");
   //   die();
   // }
   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      return -1;
   }
   $sql = $conn->prepare("INSERT INTO final_usuario (idusuario, password, email, direccion, nombre) VALUES (?, ?, ?, ?, ?)");
   $sql->bind_param("sssss", $usuario, $password, $email, $direccion, $nombre);

    if (isset($_POST["user"])) {
       $usuario = $_POST["user"];
    }else {
      $conn->close;
      return -2;
    }
    if (isset($_POST["password"])) {
       $password = $_POST["password"];
       $password=password_hash($password,CRYPT_BLOWFISH);
    }else{
      $conn->close;
      return -3;
    }
    if (isset($_POST["email"])) {
       if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          $email = $_POST["email"];
       }else {
          $conn->close;
          return -4;
       }
    }else{
      $conn->close;
      return -5;
    }
    if (isset($_POST["direccion"])) {
       $direccion = $_POST["direccion"];
    }else{
      $conn->close;
      return -6;
    }
    if (isset($_POST["nombre"])) {
       $nombre = $_POST["nombre"];
    }else{
      $conn->close;
      return -7;
    }
    if ($sql->execute() === TRUE) {
      // header("Location: controlador.php?accion=login&id=1");
      $conn->close;
      return 1;
    } else {
      $conn->close;
      return -8;
    }
}
function mCheckUser(){
   /****************************************************
	Verifica si un usuario pertenece a la BBDD
	Devuelve:
		"1" --> Ya existe ese usuario
		"-1" --> Error conexión BBDD
		"-2" --> Error al consultar si existe el usuario
      "" --> No existe el usuario
	****************************************************/
   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if ($conn->connect_errno){
      return "-1";
   }else {
     $sql = $conn->prepare("SELECT count(idusuario) FROM final_usuario WHERE idusuario = ?");
     $sql->bind_param("s", $usr);
     $usr = $_GET["usr"];
     if($sql->execute()) {
        $sql->bind_result($num);
        $sql->fetch();
        if ($num == "1") {
           return 1;
           $conn->close;
           return "Ya existe el usuario<br>";
        }else {
           return "";
        }
      } else {
        return "-2";
      }
   }
}
?>
