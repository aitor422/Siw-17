<?php
   require('fpdf181/fpdf.php');
   require('makefont/makefont.php');//Necesario para Roboto(1ª vez)
   MakeFont('static/fonts/Roboto-Light.ttf','cp1252');
   $pdf = new FPDF('P','mm','A4');
   $pdf->AddPage();
   $pdf->Image('static/images/logo_completo.png',10,10,295,295,'PNG');
   $pdf->AddFont('Roboto','','Roboto-Light');
   $pdf->SetFont('Roboto','B',22);
   $pdf->Cell(50,10,'Mail: colordigital@colordigital.es',0,0,'R',"mailto:colordigital@colordigital.es");
   $pdf->Ln(20);
   $pdf->Cell(40,40,'Productos añadidos a favoritos: ',0,0);
   $pdf->SetFont('Roboto','',14);
   //Obtenemos los productos del usuario
   $usuario = $_SESSION["usuario"];
   $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
   $consulta = "select idproducto from favoritos where idusuario = '$usuario'";
   $resultado = $con->query($consulta);
   $ids=array();
   $i=0;
   while ($datos = $resultado->fetch_assoc()) {
     $ids[$i]=$datos["idproducto"];
     $i+=1;
   }
   //Obtenemos las caracteristicas de los productos del usuario
   foreach ($ids as $idproductofor ) {
      $consulta = "select nombre,precio from productos where idproducto = '$idproductofor'";
      $resultado = $con->query($consulta);
      $datos = $resultado->fetch_assoc();//Solo hay una linea.Iteramos sobre idproducto
      $pdf->Cell(20,20,'Id Producto: '.$idproductofor,0,1);//El 1 equivale al salto de linea y debajo a la izquierda
      $pdf->Cell(20,20,'Nombre del producto: '.$datos["nombre"],0,1);
      $pdf->Cell(20,20,'Precio del producto: '.$datos["precio"].'€',0,1);
   }
   //TODO Ver cuantos caben en cada pagina y añadir pagina en función de si llegamos al tope
   $pdf->Output();
?>
