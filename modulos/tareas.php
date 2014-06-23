<div class='well alert alert-warning'><p class="lead"><i class='fa fa-bell'> </i> Tareas Activas por Expulsión o Ausencia del Alumno</p><hr />
<?
$resultcurs = mysql_query($SQLcurso);
	while($rowcurs = mysql_fetch_array($resultcurs))
	{
	$n_tareas = $n_tareas+1;
	$curso = $rowcurs[0];
	$curso0 = explode("-",$curso);
	$nivel_t = $curso0[0];	
	$grupo_t = $curso0[1];	
	$asignatura = str_replace("nbsp;","",$rowcurs[1]);
	$asignatura = str_replace("&","",$asignatura);
	$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurs[2]' and abrev not like '%\_%'";
	//echo $asigna0."<br>";
	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$codasi = $asigna2[0];
	$hoy = date('Y-m-d');
	$query = "SELECT tareas_alumnos.ID, tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.NIVEL, tareas_alumnos.GRUPO, tareas_alumnos.FECHA, tareas_alumnos.DURACION FROM tareas_alumnos, alma WHERE tareas_alumnos.claveal = alma.claveal and 
	date(tareas_alumnos.FECHA)>='$hoy' and tareas_alumnos. nivel = '$nivel_t' and tareas_alumnos.grupo = '$grupo_t' and combasi like '%$codasi%' ORDER BY tareas_alumnos.FECHA asc";
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
	echo "<p>$fechac[2]-$fechac[1]-$fechac[0] <a data-toggle='modal' href='#tarea$n_tareas' style='color:#fff'> $row1[3] $row1[2]</a> -- $curso $row[6]  &nbsp;&nbsp;&nbsp;&nbsp;
	<a href='./admin/tareas/infocompleto.php?id=$row1[0]'> <i class='fa fa-search' title='Ver informe'> </i> </a>
	<a href='./admin/tareas/informar.php?id=$row1[0]' /> <i class='fa fa-pencil' title='Rellenar informe'> </i> </a>
	</p>";
?>	
	<div class="modal hide fade in" id="tarea<? echo $n_tareas;?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Informe de Tareas para <? echo "$row1[2] $row1[1]";?></h3>
  </div>
  <div class="modal-body">
<?	
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,tareas_alumnos.NIVEL,tareas_alumnos.GRUPO,tutor, FECHA, duracion, claveal FROM tareas_alumnos, FTUTORES 
WHERE FTUTORES.nivel = tareas_alumnos.nivel and FTUTORES.grupo = tareas_alumnos.grupo and ID='$id'",$c);
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
<?
		}
	}
}
}
?>
</div>