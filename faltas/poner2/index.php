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

$pr = $_SESSION['profi'];

include("../../menu.php");
include("../menu.php");
if (isset($_GET['year'])) {$year = $_GET['year'];}elseif (isset($_POST['year'])) {$year = $_POST['year'];}
if (isset($_GET['month'])) {$month = $_GET['month'];}elseif (isset($_POST['month'])) {$month = $_POST['month'];}
if (isset($_GET['today'])) {$today = $_GET['today'];}elseif (isset($_POST['today'])) {$today = $_POST['today'];}
if (isset($_GET['hoy'])) {$hoy = $_GET['hoy'];}elseif (isset($_POST['hoy'])) {$hoy = $_POST['hoy'];}
if (isset($_GET['registro'])) {$registro = $_GET['registro'];}elseif (isset($_POST['registro'])) {$$registro = $_POST['registro'];}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];} elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}

function profesor()
{
if($_POST['submit']) {$continuar = "";}
echo "<SELECT name='profesor' id='idprofe' onChange='submit()' class='input-xlarge'>";
echo "<OPTION>";
echo "</OPTION>";	
		        // Datos del Profesor que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
$profe = mysql_query("SELECT distinct prof, no_prof FROM horw order by prof asc");
		 while($filaprofe = mysql_fetch_array($profe)) {
		 	$n_p+=1;
		        echo "<OPTION id='idopcion'>$filaprofe[1]_ $filaprofe[0]</OPTION>";
		    } 
		     	echo "</select><br />";
			}				
	?>
<?
// Limpiamos Faltas de alumnos expulsados.
$expulsados0 = "Select claveal, inicio, fin from Fechoria where expulsion > '0'";
$expulsados1 = mysql_query($expulsados0);
while($expulsados = mysql_fetch_row($expulsados1))
{
$claveal = $expulsados[0];
$inicio = $expulsados[1];
$fin = $expulsados[2];
mysql_query("delete from FALTAS where claveal = '$claveal' and date(fecha) >= '$inicio' and date(fecha) <= '$fin'");
}
// Lo mismo en Aula de Convivencia
$expulsados01 = "Select claveal, inicio_aula, fin_aula  from Fechoria where aula_conv > '0'";
$expulsados11 = mysql_query($expulsados01);
while($expulsados1 = mysql_fetch_row($expulsados11))
{
$claveal = $expulsados1[0];
$inicio_aula = $expulsados1[1];
$fin_aula = $expulsados1[2];		
mysql_query("delete from FALTAS where claveal = '$claveal' and date(fecha) >= '$inicio_aula' and date(fecha) <= '$fin_aula'");
}

// Si se ha pulsado el botón de Enviar, se llama a insertar.php para meter los datos en la tabla
if(isset($_POST['enviar']))
{		include("insertar.php");}
?>
<form action="index.php" method="POST" name="form1">
  
    <?php
// Se presenta la estructura de las tablas del formulario.
include("estructura.php");
?>
</form>
  <? include("../../pie.php"); ?> 
</body>
</html>
