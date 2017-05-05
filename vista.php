<?php

     function checksession($page) {
       if (session_status() == PHP_SESSION_NONE)
            session_start();
       if (isset($_SESSION["usuario"])) {
           $page = str_replace("##reguser##", $_SESSION["usuario"], $page);
           $page = str_replace("##loginuser##", "logout", $page);
           $page = str_replace("##linkregistro##", "controlador.php?accion=usuario&id=1", $page);
           $page = str_replace("##linklogin##", "controlador.php?accion=login&id=3", $page);
           $page = str_replace("##botonlogin##", "botonlogout", $page);
       }
       else {
         $page = str_replace("##loginuser##", "login", $page);
         $page = str_replace("##reguser##", "register", $page);
         $page = str_replace("##linklogin##", "controlador.php?accion=login&id=1", $page);
         $page = str_replace("##linkregistro##", "controlador.php?accion=registro&id=1", $page);
         $page = str_replace("##botonlogin##", "botonlogin", $page);

       }
       return $page;
     }

     function vMostrarIndice()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/index.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "index", $page);
          $page = str_replace("##index##", "active", $page);
          $page = checksession($page);
          echo $page;
     }


     function vMostrarRegistro()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/registro.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "registro", $page);
          $page = checksession($page);
          $page = str_replace("##regfailed##", "", $page);
          echo $page;
     }

     function vMostrarRegistroFail()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/registro.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "registro", $page);
          $page = checksession($page);
          $page = str_replace("##regfailed##", "Algo ha fallado, usuario no creado.", $page);
          echo $page;
     }

     function vMostrarLogin()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/login.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "login", $page);
          $page = str_replace("##loginfailed##", "", $page);
          $page = checksession($page);
          echo $page;
     }

     function vMostrarLoginFail()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/login.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "login", $page);
          $page = str_replace("##loginfailed##", "usuario o contraseña incorrectos", $page);
          $page = checksession($page);
          echo $page;
     }

     function vMostrarUser()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/user.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "tu cuenta", $page);
          $page = str_replace("##cuentausuario##", "active", $page);
          $page = checksession($page);
          if(strcmp ( $_SESSION["usuario"] , "admin" ) === 0) {
            $page = str_replace("##admin##", "<a href='controlador.php?accion=admin&id=1'>user</a>", $page);
          }
          else {
            $page = str_replace("##admin##", "", $page);
          }
          echo $page;
     }

     function vMostrarCatalogo()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/catalogo.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "catalogo", $page);
          $page = str_replace("##catalogo##", "active", $page);
          $page = checksession($page);
          echo $page;
     }

     function vMostrarLocalizacion()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/localizacion.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "localizacion", $page);
          $page = str_replace("##localizacion##", "active", $page);
          $page = checksession($page);
          echo $page;
     }
     function vMostrarServicios()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/servicios.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "servicios", $page);
          $page = str_replace("##servicios##", "active", $page);
          $page = checksession($page);
          echo $page;
     }

     function vMostrarAdmin()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/admin.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "admin", $page);
          $page = checksession($page);
          echo $page;
     }

?>
