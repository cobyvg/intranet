<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
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
<br />
<div align="center">
	<div class="page-header" align="center">
  	<h2>Administración <small> Reasignar claves de acceso de profesores</small></h2>
</div>

  <p class="block-help" style="width:400px; text-align:left"><span style="color:#9d261d">(*) </span>Marca los profesores a los que quieres reescribir la clave. Una vez enviados los datos, el NIF del profesor pasa a ser su nueva clave, y se le envía un correo para advertirle del cambio.</p><br />
</div>

<?
if (isset($_POST['enviar'])){$enviar=$_POST['enviar'];}else{$enviar='';}
if ($enviar=="Reasignar clave") {

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
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Las claves se han actualizado. El NIF del profesor pasa a ser la nueva clave de acceso.
</div></div><br />';

$mail0=mysql_query("select correo from c_profes where dni='$eldni'");
$mail=mysql_fetch_row($mail0);
		$cabecera = "From: direccion@".$dominio." \r\n";
		$direccion = $mail[0];
		$tema = "Borrado y reinicio de Contraseña";
		$texto = "La contrasseña para entrar en la Intranet ha sido reiniciada. Cuando vuelvas a entrar, escribe tu nombre de usuario y tu DNI como contraseña. En la siguiente página deberás volver a escribir una nueva contraseña.";
		mail($direccion, $tema, $texto, $cabecera); 

//mysql_query("drop table if exists cargos");
} # del si se ha enviado
?>
<form name="cargos" action="reset_password.php" method="post">
<div class="container-fluid">
<div class="row-fluid">
<?
$n_carg=mysql_query("select distinct profesor, dni from c_profes order by profesor");
$num_profes=mysql_num_rows($n_carg);
$n_p = round($num_profes/3);
$n1 = 1;
$n2 = $n_p;
$n3 = $n_p*2;
$n4 = $n_p*3;
for ($i=1;$i<4;$i++){
echo '<div class="span4"><div class="well well-large"><ul class="unstyled">';	
$carg0=mysql_query("select distinct profesor, dni from c_profes order by profesor limit ".${n.$i}.",".$n_p."");
while($carg1=mysql_fetch_array($carg0))
{
$pro=$carg1[0];
$dni=$carg1[1];
$n_i=$n_i+1;
?>
<li>
<label class="checkbox"><input type="checkbox" name="<? echo $dni;?>" value="cambio" id="dato0" />&nbsp; <? echo $pro;?></label>
</li>
<?
if($n_i % 10 == 0)
{
}
}
	echo "</ul></div></div>";
}

?>
</div>
<div align="center"><input type="submit" name="enviar" value="Reasignar clave" class="btn btn-primary"/></div>
</div>


</form>
<? include("../../pie.php");?>
</body>
</html>