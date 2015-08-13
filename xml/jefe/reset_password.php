<?php
require('../../bootstrap.php');

acl_acceso($_SESSION['cargo'], array(1));

function generador_password($long)
{
	$alfabeto = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $long_alfabeto = strlen($alfabeto) - 1;
    for ($i = 0; $i < $long; $i++) {
        $p = rand(0, $long_alfabeto);
        $pass[] = $alfabeto[$p];
    }
    return implode($pass);
}

include("../../menu.php");
?>

<div class="container">

	<div class="page-header">
  	<h2>Administraci�n <small> Restablecer contrase�a</small></h2>
	</div>
			<div class="row">

<?php
if (isset($_POST['enviar'])) {

	$num = 0;
	foreach($_POST['cambio'] as $p_dni){
		mysqli_query($db_con, "update c_profes set pass='".sha1($p_dni)."', estado=0 where dni='$p_dni'");
		
		$mail0 = mysqli_query($db_con, "select correo, profesor from c_profes where dni='$p_dni'");
		$mail = mysqli_fetch_array($mail0);
		
		$mail_correo = $mail[0];
		$mail_nomprofesor = $mail[1];
		
		// Excepci�n para el usuario Administrador
		if ($mail_nomprofesor == 'Administrador') {
			$pass_admin = generador_password(9);
			$pass_sha1	= sha1($pass_admin);
			
			mysqli_query($db_con, "UPDATE c_profes SET pass='$pass_sha1', dni='$pass_admin', estado=0 WHERE PROFESOR='Administrador' LIMIT 1");
			mysqli_query($db_con, "UPDATE departamentos SET DNI='$pass_admin' WHERE NOMBRE='Administrador' LIMIT 1");
		}
		
		require("../../lib/class.phpmailer.php");
		
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		$mail->From = 'no-reply@'.$config['dominio'];
		$mail->FromName = $config['centro_denominacion'];
		$mail->Sender = 'no-reply@'.$config['dominio'];
		$mail->IsHTML(true);
		
		// Excepci�n para el usuario Administrador
		if ($mail_nomprofesor == 'Administrador') {
			$mail->Subject = 'Aviso de la Intranet: Restablecimiento de la cuenta de Administrador';
			$mail->Body = 'Estimado '.$mail_nomprofesor.',<br><br>Tu contrase�a ha sido restablecida por alg�n miembro del equipo directivo. Para acceder a la Intranet haz click en la siguiente direcci�n <a href="http://'.$config['dominio'].'/intranet/">//'.$config['dominio'].'/intranet/</a> Utiliza la contrase�a que aparece a continuaci�n:<br><br>'.$pass_admin.'<br><br>Para mantener tu seguridad utilice una contrase�a segura.<br><br><hr>Este es un mensaje autom�tico y no es necesario responder.';
		}
		else {
			$mail->Subject = 'Aviso de la Intranet: Tu contrase�a ha sido restablecida';
			$mail->Body = 'Estimado '.$mail_nomprofesor.',<br><br>Tu contrase�a ha sido restablecida por alg�n miembro del equipo directivo. Para acceder a la Intranet haz click en la siguiente direcci�n <a href="http://'.$config['dominio'].'/intranet/">//'.$config['dominio'].'/intranet/</a> Utiliza tu DNI como contrase�a. Para mantener tu seguridad utilice una contrase�a segura.<br><br><hr>Este es un mensaje autom�tico y no es necesario responder.';
		}
		$mail->AddAddress($mail_correo, $mail_nomprofesor);
		$mail->Send();
		
		$num++;
	}
	
	if($num > 1) {
		echo '<div class="alert alert-success">Se han restablecido las contrase�as seleccionadas. Se ha enviado un correo electr�nico a los usuarios afectados.</div>';
	}
	else {
		echo '<div class="alert alert-success">Se ha restablecido la contrase�a seleccionada. Se ha enviado un correo electr�nico al usuario afectado.</div>';
	}

}
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

<button type="submit" class="btn btn-primary" name="enviar" value="Reasignar clave">Restablecer contrase�as</button>
<a class="btn btn-default" href="../index.php">Volver</a>
</div>

</form>
</div>
<div class="col-sm-6">
<legend>
Instrucciones
</legend>
<p class="block-help">Selecciona en primer lugar el profesor o profesores a los que se necesita restablecer la clave de acceso. Si quieres seleccionar varios usuarios, mant�n pulsada la tecla <kbd>Ctrl</kbd> mientras haces click con el rat�n en cada uno de ellos.</p>
<p>Tras enviar los datos del formulario se les enviar� un correo comunic�ndoles que la clave ha sido restablecida y la nueva clave provisional es ahora el NIF como si el usuario entrase por primera vez en la aplicaci�n. </p>
</div>
</div>
</div>
<?php include("../../pie.php");?>
</body>
</html>