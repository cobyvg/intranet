<?php
require('../../bootstrap.php');


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$config['dominio'].'/intranet/salir.php');
exit;	
}


include("../../menu.php");
?>

<div class="container">

	<div class="page-header">
  	<h2>Administración <small> Restablecer contraseña</small></h2>
	</div>
			<div class="row">

<?php
if (isset($_POST['enviar'])){$enviar=$_POST['enviar'];}else{$enviar='';}

if (isset($_POST['enviar'])) {

foreach($_POST['cambio'] as $p_dni){
	mysqli_query($db_con, "update c_profes set pass='$p_dni', estado=0 where dni='$p_dni'");
	
	$mail0 = mysqli_query($db_con, "select correo, profesor from c_profes where dni='$p_dni'");
	$mail = mysqli_fetch_array($mail0);
	
	$mail_correo = $mail[0];
	$mail_nomprofesor = $mail[1];
	
	require("../../lib/class.phpmailer.php");
	
	$mail = new PHPMailer();
	$mail->Host = "localhost";
	$mail->From = 'no-reply@'.$config['dominio'];
	$mail->FromName = $config['centro_denominacion'];
	$mail->Sender = 'no-reply@'.$config['dominio'];
	$mail->IsHTML(true);
	$mail->Subject = 'Aviso de la Intranet: Tu contraseña ha sido restablecida';
	$mail->Body = 'Estimado '.$mail_nomprofesor.',<br><br>Tu contraseña ha sido restablecida por algún miembro del equipo directivo. Para acceder a la Intranet haz click en la siguiente dirección <a href="//'.$config['dominio'].'/intranet/">//'.$config['dominio'].'/intranet/</a> Utiliza tu NIF como contraseña. Para mantener tu seguridad utilice una contraseña segura.<br><br><hr>Este es un mensaje automático y no es necesario responder.';
	$mail->AddAddress($mail_correo, $mail_nomprofesor);
	$mail->Send();
}

echo '<div class="alert alert-success">
Las claves de los profesores seleccionados se han reiniciado. El NIF del profesor pasa a ser la nueva clave de acceso.
</div>';



//mysqli_query($db_con, "drop table if exists cargos");
} # del si se ha enviado
?>
			<div class="col-sm-6">
<form name="cargos" action="reset_password.php" method="post">
	
<div class="well">
<div class="form-group">
	<label>Selecciona los profesores</label>
<select name="cambio[]" multiple class="form-control" style="height:300px">
<?php
$n_carg=mysqli_query($db_con, "select distinct profesor, dni from c_profes where profesor in (select distinct nombre from departamentos) order by profesor");

while($carg1=mysqli_fetch_array($n_carg))
{
$pro=mb_strtolower($carg1[0]);
$pro = ucwords($pro);
$dni=$carg1[1];
?>
		<option value="<?php echo $dni;?>"><?php echo $pro;?></option>
<?php
}
	echo "</select>";
?>
</div>

<button type="submit" class="btn btn-primary" name="enviar" value="Reasignar clave">Restablecer contraseñas</button>
<a class="btn btn-default" href="../index.php">Volver</a>
</div>

</form>
</div>
<div class="col-sm-6">
<legend>
Instrucciones
</legend>
<p class="block-help">Selecciona en primer lugar el profesor o profesores a los que se necesita restablecer la clave de acceso. Si quieres seleccionar varios usuarios, mantén pulsada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón en cada uno de ellos.</p>
<p>Tras enviar los datos del formulario se les enviará un correo comunicándoles que la clave ha sido restablecida y la nueva clave provisional es ahora el NIF como si el usuario entrase por primera vez en la aplicación. </p>
</div>
</div>
</div>
<?php include("../../pie.php");?>
</body>
</html>