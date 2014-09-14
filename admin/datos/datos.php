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



if (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];} elseif (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];} elseif (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];} else{$nombre="";}
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];} elseif (isset($_GET['apellidos'])) {$apellidos = $_GET['apellidos'];} else{$apellidos="";}
if (isset($_GET['clave_al'])) {$clave_al = $_GET['clave_al'];} else{$clave_al="";}
if (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
	$AUXSQL = " and unidad = '$unidad'";
} else{$unidad="";}

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
?>

<div class="container">
	
	<div class="page-header">
		<h2>Datos de los alumnos <small>Consultas</small></h2>
	</div>
	

	<div class="row">
	
		<div class="col-sm-12">
<?php
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
	$sql_reset=mysqli_query($db_con, "delete from control where claveal = '".$_GET['clave_alumno']."'");
	if ($sql_reset) {
		echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La contraseña del alumno para el acceso a la página pública del Centro se ha reiniciado correctamente. El alumno debe entrar ahora con el NIE como usuario y contraseña. Una vez dentro se le forzará a cambiar la contraseña.
		</div></div>';    
		if (strstr($_GET['correo'],'@')==TRUE) {
		$direccion = $_GET['correo'];
		$tema = "Contraseña de acceso privado reiniciada en $dominio";
		$texto = "La clave de acceso privada del alumno/a ha sido reiniciada. Para entrar en las páginas personales del alumno deberás introducir de nuevo el NIE (Número de Identificación Escolar) que el Centro te ha proporcionado en los dos campos del formulario de acceso. Si a pesar de todo persisten los problemas y no puedes entrar, ponte en contacto con el Tutor o Jefatura de Estudios. Dsiculpa las molestias. ";
		mail($direccion, $tema, $texto);  
		}  
	}
}

if (isset($seleccionado) and $seleccionado=="1") {
	$tr=explode(" --> ",$alumno);
	$clave_al=$tr[1];
	$nombre_al=$tr[0];
	$uni=mysqli_query($db_con, "select unidad from alma where claveal='$clave_al'");
	$un=mysqli_fetch_array($uni);
	$unidad=$un[0];
}
$AUXSQL == "";
#Comprobamos si se ha metido Apellidos o no.
if  (TRIM("$apellidos")=="")
{
}
else
{
	$AUXSQL .= " and alma.apellidos like '%$apellidos%'";
}
if  (TRIM("$nombre")=="")
{
}
else
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
else
{
	$AUXSQL .= " and alma.claveal = '$clave_al'";
}
if ($seleccionado=='1') {
	$AUXSQL = " and alma.claveal = '$clave_al'";
}

$SQL = "select distinct alma.claveal, alma.apellidos, alma.nombre, alma.unidad, 
  alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.telefonourgencia, padre, matriculas, correo from alma
  where 1 " . $AUXSQL . " order BY unidad, alma.apellidos, nombre";
// echo $SQL;
$result = mysqli_query($db_con, $SQL);

if ($row = mysqli_fetch_array($result))
{

	echo "<table class='table table-bordered table-striped table-vcentered datatable'>";
	echo "<thead><tr>
					<th></th>
					<th>Alumno/a</th>
	        <th>NIE</th>
	        <th>Unidad</th>
	        <th>Fecha Ncto.</th>	        
	        <th>Domicilio</th>
        	<th>Padre</th>
        	<th>Teléfonos</th>	
        	<th>Repite</th>";
	echo "<th></th>";
	echo "</tr></thead><tbody>";
	do {
		if ($row[11]>1) {
			$repite="Sí";
		}
		else{
			$repite="No";
		}
		$nom=$row[1].", ".$row[2];
		$unidad = $row[3];
		$claveal = $row[0];
		$correo = $row[12];
		echo "<tr>";
		$foto_dir = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto_dir)) {
		$foto = "<img src='$foto_dir' width='55' class=\"img-thumbnail\" />";
	}
	else {
		$foto = "<span class=\"fa fa-user fa-3x fa-fw\"></span>";
	}
	echo "<td>$foto</td><td>$nom</td>
<td>$row[0]</td>
<td>$unidad</td>
<td>$row[5]</td>
<td>$row[6]</td>
<td>$row[9]</td>
<td>$row[7]<br>$row[8]</td>
<td>$repite</td>";

		if ($seleccionado=='1'){
			$todo = '&todos=Ver Informe Completo del Alumno';
		}
		echo "<td><a href='http://$dominio/intranet/admin/informes/index.php?claveal=$claveal&todos=Ver Informe Completo del Alumno'><i class='fa fa-search fa-fw fa-lg' data-bs='tooltip' title='Ver detalles'></i> ";
		echo '</a></td></tr>';
	} while($row = mysqli_fetch_array($result));
	echo "</tbody></table>\n";
} else
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No hubo suerte, bien porque te has equivocado
        al introducir los datos, bien porque ningún dato se ajusta a tus criterios.
		</div></div>';

}
?> <br />
<?
if ($_GET['seleccionado']=='1'){

	// Comprobamos si el centro cuenta con módulo de la página principal para el acceso de los alumnos
	$sql_control = mysqli_query($db_con, "select * from control where claveal = '$claveal'");
	if (mysqli_num_rows($sql_control)>0) {
		$s_control = '1';
	}
	// Menú del alumno
	echo "<a href='http://$dominio/intranet/admin/informes/index.php?claveal=$claveal&todos=Ver Informe Completo del Alumno' class='btn btn-primary'>Datos completos</a>";
	echo "&nbsp;<a class='btn btn-primary' href='http://$dominio/intranet/admin/informes/cinforme.php?nombre_al=$alumno&unidad=$unidad'>Informe histórico del Alumno</a> ";
	echo "&nbsp;<a class='btn btn-primary' href='../fechorias/infechoria.php?seleccionado=1&nombre_al=$alumno'>Problema de disciplina</a> ";
	echo "&nbsp;<a class='btn btn-primary' href='http://$dominio/intranet/admin/cursos/horarios.php?curso=$unidad'>Horario</a>";
	if (stristr($_SESSION['cargo'],'1') == TRUE) {
		$dat = mysqli_query($db_con, "select unidad from FALUMNOS where claveal='$clave_al'");
		$tut=mysqli_fetch_row($dat);
		$unidad=$tut[0];
		echo "&nbsp;<a class='btn btn-primary' href='../jefatura/tutor.php?seleccionado=1&alumno=$alumno&unidad=$unidad'>Acción de Tutoría</a>";
			if ($s_control=='1') {
			echo "&nbsp;<a class='btn btn-primary' href='datos.php?resetear=1&clave_alumno=$clave_al&seleccionado=1&alumno=$alumno&unidad=$unidad&correo=$correo'  data-bs='tooltip' title='Si el alumno o sus padres han olvidado la contraseña de acceso a la página principal, este botón permite reiniciar la contraseña al NIE del alumno. Si el alumno o tutores del mismo han registrado una dirección de correo electrónico, se les enviará un cooreo automaticamente. De lo contrario habrá que ponerse en contacto para hacérselo saber.'>Reiniciar Contraseña</a>";
		}

	}
	if (stristr($_SESSION['cargo'],'8') == TRUE) {
		$dat = mysqli_query($db_con, "select unidad from FALUMNOS where claveal='$clave_al'");
		$tut=mysqli_fetch_row($dat);
		$unidad=$tut[0];
		echo "&nbsp;<a class='btn btn-primary' href='../orientacion/tutor.php?seleccionado=1&alumno=$alumno&unidad=$unidad'>Acción de Tutoría</a>";
	}
	if (stristr($_SESSION['cargo'],'2') == TRUE) {
		$tutor = $_SESSION['profi'];
		$dat = mysqli_query($db_con, "select unidad from FALUMNOS where claveal='$clave_al'");
		$dat_tutor = mysqli_query($db_con, "select unidad from FTUTORES where tutor='$tutor'");
		$tut=mysqli_fetch_row($dat);
		$tut2=mysqli_fetch_array($dat_tutor);
		$unidad=$tut[0];
		$unidad_tutor=$tut2[0];
		if ($unidad==$unidad_tutor) {
			echo "&nbsp;<a class='btn btn-primary' href='../tutoria/tutor.php?seleccionado=1&alumno=$alumno&unidad=$unidad&tutor=$tutor'>Acción de Tutoría</a>";
		if ($s_control=='1') {
			echo "&nbsp;<a class='btn btn-primary' href='datos.php?resetear=1&clave_alumno=$clave_al&seleccionado=1&alumno=$alumno&unidad=$unidad&correo=$correo'  data-bs='tooltip' title='Si el alumno o sus padres han olvidado la contraseña de acceso a la página principal, este botón permite reiniciar la contraseña al NIE del alumno. Si el alumno o tutores del mismo han registrado una dirección de correo electrónico, se les enviará un cooreo automaticamente. De lo contrario habrá que ponerse en contacto para hacérselo saber.'>Reiniciar Contraseña</a>";
		}
		}
	}
}
?>
</div>

<?php include("../../pie.php"); ?>

	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  		"paging":   true,
	      "ordering": true,
	      "info":     false,
	      
	  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 1, "asc" ]],
	  		
	  		"language": {
	  		            "lengthMenu": "_MENU_",
	  		            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
	  		            "info": "Página _PAGE_ de _PAGES_",
	  		            "infoEmpty": "No hay resultados disponibles.",
	  		            "infoFiltered": "(filtrado de _MAX_ resultados)",
	  		            "search": "Buscar: ",
	  		            "paginate": {
	  		                  "first": "Primera",
	  		                  "next": "Última",
	  		                  "next": "",
	  		                  "previous": ""
	  		                }
	  		        }
	  	});
	});
	</script>

</body>
</html>                                                                    