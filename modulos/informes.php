<?
echo "<div class='well alert alert-warning'><p class='lead'><i class='icon icon-bell-alt'> </i> Informes de Tutor&iacute;a activos por visita de padres</p><hr />";
$resultcurs = mysql_query($SQLcurso);
	while($rowcurs = mysql_fetch_array($resultcurs))
	{
	$curso = $rowcurs[0];
	$curso0 = explode("-",$curso);
	$nivel_i = $curso0[0];	
	$grupo_i = $curso0[1];	
	$asignatura = trim($rowcurs[1]);
	$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurs[2]' and abrev not like '%\_%'";
	//echo $asigna0."<br>";
	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$c_asig = $asigna2[0];
	if(is_numeric($c_asig)){
	$hoy = date('Y-m-d');
	$query = "SELECT infotut_alumno.id, infotut_alumno.apellidos, infotut_alumno.nombre, infotut_alumno.F_ENTREV FROM infotut_alumno, alma WHERE 
	infotut_alumno.claveal = alma.claveal and  date(F_ENTREV)>='$hoy' and infotut_alumno. nivel = '$nivel_i' and infotut_alumno.grupo = '$grupo_i' and combasi like '%$c_asig%' ORDER BY F_ENTREV asc";
$result = mysql_query($query);
$n_inotut="";
if (mysql_num_rows($result) > 0)
{
	while($row1 = mysql_fetch_array($result))
	{
$hay = "select * from infotut_profesor where id_alumno = '$row1[0]'  and asignatura = '$asignatura'";
$si = mysql_query($hay);	
if (mysql_num_rows($si) > 0)
		{ }
   		else
		{
	$n_infotut = $n_infotut+1;
	$fechac = explode("-",$row1[3]);
	echo "<p>$fechac[2]-$fechac[1]-$fechac[0]. 
	<a data-toggle='modal' href='#infotut$n_infotut'> $row1[2] $row1[1]</a> -- $curso $row[6] &nbsp;&nbsp;&nbsp;&nbsp; <a href='./admin/infotutoria/infocompleto.php?id=$row1[0]'> <i class='icon icon-search' title='Ver informe'> </i></a><a href='./admin/infotutoria/informar.php?id=$row1[0]' /> <i class='icon icon-pencil' title='Rellenar informe'> </i> </a>
	</p>";
	?>
<div class="modal hide fade in" id="infotut<? echo $n_infotut;?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Informe de Tutoría para <? echo "$row1[2] $row1[1]";?></h3>
  </div>
  <div class="modal-body">
<?
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,NIVEL,GRUPO,TUTOR, F_ENTREV, CLAVEAL FROM infotut_alumno WHERE ID='$row1[0]'");
$dalumno = mysql_fetch_array($alumno);
$claveal=$dalumno[6];
$datos=mysql_query("SELECT asignatura, informe, id, profesor FROM infotut_profesor WHERE id_alumno='$row1[0]'");
if(mysql_num_rows($datos) > 0)
{
while($informe = mysql_fetch_array($datos))
{
	echo "<p style='color:#08c'>$informe[0]. <span style='color:#555'> $informe[1]</span></p>";
}
}
else{
		echo "<p style='color:#08c'>Los profesores no han rellenado aún su informe de tutoría.</p>";
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
}

?>
<script language="javascript">
    $('#myModal2').modal()
    </script>
</div>