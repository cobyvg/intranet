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
?>
<?
include("../../menu.php");
include("../menu.php");
?>
<?
$pr = $_SESSION['profi'];
if(!(isset($profesor))){
$profesor = $_SESSION['profi'];}
function profesor()
{
if($submit) {$continuar = "";}
echo "<SELECT name=profesor id='idprofe' onChange='submit()'>";
echo "<OPTION>";
echo "</OPTION>";	
		        // Datos del Profesor que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
$profe = mysql_query("SELECT distinct prof, no_prof FROM horw order by no_prof asc");
		 while($filaprofe = mysql_fetch_array($profe)) {
		        echo "<OPTION id='idopcion'>$filaprofe[1]_ $filaprofe[0]</OPTION>";
		    } 
		     	echo "</select>";
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
if($enviar){ include("insertar.php"); }
?>
<form action="index.php" method="POST" name="form1">
  
    <?php
// Se presenta la estructura de las tablas del formulario.
include("estructura.php");
?>
</form>
<? include("../../pie.php");?>
</body>
</html>
