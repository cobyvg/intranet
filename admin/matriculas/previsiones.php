<?
session_start();
include("../../config.php");
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

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Matriculación de alumnos <small> Previsiones de Matrícula</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-12">

<? 
 $crea_tabla = "CREATE TABLE IF NOT EXISTS `suspensos` (
  `claveal` varchar(12) NOT NULL,
  `suspensos` tinyint(4) NOT NULL,
  `pil` tinyint(4) NOT NULL,
  `grupo` varchar( 6 ) NOT NULL,
  `nivel` varchar( 64 ) NOT NULL,
  KEY `claveal` (`claveal`)
)";
 mysql_query($crea_tabla);
// Comprobamos datos de evaluaciones
$n3 = mysql_query("select * from notas where notas3 not like ''");
$n2 = mysql_query("select * from notas where notas2 not like ''");
$n1 = mysql_query("select * from notas where notas1 not like ''");
if(mysql_num_rows($n3)>0){$n_eval = "notas3";}
elseif(mysql_num_rows($n2)>0){$n_eval = "notas2";}
elseif(mysql_num_rows($n1)>0){$n_eval = "notas1";}
else{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>No hay datos de Calificaciones en la tabla NOTAS. Debes importar las Calificaciones desde Séneca (Administración de la Intranet --> Importar Calificaciones) para que este módulo funcione.
          </div></div>';
	exit();
}
?>
<table align="center" style="width:auto" cellpadding=6>
<tr>

<?
// Evaluaciones ESO
$niv = mysql_query("select nomcurso from cursos where nomcurso like '%E.S.O.%' or nomcurso like '%Bach%'");
while ($ni = mysql_fetch_array($niv)) {
	$n_grupo+=1;
	$curso = $ni[0];
	$rep = ""; 
	$promo = "";
$notas1 = "select ". $n_eval .", claveal1, matriculas, unidad from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.curso = '$curso'";
// echo $notas1."<br>";
echo "<td style='text-align:center;' valign='top'>";

$result1 = mysql_query($notas1);
$todos = mysql_num_rows($result1);
if ($todos < '1') {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
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
$mas_cuatr = mysql_query("select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos > '4'");
$mas_cuatro=mysql_num_rows($mas_cuatr);
$cuatr = mysql_query("select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos = '4'");
$cuatro=mysql_num_rows($cuatr);
$menos_cuatr = mysql_query("select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos < '4'");
$menos_cuatro=mysql_num_rows($menos_cuatr);
$n_pil = mysql_query("select distinct claveal, grupo from suspensos where  nivel = '$curso' and pil = '1'");
$num_pil=mysql_num_rows($n_pil);
$pil_mas_cuatr = mysql_query("select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos > '4' and pil = '1'");
$pil_mas_cuatro=mysql_num_rows($pil_mas_cuatr);
$pil_menos_cuatr = mysql_query("select distinct claveal, grupo from suspensos where  nivel = '$curso' and suspensos < '4' and pil = '1'");
$pil_menos_cuatro=mysql_num_rows($pil_menos_cuatr);
$pil_cuatr = mysql_query("select distinct claveal, grupo from suspensos where nivel = '$curso' and suspensos = '4' and pil = '1'");
$pil_cuatro=mysql_num_rows($pil_cuatr);

if (strstr($nivel, "E.S.O.") == TRUE) {
	$rep="";
	$promo="";
	$rep = ($mas_cuatro - $pil_mas_cuatro) + (($cuatro - $pil_cuatro)/2); 
	$promo = ($menos_cuatro - $pil_menos_cuatro) + (($cuatro - $pil_cuatro)/2) + $num_pil;
}
else{
$rep = ($mas_cuatro) + (($cuatro)/2); 
$promo = $todos - $rep;
}
if ($n_grupo=="5") {
	echo "</td></tr><tr><td style='text-align:center' valign='top'>";
}
?>

<table class="table table-striped" align="center" style="width:96%" valign="top">
<?
if (strstr($nivel, "E.S.O.") == TRUE) {
 echo "<h4>".$nivel."</h4>";
 $rep_pil = "PIL <br /><small class='muted'>(+4: $pil_mas_cuatro; 4: $pil_cuatro; -4: $pil_menos_cuatro)</small>";
}
else{
	if (strstr($nivel, "(Ciencias y Tecnología)") == TRUE) {
		$curso = $nivel;
	}
	if (strstr($nivel, "(Humanidades y Ciencias Sociales)") == TRUE) {
		$curso = $nivel;
	}
 echo "<h4>".$curso."</h4>";	
 $rep_pil="Repetidores";
}
?>
<thead>
<th>Suspensos</th>
<th>Nº Alumnos</th>
</thead>
<tbody>
<tr>
<th>Más de 4</th>
<td style='text-align:right'><? echo $mas_cuatro;?></td>
</tr>
<th>4</th>
<td  style='text-align:right'><? echo $cuatro;?></td>
</tr>
<th>Menos de 4</th>
<td  style='text-align:right'><? echo $menos_cuatro;?></td>
</tr>
<tr>
<th><? echo $rep_pil;?></th>
<td  style='text-align:right'> <? echo $num_pil;?></td>
</tr>
</table>
<table class="table table-bordered" align="center" style="width:96%">
<tr>
<th style="color:#9d261d">Repiten</th>
<td  style='text-align:right'><? echo $rep;?></td>
</tr>
<tr>
<th style="color:#46a546">Promocionan</th>
<td  style='text-align:right'> <? echo $promo;?></td>
</tr>
</table>
</td>
<?
}
 mysql_query("drop table suspensos");

?>
</tr>
</table>

</div>
</div>
<? include("../../pie.php");