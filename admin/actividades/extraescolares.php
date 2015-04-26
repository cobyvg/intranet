<?
if (isset($_POST['submit1'])) {
	include("imprimir.php");
}
elseif(isset($_POST['submit2'])){
	include("registrar.php");
}
?>
<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'4') == TRUE or stristr($_SESSION['cargo'],'5') == TRUE)
{
	$jefes=1;
}
?>
  <?php
include("../../menu.php");
include("menu.php");  
  ?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Selección de alumnos</small></h2>
</div>
</div>

<div class="col-sm-8 col-sm-offset-2">
    <div class="well well-lg">      
<?
$profes_actividad = $_GET['profesores'];
if ($jefes==1 or strstr(mb_strtoupper($profes_actividad),mb_strtoupper($_SESSION['profi']))==TRUE) {
?>
<a href="javascript:seleccionar_todo()" class="btn btn-primary btn-sm hidden-print">Marcar todos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-primary btn-sm pull-right hidden-print">Desmarcar todos</a>
<br /><br />
<? } ?>
    <FORM action="extraescolares.php" method="POST" name="imprime">

  <?
$cursos0 = mysqli_query($db_con, "select unidades, profesores, nombre from calendario where id = '$id'");
while($cursos = mysqli_fetch_array($cursos0))
{
$actividad=$cursos[2];
echo "<legend align='center' class='text-info'>$actividad</legend>";
$profes_actividad = $cursos[1];
$profesor="";
$profes="";
$profes = explode(";",$cursos[1]);
foreach ($profes as $n_profe)
{
$profe = explode(", ",$n_profe);
$profesor.=$profe[1]." ".$profe[0].", ";
//$profesor.=$profeso.",";
}
$profesor = substr($profesor,0,-5);
$trozos = explode(";",$cursos[0]);
foreach($trozos as $valor)
{
$unidad = $valor;
$alumnos0 = "select alma.nombre, alma.apellidos, NC, alma.claveal from alma, FALUMNOS where alma.claveal = FALUMNOS.claveal and alma.unidad = '$unidad' order by NC";
//echo $cursos[0]." => ".$alumnos0."<br>";
$alumnos1 = mysqli_query($db_con, $alumnos0);
$num = mysqli_num_rows($alumnos1);
if($alumno = mysqli_fetch_array($alumnos1))
{
$datos0 = "select fechaini, horaini, profesores, nombre, descripcion, observaciones from calendario where id ='$id'";
$datos1 = mysqli_query($db_con, $datos0);
$datos = mysqli_fetch_array($datos1);
$fecha0 = explode("-",$datos[0]);
$fecha  = $fecha0[2]."-". $fecha0[1]."-". $fecha0[0];
$horario = $datos[1];
$actividad = $datos[3];
$descripcion = $datos[4];
$observaciones = $datos[5];
?>
<?

if ($jefes==1 OR strstr(mb_strtoupper($profes_actividad),mb_strtoupper($_SESSION['profi']))==TRUE) {
?>
<input name="fecha" type="hidden" id="A" value="<? echo $fecha;?>">
<input name="horario" type="hidden" id="A" value="<? echo $horario;?>">
<input name="profesor" type="hidden" id="A" value="<? echo $profesor;?>">
<input name="actividad" type="hidden" id="A" value="<? echo $actividad;?>">
<input name="descripcion" type="hidden" id="A" value="<? echo $descripcion;?>">
<input name="observaciones" type="hidden" id="A" value="<? echo $observaciones;?>">
<input name="id" type="hidden" id="A" value="<? echo $id;?>">  
<?}?> 
<table class="table table-striped">
<tr><td colspan="2"><h4><? echo "Alumnos de $unidad";?></h4></td>
</tr>

<?
do{
$apellidos = $alumno[0];
$nombre = $alumno[1];
$nc = $alumno[2];
$claveal = $alumno[3];
$extra_al="";
$ya = mysqli_query($db_con,"select * from actividadalumno where cod_actividad='$id' and claveal='$claveal'");
if (mysqli_num_rows($ya)>0) {
	$extra_al = 'checked';
}
?>
<tr><td >
<input name="<? echo $nc.$claveal;?>" type="checkbox" id="A" value="<? echo $claveal;?>" <? echo $extra_al;?>> 
</td>
<td>   
<?
echo " $nc. $apellidos $nombre</td></tr>";
}while($alumno = mysqli_fetch_array($alumnos1));
?>
</table>
<?
}}
}
?>
<br />
<div align="center">
<?
if ($jefes==1 OR strstr(mb_strtoupper($profes_actividad),mb_strtoupper($_SESSION['profi']))==TRUE) {
?>
<button type="submit" name="submit1" value="Imprimir Carta para Padres" class="btn btn-primary hidden-print">Imprimir Carta para Padres</button>&nbsp;
<button type="submit" name="submit2" value="Registrar Alumnos" class="btn btn-info hidden-print">Registrar Alumnos</button>&nbsp;
<? } ?>
<input type="button" name="print"  class="btn btn-success hidden-print" value="Imprimir Lista de Alumnos" onclick="window.print();">
</div>
  </FORM>
  </div>
  </div>
  </div>
</div> 
  <script>
function seleccionar_todo(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == "checkbox")	
			document.imprime.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == "checkbox")	
			document.imprime.elements[i].checked=0
}
</script>
<? include("../../pie.php");?>
