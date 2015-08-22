<?php
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
?>
<br />
<div align="center" style="max-width:920px;margin:auto;">
<div class="page-header">
  <h2>Informe de Evaluaciones <small> Estadísticas de Calificaciones</small></h2>
</div>

<?php
if (isset($_POST['f_curso']) and !($_POST['f_curso'] == "Curso actual")) {
	$f_curs = substr($_POST['f_curso'],5,4);
	$base_actual = $db.$f_curs;
	//echo $base_actual;
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
$act1 = substr($config['curso_actual'],0,4);
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
<select name="f_curso" onchange="submit()" class="form-control">
<?php
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
<?php
}
?>
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">1ª Evaluación</a></li>
<li><a href="#tab2" data-toggle="tab">2ª Evaluación</a></li>
<li><a href="#tab3" data-toggle="tab">Evaluación Ordinaria</a></li>
</ul>

<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<br>
<?php 
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


<?php
$titulos = array("1"=>"1ª Evaluación","2"=>"2ª Evaluación","3"=>"Evaluación Ordinaria");
foreach ($titulos as $key=>$val){

// Tabla temporal.
 $crea_tabla2 = "CREATE TABLE  `temp3` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`claveal` VARCHAR( 12 ) NOT NULL ,
`asignatura` INT( 8 ) NOT NULL ,
`nota` TINYINT( 2 ) NOT NULL ,
INDEX (  `claveal` )
) ENGINE = INNODB";
 mysqli_query($db_con, $crea_tabla2); 
 mysqli_query($db_con, "ALTER TABLE  `temp3` ADD INDEX (  `asignatura` )");
	$key == '1' ? $activ=" active" : $activ='';
?>
<div class="tab-pane fade in<?php echo $activ;?>" id="<?php echo "tab".$key;?>">
<?php
// Evaluaciones ESO
$nivele = mysqli_query($db_con, "select * from cursos");
while ($orden_nivel = mysqli_fetch_array($nivele)){
$niv = mysqli_query($db_con, "select distinct curso from alma where curso = '$orden_nivel[1]'");
while ($ni = mysqli_fetch_array($niv)) {
	$n_grupo+=1;
	$curso = $ni[0];
	$rep = ""; 
	$promo = "";
		$todos="";
$notas1 = "select notas". $key .", claveal1, matriculas, unidad, curso from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso'";
//echo $notas1."<br>";

$result1 = mysqli_query($db_con, $notas1);
$todos = mysqli_num_rows($result1);
if ($todos < '1') {
echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:920px">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones del Curso <strong class=text-danger>'.$curso.'</strong>. 
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
		mysqli_query($db_con, "insert into temp3 values('','$claveal','$bloque[0]','$cali[0]')");
	}
	}
}
}
?>
<h3>Resultados de los Alumnos por Materias y Grupo</h3><br />
<?php
$nivele = mysqli_query($db_con, "select * from cursos");
while ($orden_nivel = mysqli_fetch_array($nivele)){
?>
	<legend><?php echo $orden_nivel[1]; ?></legend><hr />
<?php
// UNIDADES DEL CURSO
$niv = mysqli_query($db_con, "select distinct unidad from alma where curso = '$orden_nivel[1]' order by unidad");
while ($ni = mysqli_fetch_array($niv)) {
	$unidad = $ni[0];
	?>
	<p class="lead"><?php echo $unidad; ?></p>
<table class="table table-striped table-bordered"  align="center" style="width:700px;" valign="top">
<thead>
<th class='text-info'>Asignatura</th>
<th class='text-info'>Matriculados</th>
<th class='text-info'>Aprob. (%)</th>
<th class='text-info'>Al. Aprob.</th>
</thead>
<tbody>	
	<?php
$sql = "select distinct asignaturas.nombre, asignaturas.codigo from asignaturas, profesores where profesores.materia = asignaturas.nombre
 and asignaturas.curso = '$orden_nivel[1]' and profesores.grupo = '$unidad' and abrev not like '%\_%' and asignaturas.codigo not in 
(select distinct asignaturas.codigo from asignaturas where asignaturas.nombre like 'Libre Disp%')";
//echo $sql;	
$as = mysqli_query($db_con, $sql);
while ($asi = mysqli_fetch_array($as)) {
	$n_c = mysqli_query($db_con, "select distinct nivel from alma where curso = '$orden_nivel[1]'");
	$niv_cur = mysqli_fetch_array($n_c);
	$nomasi = $asi[0];
	$codasi = $asi[1];
	$nivel_curso=$orden_nivel[1];
		if (stristr($nivel_curso,"3") and stristr($codasi,"25201") and $key==3) {
		$codasi="25177";
		$nomasi="Ciencias de la Naturaleza";
	}
	if (stristr($nivel_curso,"3") and (stristr($codasi,"25200")) and $key==3) {
		$codasi="";
		$nomasi="";
	}
	if (!($codasi=="")) {
		
	$cod_nota = mysqli_query($db_con, "select id from temp3, alma where asignatura = '$codasi' and nota < '5' and alma.claveal1 = temp3.claveal and unidad = '$unidad'");
	$cod_apro = mysqli_query($db_con, "select id from temp3, alma where asignatura = '$codasi' and nota > '4' and alma.claveal1 = temp3.claveal and unidad = '$unidad'");
	
	//echo "select id from temp3 where asignatura = '$codasi'<br>";
	$num_susp='';
	$num_susp = mysqli_num_rows($cod_nota);
	$num_apro='';
	$num_apro = mysqli_num_rows($cod_apro);
	$combas = mysqli_query($db_con, "select claveal from alma where combasi like '%$codasi%' and unidad = '$unidad'");
	$num_matr='';
	$num_matr = mysqli_num_rows($combas);
	
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

if ($num_matr>0) {
			echo "<tr><th>$nomasi</th><td>$num_matr</td><td>";
	echo $porciento_asig2."</td><td>".$num_apro."</span></td></tr>";
	}
	}
}
?>
</tbody>
</table>
<br />
<hr />
<?php
}
}
?>
</div>
<?php
mysqli_query($db_con, "drop table temp3");
}
?>
</div>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
	
</body>
</html>
