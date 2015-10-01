<?php
require('../../bootstrap.php');

// Corregimos identificadores de asignaturas
$result = mysqli_query($db_con, "SELECT id, dia, hora, profesor, codasi, unidad FROM FALTAS");

while ($row = mysqli_fetch_array($result)) {
	
	$result_asignatura = mysqli_query($db_con, "SELECT c_asig FROM horw WHERE no_prof='".$row['profesor']."' AND dia='".$row['dia']."' AND hora='".$row['hora']."' AND a_grupo='".$row['unidad']."' LIMIT 1") or die(mysqli_error($db_con));
	$row_asignatura = mysqli_fetch_array($result_asignatura);
	$asignatura = $row_asignatura['c_asig'];
	
	if ($row['codasi'] != $asignatura) {
		mysqli_query($db_con, "UPDATE FALTAS SET CODASI='$asignatura' WHERE id='".$row['id']."' LIMIT 1");
	}
	
}

include("../../menu.php");
include("../menu.php");
?>
<div class="container">
<div class="row">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Poner faltas</small></h2>
</div>

<?php
if (isset($_GET['year'])) {$year = $_GET['year'];}elseif (isset($_POST['year'])) {$year = $_POST['year'];}
if (isset($_GET['month'])) {$month = $_GET['month'];}elseif (isset($_POST['month'])) {$month = $_POST['month'];}
if (isset($_GET['today'])) {$today = $_GET['today'];}elseif (isset($_POST['today'])) {$today = $_POST['today'];}
if (isset($_GET['hoy'])) {$hoy = $_GET['hoy'];}elseif (isset($_POST['hoy'])) {$hoy = $_POST['hoy'];}
if (isset($_GET['registro'])) {$registro = $_GET['registro'];}elseif (isset($_POST['registro'])) {$$registro = $_POST['registro'];}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];} elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];} else{$profesor="";}
$pr = $_SESSION['profi'];
if(empty($profesor)){
$profesor = $_SESSION['profi'];}
function profesor()
{
if($_POST['submit']) {$continuar = "";}
echo "<SELECT name=profesor id='idprofe' onChange='submit()'>";
echo "<OPTION>";
echo "</OPTION>";	
		        // Datos del Profesor que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
$profe = mysqli_query($db_con, "SELECT distinct prof, no_prof FROM horw order by no_prof asc");
		 while($filaprofe = mysqli_fetch_array($profe)) {
		        echo "<OPTION id='idopcion'>$filaprofe[1]_ $filaprofe[0]</OPTION>";
		    } 
		     	echo "</select>";
			}				
	?>
<?php
// Limpiamos Faltas de alumnos expulsados.
$expulsados0 = "Select claveal, inicio, fin from Fechoria where expulsion > '0'";
$expulsados1 = mysqli_query($db_con, $expulsados0);
while($expulsados = mysqli_fetch_row($expulsados1))
{
$claveal = $expulsados[0];
$inicio = $expulsados[1];
$fin = $expulsados[2];		
mysqli_query($db_con, "delete from FALTAS where claveal = '$claveal' and date(fecha) >= '$inicio' and date(fecha) <= '$fin'");
}
// Lo mismo en Aula de Convivencia
$expulsados01 = "Select claveal, inicio_aula, fin_aula  from Fechoria where aula_conv > '0'";
$expulsados11 = mysqli_query($db_con, $expulsados01);
while($expulsados1 = mysqli_fetch_row($expulsados11))
{
$claveal = $expulsados1[0];
$inicio_aula = $expulsados1[1];
$fin_aula = $expulsados1[2];		
mysqli_query($db_con, "delete from FALTAS where claveal = '$claveal' and date(fecha) >= '$inicio_aula' and date(fecha) <= '$fin_aula'");
}

// Si se ha pulsado el botón de Enviar, se llama a insertar.php para meter los datos en la tabla
if(isset($_POST['enviar'])){ include("insertar.php"); }
?>
<form action="index.php" method="POST" name="form1">
  
    <?php
// Se presenta la estructura de las tablas del formulario.
include("estructura.php");
?>
</form>
<?php include("../../pie.php");?>
</body>
</html>
