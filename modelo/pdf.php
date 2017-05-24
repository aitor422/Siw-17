<?php

function mPdf()
{
     require('fpdf181/fpdf.php');
     //require('fpdf181/makefont/makefont.php');//Necesario para Roboto(1ª vez)
     //MakeFont('static/fonts/Roboto-Light.ttf','cp1252');

     $pdf = new FPDF('P','mm','A4');//210*297mm
     $pdf->SetTitle('Productos Favoritos - Color digital');
     $pdf->AddPage();
     $pdf->Image('static/images/logo_completo.png',10,10,40,40,'PNG');
     $pdf->AddFont('Roboto-Light','','Roboto-Light.php');
     $pdf->SetFont('Roboto-Light','',22);
     $pdf->Ln(20);
     $pdf->Cell(57,0,'Mail:',0,0,'R');
     $pdf->SetTextColor(42,163,239);
     $pdf->Cell(94,0," colordigital@colordigital.es",0,1,'R',"mailto:colordigital@colordigital.es");
     $pdf->SetTextColor(0,0,0);
     $pdf->Ln(10);
     $pdf->Cell(40,40,utf8_decode('Productos añadidos a favoritos: '),0,1);
     $pdf->SetFont('Courier','',14);

     //Obtenemos los productos del usuario
     if (session_status() == PHP_SESSION_NONE)
          session_start();
     $usuario = $_SESSION["usuario"];
     $con = new mysqli("dbserver", "siw14", "eeshaekaip", "db_siw14");
     $consulta = "select idproducto from final_favoritos where idusuario = '$usuario'";
     $resultado = $con->query($consulta);
     $ids=array();
     $i=0;
     while ($datos = $resultado->fetch_assoc()) {
       $ids[$i]=$datos["idproducto"];
       $i+=1;
     }
     //Obtenemos las caracteristicas de los productos del usuario
     foreach ($ids as $idproductofor ) {
        // mySQL no tiene FULL OUTER JOIN y hay que hacerlo de esta manera tan bonita
        $consulta = "select nombre,precio,categoria,descripcion,min(imagen) from final_productos LEFT JOIN (SELECT * FROM final_imagenes WHERE imagen like '%_pequena%') imag on final_productos.idproducto = imag.idproducto where final_productos.idproducto = '$idproductofor' UNION ALL select nombre,precio,categoria,descripcion,min(imagen) from final_productos RIGHT JOIN (SELECT * FROM final_imagenes WHERE imagen like '%_pequena%') imag on final_productos.idproducto = imag.idproducto where final_productos.idproducto is null";
        $resultado = $con->query($consulta);
        $datos = $resultado->fetch_assoc();//Solo hay una linea.Iteramos sobre idproducto
        if ($datos["imagen"]!=NULL) {
           $pdf->Image('static/images/catalogo/'.$datos["imagen"],null,null,40,40);
        }
        $pdf->Cell(20,20,'Id Producto: '.$idproductofor,0,1);//El 1 equivale al salto de linea y debajo a la izquierda
        $pdf->MultiCell(0,20,'Nombre del producto: '.$datos["nombre"],0);
        $pdf->MultiCell(0,20,utf8_decode('Descripción del producto: ').utf8_decode($datos["descripcion"]),0);
        $pdf->Cell(20,20,'Precio del producto: '.$datos["precio"].chr(128),0,1);//chr(128)->€
        $pdf->Cell(20,20,utf8_decode('Categoría del producto: ').$datos["categoria"],0,1);//chr(128)->€
     }
     $pdf->Output();
}

?>
