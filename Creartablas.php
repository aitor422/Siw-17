<?php
   $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   $sql="-- -----------------------------------------------------
   -- Table productos
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS productos (
     idproducto INT NOT NULL,
     categoria VARCHAR(45) NULL,
     nombre VARCHAR(45) NULL,
     precio INT NULL,
     destacado TINYINT(1) NULL,
     PRIMARY KEY (idproducto))";

   if ($conn->query($sql) === TRUE) {
      echo "Tabla productos correctamente <br>";
   } else {
      echo "Error creando tabla productos: " . $conn->error."<br>";
   }
   $sql="-- -----------------------------------------------------
   -- Table usuario
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS usuario (
     idusuario VARCHAR(15) NOT NULL,
     password VARCHAR(20) NULL,
     email VARCHAR(45) NULL,
     direccion VARCHAR(45) NULL,
     nombre VARCHAR(45) NULL,
     PRIMARY KEY (idusuario))";
     if ($conn->query($sql) === TRUE) {
        echo "Tabla usuario correctamente <br>";
     } else {
        echo "Error creando tabla usuario: " . $conn->error."<br>";
     }
   $sql="-- -----------------------------------------------------
   -- Table valoracion
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS valoracion (
     idprod INT NOT NULL,
     puntuacion VARCHAR(45) NULL,
     idusr VARCHAR(45) NOT NULL,
     PRIMARY KEY (idprod, idusr),
     INDEX idVal_Usr_idx (idusr ASC),
     CONSTRAINT idVal_Prod
       FOREIGN KEY (idprod)
       REFERENCES productos (idproducto)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION,
     CONSTRAINT idVal_Usr
       FOREIGN KEY (idusr)
       REFERENCES usuario (idusuario)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION)";
   if ($conn->query($sql) === TRUE) {
      echo "Tabla valoracion correctamente <br>";
   } else {
      echo "Error creando tabla valoracion: " . $conn->error."<br>";
   }
   $sql="-- -----------------------------------------------------
   -- Table comentario
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS comentario (
     idprod INT NOT NULL,
     idusuario VARCHAR(15) NOT NULL,
     Contenido VARCHAR(140) NULL,
     PRIMARY KEY (idprod, idusuario),
     INDEX idCom_Usr_idx (idusuario ASC),
     CONSTRAINT idCom_Prod
       FOREIGN KEY (idprod)
       REFERENCES productos (idproducto)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION,
     CONSTRAINT idCom_Usr
       FOREIGN KEY (idusuario)
       REFERENCES usuario (idusuario)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION)";
   if ($conn->query($sql) === TRUE) {
      echo "Tabla comentario correctamente <br>";
   } else {
      echo "Error creando tabla comentario: " . $conn->error."<br>";
   }
   $sql="-- -----------------------------------------------------
   -- Table favoritos
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS favoritos (
     idusuario VARCHAR(15) NOT NULL,
     idproducto INT NOT NULL,
     PRIMARY KEY (idusuario, idproducto),
     INDEX FK_favoritos_productos_idx (idproducto ASC),
     CONSTRAINT FK_favoritos_usuario
       FOREIGN KEY (idusuario)
       REFERENCES usuario (idusuario)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION,
     CONSTRAINT FK_favoritos_productos
       FOREIGN KEY (idproducto)
       REFERENCES productos (idproducto)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION)";
   if ($conn->query($sql) === TRUE) {
      echo "Tabla favoritos correctamente <br>";
   } else {
      echo "Error creando tabla favoritos: " . $conn->error."<br>";
   }
 ?>
