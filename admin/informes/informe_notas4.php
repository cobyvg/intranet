<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

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

?>
<?
  	include("../../menu.php");
  	include("menu.php");
?>
<br />
<div align="center" style="width:auto;margin:auto;">
<div class="page-header">
  <h2>Informe de Evaluaciones <small> Estadísticas de Calificaciones</small></h2>
</div>

<?
if (isset($_POST['f_curso']) and !($_POST['f_curso'] == "Curso actual")) {
	$f_curs = substr($_POST['f_curso'],5,4);
	$base_actual = $db.$f_curs;
	// echo $base_actual;
	$conex = mysqli_select_db($db_con, $base_actual);
	if (!$conex) {
		echo "Fallo al seleccionar la base de datos $base_actual";
	}
	else{
		mysqli_query($db_con, "drop table cursos");
		mysqli_query($db_con, "create table cursos select * from $db.cursos");
		//echo "create table if not exists cursos select * from $db.cursos";
	}
}
else{
	$conex = mysqli_select_db($db_con, $db);
}
$act1 = substr($curso_actual,0,4);
$b_act1 = ($act1-1)."-".$act1;
$base=$db.$act1;
$act2=$act1-1;
$b_act2 = ($act2-1)."-".$act2;
$act3=$act1-2;
$b_act3 = ($act3-1)."-".$act3;
$act4=$act1-3;
$b_act4 = ($act4-1)."-".$act4;

if (mysqli_query($db_con, "select * from $base.notas")) {
?>
<form method="POST" class="well well-large" style="width:450px; margin:auto">
<p class="lead">Informe Histórico</p>
<select name="f_curso" onchange="submit()">
<?
echo "<option>".$_POST['f_curso']."</option>";
echo "<option>Curso actual</option>";
for ($i=1;$i<5;$i++){
	$base_contr = $db.($act1-$i);
	$sql_contr = mysqli_query($db_con, "select * from $base_contr.notas");
	if (mysqli_num_rows($sql_contr)>0) {
		echo "<option>${b_act.$i}</option>";
	}
}
?>
</select>
</form>
<hr />
<?
}
?>
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">1ª Evaluación</a></li>
<li><a href="#tab2" data-toggle="tab">2ª Evaluación</a></li>
<li><a href="#tab3" data-toggle="tab">Evaluación Ordinaria</a></li>
</ul>

<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<? 
// Comprobamos datos de evaluaciones
$n1 = mysqli_query($db_con, "select * from notas where notas1 not like ''");
if(mysqli_num_rows($n1)>0){}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administración de la Intranet --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
	exit();
}
?>


<?
$titulos = array("1"=>"1ª Evaluación","2"=>"2ª Evaluación","3"=>"Evaluación Ordinaria");
foreach ($titulos as $key=>$val){

// Tabla temporal.
 $crea_tabla2 = "CREATE TABLE  `temp` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`claveal` VARCHAR( 12 ) NOT NULL ,
`asignatura` INT( 8 ) NOT NULL ,
`nota` TINYINT( 2 ) NOT NULL ,
INDEX (  `claveal` )
) ENGINE = INNODB";
 mysqli_query($db_con, $crea_tabla2); 
 
 if (!($_POST['f_curso'] == "Curso actual") AND strstr($base_actual,"2013")==FALSE  AND !($base_actual=="")) {
 	 mysqli_query($db_con, "ALTER TABLE `cursos` CHANGE `idcurso` `idcurso` INT( 12 ) UNSIGNED NOT NULL , CHANGE `nomcurso` `nomcurso` VARCHAR( 80 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
 	 mysqli_query($db_con, "ALTER TABLE  `temp` CHANGE  `claveal`  `claveal` VARCHAR( 12 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
 }
else {
 	  mysqli_query($db_con, "ALTER TABLE `cursos` CHANGE `idcurso` `idcurso` INT( 12 ) UNSIGNED NOT NULL , CHANGE `nomcurso` `nomcurso` VARCHAR( 80 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL");
 	 mysqli_query($db_con, "ALTER TABLE  `temp` CHANGE  `claveal`  `claveal` VARCHAR( 12 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL");
 }
 mysqli_query($db_con, "ALTER TABLE  `temp` ADD INDEX (  `asignatura` )");
	$key == '1' ? $activ=" active" : $activ='';
?>
<div class="tab-pane fade in<? echo $activ;?>" id="<? echo "tab".$key;?>">
<?
// Evaluaciones ESO
$nivele = mysqli_query($db_con, "select * from cursos");
while ($orden_nivel = mysqli_fetch_array($nivele)){
$niv = mysqli_query($db_con, "select distinct curso from alma where curso = '$orden_nivel[1]'");
while ($ni = mysqli_fetch_array($niv)) {
	$n_grupo+=1;
	$curso = $ni[0];
	$rep = ""; 
	$promo = "";
$notas1 = "select notas". $key .", claveal1, matriculas, unidad, curso from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso'";
//echo $notas1."<br>";

$result1 = mysqli_query($db_con, $notas1);
$todos = mysqli_num_rows($result1);
if ($todos < '1') {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administracción --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
}
while($row1 = mysqli_fetch_array($result1)){
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$claveal = $row1[1];
$grupo = $row1[3];
$nivel_curso = $row1[4];
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
$asig = mysqli_query($db_con, $nombreasig);
$cali = mysqli_fetch_row($asig);
if($cali[0] < '5' and !($cali[0] == ''))	{
	$susp+=1; 
	}
		mysqli_query($db_con, "insert into temp values('','$claveal','$bloque[0]','$cali[0]')");
	}
	}
}
}
?>
<br />
<h3>Resultados de los Alumnos por Materias / Nivel / Grupo:</h3>
<span class="help-block"> ( * ) En color <strong class="text-success">verde</strong> los aprobados; en color <strong class="text-warning">naranja</strong> los suspensos</span>
<br />
<?
$nivele = mysqli_query($db_con, "select * from cursos");
while ($orden_nivel = mysqli_fetch_array($nivele)){
?>
<legend><? echo $orden_nivel[1]; ?></legend>
<table class="table table-striped table-condensed table-bordered"  align="center" style="width:700px;" valign="top">
<tr><th></th>
<?
$sql_asig = "select distinct unidad from alma where curso = '$orden_nivel[1]' order by unidad";
$query_asig = mysqli_query($db_con, $sql_asig);
while ($a_asig = mysqli_fetch_array($query_asig)) {
echo '<th colspan="2" style="text-align:center">'.$a_asig[0].'</th>';
}
echo "</tr>";

$sql = "select distinct asignaturas.nombre, asignaturas.codigo, abrev from asignaturas, profesores where profesores.materia = asignaturas.nombre
 and asignaturas.curso = '$orden_nivel[1]' and abrev not like '%\_%' and asignaturas.codigo not in 
(select distinct asignaturas.codigo from asignaturas where asignaturas.nombre like 'Libre Disp%') order by asignaturas.nombre";
//echo $sql;	
$as = mysqli_query($db_con, $sql);
while ($asi = mysqli_fetch_array($as)) {
?>
<?
	$nomasi = $asi[0];
	$codasi = $asi[1];
	$abrev = $asi[2];
	echo "<tr><th nowrap>$abrev</th>";
	
$sql_asig = "select distinct unidad from alma where curso = '$orden_nivel[1]' order by unidad";
$query_asig = mysqli_query($db_con, $sql_asig);
while ($a_asig = mysqli_fetch_array($query_asig)) {	
	$unidad = $a_asig[0];
	$cod_nota = mysqli_query($db_con, "select id from temp, alma where asignatura = '$codasi' and nota < '5' and alma.claveal1 = temp.claveal and unidad = '$unidad'");
	//echo "select id from temp, alma where asignatura = '$codasi' and nota < '5' and alma.claveal1 = temp.claveal and unidad = '$unidad'";
	$cod_apro = mysqli_query($db_con, "select id from temp, alma where asignatura = '$codasi' and nota > '4' and alma.claveal1 = temp.claveal and unidad = '$unidad'");
	
	//echo "select id from temp where asignatura = '$codasi'<br>";
	$num_susp='';
	$num_susp = mysqli_num_rows($cod_nota);

	$num_apro='';
	$num_apro = mysqli_num_rows($cod_apro);
	
	$combas = mysqli_query($db_con, "select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'");
	//echo "select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'<br>";
	$num_matr='';
	$num_matr = mysqli_num_rows($combas);
	
	$porcient_asig = ($num_susp*100)/$num_matr;
	$porciento_asig='';
	$porciento_susp='';
	if ($porcient_asig > 0) {
			$porciento_susp = "<span class='text-warning'>".substr($porcient_asig,0,4)."% </span><span class=''> (".$num_susp.")</span>";
	}
		
	$porcient_asig2 = ($num_apro*100)/$num_matr;
	$porciento_asig2='';
	$porciento_apro='';
	if ($porcient_asig2 > 0) {
	$porciento_apro = "<span class='text-success'>".substr($porcient_asig2,0,4)."% </span><span class=''> (".$num_apro.")</span>";
	}
	//echo "<td>$num_matr</td>";
	echo "<td nowrap>".$porciento_susp."</td><td nowrap>$porciento_apro </td>";
	

}
echo "</tr>";
}
?>
</table>
<hr />
<br />
<?
}

?>
</div>
<?
mysqli_query($db_con, "drop table temp");
}
?>
</div>
</div>
</div>
</div>

<? include("../../pie.php");?>

</body>
</html>