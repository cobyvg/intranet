<?
// Alumnos expulsados que vuelven
if (isset($_GET['id_tareas'])) {
	$id_tareas = $_GET['id_tareas'];
}
if (isset($_GET['tareas_expulsion'])) {
if ($_GET['tareas_expulsion'] == 'Si') {
	mysql_query("update tareas_profesor set confirmado = 'Si' where id = '$id_tareas'");
}
if ($_GET['tareas_expulsion'] == 'No') {
	mysql_query("update tareas_profesor set confirmado = 'No' where id = '$id_tareas'");
}
}

$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$pr'";
//echo $SQLcurso;
$resultcurso = mysql_query($SQLcurso);
while ($exp = mysql_fetch_array($resultcurso)) {
$unidad = $exp[0];
$materia = $exp[1];
$a_asig0 = mysql_query("select distinct codigo from asignaturas where curso = '$exp[2]' and nombre = '$materia' and abrev not like '%\_%'");
$cod_asig = mysql_fetch_array($a_asig0);
$hoy = date('Y') . "-" . date('m') . "-" . date('d');
$expul= "SELECT DISTINCT alma.apellidos, alma.nombre, alma.nivel, alma.grupo, tareas_profesor.id
FROM tareas_alumnos, tareas_profesor, alma
WHERE alma.claveal = tareas_alumnos.claveal
AND tareas_alumnos.id = tareas_profesor.id_alumno
AND (date(tareas_alumnos.fin) =  date_sub('$hoy', interval 1 day) 
OR date(tareas_alumnos.fin) =  date_sub('$hoy', interval 2 day) 
OR date(tareas_alumnos.fin) =  date_sub('$hoy', interval 3 day) 
OR date(tareas_alumnos.fin) =  date_sub('$hoy', interval 4 day) 
OR date(tareas_alumnos.fin) =  date_sub('$hoy', interval 5 day)
OR date(tareas_alumnos.fin) =  date_sub('$hoy', interval 6 day)
OR date(tareas_alumnos.fin) =  date_sub('$hoy', interval 7 day)
)
AND alma.unidad =  '$unidad'
AND alma.combasi LIKE  '%$cod_asig[0]%' 
and tareas_profesor.profesor='$pr' 
and confirmado is null
ORDER BY tareas_alumnos.fecha";
$result = mysql_query ($expul);
     while ($row = mysql_fetch_array($result))
        {
        	if (mysql_num_rows($result) == '0') {        		
        	}
        	else{
	echo "<div class='well alert alert-info'><legend><i class='fa warning-sign'> </i> Alumnos que se reincorporan tras su Expulsión<br /> <small>$materia</small></legend><hr />";
	echo "<p>".$row[0].", ".$row[1]." ==> ".$unidad."</p>";
	echo "<p>¿Ha realizado el alumno las tareas que le has encomendado?&nbsp;&nbsp;&nbsp;&nbsp;<a href='index0.php?tareas_expulsion=Si&id_tareas=$row[4]'><button class='btn btn-primary'>SI</button></a>&nbsp;&nbsp;<a href='index0.php?tareas_expulsion=No&id_tareas=$row[4]'><button class='btn btn-danger'>NO</button></a></p>";
	echo "</div>";
        }
        }          	
}

// Alumnos expulsados que se van
$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$pr'";
$resultcurso = mysql_query($SQLcurso);
while ($exp = mysql_fetch_array($resultcurso)) {
$unidad = $exp[0];
$materia = $exp[1];
$hoy = date('Y') . "-" . date('m') . "-" . date('d');
$ayer0 = time() + (1 * 24 * 60 * 60);
$ayer = date('Y-m-d', $ayer0);
$result = mysql_query ("select distinct alma.apellidos, alma.nombre, alma.nivel, alma.grupo, Fechoria.expulsion, inicio, fin, id, Fechoria.claveal, tutoria from Fechoria, alma where alma.claveal = Fechoria.claveal and expulsion > '0' and Fechoria.inicio = '$ayer' and alma.unidad = '$unidad' order by Fechoria.fecha ");
if (mysql_num_rows($result) > '0') {
     while ($row = mysql_fetch_array($result))
        {
    echo "<div class='well alert alert-info'><h4>Alumnos que mañana abandonan el Centro por Expulsión </h4><h6>$materia</h6><br />";
	echo "<p>".$row[0].", ".$row[1]." ==> ".$unidad." (Expulsado $row[4] días) </p>";
	echo "</div>";
        }
        }       	
}

// Informes de Tareas
$count0=0;
$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$pr'";
$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$trozos = explode("-",$curso);
	$nivel_t = $trozos[0];
	$grupo_t = $trozos[1];
	$asignatura = str_replace("nbsp;","",$rowcurso[1]);
	$asignatura = str_replace("&","",$asignatura);	
	$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'";
	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$codasi = $asigna2[0];	
	$hoy = date('Y-m-d');
	$query = "SELECT tareas_alumnos.ID, tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.NIVEL, tareas_alumnos.GRUPO, 
	tareas_alumnos.FECHA, tareas_alumnos.DURACION FROM tareas_alumnos, alma WHERE tareas_alumnos.claveal = alma.claveal and date(tareas_alumnos.FECHA)>='$hoy' and tareas_alumnos. nivel = '$nivel_t' and tareas_alumnos.grupo = '$grupo_t' and combasi like '%$codasi:%' ORDER BY tareas_alumnos.FECHA asc";
$result = mysql_query($query);
if (mysql_num_rows($result) > 0)
{
	while($row = mysql_fetch_array($result))
	{
$si0 = mysql_query("select * from tareas_profesor where id_alumno = '$row[0]'  and asignatura = '$asignatura'");	
if (mysql_num_rows($si0) > 0)
		{ }
   		else
		{
	$count0 = $count0 + 1;
		}
	}
}
}
// Informes de tutoria
$count03=0;
$SQLcurso3 = "select distinct grupo, materia, nivel from profesores where profesor = '$pr'";
//echo $SQLcurso3."<br>";
$resultcurso3 = mysql_query($SQLcurso3);
	while($rowcurso3 = mysql_fetch_array($resultcurso3))
	{
	$curso3 = $rowcurso3[0];
	$trozos3 = explode("-",$curso3);
	$nivel3 = $trozos3[0];
	$grupo3 = $trozos3[1];
	$asignatura3 = trim($rowcurso3[1]);
	$asigna03 = "select codigo from asignaturas where nombre = '$asignatura3' and curso = '$rowcurso3[2]' and abrev not like '%\_%'";
	//echo $asigna03."<br>";
	$asigna13 = mysql_query($asigna03);
	$asigna23 = mysql_fetch_array($asigna13);
	$c_asig3 = $asigna23[0];	
	if(is_numeric($c_asig3)){
	$hoy = date('Y-m-d');
	//echo $hoy;
	
	$query3 = "SELECT id, infotut_alumno.apellidos, infotut_alumno.nombre, F_ENTREV FROM infotut_alumno, alma WHERE infotut_alumno.claveal = alma.claveal and
	 date(F_ENTREV) >= '$hoy' and infotut_alumno. nivel = '$nivel3' and infotut_alumno.grupo = '$grupo3' and combasi like '%$c_asig3:%' ORDER BY F_ENTREV asc";
	 //echo $query3."<br>";
$result3 = mysql_query($query3);
if (mysql_num_rows($result3) > 0)
{
	while($row3 = mysql_fetch_array($result3))
	{
$si03 = mysql_query("select * from infotut_profesor where id_alumno = '$row3[0]' and asignatura = '$asignatura3'");	
if (mysql_num_rows($si03) > 0)
		{ }
   		else
		{
	$count03 = $count03 + 1;
		}
	}
}
}
}
$count04=0;

// Informes de absentismo.
if (strstr($_SESSION['cargo'],'2')==TRUE) {
	$tut=$_SESSION['profi'];
	$tutor=mysql_query("select nivel, grupo from FTUTORES where tutor='$tut'");
	$d_tutor=mysql_fetch_array($tutor);
	$mas=" and absentismo.nivel='$d_tutor[0]' and absentismo.grupo='$d_tutor[1]' and tutoria IS NULL ";
}
if (strstr($_SESSION['cargo'],'1')==TRUE) {
	$mas=" and (jefatura IS NULL or jefatura = '')";
}
if (strstr($_SESSION['cargo'],'8')==TRUE) {
	$mas=" and orientacion IS NULL ";
}
if (strstr($_SESSION['cargo'],'1')==TRUE or strstr($_SESSION['cargo'],'2')==TRUE or strstr($_SESSION['cargo'],'8')==TRUE) {	
  $SQL0 = "SELECT absentismo.CLAVEAL, apellidos, nombre, absentismo.nivel, absentismo.grupo, numero, mes FROM absentismo, alma WHERE alma.claveal = absentismo.claveal $mas order by nivel, grupo";
 // echo $SQL0;	
$result0 = mysql_query($SQL0);
if (mysql_num_rows($result0) > 0)
		{ 
			$count04 = $count04 + 1;
		}
}
if(($n_curso > 0 and ($count0 > '0' OR $count03 > '0')) OR (($count04 > '0'))){
?>

<?
if (isset($count0)) {
if($count0 > '0'){include("modulos/tareas.php");}
	}
if (isset($count03)) {
if($count03 > '0'){include("modulos/informes.php");}
	}
if (isset($count04)) {
if($count04 > '0'){include("modulos/absentismo.php");}
	}
echo "<hr>"; 
?>
<?
}


// Comprobar mensajes de Padres
$n_mensajesp="";
if (isset($_GET['verifica_padres'])) {
	$verifica_padres = $_GET['verifica_padres'];
	 mysql_query("UPDATE mensajes SET recibidotutor = '1' WHERE id = $verifica_padres");
}
if(stristr($carg,'2') == TRUE)
{
	$nivel_m = $_SESSION ['s_nivel'];
	$grupo_m = $_SESSION ['s_grupo'];

 if (isset($_GET['asunto']) and $_GET['asunto'] == "Mensaje de confirmación") {
 	 mysql_query("UPDATE mensajes SET recibidopadre = '1' WHERE id = $verifica_padres");
 }
$men1 = "select ahora, asunto, texto, nombre, apellidos, id from mensajes, alma where mensajes.claveal = alma.claveal and mensajes.nivel = '$nivel_m' and mensajes.grupo = '$grupo_m' and recibidotutor = '0'";
$men2 = mysql_query($men1);
if(mysql_num_rows($men2) > 0)
{
echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="lead">	
	<i class="fa fa-comment"> </i> Mensajes de Padres o Alumnos</p><hr /><ul>';
while($men = mysql_fetch_row($men2))
{
$n_mensajesp=$n_mensajesp+1;
$fechacompl = explode(" ",$men[0]);
$fech = explode("-",$fechacompl[0]);
$asunto = $men[1];
$texto = $men[2];
$nombre = $men[3];
$apellidos = $men[4];
$id = $men[5];
$origen = $men[4].", ".$men[3];
$fechaenv = "el día $fech[2] del $fech[1] de $fech[0], a las $fechacompl[1]";
?> 
<li>
<a data-toggle="modal" href="#mensajep<? echo $n_mensajesp;?>"><? echo $asunto; ?></a>
<br />
 <? echo "<span style='font-size:0.8em;color:#eee'>".mb_strtolower($origen)." (".formatea_fecha($fechacompl[0])." ".$fechacompl[1].")</span>";?>
</li>
<div class="modal hide fade" id="mensajep<? echo $n_mensajesp;?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <p class="lead text-info">Mensaje de <? echo $origen;?> </p><small class="muted">Enviado <? echo $fechaenv;?></small>
  </div>
  <hr />
  <div class="modal-body">
<p class="text-info"><? echo $asunto;?></p>
<span style="color:#333"><? echo $texto;?></span>
</div>
  <div class="modal-footer">
  <form name="mensaje_enviado" action="index0.php" method="post" enctype="multipart/form-data" class="form-inline">
  <a href="#" class="btn btn-warning" data-dismiss="modal">Cerrar</a>
    <?

echo '<a href="./admin/mensajes/redactar.php?padres=1&asunto='.$asunto.'&origen='.$origen.'" target="_top" class="btn btn-primary">Responder</a>';
?>
<a href="index0.php?verifica_padres=<? echo $id;?>" target="_top" class="btn btn-danger">Leído</a> 
<input type='hidden' name = 'id_ver' value = '$id' />
</form>
</div>
</div>
<?
}
echo "</ul></div>";
}

}



// Comprobar mensajes de profesores
$n_mensajes="";
if (isset($_GET['verifica'])) {
	$verifica = $_GET['verifica'];
	 mysql_query("UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$verifica'");
}
$men1 = "select ahora, asunto, texto, profesor, id_profe, origen from mens_profes, mens_texto where mens_texto.id = mens_profes.id_texto and profesor = '$pr' and recibidoprofe = '0'";
$men2 = mysql_query($men1);
if(mysql_num_rows($men2) > 0)
{

	echo "<div class='well alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><p class='lead'><i class='fa fa-comment'> </i> Mensajes de Profesores</p><hr /><ul>";
	while($men = mysql_fetch_row($men2))
{
$n_mensajes+=1;
$fechacompl = explode(" ",$men[0]);
$fech = explode("-",$fechacompl[0]);
$asunto = $men[1];
$texto = $men[2];
$pr = $men[3];
$id = $men[4];
$orig = $men[5];
$origen0 = explode(", ",$men[5]);
$origen = $origen0[1]." ".$origen0[0];
$fechaenv = "el $fech[2] del $fech[1] de $fech[0], a las $fechacompl[1]";
?>
<li>
<a data-toggle="modal" href="#mensaje<? echo $n_mensajes;?>">
<? echo $asunto; ?>
</a>
<br />
 <? echo "<span style='font-size:0.8em;color:#eee'>".mb_strtolower($origen)." (".formatea_fecha($fechacompl[0])." ".$fechacompl[1].")</span>";?>
 </li>

<div class="modal hide fade" id="mensaje<? echo $n_mensajes;?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <p class="text-success">Mensaje de <? echo $origen;?> </p><small class="muted">Enviado <? echo $fechaenv;?></small>
  </div>
  <hr />
  <div class="modal-body">
<p class="text-success"><? echo $asunto;?></p>
<span style="color:#333"><? echo $texto;?></span>
  </div>
  <div class="modal-footer">
  <form name="mensaje_enviado" action="index0.php" method="post" enctype="multipart/form-data" class="form-inline">
  <a href="#" target="_top" data-dismiss="modal"class="btn btn-warning">Cerrar</a>
    <?
	$asunto = str_replace('"','',$asunto);
	echo '<a href="./admin/mensajes/redactar.php?profes=1&asunto='.$asunto.'&origen='.$orig.'&verifica='.$id.'" target="_top" class="btn btn-primary">Responder</a>';
?>
<a href="index0.php?verifica=<? echo $id;?>" target="_top" class="btn btn-danger">Leído</a>  
<input type='hidden' name = 'id_ver' value = '$id' />
</form>
</div>
</div>
<?
}
echo "</div>";
}

?>
