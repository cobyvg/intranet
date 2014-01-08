<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);?>
<?
  	include("../../menu.php");
  	include("menu.php");
?>
<br />
<div align="center" style="max-width:1000px;margin:auto;">
<div class="page-header" align="center">
  <h2>Informe de Evaluaciones <small> Estadísticas de Calificaciones</small></h2>
</div>
<br />
<div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="icon-spinner icon-spin icon-2x pull-left"></i> Cargando los datos...
 </div>
<div id='t_larga' style='display:none' >
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">1ª Evaluación</a></li>
<li><a href="#tab2" data-toggle="tab">2ª Evaluación</a></li>
<li><a href="#tab3" data-toggle="tab">Evaluación Ordinaria</a></li>
</ul>

<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<? 
// Comprobamos datos de evaluaciones
$n1 = mysql_query("select * from notas where notas1 not like ''");
if(mysql_num_rows($n1)>0){}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administración de la Intranet --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
	exit();
}
?>


<?
$titulos = array("1"=>"1ª Evaluación","2"=>"2ª Evaluación","3"=>"Evaluación Ordinaria");
foreach ($titulos as $key=>$val){
	
// Creamos la tabla en cada evaluación
 $crea_tabla = "CREATE TABLE IF NOT EXISTS `suspensos` (
  `claveal` varchar(12) NOT NULL,
  `suspensos` tinyint(4) NOT NULL,
  `pil` tinyint(4) NOT NULL,
  `grupo` varchar( 6 ) NOT NULL,
  `nivel` varchar( 64 ) NOT NULL,
  KEY `claveal` (`claveal`)
)";
 mysql_query($crea_tabla);
// Tabla temporal.
 $crea_tabla2 = "CREATE TABLE  `temp` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`claveal` VARCHAR( 12 ) NOT NULL ,
`asignatura` INT( 8 ) NOT NULL ,
`nota` TINYINT( 2 ) NOT NULL ,
INDEX (  `claveal` )
) ENGINE = INNODB";
 mysql_query($crea_tabla2); 
	if ($key == '1') {$activ = ' active';}
?>
<div class="tab-pane fade in<? echo $activ;?>" id="<? echo "tab".$key;?>">
<h3><? echo $val;?></h3><br />

<table class="table table-striped table-bordered"  align="center" style="width:auto" valign="top">
<thead>
<th></th>
<th class='text-info'>Alumnos</th>
<th class='text-warning'>Repiten</th>
<th>0 Susp.</th>
<th>1-2 Susp.</th>
<th>3-5 Susp.</th>
<th>6-8 Susp.</th>
<th>9+ Susp.</th>
<th class='text-success'>Promocionan</th>
</thead>
<tbody>
<?
// Evaluaciones ESO
$nivele = mysql_query("select * from cursos");
while ($orden_nivel = mysql_fetch_array($nivele)){
$niv = mysql_query("select distinct curso, nivel from alma where curso = '$orden_nivel[1]'");
while ($ni = mysql_fetch_array($niv)) {
	$n_grupo+=1;
	$curso = $ni[0];
	$nivel = $ni[1];
	$rep = ""; 
	$promo = "";
$notas1 = "select notas". $key .", claveal1, matriculas, unidad from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso'";
//echo $notas1."<br>";

$result1 = mysql_query($notas1);
$todos = mysql_num_rows($result1);
if ($todos < '1') {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administracción --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
}
while($row1 = mysql_fetch_array($result1)){
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$claveal = $row1[1];
$grupo = $row1[3];
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
$asig = mysql_query($nombreasig);
$cali = mysql_fetch_row($asig);
if($cali[0] < '5' and !($cali[0] == ''))	{
	$susp+=1; 
	mysql_query("insert into temp values('','$claveal','$bloque[0]','$cali[0]')");
	}
	}
mysql_query("insert into suspensos  (
`claveal` ,
`suspensos` ,
`pil` ,
`grupo`,
`nivel`
)
VALUES (
'$claveal',  '$susp',  '$pil', '$grupo', '$curso'
)");
	}

// Calculamos
$cer = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos = '0'");
$cero = '';
$cero=mysql_num_rows($cer);

$uno_do = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos > '0' and suspensos < '3'");
$uno_dos='';
$uno_dos=mysql_num_rows($uno_do);

$tres_cinc = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos > '2' and suspensos < '6'");
$tres_cinco='';
$tres_cinco=mysql_num_rows($tres_cinc);

$seis_och = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos > '5' and suspensos < '9'");
$seis_ocho='';
$seis_ocho=mysql_num_rows($seis_och);

$nuev = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos > '8'");
$nueve='';
$nueve=mysql_num_rows($nuev);

//$tota = mysql_query("select distinct notas.claveal from notas, alma where alma.claveal1 = notas.claveal and nivel = '$curso'");
$tota = mysql_query("select distinct claveal from suspensos where nivel = '$curso'");
$total='';
$total=mysql_num_rows($tota);

// Promocion
	$extra1 = " and suspensos = '0'";
	$prom1 = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and grupo not like '1E%' and grupo not like '2E%' and grupo not like '3E%' and grupo not like '1B%'  $extra1");
	$promo1=mysql_num_rows($prom1);
	if ($promo1==0) { $promo1=""; }

	$extra2 = " and suspensos < '3'";
	$prom2 = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and (grupo like '1E%' or grupo like '2E%' or grupo like '3E%' or grupo like '1B%')  $extra2");
	$promo2=mysql_num_rows($prom2);
	if ($promo2==0) { $promo2=""; }

$n_pil = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and pil = '1'");
$num_pil='';
$num_pil=mysql_num_rows($n_pil);

$porcient = (($promo1+$promo2)*100)/$total;
$porciento='';
$porciento = substr($porcient,0,5);
?>

<tr>
<th><? echo $curso;?></th>
<th class='text-info'><? echo $total;?></th>
<td class='text-warning'><? echo $num_pil;?></td>
<td><? echo $cero;?></td>
<td><? echo $uno_dos;?></td>
<td><? echo $tres_cinco;?></td>
<td><? echo $seis_ocho;?></td>
<td><? echo $nueve;?></td>
<th class='text-success'><? echo $promo2."".$promo1." <span class='muted pull-right'>(".$porciento.")</span>";?></th>
</tr>
<?
}
}
?>
</tbody>
</table>

<!--  Estadísticas por asignatura -->

<hr />
<h3>Asignaturas del Nivel</h3><br />
<?
$nivele = mysql_query("select * from cursos");
while ($orden_nivel = mysql_fetch_array($nivele)){
	?>
	<legend><? echo $orden_nivel[1]; ?></legend>
<table class="table table-striped table-bordered"  align="center" style="width:auto" valign="top">
<thead>
<th class='text-info'>Asignatura</th>
<th class='text-success'>Matriculados</th>
<th class='text-error'>Suspensos</th>
</thead>
<tbody>	
	<?
$as = mysql_query("select asignaturas.nombre, asignaturas.codigo from asignaturas where curso = '$orden_nivel[1]' and abrev not like '%\_%'");
//echo "select asignaturas.nombre, asignaturas.codigo from asignaturas where curso = '$orden_nivel[1]' and abrev not like '%\_%'<br>";
while ($asi = mysql_fetch_array($as)) {
	$nomasi = $asi[0];
	$codasi = $asi[1];
	$cod_nota = mysql_query("select id from temp where asignatura = '$codasi'");
	//echo "select id from temp where asignatura = '$codasi'<br>";
	$num_susp='';
	$num_susp = mysql_num_rows($cod_nota);
	$combas = mysql_query("select claveal from alma where combasi like '%$codasi%' and curso = '$orden_nivel[1]'");
	//echo "select claveal from alma where combasi like '%$codasi%' and curso = '$orden_nivel[1]'<br>";
	$num_matr='';
	$num_matr = mysql_num_rows($combas);
	$porcient_asig = ($num_susp*100)/$num_matr;
	$porciento_asig='';
	$porciento_asig = substr($porcient_asig,0,5);
	if ($porciento_asig>0) {
			echo "<tr><th>$nomasi</th><td>$num_matr</td><td>";
	echo $num_susp." <span class='muted'>(".$porciento_asig.")</span></td</tr>";
	}

}
?>
</tbody>
</table>
<hr />
<?
}
?>

</div>
<?
mysql_query("drop table suspensos");
mysql_query("drop table temp");
}
?>
</div>
</div>
</div>
</div>

<? include("../../pie.php");?>
 <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>  
</body>
</html>