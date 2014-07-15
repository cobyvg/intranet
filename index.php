<?
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
	header("location:config/index.php");
	exit();
}
}
// Archivo de configuración cargado
include_once("config.php");

if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}

registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$pr = $_SESSION ['profi'];
// Comprobamos si da clase a alg&uacute;n grupo
$cur0 = mysql_query ( "SELECT distinct prof FROM horw where prof = '$pr'" );
$cur1 = mysql_num_rows ( $cur0 );
$_SESSION ['n_cursos'] = $cur1;
$n_curso = $_SESSION ['n_cursos'];
// Variable del cargo del Profesor
$cargo0 = mysql_query ( "select cargo, departamento, idea from departamentos where nombre = '$pr'" );
$cargo1 = mysql_fetch_array ( $cargo0 );
$_SESSION ['cargo'] = $cargo1 [0];
$carg = $_SESSION ['cargo'];
$_SESSION ['dpt'] = $cargo1 [1];
$dpto = $_SESSION ['dpt'];
if (isset($_POST['idea'])) {}
else{
$_SESSION ['ide'] = $cargo1 [2];
$idea = $_SESSION ['ide'];
}
if (stristr ( $carg, '2' ) == TRUE) {
	$result = mysql_query ( "select distinct unidad from FTUTORES where tutor = '$pr'" );
	$row = mysql_fetch_array ( $result );
	$_SESSION ['tut'] = $pr;
	$_SESSION ['s_unidad'] = $row [0];
}
?>
<? include("menu.php");?>

 <div class="container-fluid" style="padding-top:22px;">  
   <div class="row-fluid">  
   
        <div class="span3">  
            <? if (strstr($_SESSION ['cargo'],"6") or strstr($_SESSION ['cargo'],"7")) {include("menu_conserje.php");}else{include("menu2.php");}?> 
			<br />
              <? 
			  include("ausencias.php"); 
			  include ("fijos.php");
			  include ("mensajes.php");
			  ?>
        </div><!--/span-->  
        <div class="span9">   
          <div class="row-fluid">
            
            <div class="span7"> 
              <?
			  if (stristr ( $carg, '2' ) == TRUE) {
		include ("admin/tutoria/control.php");
			  }
			  ?>
              <? include ("pendientes.php");  ?>
              <? 
              echo "<div style='padding:19px;padding-top:0px;'>";
              include("noticias.php");
              ?>
              <? 
              include("junta.php");
              echo "</div>";
              ?>
 
            </div><!--/span--> 
             
            <div class="span5">
             <div style='padding:19px;padding-top:0px;'>
             <legend><i class="fa fa-search"></i> Buscar alumnos</legend> 
             <form action="index.php" method="GET">
             	<input name="buscarAlumnos" type="text" class="span12" id="buscarAlumnos" onkeyup="javascript:buscar('resAlumnos',this.value);" placeholder="Buscar alumnos...">
             </form>
             <div id="resAlumnos"></div>
             </div>
             <?
              echo "<div style='padding:19px;padding-top:0px;'>";
			  include("admin/calendario/index.php");

			  if ($mod_horario and ($n_curso > 0)) {
				echo "<hr /><br />";
					include ("horario.php");
				
				}
			echo "<hr /><br />";	
			include ("buscar.php");
			 echo "</div>";
			  ?> 
              </div>
            </div><!--/span-->  
          </div><!--/row-->  
          <hr>  
     <footer>  
      </footer>  
  
    </div><!--/.fluid-container-->  
<? include("pie.php");?>  
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
</script> 
    <script>  
	$(function ()  
	{ $("#pop1").popover();  
	});  
	</script>
  </body>  
</html>  

