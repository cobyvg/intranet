<hr />
<br />
<h3>Resultados por Materias</h3><br />

<?
$titulos = array("3"=>"Evaluación Ordinaria");
foreach ($titulos as $key=>$val){

// Tabla temporal.
 $crea_tabla2 = "CREATE TABLE  `temp` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`claveal` VARCHAR( 12 ) NOT NULL ,
`asignatura` INT( 8 ) NOT NULL ,
`nota` TINYINT( 2 ) NOT NULL ,
INDEX (  `claveal` )
) ENGINE = INNODB";
 mysql_query($crea_tabla2); 

 mysql_query("ALTER TABLE  `temp` CHANGE  `claveal`  `claveal` VARCHAR( 12 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL");
 
 mysql_query("ALTER TABLE  `temp` ADD INDEX (  `asignatura` )");
?>
<?
$todos="";
$notas1 = "select notas". $key .", claveal1, matriculas, unidad, alma.curso from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.unidad = '$unidad'";
//echo $notas1."<br>";
$notas2 = mysql_query("select notas3 from notasl");
$result1 = mysql_query($notas1);
$todos = mysql_num_rows($result1);
if ($todos < '1' or $todos == "") {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No se han registrado las calificaciones de la Evaluación Ordinaria todavía. Es importante que <strong><u>no imprimas</u></strong> la Memoria de Tutoría hasta que las notas de la Evaluación Ordinaria se hayan registrado. De lo contrario, las Estadísticas de la Evaluación Ordinaria no aparecerán en la Memoria.
          </div></div>';
}
while($row1 = mysql_fetch_array($result1)){
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$claveal = $row1[1];
$grupo = $row1[3];
$curso_actual = $row1[4];
if ($row1[2]>"1") {
	$pil = "1";
}
else{
	$pil = '0';
}
$trozos1 = explode(";", $asignatura1);
$num = count($trozos1);
$susp="";
 for ($i=0;$i<$num; $i++)
  {
$bloque = explode(":", $trozos1[$i]);
$nombreasig = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";
//echo $nombreasig."<br>";
$asig = mysql_query($nombreasig);
$cali = mysql_fetch_row($asig);
if($cali[0] < '5' and !($cali[0] == ''))	{
	$susp+=1; 
	}
		mysql_query("insert into temp values('','$claveal','$bloque[0]','$cali[0]')");
		//echo "insert into temp values('','$claveal','$bloque[0]','$cali[0]')<br>";
	}
	}

$unidad = $grupo;

?>

<table class="table table-striped table-bordered"  align="center" style="width:800px;" valign="top">
<thead>
<th class='text-info'>Asignatura</th>
<th class='text-info'>Matriculados</th>
<th class='text-info'>Suspensos</th>
<th class='text-info'>Aprobados</th>
</thead>
<tbody>	
	<?
$sql = "select distinct asignaturas.nombre, asignaturas.codigo from asignaturas, profesores where profesores.materia = asignaturas.nombre
 and asignaturas.curso = '$curso_actual' and profesores.grupo = '$unidad' and abrev not like '%\_%' and asignaturas.codigo not in 
(select distinct asignaturas.codigo from asignaturas where asignaturas.nombre like 'Libre Disp%')";
//echo $sql;	
$as = mysql_query($sql);
while ($asi = mysql_fetch_array($as)) {
	$nomasi = $asi[0];
	$codasi = $asi[1];
	$cod_nota = mysql_query("select id from temp, alma where asignatura = '$codasi' and nota < '5' and alma.claveal1 = temp.claveal and unidad = '$unidad'");
	$cod_apro = mysql_query("select id from temp, alma where asignatura = '$codasi' and nota > '4' and alma.claveal1 = temp.claveal and unidad = '$unidad'");
	
	//echo "select id from temp where asignatura = '$codasi'<br>";
	$num_susp='';
	$num_susp = mysql_num_rows($cod_nota);
	$num_apro='';
	$num_apro = mysql_num_rows($cod_apro);
	$combas = mysql_query("select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'");
	//echo "select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'<br>";
	$num_matr='';
	$num_matr = mysql_num_rows($combas);
	
	$porcient_asig = ($num_susp*100)/$num_matr;
	$porciento_asig='';
if ($porcient_asig>49) {
	$porciento_asig = "<span class='text-success'>".substr($porcient_asig,0,4)."%</span>";
}
else{
	$porciento_asig = "<span class='text-danger'>".substr($porcient_asig,0,4)."%</span>";	
}
	
	$porcient_asig2 = ($num_apro*100)/$num_matr;
	$porciento_asig2='';
if ($porcient_asig2>49) {
	$porciento_asig2 = "<span class='text-success'>".substr($porcient_asig2,0,4)."%</span>";
}
else{
	$porciento_asig2 = "<span class='text-danger'>".substr($porcient_asig2,0,4)."%</span>";	
}

if ($porcient_asig>0) {
			echo "<tr><th>$nomasi</th><td>$num_matr</td><td>";
	echo $porciento_asig."<span class='pull-right'>(".$num_susp.")</span></td><td>$porciento_asig2 <span class='pull-right'>(".$num_apro.")</span></td></tr>";
	}

}
?>
</tbody>
</table>
<br />
<hr />
<?
?>

<?
}
mysql_query("drop table temp");
?>

