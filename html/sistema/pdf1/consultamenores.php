<?php 
	require_once('conexion/conexion.php');	
	$usuario = 'SELECT * FROM grupo_familiar where edad_miembro <= 18 ORDER BY cedula_miembro ASC';	
	$usuarios=$mysqli->query($usuario);
	
if(isset($_POST['create_pdf'])){
	require_once('tcpdf/tcpdf.php');
	
	$pdf = new TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Miguel Caro');
	$pdf->SetTitle($_POST['reporte_name']);
	
	$pdf->setPrintHeader(false); 
	$pdf->setPrintFooter(false);
	$pdf->SetMargins(20, 20, 20, false); 
	$pdf->SetAutoPageBreak(true, 20); 
	$pdf->SetFont('Helvetica', '', 10);
	$pdf->addPage();

	$content = '';

  $content .= '
    <div class="row">
          <div class="col-md-12">
              <h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
        
      <table border="1" cellpadding="5" bgcolor="#blue">
        <thead >
          <tr>
           <th>N</th>
            <th>Cedula</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>F Nacimiento</th>
            <th>Edad</th>
            <th>Telefono</th>
           
          </tr>
        </thead>
  ';
  
  
  while ($user=$usuarios->fetch_assoc()) { 
  $content .= '
    <tr bgcolor="#red">
            <td>'.$user['nacionalidad_miembro'].'</td>
            <td>'.$user['cedula_miembro'].'</td>
            <td>'.$user['nombres_miembro'].'</td>
            <td>'.$user['apellidos_miembro'].'</td>
            <td>'.$user['fecha_nacimiento_miembro'].'</td>
            <td>'.$user['edad_miembro'].'</td>
            <td>'.$user['telefono_miembro'].'</td>
          
        </tr>

          
  ';
  }
  
  $content .= '</table>';
  
 


	
	
	$pdf->writeHTML($content, true, 0, true, 0);

	$pdf->lastPage();
	$pdf->output('Reporte.pdf', 'I');
}

?>
		 
          
        
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Exportar a PDF - Mision Sucre</title>
<meta name="keywords" content="">
<meta name="description" content="">
<!-- Meta Mobil
================================================== -->
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>

<body style="background-color:#FFC2A8">
	<div class="container-fluid">
        <div class="row padding">
          <div class="well well-well">
        	<div class="col-md-12">
            	<?php $h1 = "Datos de los Menores de Edad en pdf";  
            	 echo '<h1>'.$h1.'</h1>'
				?>
            </div>
 
              <div class="row">
      <table class="table table-hover" style="text-align:center;">
        <thead>
          <tr>
            <th><center>N</center></th>
            <th><center>Cedula</center></th>
            <th><center>Nombres</center></th>
            <th><center>Apellidos</center></th>
            <th><center>F de Nacimiento</center></th>
            <th><center>Edad</center></th>
            <th><center>Telefono</center></th>
            <th><center>Cedula Jefe</center></th>
            
            
          </tr>
        </thead>
        <tbody>
        <?php 
      while ($user=$usuarios->fetch_assoc()) {   ?>
          <tr class="">
            <td><?php echo $user['nacionalidad_miembro']; ?></td>
            <td><?php echo $user['cedula_miembro']; ?></td>
            <td><?php echo $user['nombres_miembro']; ?></td>
            <td><?php echo $user['apellidos_miembro']; ?></td>
            <td><?php echo $user['fecha_nacimiento_miembro']; ?></td>
            <td><?php echo $user['edad_miembro']; ?></td>
            <td><?php echo $user['telefono_miembro']; ?></td>
            <td><?php echo $user['cedulaj']; ?></td>
            
          </tr>
         <?php } ?>
        </tbody>
      </table>

      
    
              <div class="col-md-12">
                <form method="post">
                  <input type="hidden" name="reporte_name" value="<?php echo $h1; ?>">
                  <a href="../vista/cargarmenores.php" class="btn btn-danger pull-left" > Volver</a>
                  <input type="submit" name="create_pdf" class="btn btn-danger pull-right" value="Generar PDF">
                </div>
                </form>
              </div>
        </div>
    </div>

</body>
</html>