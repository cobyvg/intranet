<?  
// Procesamos los datos
if ($seleccionar=="1") {
$curso = substr($curso,0,strlen($curso)-1);
$cursos = explode(", ",$curso);
$unidad = "";
foreach($cursos as $unidad)
{
	$alumnos = "";
	foreach ($_POST as $key => $val) {
		//echo "$key => $val<br>";
		if (strlen(strstr($key,"select_")) > 0) {
		$trozos = explode("_",$key);
		if ($unidad == $trozos[2]) {
		$alumnos .= $trozos[1].","; 		
		}
		}
		}	
		$select1 = "select id, curso, alumnos from grupos where profesor = '$profesor' and asignatura = '$asignatura'  and curso = '$unidad'";
		$select0 = mysql_query($select1);
		$select = mysql_fetch_array($select0);
		if(mysql_num_rows($select0) == "1"){
			if (!(empty($alumnos))) {
		$actualiza = "UPDATE grupos SET alumnos = '$alumnos' WHERE id = '$select[0]'";
		// echo $actualiza."<br>";
		$actua0 = mysql_query($actualiza);	
			}
		}
		else{
  		$insert = "insert into grupos (profesor, asignatura, curso, alumnos) values ('$profesor','$asignatura','$unidad', '$alumnos')";
  		//echo $insert."<br>";
  		$insert0 = mysql_query($insert);	
 		}		
}
}

  foreach ($_POST as $key => $val) {
  	$trozos = explode("-",$key);
  	$id = $trozos[0];
  	$claveal = $trozos[1];
  	$dupli = mysql_query("select * from datos where id = '$id' and claveal = '$claveal'");
	$duplic = mysql_fetch_array($dupli);
// Condiciones para procesar los datosxxx
  	if (is_numeric($claveal) and is_numeric($id)) {
  		//echo "$id - $claveal - $val<br>";
		if(!(empty($duplic[1]))){
		$actualiza = "UPDATE datos SET nota = '$val' WHERE datos.id = '$id' AND datos.claveal = '$claveal'";
		$actua0 = mysql_query($actualiza);
		}
		elseif(empty($val) and !($val=="0")){
		$borra = "delete from datos  WHERE datos.id = '$id' AND datos.claveal = '$claveal'";
		$borra0 = mysql_query($borra);
		}
		else{
  		$insert = "insert into datos (id, claveal, nota, ponderacion) values ('$id','$claveal','$val','1')";
  		$insert0 = mysql_query($insert);	

  		}
		}
  }  
mysql_select_db($db);
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los Alumnos han sido registrados en esta Asignatura.          
</div></div>';

?>
<script language="javascript">
<? 
// Redireccionamos al Cuaderno    
// $mens = "cuaderno.php?dia=$dia&hora=$hora&asignatura=$asignatura&profesor=$pr";
$mens = "index0.php";
?>
setTimeout("window.location='<? echo $mens; ?>'", 800) 
</script>
