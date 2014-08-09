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
  	<h2>Administración <small> Reiniciar claves de acceso de profesores</small></h2>
	</div>


<?
if (isset($_POST['enviar'])){$enviar=$_POST['enviar'];}else{$enviar='';}
if (isset($_POST['enviar'])) {

foreach($_POST as $var => $valor)
{
if ($valor!='Reasignar clave'){
$dni=$var;
$cambia[$dni]=$valor;

} #del foreach

} # del if enviar

foreach($cambia as $eldni => $valor){
mysql_query("update c_profes set pass='$eldni' where dni='$eldni'");
}
echo '<div class="alert alert-success">
Las claves de los profesores seleccionados se han reiniciado. El DNI del profesor pasa a ser la nueva clave de acceso.
</div>';

$mail0=mysql_query("select correo from c_profes where dni='$eldni'");
$mail=mysql_fetch_row($mail0);
		$cabecera = "From: ".$email_del_centro." \r\n";
		$direccion = $mail[0];
		$tema = "Borrado y reinicio de Contraseña";
		$texto = "La contrasseña para entrar en la Intranet ha sido reiniciada. Cuando vuelvas a entrar, escribe tu nombre de usuario y tu DNI como contraseña. En la siguiente página deberás volver a escribir una nueva contraseña.";
		mail($direccion, $tema, $texto, $cabecera); 

//mysql_query("drop table if exists cargos");
} # del si se ha enviado
?>
<form name="cargos" action="reset_password.php" method="post">
	
	<p class="block-help">Marca los profesores a los que quieres reiniciar la clave. Una vez enviados los datos, el NIF del profesor pasa a ser su nueva clave, y se le envía un correo para advertirle del cambio.</p>
<div class="row">
<?
$n_carg=mysql_query("select distinct profesor, dni from c_profes order by profesor");
$num_profes=mysql_num_rows($n_carg);
$n_p = round($num_profes/3);
$n1 = 1;
$n2 = $n_p;
$n3 = $n_p*2;
$n4 = $n_p*3;
for ($i=1;$i<4;$i++){
echo '<div class="col-sm-4"><div class="well well-large">';	
$carg0=mysql_query("select distinct profesor, dni from c_profes order by profesor limit ".${n.$i}.",".$n_p."");
while($carg1=mysql_fetch_array($carg0))
{
$pro=$carg1[0];
$dni=$carg1[1];
$n_i=$n_i+1;
?>
<div class="checkbox">
	<label>
		<input type="checkbox" name="<? echo $dni;?>" value="cambio" id="dato0"> <? echo $pro;?>
	</label>
</div>
<?
if($n_i % 10 == 0)
{
}
}
	echo "</div></div>";
}

?>
</div>

<button type="submit" class="btn btn-primary" name="enviar" value="Reasignar clave">Reiniciar contraseñas</button>
<a class="btn btn-default" href="../index.php">Volver</a>


</form>
</div>

<? include("../../pie.php");?>
</body>
</html>