<div class='alert alert-warning'><p class="lead"><i class='fa fa-bell'> </i> Tareas Activas por Expulsión o Ausencia del Alumno</p><hr />
<?
$resultcurs = mysql_query($SQLcurso);
	while($rowcurs = mysql_fetch_array($resultcurs))
	{
	$n_tareas = $n_tareas+1;
	$curso = $rowcurs[0];
	$unidad_t = $curso;	
	$asignatura = str_replace("nbsp;","",$rowcurs[1]);
	$asignatura = str_replace("&","",$asignatura);
	$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurs[2]' and abrev not like '%\_%'";
	//echo $asigna0."<br>";
	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$codasi = $asigna2[0];
	$hoy = date('Y-m-d');
	$query = "SELECT tareas_alumnos.ID, tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.unidad, alma.matriculas, tareas_alumnos.FECHA, tareas_alumnos.DURACION FROM tareas_alumnos, alma WHERE tareas_alumnos.claveal = alma.claveal and 
	date(tareas_alumnos.FECHA)>='$hoy' and tareas_alumnos.unidad = '$unidad_t' and combasi like '%$codasi%' ORDER BY tareas_alumnos.FECHA asc";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0)
{
	while($row1 = mysql_fetch_array($result))
	{
$hay = "select * from tareas_profesor where id_alumno = '$row1[0]'  and asignatura = '$asignatura'";
$si = mysql_query($hay);	
if (mysql_num_rows($si) > 0)
		{ }
   		else
		{
	$fechac = explode("-",$row1[6]);
	echo "<p>$fechac[2]-$fechac[1]-$fechac[0] <a class='alert-link' data-toggle='modal' href='#tarea$n_tareas'> $row1[3] $row1[2]</a> -- $curso $row[6]  &nbsp;&nbsp;&nbsp;&nbsp;
	<span class=' pull-right'>
	<a href='./admin/tareas/infocompleto.php?id=$row1[0]' class='alert-link' style='margin-right:10px'> <i class='fa fa-search' title='Ver informe'> </i> </a>
	<a href='./admin/tareas/informar.php?id=$row1[0]' class='alert-link' style='margin-right:10px'> <i class='fa fa-pencil' title='Rellenar informe'> </i> </a>
	</span>
	</p>";
?>	
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="tarea<? echo $n_tareas;?>">
	  <div class="modal-dialog">
    <div class="modal-content">	
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Informe de Tareas para <? echo "$row1[3] $row1[2]";?></h3>
  </div>
  <div class="modal-body">
<?	
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,tareas_alumnos.unidad,tareas_alumnos.GRUPO,tutor, FECHA, duracion, claveal FROM tareas_alumnos, FTUTORES 
WHERE FTUTORES.unidad = tareas_alumnos.unidad and FTUTORES.grupo = tareas_alumnos.grupo and ID='$id'",$c);
$dalumno = mysql_fetch_array($alumno);
$claveal=$dalumno[7];
$datos=mysql_query("SELECT asignatura, tarea FROM tareas_profesor WHERE id_alumno='$id'",$c);
if(mysql_num_rows($datos) > 0)
{
while($informe = mysql_fetch_array($datos))
{
	echo "<p style='color:#08c'>$informe[0]. <span style='color:#555'>$informe[1]</span></p>";
}
}
else
{
echo '<p style="color:#08c"> Los Profesores no han rellenado aún su Informe de tareas</p>';
}
?>
</div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
  </div>
</div>
</div>
</div>
<?
		}
	}
}
}
?>
</div>