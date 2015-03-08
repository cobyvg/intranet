<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$claveal = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];

	$curso = $unidad;
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	
        <? 

  // Datos del Alumno  
  		echo "<div align='center'>";
   echo "<h3 align='center'>$todosdatos</h3>";     
   echo "<p class='lead muted' align='center'><i class='icon icon-bug'> </i> 
Informe sobre Faltas de Asistencia y Problemas de Convivencia</p>";
 ?>
<br /><h4 >Faltas de Asistencia en este Curso</h4><br />
<?php $result = mysql_query("SELECT DISTINCT fecha FROM FALTAS WHERE claveal = '$clave_al' ORDER BY fecha DESC"); ?>
<?php if (mysql_num_rows($result)): ?>

	<table class="table table-bordered table-striped table-hover" style="width:700px;">
			<tr class="text-info">
				<th>Fecha</th>
				<?php for ($i = 1; $i < 7; $i++): ?>
				<th><?php echo $i; ?>ª hora</th>
				<?php endfor; ?>
			</tr>
		<tbody>
			<?php while ($row = mysql_fetch_array($result)){ ?>
			<tr>
				<th><?php echo $row['fecha']; ?></th>
				<?php for ($i = 1; $i < 7; $i++){ ?>
				<?php $result_falta = mysql_query("SELECT DISTINCT asignaturas.abrev, asignaturas.nombre, falta FROM FALTAS 
				JOIN asignaturas ON FALTAS.codasi = asignaturas.codigo  WHERE claveal = '$claveal' AND fecha = '".$row['fecha']."' 
				AND hora = '$i' and asignaturas.abrev not like '%\_%'"); 
				?>
				<?php $row_falta = mysql_fetch_array($result_falta); ?>
				<td>
						<abbr data-bs="tooltip" title="<?php echo $row_falta['nombre']; ?>">
						<span class="label label-default"><?php echo $row_falta['abrev']; ?></span>
						</abbr>
					<?php echo ($row_falta['falta'] == "I" || $row_falta['falta'] == "F") ? 
					'<span class="label label-warning">'.$row_falta['falta'].'</label>' : ''; ?>
					<?php echo ($row_falta['falta'] == "J") ? '<span class="label label-success">'.$row_falta['falta'].'</label>' 
					: ''; ?>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>

<?php endif; ?>

<?
echo "<hr /><br /><h4 >Problemas de Convivencia en este Curso</h4><br />";
  mysql_connect ($host, $user, $pass);
  mysql_select_db ($db);
  $result = mysql_query ("select distinct Fechoria.fecha,
  Fechoria.asunto, Fechoria.notas, Fechoria.informa from Fechoria, alma
  where alma.claveal = Fechoria.claveal and alma.claveal = $clave_al order by alma.unidad, alma.apellidos, 
Fechoria.fecha");

  if (mysql_num_rows($result)>0)
        {
		echo "<table class='table table-striped span11'>";
        echo "<thead><tr class='text-info'><th>Fecha</th><th nowrap>Tipo de 
Problema</th><th>Descripción</th><th>Profesor</th></tr></thead><tbody>"; 

while($row = mysql_fetch_array($result)) {
	if (date($row[0])>"2014-12-01") {
  	$notas=$row[2];
  }
  else{
  	$notas="";
  }
		printf ("<tr><td nowrap>$row[0]</td><td>$row[1]</td><td>$notas</td><td>$row[3]</td></tr>", 
$row[0], $row[1], $row[2], $row[3]);
        } 
echo "</tbody></table>\n";
        } else 
		{
			echo "<div class='alert alert-success' style=' 
max-width:450px;margin:auto'>El Alumno no tiene Problemas de Convivencia 
registrados en este Curso Escolar.</div><br />";
		}
  ?>
    </div>
  <? include "../pie.php"; ?>

