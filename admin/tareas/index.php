<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);



$profesor = $_SESSION['profi'];
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
<? 
	include("../../menu.php");
  	include("menu.php");
?>
<div align="center">
  <?php
  $tut = mysql_query("select unidad, grupo from FTUTORES where tutor = '$profesor'");
  $tuto = mysql_fetch_array($tut);
  $unidad = $tuto[0];
  $grupo = $tuto[1];
?>
<div class="page-header">
  <h2>Informes de Tareas <small> Expulsión o ausencia del Alumno</small></h2>
</div>
<br />
 <div class="well-transparent well-large" style="width:580px;">

<?
// Buscamos los grupos que tiene el Profesor, con su asignatura y nivel
	$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$profesor'";
	//echo $SQLcurso;
$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$unidad = $trozos[0];
	$asignatura = str_replace("nbsp;","",$rowcurso[1]);
	$asignatura = str_replace("&","",$asignatura);
	

// Buscamos el código de la asignatura (materia) de cada grupo al que da el profesor
	$asigna0 = "select codigo, nombre from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'";
	//echo "$asigna0<br>";
	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$codasi = $asigna2[0];
	$n_asig = $asigna2[1];
	$hoy=date('Y-m-d');
// Buscamos los alumnos de esos grupos que tienen informes de Tutoría activos y además tienen esa asignatura en su el campo combasi	
	$query = "SELECT tareas_alumnos.ID, tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.unidad, alma.matriculas, tareas_alumnos.FECHA, tareas_alumnos.DURACION FROM tareas_alumnos, alma WHERE tareas_alumnos.claveal = alma.claveal and  date(tareas_alumnos.FECHA)>='$hoy' and tareas_alumnos. unidad = '$unidad' and combasi like '%$codasi%' ORDER BY tareas_alumnos.FECHA asc";
	$result = mysql_query($query);
	$result0 = mysql_query ( "select tutor from FTUTORES where unidad = '$unidad'" );
	$row0 = mysql_fetch_array ( $result0 );	
	$tuti = $row0[0];
	if (mysql_num_rows($result) > 0)
{
	echo "<form name='consulta' method='POST' action='tutoria.php'>";
//$num_informe = mysql_num_rows($sql1);
echo "<p class='lead text-info'>$curso <br /><small class='muted'>$n_asig</small></p>";
echo "<table align=center  class='table'><tr style='background-color:#f6f6f6'>";
echo "<th>Alumno</th>
<th>Fecha Inicio</th>
<th></th>
</tr>";
$count = "";
	while($row = mysql_fetch_array($result))
	{
		
// Comprobamos que el profesor no ha rellenado el informe de esa asignatura	
$hay = "select * from tareas_profesor where id_alumno = '$row[0]' and asignatura = '$asignatura'";
$si = mysql_query($hay);	
if (mysql_num_rows($si) > 0)
		{ 
		echo "<tr><TD> $row[3] $row[2]</td>
   <TD colspan='1' nowrap><span class='badge badge-warning'>Informe ya rellenado</span></td>";
   echo "<TD> 
			<a href='infocompleto.php?id=$row[0]&c_asig=$asignatura' class=' btn-mini'><i class='fa fa-search' title='Ver Informe'> </i> </a>
			&nbsp; <a href='borrar_informe.php?id=$row[0]&del=1' class=' btn-mini'><i class='fa fa-trash-o' title='Borrar Informe' data-bb='confirm-delete'> </i> </a> ";			
   if (stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
   	echo "&nbsp;<a href='borrar_informe.php?id=$row[0]&del=1' class=' btn-mini'><i class='fa fa-trash-o' title='Borrar Informe' data-bb='confirm-delete'> </i> </a> 	";
   }
			echo "</td>";	
   }
   		else
		{
		$count = $count + 1;
		echo "<tr><TD>
	 $row[3] $row[2]</td>
   <TD>$row[6]</td>
   ";
	 echo "
	 <input type='hidden' name='profesor' value='$profesor'>";
			echo "
      <td>";
	  if (mysql_num_rows($si) > 0 and $count < 1)
		{} 
		else{
			echo "<a href='infocompleto.php?id=$row[0]&c_asig=$asignatura' class=' btn-mini'><i class='fa fa-search' title='Ver Informe'> </i> </a>";		
		 if (stristr($cargo,'1') == TRUE or ($tuti == $_SESSION['profi'])) {
   	echo "&nbsp;<a href='borrar_informe.php?id=$row[0]&del=1' class=' btn-mini'><i class='fa fa-trash-o' title='Borrar Informe' data-bb='confirm-delete'> </i> </a> 	";
   }	
		}
	  if (mysql_num_rows($si) > 0 and $count < 1)
		{} 
		else{ 
echo "&nbsp;<a href='informar.php?id=$row[0]' class=' btn-mini'><i class='fa fa-pencil-square-o' title='Redactar Informe'> </i> </a>";
			}
		}
	}	

	 echo "</td>
	  </tr>
	  </table><br /></form><hr>";

}
else{

		echo "<p class='lead text-info'>$curso<br /><small class='muted'> $n_asig</small></p>";
				echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
No hay Informes de Tareas Activos para t&iacute;</div></div><hr>';
}

	}
	   		
?>
</div>
<? include("../../pie.php");?>		
</body>
</html>
