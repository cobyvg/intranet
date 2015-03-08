<?
session_start();
if($_SESSION['aut']<>1)
{
	header("location:http://iesmonterroso.org");
	exit;
}
$clave_al = $_SESSION['clave_al'];
$todosdatos = $_SESSION['todosdatos'];
$unidad = $_SESSION['unidad'];
$alumno = $_SESSION['alumno'];
$ip = $_SERVER['REMOTE_ADDR'];
$dni = $_SESSION['dni'];
$correo = $_SESSION['correo'];
include("../conf_principal.php");
include("../funciones.php");
mysql_connect ($host, $user, $pass);
mysql_select_db ($db);

?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9"><?	
echo "<h3 align='center'>$todosdatos<br /></h3>";
echo "<p class='lead muted' align='center'><i class='icon icon-comment'> </i>
Mensaje para el Tutor del Grupo $unidad</p><hr />";
if(isset($_POST['submit'])){$submit=$_POST['submit'];}else{$submit="";}
if(isset($_POST['asunto'])){$asunto=$_POST['asunto'];}elseif(isset($_GET['asunto'])){$asunto=$_GET['asunto'];}else{$asunto="";}
if(isset($_POST['texto'])){$texto=$_POST['texto'];}else{$texto="";}

if(isset($_GET['verifica'])){
	$verifica = $_GET['verifica'];
	mysql_query("UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe =
'".$_GET['verifica']."'");

	$asunto0 = "Mensaje de confirmación";
	$texto0 = "El mensaje enviado a los padres del alumno/a $todosdatos ha
sido recibido y leído por estos en la Página Principal del Centro.";
	$ip = $_SERVER['REMOTE_ADDR'];
	$actualiza = mysql_query("insert into mensajes
(dni,claveal,asunto,texto,ip,unidad, recibidotutor, recibidopadre) values 
('".$dni."','".$clave_al."','".$asunto0."','".$texto0."','".$ip."','".$unidad."','0','1')");
unset($asunto0);	
unset($texto0);	
}

if($_POST['submit']=="Enviar")
{
	if(!$asunto or !$texto)
	{
		echo "<div class='alert alert-warning' style='
max-width:450px;margin:auto'><h4>ATENCIÓN:</h4>Es necesario que rellenes tanto 
el <strong>Asunto</strong> como el <strong>Texto</strong> del mensaje. Por 
favor, escribe los datos requeridos y vuelve a enviarlos.</div><br /><br />";
	}
	else
	{	
		if ($_FILES['archivo']['tmp_name']) {
		
			$uploaddir = __DIR__.'/files/';
			
			$filename = substr_replace(md5($_FILES['archivo']['name']),0,5).'_'.str_replace(' ', '_', $_FILES['archivo']['name']);
			$uploadfile = $uploaddir . $filename;
			
			move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile);
			
			$filename_sql = "'".$filename."'";
		}
		else {
			$filename = "NULL";
		}
		
		$query="insert into mensajes (dni,claveal,asunto,texto,ip,correo,unidad, archivo)
values 
('".$_SESSION['dni']."','".$_SESSION['clave_al']."','".$asunto."','".$texto."',
'".$ip."','".$_SESSION['correo']."','".$_SESSION['unidad']."', '".$filename_sql."')";
		 //echo $query;
		mysql_query($query);
		echo "<div class='alert alert-success' style=' max-width:450px;margin:auto'>El
mensaje se ha enviado correctamente al Tutor del Grupo. Recibirás un aviso en 
estas páginas cuando el Tutor confirme haberlo recibido.</div><br /><br />";
	}
}


?>
<br>
<div class="well well-large span8 offset2">

<form id="form1" name="form1" method="post" action="mensajes.php" enctype="multipart/form-data"><label>Asunto<br />
<input name="asunto" type="text" class="input-block-level"
	maxlength="255" value="<? echo $asunto;?>" /> </label> <label>Texto<br />
<textarea name="texto" id="forminput" rows="10" class="input-xlarge"
	style="width: 95%"> <? 
	echo $texto;?> </textarea> </label>

<label for="archivo">Adjuntar archivo:</label>
<input name="archivo" id="archivo" type="file" class="input-block-level" value="" /> 
<hr />

<input name="clave_al" type="hidden"
	value="<? echo $_SESSION['clave_al'];?>" /> <input type="submit"
	name="submit" value="Enviar" onclick="submit()" class="btn btn-primary btn-large" />
</form>
<hr />
<p class="muted">Este formulario permite enviar un mensaje al <em>Tutor
del Grupo</em> del Alumno con el fin de solicitar una cita, realizar una
consulta, proporcionarle información, etc.). Es también posible enviar documentos que los padres consideran relevantes para el Tutor (una imagen o un archivo PDF, por ejemplo).<br>
Un nuevo mensaje de confirmación aparecerá la próxima vez que entres <em>en
estas páginas</em> una vez el Tutor haya leído el mensaje. Si es
necesario, el Tutor se pondrá en contacto contigo.</p>
</div>

	<?
	$historic = mysql_query("select ahora, asunto, texto, origen from mens_texto
where destino like '%".$_SESSION['alumno']."%'");
	$num_mens_texto = mysql_num_rows($historic);
	if ($num_mens_texto > 0) {
		?>
<div class="span10 offset1">
<hr />
<table class='table table-striped table-bordered'>
	<h4>Mensajes Recibidos en estas páginas/a</h4>
	<br />
	<?
	$hist10 = mysql_query("select ahora, asunto, texto, origen from mens_texto where
destino like '%".$_SESSION['alumno']."%'");
	while ($hist1 = mysql_fetch_array($hist10)) {
		$trozos = explode(", ", $hist1[3]);
		$pr_mens = "$trozos[1] $trozos[0]";
		echo "<tr><td width='33%'><p
class='text-info'>$hist1[1]</p><small>Autor: $pr_mens<br />Fecha: 
$hist1[0]</small></td><td>$hist1[2]</td></tr>";
	}
	echo "</table></div>";
	}
	?>
	<br />
	<?
	$historic1 = mysql_query("select ahora, asunto, texto from mensajes where
claveal = '$clave_al' and asunto not like 'Mensaje de confirmación'");
	$num_mensa = mysql_num_rows($historic1);
	if ($num_mensa > 0) {
		?>
	<div class="span10 offset1">
	<hr />
	<h4>Mensajes Enviados al Tutor del Alumno/a</h4>
	<br />
	<table class='table table-striped table-bordered'>
	<?
	$hist0 = mysql_query("select ahora, asunto, texto from mensajes where claveal =
'$clave_al' and asunto not like 'Mensaje de confirmación'");
	//echo "select ahora, asunto , texto from mensajes where claveal = '$ckaveal'";
	while ($hist = mysql_fetch_array($hist0)) {
		echo "<tr><td width='33%'><p class='text-info'>$hist[1]</p><small>Fecha:
		$hist[0]</small></td><td>$hist[2]</td></tr>";
	}
	echo "</table></div>";
	}
	?>
		<br />
		</div>
		<? include "../pie.php"; ?>
    
