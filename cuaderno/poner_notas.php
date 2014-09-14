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
		$select0 = mysqli_query($db_con, $select1);
		$select = mysqli_fetch_array($select0);
		if(mysqli_num_rows($select0) == "1"){
			if (!(empty($alumnos))) {
		$actualiza = "UPDATE grupos SET alumnos = '$alumnos' WHERE id = '$select[0]'";
		// echo $actualiza."<br>";
		$actua0 = mysqli_query($db_con, $actualiza);	
			}
		}
		else{
  		$insert = "insert into grupos (profesor, asignatura, curso, alumnos) values ('$profesor','$asignatura','$unidad', '$alumnos')";
  		//echo $insert."<br>";
  		$insert0 = mysqli_query($db_con, $insert);	
 		}		
}
}

  	// Borramos datos en casillas de verificación visibles
  	$contr = mysqli_query($db_con, "select id from notas_cuaderno where profesor = '$profesor' and Tipo like 'Casilla%' and oculto = '0'");
  	while($control_veri = mysqli_fetch_array($contr)){
  		//echo "Borramos registro $claveal ==> $id<br />";
  		$borra_veri = "delete from datos  WHERE datos.id = '$control_veri[0]'";
		$borra1 = mysqli_query($db_con, $borra_veri);
  	}
 
 
  foreach ($_POST as $key => $val) {
  	// echo "$key --> $val<br />";
  	$trozos = explode("-",$key);
  	$id = $trozos[0];
  	$claveal = $trozos[1];
  	
	// Duplicados
  	$dupli = mysqli_query($db_con, "select * from datos where id = '$id' and claveal = '$claveal'");
	$duplic = mysqli_fetch_array($dupli);

	// Condiciones para procesar los datos
  	if (is_numeric($claveal) and is_numeric($id)) {

		if(!(empty($duplic[1]))){
		$actualiza = "UPDATE datos SET nota = '$val' WHERE datos.id = '$id' AND datos.claveal = '$claveal'";
		//echo $actualiza."<br />";
		$actua0 = mysqli_query($db_con, $actualiza);
		}
		elseif(empty($val) and !($val=="0")){
		$borra = "delete from datos  WHERE datos.id = '$id' AND datos.claveal = '$claveal'";
		$borra0 = mysqli_query($db_con, $borra);
		}
		else{
  		$insert = "insert into datos (id, claveal, nota, ponderacion) values ('$id','$claveal','$val','1')";
  		$insert0 = mysqli_query($db_con, $insert);	
		//echo $insert."<br />";
  		}
		}
  }  
mysqli_select_db($db_con, $db);
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los Alumnos han sido registrados en esta Asignatura.          
</div></div>';
?>

