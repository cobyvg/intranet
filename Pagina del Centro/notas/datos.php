<?
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
$clave_al = $_SESSION['clave_al'];
$todosdatos = $_SESSION['todosdatos'];
$alumno = $_SESSION['alumno'];
	include("../conf_principal.php");	
	include("../funciones.php");
	
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
	
	$mes = date('m');	
	if ($_SESSION['esdeprimaria']=="1" and ($mes=='6')) {
	include "../cabecera.php"; 

	$nivel = $_SESSION['nivel'];
	$claveal = $_SESSION['clave_al'];
	//echo $claveal."<br>";
	
	echo "<div class='container'><div class='row'><div class='span10 
offset1'><br /><h3 align='center'>".$_SESSION['todosdatos']."<br /></h3><legend 
align='center' class='muted'>Colegio ".$_SESSION['colegio']."</legend>";
	
//	include("matriculas.php");
	exit();
	}
	
	$clave_al = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$alumno = $_SESSION['alumno'];
	$claveal = $_SESSION['clave_al'];
	$curso = $_SESSION['curso'];
	$unidad = $_SESSION['unidad'];
	$dni = $_SESSION['dni'];
	$correo = $_SESSION['correo'];
?>
<style>
.table th{
font-weight:bold;
color:#666;
font-size:0.9em;
}
</style>
<?
include "../cabecera.php"; ?>
<?
if ($_SESSION['esdeprimaria']<>1) {
	include('consultas.php'); 
}
	?>
<div class="span9">	

<?php
   echo "<h3 align='center'>".$todosdatos."</h3>";

   if ($mes==6) {
//	include('matriculas.php'); 
}

// Recibido el mensaje por parte del Tutor

$men1 = "select ahora, asunto, id from mensajes where claveal = '$clave_al' and 
recibidotutor = '1' and recibidopadre = '0'";
//echo $men1;
$men2 = mysql_query($men1);
while($men = mysql_fetch_row($men2))
{
$fechacompl = explode(" ",$men[0]);
$fech = explode("-",$fechacompl[0]);
$fechaenv = "el día $fech[2] del $fech[1] de $fech[0], a las $fechacompl[1]";
 echo "<br /><div class='alert alert-success' 
style='width:500px;margin:auto;'><h4>Mensaje de confirmación:</h4><br>El 
Tutor ha recibido el mensaje enviado desde estas páginas 
$fechaenv</div><br /><br />";
mysql_query("UPDATE mensajes SET recibidopadre = '1' WHERE id = $men[2]");
}


// Comprobar mensajes
  
if(isset($_POST['verifica'])){
$verifica = $_POST['verifica'];
mysql_query("UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = 
'".$_POST['verifica']."'");
$t_mens = mysql_query("select asunto from mens_texto where id = (select distinct id_texto from mens_profes where id_profe = '".$_POST['verifica']."')");
$mens_texto = mysql_fetch_array($t_mens);
$asunto_mensaje = $mens_texto[0];
$asunto = "Mensaje de confirmación";
$texto = "El mensaje enviado a los padres del alumno/a $todosdatos ($asunto_mensaje) ha 
sido recibido y leído por estos en la Página Principal del Centro.";
$ip = $_SERVER['REMOTE_ADDR'];
$actualiza = mysql_query("insert into mensajes 
(dni,claveal,asunto,texto,ip,unidad, recibidotutor, recibidopadre) values 
('".$dni."','".$clave_al."','".$asunto."','".$texto."','".$ip."','".$unidad."','0','1')");
}  

$men1 = "select ahora, asunto, texto, profesor, id_profe, origen from 
mens_profes, mens_texto where mens_texto.id = mens_profes.id_texto and profesor 
= '$alumno' and recibidoprofe = '0'";
//echo $men1;
$men2 = mysql_query($men1);
if(mysql_num_rows($men2) > 0)
{
while($men = mysql_fetch_row($men2))
{
$n_mensajes+=1;
$fechacompl = explode(" ",$men[0]);
$fech = explode("-",$fechacompl[0]);
$asunto = $men[1];
$texto = $men[2];
$pr = $men[3];
$id = $men[4];
$orig = $men[5];
$origen0 = explode(", ",$men[5]);
$origen = $origen0[1]." ".$origen0[0];
$fechaenv = "el $fech[2] del $fech[1] de $fech[0], a las $fechacompl[1]";
?>
<br /><div class='alert alert-success' style=" max-width:450px;margin:auto">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<a data-toggle="modal" href="#mensaje<? echo $n_mensajes;?>"  rel="tooltip" 
title="<? echo substr($texto,0,132)."...";?>">
<p><? echo $asunto; ?></p>
</a>
<p><i class="icon-comment"> </i>  <? echo "".$origen."";?></p>
</div>

<div class="modal hide fade" id="mensaje<? echo $n_mensajes;?>">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4>Mensaje del Tutor <? echo $origen;?> </h4><br /><small>Enviado <? echo 
$fechaenv;?></small>
  </div>
  <div class="modal-body">
<p><? echo $asunto;?></p>
<p><? echo $texto;?></p>  </div>
  <div class="modal-footer">
  <form name="mensaje_enviado" action="datos.php" method="post" 
enctype="multipart/form-data" class="form-inline">
  <a href="#" target="_top" data-dismiss="modal"class="btn">Cerrar</a>
    <?
	$asunto = str_replace('"','',$asunto);
	echo '<a 
href="mensajes.php?verifica='.$id.'&clave_al='.$clave_al.'&asunto='.$asunto.'&origen='.$orig.'" 
class="btn btn-primary">Responder</a>';
?>
<button type="submit" name="verifica" value="<?php  echo $id; ?>" class="btn 
btn-danger">Leído</a>  
<input type='hidden' name = 'id_ver' value = '<? echo $id; ?>' />
</form>
</div>
</div>
<br /><br />
<?
}
}

  
  $SQL = "select distinct apellidos, nombre, UNIDAD, DNI, fecha, 
domicilio, codpostal, localidad, telefono, telefonourgencia, control.correo, 
 padre, dnitutor, alma.claveal, curso from 
alma, control where alma.claveal=control.claveal and alma.claveal = 
'$clave_al'";
 // echo $SQL;
  $result = mysql_query($SQL);
  if ($row = mysql_fetch_array($result))
        {
				//$claveal=$row[16];

                do {
		echo "<p class='lead muted' align='center'><i class='icon icon-user'> </i> Información del Alumno registrada en el Centro</p><hr />";	
	
		echo '<br><div class="span5 offset-1">';	
		echo "<table class='table table-striped table-bordered'>";
			echo "
			<tr><th>APELLIDOS</th><td class='text-success'>$row[0]</td></tr>
			<tr><th>NOMBRE</th><td class='text-success'>$row[1]</td></tr>
			<tr><th>CURSO</th><td class='text-success'>$row[14]</td></tr>
			<tr><th>UNIDAD</th><td class='text-success'>$row[2]</td></tr>
			<tr><th>DNI</th><td class='text-success'>$row[3]</td></tr>
			<tr><th>FECHA</th><td class='text-success'>$row[4]</td></tr>
			<tr><th>DOMICILIO</th><td class='text-success'>$row[5]</td></tr>
			<tr><th>CÓDIGO POSTAL</th><td class='text-success'>$row[6]</td></tr>
			<tr><th>LOCALIDAD DE NACIMIENTO</th><td class='text-success'>$row[7]</td></tr>
			<tr><th>TELÉFONO</th><td class='text-success'>$row[8]</td></tr>
			<tr><th>TFNO. URGENCIAS</th><td class='text-success'>$row[9]</td></tr>
			<tr><th>CORREO ELECTRÓNICO</th><td class='text-success'>$row[10]</td></tr>
			<tr><th>TUTOR</th><td class='text-success'>$row[11]</td></tr>
			<tr><th>DNI TUTOR</th><td class='text-success'>$row[12]</td><tr>";

        } while($row = mysql_fetch_array($result));

		echo "</table>";
		}
		echo "</div>";
?>	
<div class="span5 ">	
  <div class="well well-large">	
  <?
$ft=mysql_query("select datos, tamaño from fotos where nombre = 
'$clave_al.jpg'");
	if (mysql_num_rows($ft)>'0') {
		$ft1=mysql_fetch_array($ft);
		$grande=$ft1[1];
echo "<div align='center'><img src='./muestra_imagen.php?clave_al=$clave_al' 
width='200' height='240' class='img-polaroid' /></div>";	
}
?>
  <br />

  <p class="text-info">Esta página ofrece los datos registrados en la 
<strong>Matrícula</strong> del Alumno en el Centro, tal como fueron presentados 
por el Alumno o sus Padres. <br><em>En el caso de que alguno de los datos sea incorrecto 
o haya cambiado, es conveniente comunicarlo en la Administración del Instituto 
para su rectificación.</em> <br>Esto es especialmente importante en el caso de la 
dirección postal y los teléfonos de contacto, ya que de ellos dependen las 
comunicaciones entre el Centro y la familia del alumno.</p>
  </div>
</div>
</div>
</div><!-- span9 -->

<?
include('../pie.php');
?>  
