<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	

<?
  ?>
<?
    echo "<h3 align='center'>$todosdatos<br /></h3>
    <div class='container'>
    <div class='row'>";
  		echo "<p class='lead muted' align='center'><i class='icon icon-edit'> </i> Asignaturas y Profesores del Alumno en el Curso</p><hr />";
		$SQLP = "select tutor from FTUTORES where unidad = '$unidad'";
  $resultP = mysql_query($SQLP);
  if ($rowP = mysql_fetch_array($resultP))
        {
echo '<br><div class="well well-large span6 offset3">';	
echo "<h4 align='center'>Tutor del Grupo $unidad.</h4>";

                do {
                	$tr_tut = explode(", ",$rowP[0]);
				echo "<h4 align='center' class= 'text-success'>$tr_tut[1] $tr_tut[0]</h4>";
        } while($rowP = mysql_fetch_array($resultP));
		echo "</div></div>";	
		}

	echo "<br><div class='row'><div class='span8 offset2'><table class='table table-striped'>";
				
$comb = mysql_query("select combasi from alma where claveal = '$clave_al'");
$combasi = mysql_fetch_array($comb);
$tr_combasi = explode(":",$combasi[0]);
foreach ($tr_combasi as $codigo){
	  $SQL = mysql_query("select distinct materia, nivel, profesor from profesores, asignaturas where materia= nombre and grupo = '$unidad' and codigo = '$codigo' and abrev not like '%\_%' and curso = '".$_SESSION['curso']."'");

  while ($rowasig = mysql_fetch_array($SQL))
        {
	printf ("<tr><th>$rowasig[0]</th><td>$rowasig[1]</td><td class='text-info'>$rowasig[2]</tr>");				
	}	
}

echo "</table></div></div>";
?>
</div>
</div>
<?

  ?>
</div>
 <? include "../pie.php"; ?>

