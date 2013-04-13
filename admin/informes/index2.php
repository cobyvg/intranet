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
include_once("../../funciones.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Informe del Alumno</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">

<?php
  $SQL1 = "select distinct alma.apellidos, alma.nombre, alma.nivel, alma.grupo, alma.claveal from alma where alma.claveal = '$claveal' order BY alma.apellidos";
  // print ("$AUXSQL");
  $result1= mysql_query($SQL1);
  if ($row1 = mysql_fetch_array($result1))
  {
  	$nivel=$row1[2];
  	$grupo=$row1[3];
  $nom="$row1[0], $row1[1]";
   echo '<div align="center">
<div class="page-header" style="margin-top:-15px;" align="center">
  <h1>Informe del alumno <small>'. $nom .' ('.$row1[2].'-'.$row1[3],')</small></h1>
</div>
<br />';		
if (!($todos == 'Ver Informe Completo del Alumno') ){
?>
<br />
<form name='formulario' method='post' action='index2.php'>
<input name='claveal' type='hidden' value=<? echo "$claveal"; ?>>
<input name='todos' type='submit' id='' value='Ver Informe Completo del Alumno'>
 </form>
 </div>
<?
}
  	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto)) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-top:10px;border:1px solid #bbb;''  />";
		echo "</div>";
	}

  
    } else
    {
    print "<p id='texto_en_marco'>RESULTADOS DE LA BÚSQUEDA:<br>No hubo suerte, bien porque te has equivocado al introducir los datos, bien porque ningún dato se ajusta a tus criterios.</p>";
}
 $SQL2 = "select distinct alma.claveal, alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.padre, alma.matriculas, telefonourgencia, correo, paisnacimiento, nacionalidad, edad from alma where alma.claveal= $claveal order BY alma.apellidos";
 //     print ("$SQL2");
    $result2 = mysql_query($SQL2);
     if ($row2 = mysql_fetch_array($result2))
     {
    echo "<center><table class='tabla' style='padding:4px 8px;'>";
      do {
	  if($row2[6] > 1){  $repite = "SI";  }else{  $repite = "NO";  }
 echo "  <tr><td id='filasecundaria'>CLAVE</td><td style='padding:4px 8px;'>$row2[0] </td><td id='filasecundaria'>DNI</td><td>$row2[1] </td></tr>
	  <tr><td id='filasecundaria'>FECHA</td><td style='padding:4px 8px;'>$row2[2] </td><td id='filasecundaria'>DOMICILIO</td><td>$row2[3] </td></tr>
	  <tr><td id='filasecundaria'>TELÉFONO</td><td style='padding:4px 8px;'>$row2[4] </td><td id='filasecundaria'>TFNO. URGENCIAS</td><td>$row2[7] </td></tr>
	  <tr><td id='filasecundaria'>CORREO</td><td style='padding:4px 8px;'>$row2[8] </td><td id='filasecundaria'>TUTOR</td><td>$row2[5] </td></tr>
	  <tr><td id='filasecundaria'>PAÍS NACIMIENTO</td><td style='padding:4px 8px;'>$row2[9] </td><td id='filasecundaria'>NACIONALIDAD</td><td>$row2[10] </td></tr>
	  <tr><td id='filasecundaria'>EDAD</td><td style='padding:4px 8px;'>$row2[11] </td><td id='filasecundaria'>REPITE</td><td>$repite</td></tr>";
			      } while($row2 = mysql_fetch_array($result2));
			      echo "</table></center><br>\n";
			} 
if ($mod_faltas) {include("faltas.php");
echo "<br>";}

  if ($todos== "")
  {}
  else
{
if ($mod_faltas) {include("faltasd.php");
  echo "<br>";}

include("fechorias.php");
  echo "<br>";

include("notas.php");
  echo "<br>";
}
  if ($todos== "")
  {}
  else
  {include("tutoria.php");
echo "<br>";} 
  if ($todos == "")
  {}
  else
  {
  if ($mod_horario) {
//  	include("horarios.php");
// secho "<br>";}
  }
  if ($todos== "")
  {}
  else
  {  
  	$tutori = $_SESSION['profi'];
  	$activ = mysql_query("select * from FTUTORES where tutor='$tutori' and nivel = '$nivel' and grupo = '$grupo'");
  	if (mysql_num_rows($activ) > 0 OR stristr($_SESSION['cargo'],'1') == TRUE) {
  	  	include("act_tutoria.php");	
  		}
  }
  }
?>
</BODY>
</HTML>
