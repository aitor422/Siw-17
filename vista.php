<?php

     function checksession($page, $producto) {
       if (session_status() == PHP_SESSION_NONE)
            session_start();
       if (isset($_SESSION["usuario"])) {
           $page = str_replace("##reguser##", $_SESSION["usuario"], $page);
           $page = str_replace("##loginuser##", "logout", $page);
           $page = str_replace("##linkregistro##", "controlador.php?accion=usuario&id=1", $page);
           $page = str_replace("##linklogin##", "controlador.php?accion=login&id=3", $page);
           $page = str_replace("##botonlogin##", "botonlogout", $page);
           $page = str_replace("##parausuarios##", "", $page);
           if ($producto != 0) {
             $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
             mysqli_set_charset($con,"utf8");
             $usuario = $_SESSION['usuario'];
             $consulta = "select count(*) as cuenta from favoritos where idusuario='$usuario' and idproducto=$producto";
             $resultado = $con->query($consulta);
             $resultado = $resultado->fetch_assoc();
             if($resultado["cuenta"] == "1") {
               $page = str_replace("##favorito##", "Eliminar de favoritos", $page);
             }
             else {
               $page = str_replace("##favorito##", "Añadir a favoritos", $page);
             }
           }
           $page = str_replace("##scriptparausuarios##", "", $page);
       }
       else {
         $page = str_replace("##loginuser##", "login", $page);
         $page = str_replace("##reguser##", "register", $page);
         $page = str_replace("##linklogin##", "controlador.php?accion=login&id=1", $page);
         $page = str_replace("##linkregistro##", "controlador.php?accion=registro&id=1", $page);
         $page = str_replace("##botonlogin##", "botonlogin", $page);
         $cachos = explode("##parausuarios##", $page);
         if (count($cachos) > 1) {
           $page = $cachos[0] . $cachos[2];
         }

         $cachos = explode("##scriptparausuarios##", $page);
         if (count($cachos) > 1) {
           $page = $cachos[0] . $cachos[2];
         }
       }
       return $page;
     }

     function vMostrarIndice()
     {
            $cadena = "<table><tr>";
           $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/index.html") . file_get_contents("templates/core/footer.html");
           $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
           $consulta = "SELECT productos.idproducto, precio, min(imagen) AS imagen FROM productos LEFT JOIN (SELECT * FROM imagenes WHERE imagen like '%_grande%') a on productos.idproducto = a.idproducto WHERE destacado=1 GROUP BY productos.idproducto limit 5";
           $resultado = $con->query($consulta);
           $i = 1;
           while ($datos = $resultado->fetch_assoc()) {
             $page = str_replace("##$i##", $datos["idproducto"], $page);
             $page = str_replace("##p$i##", $datos["precio"] . ".-", $page);
            if ($datos["imagen"] == null)
                  $page = str_replace("##imagen$i##", "http://placehold.it/1000x300" , $page);
            else
                  $page = str_replace("##imagen$i##", "/static/images/catalogo/" . $datos["imagen"]  . " height='300px'" , $page);
             $i++;
           }
           $consulta = "select * from productos where destacado=1 limit 20 offset 5";
           $resultado = $con->query($consulta);
           while ($datos = $resultado->fetch_assoc()) {
             $cadena = $cadena . "<td><a href='controlador.php?accion=producto&id=1&producto=" . $datos["idproducto"] . "'>" . $datos["idproducto"] ."</a></td>";
             if (($i % 5) == 0) {
               $cadena = $cadena . "</tr><tr>";
             }
             $i++;
           }
           $cadena = $cadena . "</tr></table>";
           $page = str_replace("##tablaproductos##", $cadena, $page);
          $page = str_replace("##titulo##", "index", $page);
          $page = str_replace("##index##", "active", $page);
          $page = checksession($page, 0);
          echo $page;
     }


     function vMostrarRegistro()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/registro.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "registro", $page);
          $page = checksession($page, 0);
          $page = str_replace("##regfailed##", "", $page);
          echo $page;
     }

     function vMostrarRegistroFail()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/registro.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "registro", $page);
          $page = checksession($page, 0);
          $page = str_replace("##regfailed##", "Algo ha fallado, usuario no creado.", $page);
          echo $page;
     }

     function vMostrarLogin()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/login.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "login", $page);
          $page = str_replace("##loginfailed##", "", $page);
          $page = checksession($page, 0);
          echo $page;
     }

     function vMostrarLoginFail()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/login.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "login", $page);
          $page = str_replace("##loginfailed##", "usuario o contraseña incorrectos", $page);
          $page = checksession($page, 0);
          echo $page;
     }

     function vMostrarUser()
     {
       if (session_status() == PHP_SESSION_NONE)
            session_start();
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/user.html") . file_get_contents("templates/core/footer.html");
          $cadena = "<ul>";
          $usuario = $_SESSION["usuario"];
           $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
           $consulta = "select idproducto from favoritos where idusuario = '$usuario'";
           $resultado = $con->query($consulta);
           while ($datos = $resultado->fetch_assoc()) {
             $cadena = $cadena . "<li><a href='controlador.php?accion=producto&id=1&producto=" . $datos["idproducto"] . "'>" . $datos["idproducto"] ."</a></li>";
           }
           $cadena = $cadena . "</ul>";
           if ($cadena == "<ul></ul>") {
             $page = str_replace("##productos##", "nada por aquí...", $page);
             $page = str_replace("##botonpdf##", "", $page);
           }
           else {
             $page = str_replace("##productos##", $cadena, $page);
             $page = str_replace("##botonpdf##", "<a target='_blank' href='pdf.php'><button id='botongenerarpdf' class='botonesbonitos' type='button' name='button'  >Generar PDF con favoritos</button></a>", $page);
           }
          $page = str_replace("##titulo##", "tu cuenta", $page);
          $page = str_replace("##cuentausuario##", "active", $page);
          $page = checksession($page, 0);
          if(strcmp ( $usuario , "admin" ) === 0) {
            $page = str_replace("##admin##", "<a class='last' href='controlador.php?accion=admin&id=1'><button class='botonesbonitos' type='button' >Zona de administración</button></a>", $page);
          }
          else {
            $page = str_replace("##admin##", "", $page);
          }
          echo $page;
     }

     function vMostrarCatalogo()
     {
         $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
         mysqli_set_charset($con,"utf8");
         $consulta = "select distinct(categoria) as cat from productos";
         $resultado = $con->query($consulta);
         $selectores = "";
         while ($datos = $resultado->fetch_assoc()) {
           if ($datos["cat"] != "") {
             $selectores = $selectores . "<option value='" . $datos["cat"] . "'>". $datos["cat"] ."</option>";
           }
         }

          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/catalogo.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##selectorescategoria##", $selectores, $page);
          $page = str_replace("##titulo##", "catálogo", $page);
          $page = str_replace("##catalogo##", "active", $page);
          $page = checksession($page, 0);
          echo $page;
     }

     function vMostrarLocalizacion()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/localizacion.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "localizacion", $page);
          $page = str_replace("##localizacion##", "active", $page);
          $page = checksession($page, 0);
          echo $page;
     }
     function vMostrarServicios()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/servicios.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "servicios", $page);
          $page = str_replace("##servicios##", "active", $page);
          $page = checksession($page, 0);
          echo $page;
     }

     function vMostrarAdmin() {
          if (session_status() == PHP_SESSION_NONE)
               session_start();
          if ($_SESSION["usuario"] != "admin")
               vMostrarIndice();
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/admin.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "admin", $page);
          $page = checksession($page, 0);
          echo $page;
     }

     function vMostrarProducto($producto) {
       $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
       $consulta = "SELECT productos.idproducto, nombre, precio, min(imagen) AS imagen FROM productos LEFT JOIN (SELECT * FROM imagenes WHERE imagen like '%_mediana%') a ON productos.idproducto = a.idproducto WHERE productos.idproducto = $producto GROUP BY productos.idproducto";
       $resultado = $con->query($consulta);
       $resultado = $resultado->fetch_assoc();
       $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/producto.html") . file_get_contents("templates/core/footer.html");
       $page = str_replace("##titulo##", $producto, $page);
      if ($resultado["imagen"] == null)
            $page = str_replace("##imagen##", "http://placehold.it/350x150", $page);
      else
             $page = str_replace("##imagen##", "/static/images/catalogo/" . $resultado["imagen"], $page);
       $page = str_replace("##idproducto##", $resultado["idproducto"], $page);
       $page = str_replace("##descripcion##", $resultado["nombre"], $page);
       $page = str_replace("##precio##", $resultado["precio"], $page);
       $page = checksession($page, $producto);
       echo $page;
     }

     function vMostrarLegal()
     {
          $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/legal.html") . file_get_contents("templates/core/footer.html");
          $page = str_replace("##titulo##", "legal", $page);
          $page = checksession($page, 0);
          echo $page;
     }

     function vMostrarNuevo(){
          if (session_status() == PHP_SESSION_NONE)
               session_start();
          if ($_SESSION["usuario"] != "admin")
               vMostrarIndice();

         $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
         mysqli_set_charset($con,"utf8");
         $consulta = "select distinct(categoria) as categoria from productos";
         $resultado = $con->query($consulta);
         $selectores = "";
         while ($datos = $resultado->fetch_assoc()) {
           if ($datos["categoria"] != "") {
             $selectores = $selectores . "<option value='" . $datos["categoria"] . "'>". $datos["categoria"] ."</option>";
           }
         }
         $consulta = "select max(idproducto) as maximo from productos";
         $resultado = $con->query($consulta);
         $datos = $resultado->fetch_assoc();
         $nuevoid=$datos["maximo"]+1;
         $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/admin.html") . file_get_contents("templates/nuevo.html"). file_get_contents("templates/core/footer.html");
         $page = str_replace("##titulo##", "nuevo", $page);
         $page = str_replace("##nuevo##", "active", $page);
         $page = str_replace("##selectorescategoria##", $selectores, $page);
         $page = str_replace("##id##", '<input type="hidden" id="nuevoid" value="'.$nuevoid.'">', $page);
         $page = checksession($page, 0);
         echo $page;
     }

     function vMostrarModificar(){
          if (session_status() == PHP_SESSION_NONE)
               session_start();
          if ($_SESSION["usuario"] != "admin")
               vMostrarIndice();

         $page = file_get_contents("templates/core/header.html") . file_get_contents("templates/admin.html") . file_get_contents("templates/modificar.html"). file_get_contents("templates/core/footer.html");
         $page = str_replace("##modificar##", "modificar", $page);
         $page = checksession($page, 0);
         echo $page;
     }

?>
