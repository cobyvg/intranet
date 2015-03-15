<?
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}
?>
<? include("../conf_principal.php");?>
<? include "../cabecera.php"; ?>
<? include('../menu.php'); ?>
<? include("../funciones.php");?>

<div class="span9"><?
$tr_curso = explode("/",$curso_actual);
$uno = substr($tr_curso[0],strlen($tr_curso[0])-4);
$dos = substr($tr_curso[1],strlen($tr_curso[1])-4);
$curso_uno = $uno+1;
$curso_dos = $dos+1;
$curso_junio = "$curso_uno/$curso_dos";
if (date('m')>'05' and (date('m')=='09' and date('d')<'15')) {
	$curso_textos=$curso_junio;
}
else{
	$curso_textos=$curso_actual;
}
?>
<br>
<h3 align='center'><i class='icon icon-book'> </i> Libros de Texto para el Curso Escolar <? echo $curso_textos; ?>.
</h3>
<hr />

<div class="span8 offset2">

<div class="well well-large" align="center">

<form action="index.php" method="post" id="textos">
<p class="lead muted">Selecciona NIVEL y GRUPO:</p>
<hr />
<select name="nivel" class="input" style="width: 60%"
	onchange="submit()">
	<?
	if(isset($_POST['nivel'])){echo "<option>".$nivel."</option>";}else{echo '<option>Selecciona NIVEL</option>';}
	nivel_completo();
	?>

</select> <select name="grupo" id="select7" class="input"
	style="width: 20%">
	<?
	if(isset($_POST['grupo'])){echo "<option>".$grupo."</option>";}
	elseif(isset($_POST['nivel'])){echo '<option>Selecciona GRUPO</option>';}

	?>
	<?
	grupo_completo($nivel);
	?>
</select>
<hr />
<input type="submit" name="enviar22" value="Buscar Textos"
	class="btn btn-primary btn-block btn-large" /></form>
</div>
	<? if(!(isset($_POST['enviar22']))){ ?>
<div class="well well-large well-transparent">
<h4 class="muted">Notas sobre la Consulta de los Libros de Texto.</h4>
<ul class="muted">
	<li>Los Libros de Texto se presentan por <strong>Nivel</strong>
	(v&aacute;lidos para todos los Grupos, p.ej. '1ESO') o por <strong>Grupo</strong>
	(v&aacute;lidos para un s&oacute;lo Grupo, p.ej. '1ESO-A').</li>
	<li>Hay dos tipos de Textos: <strong>obligatorios</strong> y <strong>recomendados</strong>.
	Los primeros son material acad&eacute;mico necesario para el desarrollo
	de una Asignatura; los segundos son material opcional que complementa
	una Asignatura.</li>
	<li>Los libros pueden ser de <strong>Texto</strong> o de <strong>Lectura</strong>.
	Estos &uacute;ltimos son propios de aquellas Asignaturas relacionadas
	directamente con contenidos escritos (Literatura, Filosof&iacute;a,
	Cultura Cl&aacute;sica, etc.)</li>
	<li>Se puede obtener m&aacute;s informaci&oacute;n a trav&eacute;s del
	<strong>Tutor</strong> del Grupo, el <strong>Departamento</strong>
	correspondiente o la <strong>Direcci&oacute;n</strong> del Centro.</li>
</ul>
</div>
	<?
	}
	echo "</div>";
	if(isset($_POST['enviar22']))
	{
		echo '
		<div class="span10 offset1"><hr />';
		include("textos.php");
		echo '</div><hr /><br />';
	}
	?></div>
<!-- span9 --> <? include("../pie.php");?>