<?php

    echo "aaaaaaaa";

    $conn = mysqli_connect("dbserver", "siw14", "eeshaekaip", "db_siw14");
    if ($conn->connect_errno{
       echo -1;
    }
    else {
      $sql = $conn->prepare("SELECT count(idusuario) FROM usuario WHERE idusuario LIKE ?");
      $sql->bind_param("s", $usr);
      $usr = $_GET["usr"];
      if($sql->execute()) {
        $sql->bind_result($num);
        $sql->fetch();
        if ($num === "1") {
          echo "Ya existe el usuario<br>"
        }
        else {
          echo "";
        }
      } else {
        echo -2;
      }


    }

 ?>
