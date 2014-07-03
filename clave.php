<?
session_start();
include("config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
if (isset($_POST['usuario'])) {$usuario = $_POST['usuario'];}else{$usuario="";}
if (isset($_POST['correo'])) {$correo = $_POST['correo'];}else{$correo="";}
if (isset($_POST['codigo2'])) {$codigo2 = $_POST['codigo2'];}else{$codigo2="";}
if (isset($_POST['codigo3'])) {$codigo3 = $_POST['codigo3'];}else{$codigo3="";}
if (isset($_POST['control'])) {$control = $_POST['control'];}else{$control="";}

$pr = $_SESSION['profi'] ;
if($control=="1")
  {
$res = mysql_query('select * from c_profes');
if (mysql_field_name($res, 5) == "correo") { }
else {
	mysql_query("ALTER TABLE  `c_profes` ADD  `correo` VARCHAR( 64 )  NULL ");
} 
?>
 
<?
include("menu.php");
?>
<br />
 <div class="page-header" align="center">
  <h2>Cambio de la clave de acceso</small></h2>
</div>
<br />
<div align="center" class="well well-large" style="width:540px;margin:auto">
	<br />
<?	
if ($codigo2 === $codigo3 and !(empty($codigo2)) and !(empty($correo))) 
{	
$cod_sha = sha1($codigo2);
$contra = "update c_profes set   pass = '$cod_sha', correo='$correo' where profesor = '$pr' ";
mysql_query($contra) or die('
    <div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:450px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
Se ha producido un error:<br />No se ha podido cambiar la contraseña en la Base de Datos, así que mejor te pongas en contacto con quien pueda arreglar el asunto.
			</div>
          </div>');
echo '
    <div align="center"><div class="alert alert-success alert-block fade in" style="max-width:450px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La Contraseña se ha modificado en la Base de Datos. <br />La nueva clave para entrar es <span class="badge badge-warning">'.$codigo2.'</span>.
Puedes volver a cambiarla en cualquier momento. Y si te olvidas de la misma, ponte en contacto para volver al principio.
			</div>
          </div> ';
		  echo '<br><form><input name="volver" type="button" onClick="location.href=\'http://'.$dominio.'/intranet/index.php\'" value="Ir a la Página Principal" class="btn btn-primary"></form>';
}
else {
if(empty($correo))
{
echo '
    <div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:450px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
El Correo electrónico es necesario, y no lo has rellenado.</span><br />Si ya dispones de una cuenta de correo, vuelve atrás y rellena el campo correpondiente del formulario. Si no dispones de una cuenta de correo, el Centro te puede proporcionar una. Ponte en contacto con la Dirección
			</div>
          </div> ';
}
else{
echo '
    <div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:450px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
Las claves que has elegido no coinciden. Vuelve atrás e inténtalo de nuevo. Y no olvides que hay que respetar la diferencia entre mayúsculas y minúsculas.        
			</div>
          </div> ';
   }

}
echo "</body></html>";
  }
  else
  {
  	include("menu.php");
  	
?>
<script type="text/javascript">
<!--
function validatePass(campo) {
    var RegExPattern = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!""#$%&''()*+,-./:;<=>?@[\]^_`{|}]).{8,12}$/;
    var errorMessage = 'Clave Incorrecta. La clave no cumple las condiciones mencionadas más abajo.';
    if ((campo.value.match(RegExPattern)) && (campo.value!='')) {
      document.entrada.submit(); 
    } else {
	alert(errorMessage);
		campo.select();
		campo.focus();
		return 0;		
    } 
}
//-->
</script>
 <br />
 <div class="page-header" align="center">
  <h2>Cambio de la clave de acceso</h1>
</div>
<br />
<div align="center" class="well well-large" style="width:540px;margin:auto">

 <?
  $dat=mysql_query("select * from c_profes where profesor='$pr'");
  $todos=mysql_fetch_array($dat);
  
?>
<form name="entrada" action="clave.php" method="post">
<table cellpadding="4">
<tr><th style="text-align:left">Usuario</th><td><input class="input-xlarge" type="text" name="usuario" disabled="disabled" value="<? echo $todos[2];?>" size=40></td></tr>
<tr><th style="text-align:left">Nueva Contraseña&nbsp;&nbsp;</th><td><input type="password" name="codigo2" value="" size=20 /></td></tr>
<tr><th style="text-align:left">Repítela otra vez</th><td><input type="password" name="codigo3" value="" size=20 /></td></tr>
<tr><th style="text-align:left">Correo</th><td><input class="input-xlarge" type="text" name="correo" value="<? echo $todos[5];?>" size=40></td></tr>
</table>
<br /><div align="center"><input class="btn btn-primary" type='button' value="Cambiar clave" onclick='validatePass(document.entrada.codigo2)';></div>
<input name=control type=hidden value="1">
</form> 
  <script type="text/javascript">
  document.forms[0].elements[0].focus(); 
  </script>
  <br />
  <div class="well well-large" style='text-align:left;'>
  <p>
A partir de este momento tendrás que usar tu nombre de usuario IdEA y esta clave para acceder a la intranet.
La dirección de correo electrónico se usará para las notificaciones y para reiniciar la contraseña
en caso de olvido.</p>
<p>Siguiendo el esquema de Séneca, la clave debe cumplir las siguientes condiciones:</p>

<ol>  
<li>Tener al menos 8 caracteres y un máxima de 12.</li>
<li>Contener al menos una letra, un número y un signo de puntuación o un símbolo.</li>
<li>Los símbolos aceptados son !"#$%&'()*+,-./:;<=>?@[\]^_`{|}~</li>
<li>Las letras acentuadas y las eñes no están admitidas.</li>
<li>No ser similar al nombre de usuario.</li>
<li>No ser similar a su D.N.I. o pasaporte.</li>
</ol>

</div>
 </div>
<?
  }
  include("pie.php");
  ?>