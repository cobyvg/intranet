<? include("../conf_principal.php");?>
<? include "../cabecera.php"; ?>
<? include "../menu.php"; ?>

<div class="span9">	
<h3 align='center'>Consultas en los Fondos de la Biblioteca del Centro<br /></h3>  <hr />	           
 <div class="span10 offset1">
 <div align="center">
  <?php
		
include("../conf_principal.php");
  mysql_connect ($biblio_host,$biblio_user,$biblio_pass);
  mysql_select_db ($biblio_db);
  if (isset($_POST['autor'])) {
  	$autor = $_POST['autor'];
  }
  elseif (isset($_GET['autor'])) {
  	$autor = $_GET['autor'];
  }
  
  if (isset($_POST['titulo0'])) {
  	$itulo0 = $_POST['titulo0'];
  }
  elseif (isset($_GET['titulo0'])) {
  	$itulo0 = $_GET['titulo0'];
  }
  
  if (isset($_POST['editorial'])) {
  $editorial = $_POST['editorial'];	
  }
  elseif (isset($_GET['editorial'])) {
  $editorial = $_GET['editorial'];	
  }
  
    if (isset($_GET['idfondo'])) {
  $idfondo = $_GET['idfondo'];	
  }  
  $AUXSQL == "";
  if  (TRIM("$autor")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and qrFondos.Autor like '%$autor%'";
    }
  if  (TRIM("$titulo")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and qrFondos.Titulo like '%$titulo0%'";
    }
  IF (TRIM("$editorial")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and qrFondos.Editorial like '%$editorial%'";
    }

  if(!(empty($idfondo)))
  {
  echo "<p class='lead muted'>Datos del volumen seleccionado</p>";

 $informe0 = "select qrFondos.idFondo, qrFondos.Autor, qrFondos.Titulo, qrFondos.Editorial, qrFondos.ISBN, qrFondos.TipoFondo, qrFondos.AnoEdicion, qrFondos.Extension, qrFondos.Serie, CDU2.TEXTO, qrFondos.LugarEdicion from qrFondos, CDU, CDU2 where qrFondos.idFondo = CDU.idFondo and CDU.CDU = CDU2.CDU and qrFondos.idFondo = '$idfondo'";
 $sqlinforme0 = mysql_query($informe0);
$filas = mysql_num_rows($sqlinforme0);
if ($filas > 0) {
 $informe = "select qrFondos.idFondo, qrFondos.Autor, qrFondos.Titulo, qrFondos.Editorial, qrFondos.ISBN, qrFondos.TipoFondo, qrFondos.AnoEdicion, qrFondos.Extension, qrFondos.Serie, qrFondos.LugarEdicion, CDU2.TEXTO from qrFondos, CDU, CDU2 where qrFondos.idFondo = CDU.idFondo and CDU.CDU = CDU2.CDU and qrFondos.idFondo = '$idfondo'";	
}
else 
{
$informe = "select qrFondos.idFondo, qrFondos.Autor, qrFondos.Titulo, qrFondos.Editorial, qrFondos.ISBN, qrFondos.TipoFondo, qrFondos.AnoEdicion, qrFondos.Extension, qrFondos.Serie, qrFondos.LugarEdicion from qrFondos where qrFondos.idFondo = '$idfondo'";
}
$sqlinforme = mysql_query($informe);
if($rowinforme = mysql_fetch_array($sqlinforme))
	{
	$id = $rowinforme[0];
	$autor0 = $rowinforme[1];
	$tituloa = $rowinforme[2];
	$editorial0 = $rowinforme[3];
	$isbn = $rowinforme[4];
	$tipofondo = $rowinforme[5];
	$anoedicion = $rowinforme[6];
	$extension = $rowinforme[7];
	$serie = $rowinforme[8];
	$LugarEdicion = $rowinforme[9];
	$cdu = $rowinforme[10];	
$numero = "select idFondo from qrFondos where Titulo = '$titulo0' and Autor = '$autor'";
$numero1 = mysql_query($numero);
$numero2 = mysql_num_rows($numero1);
$ejemplares = $numero2;
echo "<table class='table table-striped tanle-bordered' style='width:auto;'>
  <tr>
    <td>T&Iacute;TULO: <span class='text-info'>$tituloa</span></td>
      <td>AUTOR: <span class='text-info'>$autor0</span></td>
    </tr>
  <tr>
    <td>EDITORIAL: <span class='text-info'>$editorial0</span></td>
      <td>ISBN: <span class='text-info'>$isbn</span></td>
    </tr>
    
  <tr>
    <td>TIPO DE FONDO: <span class='text-info'>$tipofondo</span></td>
      <td>AÑO DE EDICI&Oacute;N: <span class='text-info'>$anoedicion</span></td>
    </tr>
    
      <tr>
    <td>P&Aacute;GINAS: <span class='text-info'>$extension</span></td>
      <td>CLASIFICACI&Oacute;N: <span class='text-info'>$cdu </span></td>
    </tr>
      <tr>
    <td>N&Uacute;MERO DE EJEMPLARES: <span class='text-info'>$ejemplares</span></td>
      <td>LUGAR DE EDICI&Oacute;N: <span class='text-info'>$LugarEdicion </span></td>
    </tr>
        
  </table><hr /><br />";
  }
  }
  
  	if (!($autor == "" and $titulo0 == "" and $editorial == "")) {
 
  $result = mysql_query ("select qrFondos.idFondo, qrFondos.Autor, qrFondos.Titulo, qrFondos.Editorial from qrFondos where 1 " . $AUXSQL . " order by qrFondos.Autor asc");
if (mysql_num_rows($result) > 0) {
print "<p class='lead muted'>Búsqueda de Libros en la Biblioteca</p>";
echo "<table class='table table-striped table-bordered'>";
echo "<thead><th>Autor</th><th>Título</th><th>Editorial</th><th></th></thead><tbody>";

while($row = mysql_fetch_array($result))
		 {
	$id = $row[0];
	$autor2 = $row[1];
	$titulo2 = $row[2];
	$editorial2 = $row[3];		
		if(substr($row[3],0,1) == ":")
				{
				$limpia = explode(":",$editorial2);
				$editorial2 = $limpia[1];
				}
				// echo $dospuntos;
				$limpia = explode(":",$row[3]);
printf ("<tr><td class='text-success'>%s</td><td>%s</td><td>%s</td><td><a href='biblioteca.php?idfondo=$id&autor=$autor&titulo=$titulo0&editorial=$editorial'><i class='icon icon-search' rel='Tooltip' title='Ver detalles del volumen'> </i></a></td></tr>", $row[1], $row[2], $row[3]);
        }
            echo "</table>";
        }
        else {
				echo ' <br /><div class="alert alert-warning" style="width:500px;margin:auto;"><h4>Problema en la Consulta de Fondos.</h4>Parece que ningún volumen de los Fondos de la Biblioteca responde a tu criterio de búsqueda, bien porque no existe el texto o bien porque no ha sido aún registrado. Puedes volver atrás e intentarlo de nuevo</div><br />';
        	}	
}

else {
	echo ' <br /><div class="alert alert-warning" style="width:500px;margin:auto;"><h4>Problema en la Consulta de Fondos.</h4>Debes escribir algún dato en los campos "<em>Autor</em>", "<em>Título</em>" o "<em>Editorial</em>" del formulario de la página anterior. Vuelve atrás e inténtalo de nuevo rellenando algún campo del formulario.</div><br />';
}	
    echo " <div align=center style='margin-top:15px;'><a href=index.php class='btn btn-primary'>Consultar más Libros</a></div><br />";
  ?>
</div>
</div>
</div>
<? include "../pie.php"; ?>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
</script> 
