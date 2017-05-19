<?php

     include 'vista.php';
     include 'modelo.php';
     $resultado=mMostrarIndice();
     $resultado2=mMostrarIndiceTablaProds();
     vMostrarIndice($resultado,$resultado2);

?>
