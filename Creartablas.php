<?php
   $dblink = mysqli_connect("http://webalumnos.tlm.unavarra.es:10298/", "siw14", "eeshaekaip", "db_siw14");
   if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   $sql="-- -----------------------------------------------------
   -- Table `mydb`.`productos`
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS `mydb`.`productos` (
     `idproducto` INT NOT NULL,
     `categoria` VARCHAR(45) NULL,
     `nombre` VARCHAR(45) NULL,
     `precio` INT NULL,
     `destacado` TINYINT(1) NULL,
     PRIMARY KEY (`idproducto`))
   ENGINE = InnoDB;


   -- -----------------------------------------------------
   -- Table `mydb`.`usuario`
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS `mydb`.`usuario` (
     `idusuario` VARCHAR(15) NOT NULL,
     `contraseña` VARCHAR(20) NULL,
     `email` VARCHAR(45) NULL,
     `direccion` VARCHAR(45) NULL,
     `nombre` VARCHAR(45) NULL,
     PRIMARY KEY (`idusuario`))
   ENGINE = InnoDB;


   -- -----------------------------------------------------
   -- Table `mydb`.`valoracion`
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS `mydb`.`valoracion` (
     `idprod` INT NOT NULL,
     `puntuacion` VARCHAR(45) NULL,
     `idusr` VARCHAR(45) NOT NULL,
     PRIMARY KEY (`idprod`, `idusr`),
     INDEX `idVal_Usr_idx` (`idusr` ASC),
     CONSTRAINT `idVal_Prod`
       FOREIGN KEY (`idprod`)
       REFERENCES `mydb`.`productos` (`idproducto`)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION,
     CONSTRAINT `idVal_Usr`
       FOREIGN KEY (`idusr`)
       REFERENCES `mydb`.`usuario` (`idusuario`)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION)
   ENGINE = InnoDB;


   -- -----------------------------------------------------
   -- Table `mydb`.`comentario`
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS `mydb`.`comentario` (
     `idprod` INT NOT NULL,
     `idusuario` VARCHAR(15) NOT NULL,
     `Contenido` VARCHAR(140) NULL,
     PRIMARY KEY (`idprod`, `idusuario`),
     INDEX `idCom_Usr_idx` (`idusuario` ASC),
     CONSTRAINT `idCom_Prod`
       FOREIGN KEY (`idprod`)
       REFERENCES `mydb`.`productos` (`idproducto`)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION,
     CONSTRAINT `idCom_Usr`
       FOREIGN KEY (`idusuario`)
       REFERENCES `mydb`.`usuario` (`idusuario`)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION)
   ENGINE = InnoDB;


   -- -----------------------------------------------------
   -- Table `mydb`.`favoritos`
   -- -----------------------------------------------------
   CREATE TABLE IF NOT EXISTS `mydb`.`favoritos` (
     `idusuario` VARCHAR(15) NOT NULL,
     `idproducto` INT NOT NULL,
     PRIMARY KEY (`idusuario`, `idproducto`),
     INDEX `FK_favoritos_productos_idx` (`idproducto` ASC),
     CONSTRAINT `FK_favoritos_usuario`
       FOREIGN KEY (`idusuario`)
       REFERENCES `mydb`.`usuario` (`idusuario`)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION,
     CONSTRAINT `FK_favoritos_productos`
       FOREIGN KEY (`idproducto`)
       REFERENCES `mydb`.`productos` (`idproducto`)
       ON DELETE NO ACTION
       ON UPDATE NO ACTION)
   ENGINE = InnoDB;";
   if ($conn->query($sql) === TRUE) {
      echo "Tabla creada correctamente";
   } else {
      echo "Error creando tabla: " . $conn->error;
   }
 ?>
