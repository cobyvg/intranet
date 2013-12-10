<?
/*

 * @autor Miguel ï¿½ngel Garcï¿½a Gonzï¿½lez <miguel@iesmonterroso.org>
 * @copyright Miguel ï¿½ngel Garcï¿½a Gonzï¿½lez, <miguel@iesmonterroso.org>, http://esmonterroso.org/intranet/
 * @licencia http://www.gnu.org/licenses/gpl.html GNU GPL
 * @paquete Intranet del IES Monterroso, Consejerï¿½a de Educaciï¿½n de la junta de Andalucia.
 
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

 */
session_start();
// Comprobamos estado del archvo de configuraciï¿½n.
$f_config = file_get_contents('config.php');

$tam_fichero = strlen($f_config);
if (file_exists ( "config.php" ) and $tam_fichero > '10') {
}
else{
// Compatibilidad con versiones anteriores: se mueve el archivo de configuraciï¿½n al directorio raï¿½z.
// Archivo de configuraciï¿½n en antiguo directorio se mueve al raiz de la intranet
if (file_exists ("/opt/e-smith/config.php")) 
{
	$texto = fopen("config.php","w+");
	if ($texto==FALSE) {
		echo "<script>alert('Parece que tenemos un problema serio para continuar: NO es posible escribir en el directorio de la Intranet. Debes asegurarte de que sea posible escribir en ese directorio, porque la aplicación necesita modificar datos y crear archivos dentro del mismo. Utiliza un Administrador de archvos para conceder permiso de escritura en el directorio donde se encuentra la intranet. Hasta entonces me temo que no podemos continuar.')</script>";
		fclose($texto);
		exit();
	}
	else{
$lines = file('/opt/e-smith/config.php');
$Definitivo="";
foreach ($lines as $line_num => $line) {
$Definitivo.=$line;
}
$pepito=fwrite($texto,$Definitivo) or die("<script>alert('Parece que tenemos un problema serio para continuar: NO es posible escribir en el archivo de configuración de la Intranet ( config.php ). Debes asegurarte de que sea posible escribir en ese directorio, porque la aplicación necesita modificar datos y crear archivos dentro del mismo. Utiliza un Administrador de archvos para conceder permiso de escritura en el directorio donde se encuentra la intranet. Hasta entonces me temo que no podemos continuar.')</script>");
fclose ($texto);
}
}
else{
	header ( "location:config/index.php" );
	exit ();
}
}
// Arhivo de configuraciï¿½n cargado
include_once ("config.php");

// Comienzo de sesiï¿½n.
$_SESSION ['autentificado'] = '0';
if (isset ( $_SESSION ['profi'] )) {
	unset ( $_SESSION ['profi'] );
	session_destroy ();
}
$cabecera = '
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<title>Intranet &middot; '.$nombre_del_centro.'</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">
<meta name="author" content="">

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/otros.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" >
<link href="css/bootstrap-responsive.css" rel="stylesheet">

<script>
function navegador(){
	if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion < 8) {
		alert("Estás usando una versión antigua de Internet Explorer que ya no es compatible con esta aplicación. Es posible que algunos módulos de la aplicación no funcione correctamente con la versión actual de su navegador. Actualice a una versión superior o utilice otro navegador compatible como Mozilla Firefox, Google Chrome u Opera");
	}
}

window.onload = navegador;
</script>
  </head>  
  <body>
<div class="container-fluid">
<div class="row-fluid">
<br />
<div align="center" class="well" style="max-width:300px;margin:auto">
<h2>Intranet</h1><h2><small>'.$nombre_del_centro.'</small></h2><hr>';

// Entramos
if ($_POST['submit'] == 'Entrar' and ! ($_POST['idea'] == "" or $_POST['clave'] == "")) {
	$clave0 = $_POST['clave'];
	$clave = sha1 ( $_POST['clave'] );
	$pass0 = mysql_query ( "SELECT c_profes.pass, c_profes.profesor , departamentos.dni FROM c_profes, departamentos where c_profes.profesor = departamentos.nombre and c_profes.idea = '".$_POST['idea']."'" );

	$pass1 = mysql_fetch_array ( $pass0 );
	$codigo = $pass1 [0];
	$dni = $pass1 [2];
	
	// Si le Profesor entra por primera vez... (DNI es igual a Contraseï¿½a)
	if ($dni == strtoupper ( $clave0 ) and (strlen ( $codigo ) < '12') and ! (empty ( $dni )) and ! (empty ( $codigo ))) {
		$_SESSION ['autentificado'] = '1';
		$_SESSION ['profi'] = $pass1 [1];
		$profe = $_SESSION ['profi'];
		
		// Departamento al que pertenece
		$dep0 = mysql_query ( "select departamento from departamentos where nombre = '$profe'" );
		
		$dep1 = mysql_fetch_array ( $dep0 );
		$_SESSION ['depto'] = $dep1 [0];
		// Registramos la entrada en la Intranet
		mysql_query ( "insert into reg_intranet (profesor, fecha,ip) values ('$profe',now(),'" . $_SERVER ['REMOTE_ADDR'] . "')" );
		$id_reg = mysql_query ( "select id from reg_intranet where profesor = '$profe' order by id desc limit 1" );
		$id_reg0 = mysql_fetch_array ( $id_reg );
		$_SESSION ['id_pag'] = $id_reg0 [0];
		
		include_once('actualizar.php');
		header ( "location:clave.php" );
		exit ();
	}
	// Se ha olvidado de escribir el usuario
	if ($_POST['idea'] == "") {
	echo $cabecera;
		?>
    <br />
    <div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:360px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No te has identificado, y debes
hacerlo para entrar en la Intranet.<br />Vuelve atrás e inténtalo de nuevo.          
			</div>
          </div> 
          <br />
          <form><input name="volver" type="button" class="btn btn-primary" onClick="history.go(-1)"
	value="Volver"></form>   
  </div>
  <br>

 <?
		echo "</body>
</html>";
		exit ();
	}
	
	// O no ha escrito el usuario o bien estï¿½ intentando entrar ilegalmente
	if (empty ( $codigo )) {
		echo $cabecera;
				?>
    <br />
    <div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:360px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
El nombre de usuario no es correcto.<br />
Vuelve atrás e inténtalo de nuevo.         
			</div>
          </div> 
          <br /><form><input name="volver" type="button" class="btn btn-primary" onClick="history.go(-1)"
	value="Volver"></form>   
  </div>
  <br>

 <?
		echo "</body>
</html>";
		exit ();
	} 
	
	
	else {
		
		// Si hay usuario y pertenece a alguien del Centro, comprobamos la contraseï¿½a.
		if ($codigo == $clave) {
			$_SESSION ['pass'] = $codigo;
			$pr0 = mysql_query ( "SELECT profesor FROM c_profes where idea = '".$_POST['idea']."'" );
			$pr1 = mysql_fetch_array ( $pr0 );
			$_SESSION ['profi'] = $pr1 [0];
			$profe = $_SESSION ['profi'];
			// Comprobamos si da clase a algï¿½n grupo
			$cur0 = mysql_query ( "SELECT distinct nivel FROM profesores where profesor = '$profe'" );
			$cur1 = mysql_num_rows ( $cur0 );
			$_SESSION ['n_cursos'] = $cur1;
			// Departamento al que pertenece
			$dep0 = mysql_query ( "select departamento from departamentos where nombre = '$profe'" );
			$dep1 = mysql_fetch_array ( $dep0 );
			$_SESSION ['depto'] = $dep1 [0];
			// Registramos la entrada en la Intranet
			mysql_query ( "insert into reg_intranet (profesor, fecha,ip) values ('$profe',now(),'" . $_SERVER ['REMOTE_ADDR'] . "')" );
			$id_reg = mysql_query ( "select id from reg_intranet where profesor = '$profe' order by id desc limit 1" );
			$id_reg0 = mysql_fetch_array ( $id_reg );
			$_SESSION ['id_pag'] = $id_reg0 [0];
			
			include_once('actualizar.php');
			// Comprobamos si el usuario es Admin y entra por primera vez
			if ($profe=="admin" and $clave == sha1("12345678")) {
				$_SESSION ['autentificado'] = '1';			
				header ( "location:clave.php" );
			}
			else{
			//Abrimos la pï¿½gina principal
			$_SESSION ['autentificado'] = '1';			
				header ( "location:index0.php" );
			}
			exit ();
		} else 
		// La contraseï¿½a no es correcta
{
	echo $cabecera;
	?>
    <br />
    <div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:360px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
La clave que has escrito no es
correcta.Vuelve atrás e inténtalo de nuevo. Y no olvides que hay que respetar la
diferencia entre mayúsculas y minúsculas.        
			</div>
          </div> 
          <br /><form><input name="volver" type="button" class="btn btn-primary" onClick="history.go(-1)"
	value="Volver"></form>   
  </div>
  <br>

 <?
		echo "</body>
</html>";
		exit ();		
			?>
  <?
		}
	}
} else {
	echo $cabecera;
if (!(is_writable('config.php'))) {
?>
<br />
    <div align="justify"><div class="alert alert-danger alert-block fade in" style="max-width:360px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend class="lead">ATENCIÓN:</legend>Parece que tenemos un problema con el archivo de configuración de la aplicación. 
			No se puede escribir en el archivo, y eso indica que hay problemas. Debes asegurarte que el directorio donde has
			colocado los archivos de la aplicación tiene permiso de escritura. De lo contrario, no podremos continuar...
			</div>
          </div> 
<?
}
	?>    
<form action="index.php" method="post" align="left" class="form-signin" id = "form-signin">
<div  align="center">
<div class="input-prepend">
    <span class="add-on"><i class="icon icon-user">&nbsp;</i></span>
    <input type="text" placeholder="Usuario" name="idea">
</div>
<br />
<div class="input-prepend"">
    <span class="add-on"><i class="icon icon-key"></i></span>
    <input type="password" placeholder="Clave" name="clave">
</div>
</div>
<br />
<button type="submit" name="submit" value="Entrar" class="btn btn-block btn-primary"><i class="icon icon-signin icon-white icon-large"></i> &nbsp;Entrar</button>
</form>
  
<a data-toggle="modal" href="#ayuda">
<i class="icon icon-large icon-border icon-question-sign pull-right" style="color:#888"> </i>
</a>  
<div class="modal hide fade" id="ayuda">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Acceso a la Intranet</h3>
  </div>
  <div class="modal-body">
<p class="help-block">Para
acceder a la Intranet <em>por primera vez</em>, escribe tu nombre de usuario (el
mismo nombre de usuario que utilizas para entrar en Séneca) y tu DNI
como clave de acceso. Pasarás a una página en la que deberías introducir
una nueva Clave de Acceso, al modo de SÉNECA, con la que entrarás a
partir de entonces. <em style="color: #08c;">Es muy recomendable que
utilices tu clave de SÉNECA también en la Intranet, para simplificarte
la vida y no multiplicar las contraseñas</em>.</p>
<p> Por motivos de
seguridad que nos afectan a todos, es necesario proteger bien la clave y
cambiarla ante la menor duda: <em style="color: #08c;">los Alumnos nunca
deben conocerla.</em> <br /></p>
<p>Si has olvidado la contraseña, ponte en contacto con alguien de la Dirección del Centro. Se escribirá de nuevo tu DNI como contraseña y podrás
crear una nueva como si fuera la primera vez. Para cualquier otro tipo
de problema, ponte también en contacto. 
</p>
</div>
</div>
<br />

<?	
}
?>
    <script src="http://<? echo $dominio;?>/intranet/js/jquery.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap.min.js"></script>
</body>
</html>
