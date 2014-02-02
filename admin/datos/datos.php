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

if (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];} elseif (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];} elseif (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];} else{$nombre="";}
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];} elseif (isset($_GET['apellidos'])) {$apellidos = $_GET['apellidos'];} else{$apellidos="";}
if (isset($_GET['clave_al'])) {$clave_al = $_GET['clave_al'];} else{$clave_al="";}
if (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
	$tr_uni = explode("-",$_GET['unidad']);
	$nivel = $tr_uni[0];
	$grupo = $tr_uni[1];
	$AUXSQL = " and unidad = '$nivel-$grupo'";
} else{$unidad="";}
?>
<br />
<div align="center">
<div class="page-header" align="center">
<h2>Datos de los Alumnos <small> Consultas</small></h2>
</div>
</div>
<div class='container-fluid'>
<div class="row-fluid">
<div class="span12"><?php
// Si se envian datos desde el campo de búsqueda de alumnos, se separa claveal para procesarlo.
if (!(isset($_GET['seleccionado']))) {
	$seleccionado="";
}else{
	$seleccionado=$_GET['seleccionado'];
}
if (!(isset($_GET['alumno']))) {
	$alumno="";
}
else{
	$alumno=$_GET['alumno'];
}
if (!(isset($AUXSQL))) {
	$AUXSQL="";
}

//Reseteamos Clave en la página principal
if (isset($_GET['resetear']) and $_GET['resetear']==1) {
	$sql_reset=mysql_query("delete from control where claveal = '".$_GET['clave_alumno']."'");
	if ($sql_reset) {
		echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La contraseña del alumno para el acceso a la página pública del Centro se ha reiniciado correctamente. El alumno debe entrar ahora con el NIE como usuario y contraseña. Una vez dentro se le forzará a cambiar la contraseña.
		</div></div>';    
		if (strstr($_GET['correo'],'@')==TRUE) {
		$direccion = $_GET['correo'];
		$tema = "Contraseña de acceso privado reiniciada en iesmonterroso.org";
		$texto = "La clave de acceso privada del alumno/a ha sido reiniciada. Para entrar en las páginas personales del alumno deberás introducir de nuevo el NIE (Número de Identificación Escolar) que el Centro te ha proporcionado en los dos campos del formulario de acceso. Si a pesar de todo persisten los problemas y no puedes entrar, ponte en contacto con el Tutor o Jefatura de Estudios. Dsiculpa las molestias. ";
		mail($direccion, $tema, $texto);  
		}  
	}
}

if (isset($seleccionado) and $seleccionado=="1") {
	$tr=explode(" --> ",$alumno);
	$clave_al=$tr[1];
	$nombre_al=$tr[0];
	$uni=mysql_query("select unidad, nivel, grupo from alma where claveal='$clave_al'");
	$un=mysql_fetch_array($uni);
	$unidad=$un[0];

	$foto = '../../xml/fotos/'.$clave_al.'.jpg';
	if (file_exists($foto)) {
		echo "<div align='center'><img src='$foto' border='2' width='100' height='119' style='margin:auto;border:1px solid #bbb;'  /></div>";
		echo "<br />";
	}
}
$AUXSQL == "";
#Comprobamos si se ha metido Apellidos o no.
if  (TRIM("$apellidos")=="")
{
}
ELSE
{
	$AUXSQL .= " and alma.apellidos like '%$apellidos%'";
}
if  (TRIM("$nombre")=="")
{
}
ELSE
{
	$AUXSQL .= " and alma.nombre like '%$nombre%'";
}

if  (isset($_POST['unidad']))
{
	$AUXSQL=" and (";
	foreach ($_POST['unidad'] as $grupo){
		$AUXSQL .= " alma.unidad like '$grupo' or";
	}
	$AUXSQL=substr($AUXSQL,0,-2);
	$AUXSQL.=")";
}

if  (TRIM("$clave_al")=="")
{
}
ELSE
{
	$AUXSQL .= " and alma.claveal = '$clave_al'";
}
if ($seleccionado=='1') {
	$AUXSQL = " and alma.claveal = '$clave_al'";
}

$SQL = "select distinct alma.claveal, alma.apellidos, alma.nombre, alma.nivel, alma.grupo,\n
  alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.telefonourgencia, padre, matriculas, correo from alma
  where 1 " . $AUXSQL . " order BY nivel, grupo, alma.apellidos, nombre";
//echo $SQL;
$result = mysql_query($SQL);
if (mysql_num_rows($result)>25 and !($seleccionado=="1")) {
	$datatables_activado = true;
}
if ($row = mysql_fetch_array($result))
{

	echo "<div align=center><table  class='table table-striped tabladatos' style='width:auto;'>";
	echo "<thead><tr>
			<th>Clave</th>
	        <th> DNI</th>
	        <th>Nombre</th>
	        <th width='60'>Grupo</th>
	        <th> Fecha</th>	        
	        <th>Domicilio</th>
        	<th>Padre</th>
        	<th>Tlfno. 1</th>	
        	<th>Tlfno. 2</th>
        	<th>Repite</th>				
		";

	echo "</th><th></th>";
	echo "</tr></thead><tbody>";
	do {
		if ($row[11]>1) {
			$repite="Sí";
		}
		else{
			$repite="No";
		}
		$nom=$row[1].", ".$row[2];
		$unidad = $row[3]."-".$row[4];
		$claveal = $row[0];
		$correo = $row[12];
		echo "<tr>
<td>$row[0]</td>
<td>$row[5]</td>
<td>$nom</td>
<td>$unidad</td>
<td>$row[6]</td>
<td>$row[7]</td>
<td>$row[10]</td>
<td>$row[8]</td>
<td>$row[9]</td>
<td>$repite</td>";

		if ($seleccionado=='1'){
			$todo = '&todos=Ver Informe Completo del Alumno';
		}
		echo "<td><a href='http://$dominio/intranet/admin/informes/index.php?claveal=$claveal&todos=Ver Informe Completo del Alumno'><i class='icon icon-search' rel='Tooltip' title='Ver detalles'> </i> ";
		echo '</a></td></tr>';
	} while($row = mysql_fetch_array($result));
	echo "</tbody></table></font></center>\n";
} else
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</hlegend5>
No hubo suerte, bien porque te has equivocado
        al introducir los datos, bien porque ningún dato se ajusta a tus criterios.
		</div></div>';

}
?> <br />
<?
if ($_GET['seleccionado']=='1'){

	// Comprobamos si el centro cuenta con módulo de la página principal para el acceso de los alumnos
	$sql_control = mysql_query("select * from control where claveal = '$claveal'");
	if (mysql_num_rows($sql_control)>0) {
		$s_control = '1';
	}
	// Menú del alumno
	echo "<a href='http://$dominio/intranet/admin/informes/index.php?claveal=$claveal&todos=Ver Informe Completo del Alumno' class='btn btn-primary'>Datos completos</a>";
	echo "&nbsp;<a class='btn btn-primary' href='http://$dominio/intranet/admin/informes/cinforme.php?nombre_al=$alumno&nivel=$un[1]&grupo=$un[2]'>Informe histórico del Alumno</a> ";
	echo "&nbsp;<a class='btn btn-primary' href='../fechorias/infechoria.php?seleccionado=1&nombre_al=$alumno'>Problema de disciplina</a> ";
	echo "&nbsp;<a class='btn btn-primary' href='http://$dominio/intranet/admin/cursos/horarios.php?curso=$unidad'>Horario</a>";
	if (stristr($_SESSION['cargo'],'1') == TRUE) {
		$dat = mysql_query("select nivel, grupo from FALUMNOS where claveal='$clave_al'");
		$tut=mysql_fetch_row($dat);
		$nivel=$tut[0];
		$grupo=$tut[1];
		echo "&nbsp;<a class='btn btn-primary' href='../jefatura/tutor.php?seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo'>Acción de Tutoría</a>";
			if ($s_control=='1') {
			echo "&nbsp;<a class='btn btn-primary' href='datos.php?resetear=1&clave_alumno=$clave_al&seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo&correo=$correo'  rel='tooltip' title='Si el alumno o sus padres han olvidado la contraseña de acceso a la página principal, este botón permite reiniciar la contraseña al NIE del alumno. Si el alumno o tutores del mismo han registrado una dirección de correo electrónico, se les enviará un cooreo automaticamente. De lo contrario habrá que ponerse en contacto para hacérselo saber.'>Reiniciar Contraseña</a>";
		}

	}
	if (stristr($_SESSION['cargo'],'8') == TRUE) {
		$dat = mysql_query("select nivel, grupo from FALUMNOS where claveal='$clave_al'");
		$tut=mysql_fetch_row($dat);
		$nivel=$tut[0];
		$grupo=$tut[1];
		echo "&nbsp;<a class='btn btn-primary' href='../orientacion/tutor.php?seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo'>Acción de Tutoría</a>";
	}
	if (stristr($_SESSION['cargo'],'2') == TRUE) {
		$tutor = $_SESSION['profi'];
		$dat = mysql_query("select nivel, grupo from FALUMNOS where claveal='$clave_al'");
		$dat_tutor = mysql_query("select nivel, grupo from FTUTORES where tutor='$tutor'");
		$tut=mysql_fetch_row($dat);
		$tut2=mysql_fetch_array($dat_tutor);
		$nivel=$tut[0];
		$grupo=$tut[1];
		$nivel_tutor=$tut2[0];
		$grupo_tutor=$tut2[1];
		if ($nivel==$nivel_tutor and $grupo==$grupo_tutor) {
			echo "&nbsp;<a class='btn btn-primary' href='../tutoria/tutor.php?seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo&tutor=$tutor'>Acción de Tutoría</a>";
		if ($s_control=='1') {
			echo "&nbsp;<a class='btn btn-primary' href='datos.php?resetear=1&clave_alumno=$clave_al&seleccionado=1&alumno=$alumno&nivel=$nivel&grupo=$grupo&correo=$correo'  rel='tooltip' title='Si el alumno o sus padres han olvidado la contraseña de acceso a la página principal, este botón permite reiniciar la contraseña al NIE del alumno. Si el alumno o tutores del mismo han registrado una dirección de correo electrónico, se les enviará un cooreo automaticamente. De lo contrario habrá que ponerse en contacto para hacérselo saber.'>Reiniciar Contraseña</a>";
		}
		}
	}
}
?> <? include("../../pie.php");?>
</BODY>
</HTML>                                                                    