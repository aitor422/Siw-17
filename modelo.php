<?php

     foreach (glob("modelo/*.php") as $filename)
     {
         include $filename;
     }

 ?>
