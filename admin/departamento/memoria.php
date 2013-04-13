<?
ini_set("session.cookie_lifetime","2800"); 
ini_set("session.gc_maxlifetime","3600");
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$profesor = $_SESSION ['profi'];
$n_preg=15;
?>

<script type="text/javascript" src="../../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		language: "es",
		mode : "textareas",
		plugins : "table", 
		theme : "advanced",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "none",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,hr,removeformat,visualaid,|,sub,sup,|,charmap",
		theme_advanced_buttons3 : "tablecontrols"
	});
</script>

<?
include '../../menu.php';
// Miembros
$depto=$_SESSION ['dpt'];
$dep0 = mysql_query("select nombre from departamentos where departamento = '$depto'");
$miembros.="Los profesores que componen el Departamento, así como sus grupos y las asignaturas que imparten a los mismos son los siguientes:<br /><br />";
while ($dep = mysql_fetch_array($dep0)) {
	$jefe=$dep[0]."<br />\n";
	$cl = "";
	$grupos0 = mysql_query("select distinct grupo, materia from profesores where profesor = '$dep[0]'");
	while ($grupos = mysql_fetch_array($grupos0)) {
	$cl.=$grupos[0]." (".$grupos[1]."), ";
	}
	$cl = substr($cl,0,-2);
	$miembros.=$jefe.$cl."<br /><br />\n\n";
}
// Actividades
$act0 = mysql_query("select distinct actividad, grupos, fecha from actividades where departamento = '$depto'");
//echo "select nombre from departamentos where departamento = '$depto'";
if (mysql_num_rows($act0)>0) {
	$activ.= "Las actividades complementarias y extraescolares realizadas por el Departamento son las siguientes:<br /><br />";
}
while ($act = mysql_fetch_array($act0)) {
	$jefe2=$act[2].". ".$act[0]."<br />\nGrupos afectados por la actividad: ";
	$cl2 = $act[1];
	$cl2 = substr($cl2,0,-1);
	$activ.=$jefe2.$cl2."<br /><br />\n\n";
}

$campos=array('p1','p2','p3','p4','p5','p6','p7','p8','p9','p10','p11','p12','p13','p14','p15','p16','p17','p18','p19','p20');
#Preguntas
$pregunta[1]='1.1. Composición.';
$nota[1]='Miembros del Departamento, reparto de asignaturas, etc...';
$pregunta[2]='1.2. Reuniones del Departamento.';
$nota[2]='Número de reuniones aprox., asuntos y acuerdos más importantes.';
$pregunta[3]='1.3. Consideraciones generales.';
$nota[3]='Valoración general del funcionamiento del Departamento.';
$pregunta[4]='2. Análisis y propuestas de mejora de los resultados académicos.';
$nota[4]='';
$pregunta[5]='3. Seguimiento de la programación.';
$nota[5]='Análisis y descripción del grado de consecución de los objetivos propuestos en la programación por asignatura y grupo.';
$pregunta[6]='4.1.¿Se han aplicado y revisado los criterios de evaluación de cada asignatura?, ¿Cómo?. Indica los avances y dificultades más significativas al respecto.';
$nota[6]='';
$pregunta[7]='4.2.¿Se concretaron objetivos y contenidos mínimos al principio de curso? En caso afirmativo, ¿qué consecuencia ha tenido esta medida?';
$nota[7]='';
$pregunta[8]='5.1. Alumnos con materias pendientes de otros cursos.';
$nota[8]='Metodología. Análisis de los resultados y propuestas de mejora.';
$pregunta[9]='5.2. Adaptaciones curriculares.';
$nota[9]='¿Ha sido necesario aplicar alguna ACIs? En caso afirmativo, indicar alumno, nivel, asignatura y resultado.';
$pregunta[10]='6. Proyecto TIC.';
$nota[10]='Aplicación de las TIC en el aula, valoración y sugerencias.';
$pregunta[11]='7. PLan de Lectura';
$nota[11]='Acciones referentes al plan de lectura y valoración.';
$pregunta[12]='8. Actividades complementarias y extraescolares.';
$nota[12]='Valoración.';
$pregunta[13]='9. Material necesario.';
$nota[13]='Dentro de las circunstancias que rodean a nuestro Centro, ¿qué material consideras que es necesario para poder impartir mejor tu(s) asignatura(s) el curso que viene?';
$pregunta[14]='10. Formación';
$nota[14]='Propuestas de formación.';
$pregunta[15]='11. Propuestas y comentarios generales.';
$nota[15]='Usa este espacio para cualquier cuestión que no esté contemplada en los puntos anteriores.';
$pregunta[16]='Esta es la 16º pregunta';
$nota[16]='';
$pregunta[17]='Esta es la 17º pregunta';
$nota[17]='';
$pregunta[18]='Esta es la 18º pregunta';
$nota[18]='';
$pregunta[19]='Esta es la 19º pregunta';
$nota[19]='';
$pregunta[20]='Esta es la 20º pregunta';
$nota[20]='';

$profe = $_SESSION['profi'];
##########################
# Actualización de datos
##########################
# Se comprueba si hay envío y se actualiza el registro correspondiente con update
if (isset($_POST['aceptar'])){$aceptar=$_POST['aceptar'];}else{$aceptar='';}

if($aceptar == "Si"){

foreach($campos as $nombre_del_campo)
{
if (!isset($_POST[$nombre_del_campo]) or ($_POST[$nombre_del_campo]=='')){$_POST[$nombre_del_campo]="";}	
}
#	echo 'paso por actualizar<br>';


$actualiza = "UPDATE  mem_dep SET  ";
for ($i=1; $i<=$n_preg; $i++){ $actualiza.="p".$i." = '".$_POST[$campos[$i-1]]."',";}
$actualiza.=" jefe = '".$profe."'";
$actualiza.=" WHERE departamento =  '".$depto."' LIMIT 1 ";
#echo $actualiza.'<br>';
mysql_query($actualiza);	
}
##########################
# Fin Actualización de datos
###########################

###############
# Lectura de los datos de la memoria
##############
#Comprobamos si está el registro para crearlo si no lo encontramos;
	$sqlmem="SELECT departamento FROM mem_dep WHERE departamento='".$depto."'";
	$datos_memoria= mysql_query($sqlmem);
	$memoria = mysql_fetch_array($datos_memoria);
	#echo 'Grupo: ',$memoria[0],'kjhd'.$grupo.'<br>';
	if ($memoria[0]=='') {mysql_query("INSERT INTO  mem_dep (departamento, jefe) VALUES ('".$depto."', '".$profe."')");}
#Seleccionamos ahora el registro del grupo
$sqlmem="SELECT * FROM mem_dep WHERE departamento='".$depto."'";
$datos_memoria= mysql_query($sqlmem);
$memoria = mysql_fetch_array($datos_memoria);
# Se le asigna a los campo un valor más manejable
for ( $i = 1 ; $i <= $n_preg ; $i ++) {
$p[$i]=$memoria[$i+1];
}
if ($memoria[1]!=''){$profe=$memoria[1];}

####################
# Fin de la lectura de datos de la memoria
####################


echo '<div class="container-fluid"><div class="row-fluid">';
echo "<div class='span10 offset1'>";
?>
<div class="page-header" align="center" style="margin-top:-15px">
  <h1>Jefatura de Departamento <small> Memoria final</small></h1>
</div>
<?
echo '<h3 align ="center" class="text-info">',$_SESSION ['dpt'],'</h3><br /><br />';

echo '<div class="well-2 well-large" style="max-width:980px;margin:auto;">';
# formulario
echo '<form action="memoria.php?depto='.$depto.'" method="post" name="memoria" class="form-vertical">
  <div class="control-group">';
echo '<input type="hidden" name="aceptar" value="Si" />';
#  preguntas
echo '<label class="control-label" for="inputZprofe">Jefe del Departamento</label> ';

$prof = mysql_query("SELECT nombre FROM departamentos where departamento = '$depto' and cargo like '%4%'");
$profes = mysql_fetch_row($prof);

echo '<div class="controls"><input type="text" class="input input-xlarge" disabled name="zprofe" value = "'.$profes[0].'"></div>';
echo "<hr>";

for ($i=1; $i<=$n_preg; $i++){
if ($i==1) {echo "<p class='lead'>"."1. Aspectos organizativos del departamento"."</p>";}
if ($i==6) {echo "<p class='lead'>"."4. Criterios de Evaluación."."</p>";}
if ($i==8) {echo "<p class='lead'>"."5. Medidas de atención a la diversidad."."</p>";}
echo "<p class='text-info'>".$pregunta[$i]."</p>";
echo "<p class='muted'>".$nota[$i]."</p>";
if (strstr($pregunta[$i], "1.1.")==TRUE and strlen($p[$i])<"5") {
	$contenido = $miembros;
}
elseif(strstr($pregunta[$i], "8. Act")==TRUE and strlen($p[$i])<"5"){
	$contenido = $activ;
}
else{
	$contenido = $p[$i];
}
echo '<div class="controls">
<TEXTAREA style="width:98%;height:360px;" NAME="'.$campos[$i-1].'">';
echo $contenido;
echo '</TEXTAREA></div><hr>';
}
echo '<center><button class="btn btn-primary" type="submit" name="procesar" value="Guardar" ><i class="icon icon-edit icon-white"> </i> Guardar</button>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" target="_blank" href="memoria_print.php?depto='.$depto.'"><i class="icon icon-print icon-white"> </i> Imprimir</a></center>';
echo '</div>'; # del primer cuadro de preguntas



# aqui el </form ....
echo "</form>";

mysql_close();
##############################
include('../../pie.php');?>
