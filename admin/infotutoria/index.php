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

$pr = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];
?>
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar el registro de la base de datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
  <?php
 include("../../menu.php");
 include("menu.php"); 
  $tut = mysql_query("select unidad from FTUTORES where tutor = '$pr'");
  $borrar = mysql_num_rows($tut);
  $tuto = mysql_fetch_array($tut);
  $unidad = $tuto[0];
?>
 <div align="center"> 
<div class="page-header" align="center">
  <h2>Informes de Tutoría <small> Informes activos</small></h2>
</div>
<br />
    
 <div class="well-transparent well-large" style="width:580px;">
<? 
// Buscamos los grupos que tiene el Profesor, con su asignatura y nivel
	$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$pr'";
$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$grupo = $rowcurso[0];
	$asignatura = trim($rowcurso[1]);
	

// Buscamos el código de la asignatura (materia) de cada grupo al que da el profesor
	$asigna0 = "select codigo, nombre from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'";
	//echo "$asigna0<br>";
	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$c_asig = $asigna2[0];	
	$n_asig = $asigna2[1];
	$hoy = date('Y-m-d');
// Buscamos los alumnos de esos grupos que tienen informes de Tutoría activos y además tienen esa asignatura en su el campo combasi	
	$query = "SELECT id, infotut_alumno.apellidos, infotut_alumno.nombre, F_ENTREV, FECHA_REGISTRO FROM infotut_alumno, alma WHERE alma.claveal = infotut_alumno.claveal and date(F_ENTREV)>='$hoy' and alma.unidad = '$grupo' and combasi like '%$c_asig%' ORDER BY F_ENTREV asc";
	//echo $query."<br>";
	$result = mysql_query($query);
	$result0 = mysql_query ( "select tutor from FTUTORES where unidad = '$grupo'" );
	$row0 = mysql_fetch_array ( $result0 );	
	$tuti = $row0[0];	
	//echo $tuti." == ",$_SESSION['profi'];
	if (mysql_num_rows($result) > 0)
{
	echo "<form name='consulta' method='POST' action='tutoria.php'>";
//$num_informe = mysql_num_rows($sql1);
echo "<p class='lead text-info'>$grupo <br /><small class='muted'>$n_asig</small></p>";
echo "<table align=center  class='table'><tr style='background-color:#f6f6f6'>";
echo "<th>Alumno</th>
<th>Cita padres</th>
<th>Fecha alta</th>
<th></th>
</tr>";
$count = "";
	while($row = mysql_fetch_array($result))
	{
// Comprobamos que el profesor no ha rellenado el informe de esa asignatura	
$hay = "select * from infotut_profesor where id_alumno = '$row[0]' and asignatura = '$asignatura'";
// echo "$hay<br>";
$si = mysql_query($hay);	
$activos=mysql_num_rows($si) ;
if ($activos > 0)
		{ 
	echo "<tr><TD> $row[1], $row[2]</td>
   <TD colspan='2' nowrap><span class='badge badge-warning'>Informe ya rellenado</span></td>";
	if ($borrar == '1' or stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
			echo "<TD> 
			<a href='infocompleto.php?id=$row[0]&c_asig=$asignatura' class=''><i class='fa fa-search' title='Ver Informe'> </i></a>
			&nbsp;<a href='borrar_informe.php?id=$row[0]&del=1' class=''><i class='fa fa-trash-o' title='Borrar Informe'  onClick='return confirmacion();'> </i> </a> 			
			</td>";		
		}
		echo "</tr>";	
   }
   		else
		{
		$count = $count + 1;
	echo "<tr><TD>
	 $row[1], $row[2]</td>
   <TD>$row[3]</td>
   <TD>$row[4] </td>
   <td>";
	 echo "
	 <input type='hidden' name='profesor' value='$profesor'>";
		 if (mysql_num_rows($si) > 0 and $count < 1)
		{} else{ 
			echo "<a href='infocompleto.php?id=$row[0]&c_asig=$asignatura' class=''><i class='fa fa-search' title='Ver Informe'> </i></a>";	
			if ($borrar == '1' or stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
				echo "&nbsp;<a href='borrar_informe.php?id=$row[0]&del=1' class=''><i class='fa fa-trash-o' title='Borrar Informe' onClick='return confirmacion();'> </i> </a> 	";
			}
		}	  
	  if (mysql_num_rows($si) > 0 and $count < 1)
		{} else{ 
echo "&nbsp;<a href='informar.php?id=$row[0]' class=''><i class='fa fa-pencil-square-o' title='Redactar Informe'> </i> </a>";
				}
   echo "</td>
   </tr>";
		}
	}	
	echo "</table>";
	 
	 echo "<br /></form><hr>";
}
	else{
		echo "<p class='lead text-info'>$grupo<br /><small class='muted'> $n_asig</small></p>";
			echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No hay Informes de Tutor&iacute;a Activos para t&iacute;</div></div><hr>';
}
	}	
?>
  </div>  
<? include("../../pie.php");?>		
</body>
</html>
