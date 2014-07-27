<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'4') == TRUE) and !(stristr($_SESSION['cargo'],'5') == TRUE) and !(stristr($_SESSION['cargo'],'8') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}  
?>
<?php
 include("../../menu.php");
 include("menu.php");
 ?>
<br />
<div align="center">
<div class="page-header">
  <h2>Biblioteca del Centro <small> Consultas en los Fondos de la Biblioteca</small></h2>
</div>
</div>
<br />
<div class="container-fluid">
<div class="row">
           
 <div class="col-sm-10 col-sm-offset-1">
 <div align="center">
  <?php
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
    $AUXSQL .= " and Autor like '%$autor%'";
    }
  if  (TRIM("$titulo")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and Titulo like '%$titulo0%'";
    }
  IF (TRIM("$editorial")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and Editorial like '%$editorial%'";
    }

  if(!(empty($idfondo)))
  {
  echo "<p class='lead text-muted'>Datos del volumen seleccionado</p>";

 $informe0 = "select  id, Autor, Titulo, Editorial, ISBN, tipoEjemplar, anoEdicion, extension, serie, ubicacion, LugarEdicion from biblioteca where id = '$idfondo'";
 $sqlinforme0 = mysql_query($informe0);
$filas = mysql_num_rows($sqlinforme0);
if ($filas > 0) {
 $informe = "select id, Autor, Titulo, Editorial, ISBN, tipoEjemplar, anoEdicion, extension, serie, ubicacion, lugaredicion from biblioteca where id = '$idfondo'";	
}
else 
{
$informe = "select id, Autor, Titulo, Editorial, ISBN, tipoEjemplar, anoEdicion, extension, serie, ubicacion, lugaredicion from biblioteca where id = '$idfondo'";
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
	$LugarEdicion = $rowinforme[10];
	$ubicacion = $rowinforme[9];	
$numero = "select id from biblioteca where Titulo = '$titulo0' and Autor = '$autor'";
$numero1 = mysql_query($numero);
$numero2 = mysql_num_rows($numero1);
$ejemplares = $numero2;
echo "<table class='table table-striped tanle-bordered' style='width:600px;'>
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
      <td>UBICACI&Oacute;N: <span class='text-info'>$ubicacion </span></td>
    </tr>
      <tr>
    <td>N&Uacute;MERO DE EJEMPLARES: <span class='text-info'>$ejemplares</span></td>
      <td>LUGAR DE EDICI&Oacute;N: <span class='text-info'>$LugarEdicion </span></td>
    </tr>
        
  </table><hr /><br />";
  }
  }
  
  	if (!($autor == "" and $titulo0 == "" and $editorial == "")) {
 
  $result = mysql_query ("select id, Autor, Titulo, Editorial from biblioteca where 1 " . $AUXSQL . " order by Autor asc");
if (mysql_num_rows($result) > 0) {
print "<p class='lead text-muted'>Búsqueda de Libros en la Biblioteca</p>";
echo "<table class='table table-striped table-bordered' style='width:auto'>";
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
printf ("<tr><td class='text-success'>%s</td><td>%s</td><td>%s</td><td><a href='biblioteca.php?idfondo=$id&autor=$autor&titulo=$titulo0&editorial=$editorial'><i class='fa fa-search' rel='Tooltip' title='Ver detalles del volumen'> </i></a></td></tr>", $row[1], $row[2], $row[3]);
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
