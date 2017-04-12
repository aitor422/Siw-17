<?php

     function vMostrarIndice()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/index.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "index", $page);
          echo $page;
     }

     function vMostrarRegistro()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/registro.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "registro", $page);
          echo $page;
     }

?>
