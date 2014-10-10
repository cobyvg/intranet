<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

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


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?
include("../../menu.php");
?>

<div class="container">

	<div class="page-header">
  	<h2>Administración <small> Restablecer contraseña</small></h2>
	</div>
			<div class="row">

<?
if (isset($_POST['enviar'])){$enviar=$_POST['enviar'];}else{$enviar='';}

if (isset($_POST['enviar'])) {

foreach($_POST['cambio'] as $p_dni){
mysqli_query($db_con, "update c_profes set pass='$p_dni' where dni='$p_dni'");
}

echo '<div class="alert alert-success">
Las claves de los profesores seleccionados se han reiniciado. El NIF del profesor pasa a ser la nueva clave de acceso.
</div>';

$mail0=mysqli_query($db_con, "select correo from c_profes where dni='$eldni'");
$mail=mysqli_fetch_row($mail0);
		$cabecera = "From: ".$email_del_centro." \r\n";
		$direccion = $mail[0];
		$tema = "Borrado y reinicio de Contraseña";
		$texto = "La contrasseña para entrar en la Intranet ha sido reiniciada. Cuando vuelvas a entrar, escribe tu nombre de usuario y tu DNI como contraseña. En la siguiente página deberás volver a escribir una nueva contraseña.";
		mail($direccion, $tema, $texto, $cabecera); 

//mysqli_query($db_con, "drop table if exists cargos");
} # del si se ha enviado
?>
			<div class="col-sm-6">
<form name="cargos" action="reset_password.php" method="post">
	
<div class="well">
<div class="form-group">
	<label>Selecciona los profesores</label>
<select name="cambio[]" multiple class="form-control" style="height:300px">
<?
$n_carg=mysqli_query($db_con, "select distinct profesor, dni from c_profes where profesor in (select distinct nombre from departamentos) order by profesor");

while($carg1=mysqli_fetch_array($n_carg))
{
$pro=mb_strtolower($carg1[0]);
$pro = ucwords($pro);
$dni=$carg1[1];
?>
		<option value="<? echo $dni;?>"><? echo $pro;?></option>
<?
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
<p class="block-help">Selecciona en primer lugar el profesor o profesores a los que se necesita reasignar la clave de acceso. Si quieres seleccionar varios usuarios, mantén pulsada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón en cada uno de ellos.</p>
<p>Tras enviar los datos del formulario se les enviará un correo comunicándoles que la clave ha sido reiniciada y la nueva clave provisonal es ahora el NIF como si el usuario entrase por primera vez en la aplicación. </p>
</div>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>