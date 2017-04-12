<?php

     public function vMostrarIndice()
     {
          $page = file_get_contents("templates/core/header.html");
          $page = str_replace("##titulo##", "index", $page);
          $page . file_get_contents("templates/index.html");
          $page . file_get_contents("templates/core/footer.html");
     }

?>
