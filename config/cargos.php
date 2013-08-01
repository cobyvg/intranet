<?
session_start ();
include ("../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );

if (! (stristr ( $_SESSION ['cargo'], '1' ) == TRUE)) {
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
?>
<?
include ("../menu.php");
// $datatables_activado = true;
?>
<div class='container-fluid'>
  <div class="row-fluid">
   <div class="span10 offset1"> 
   <br /> 
<div align="center">
<div class="page-header">
  <h2>Administración <small> Perfiles de Profesores</small></h2>
</div>
<p align="left" class="help-block well" style="width:540px"><i class="icon icon-question-sign"> </i> Si necesitas información sobre los distintos perfiles de los profesores, puedes conseguirla colocando el cursor del ratón sobre los distintos tipos de perfiles (DACE, JD, Administ., Orienta, etc.).</p>
</div>
<br />
<?
if ($_POST['enviar'] == "Enviar") {
mysql_query ( "truncate table FTUTORES" );
mysql_query ( "truncate table cargos " );
	
	foreach ( $_POST as $dni => $cargo_profe ) {
		if ($cargo_profe == "Enviar") {
			continue;
		} elseif (strlen ( $cargo_profe ) > "1") {
			$dni = substr ( $dni, 0, -2 );
			$trozos = explode ( "-", $cargo_profe );
			$n_profe = mysql_query ( "select nombre from departamentos where dni='$dni'" );
			$n_prof = mysql_fetch_array ( $n_profe );
			$nivel = $trozos [0];
			$grupo = $trozos [1];
			$n_tutor = mb_strtoupper ( $n_prof [0], 'iso-8859-1' );
			
			mysql_query ( "insert INTO `FTUTORES` ( `nivel` , `grupo`, `tutor` ) VALUES ('$nivel', '$grupo', '$n_tutor')" );
		
		} elseif (strlen ( $cargo_profe ) < "2") {
			mysql_query ( "update departamentos set cargo = ''" );
			$dni = substr ( $dni, 0, - 1 );
			mysql_query ( "INSERT INTO `cargos` ( `dni` , `cargo` ) VALUES ('$dni', '$cargo_profe')" );
			//echo "INSERT INTO `cargos` ( `dni` , `cargo` ) VALUES ('$dni', '$cargo_profe')<br />"; 
		}
	}
	mysql_query ( "delete from cargos where cargo = '0'" );
	$n_cargo = mysql_query ( "select dni from departamentos" );
	while ( $n_carg = mysql_fetch_array ( $n_cargo ) ) {
		$num_cargos = "";
		$num_car = mysql_query ( "select distinct cargo from cargos where dni = '$n_carg[0]'" );
		while ( $num_carg = mysql_fetch_array ( $num_car ) ) {
			$num_cargos .= $num_carg [0];
		}
		mysql_query ( "update departamentos set cargo='$num_cargos' where dni='$n_carg[0]'" );
	}
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente.
          </div></div>';
}

$head = '<thead>
	<tr>
		<th>Profesor</th>
		<th align="center"><span rel="Tooltip" title="Miembros del Equipo Directivo del Centro">Direccion</span></th>
		<th align="center"><span rel="Tooltip" title="Tutores de Grupo de todos los niveles">Tutor</span></th>
		<th align="center"><span rel="Tooltip" title="Tutores de faltas de asistencia. Estos tutores se encargan de pasar a la Intranet las faltas que los profesores registran en su parte personal (Administracción de la Intranet --> Faltas de Asistencia -> Horario de faltas para profesores), que entregan los viernes en Jefatura o Conserjería. ">Faltas</span></th>
		<th align="center"><span rel="Tooltip" title="Jefes de los distintos Departamentos que el IES ha seleccionado.">JD</span></th>
		<th align="center"><span rel="Tooltip" title="Miembros del Equipo Técnico de Coordinación Pedadgógica">ETCP</span></th>
		<th align="center"><span rel="Tooltip" title="Miembro del departamento de Actividades Complementarias y Extraescolares.">DACE</span></th>
		<th align="center"><span rel="Tooltip" title="Miembros del personal de Administracción y Servicios: Conserjes.">Conserje</span></th>
		<th align="center"><span rel="Tooltip" title="Miembros del personal de Administracción y Servicios: Administrativos">Administ.</span></th>
		<th align="center"><span rel="Tooltip" title="Todos los profesores que pertenecen al Equipo de Orientación, incluídos ATAL, Apoyo, PCPI, etc.">Orienta.</span></th>
		<th align="center"><span rel="Tooltip" title="Profesores que participan en el Plan de Bilinguismo">Bilingue</span></th>
		<th align="center"><span rel="Tooltip" title="Profesores encargados de atender a los alumnos en el Aula de Convivencia del Centro, si este cuenta con ella.">Conviven.</span></th>
		<th align="center"><span rel="Tooltip" title="Profesores que participan en el Plan de Bibliotecas o se encargan de llevar la Biblioteca del Centro">Biblio.</span></th>
	</tr>
	</thead>';
?>

<form name="cargos" action="cargos.php" method="post">
<table class="table table-bordered table-striped" style="width:100%" align="center">
<? echo $head;?>
	<tbody>
<?
$carg0 = mysql_query ( "select distinct nombre, cargo, dni from departamentos order by nombre" );
$num_profes = mysql_num_rows ( $carg0 );
while ( $carg1 = mysql_fetch_array ( $carg0 ) ) {
	$pro = $carg1 [0];
	$car = $carg1 [1];
	$dni = $carg1 [2];
	$n_i = $n_i + 10;
	if ($n_i%"100"=="0") {
		echo $head;
	}
	?>
<tr>
		<td align="left" style="color:#08c"><?
	echo $pro;
	?></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>1"
			value="1" <?
	if (stristr ( $car, '1' ) == TRUE) {
		echo "checked";
	}
	?>
			id="dato0" /></td>
		<td align="center" nowrap><input type="checkbox" name="<?
	echo $dni;
	?>2"
			value="2" id="dato0"
			<?
	if (stristr ( $car, '2' ) == TRUE) {
		echo "checked";
	}
	?> /> <select class="input-small"
			name="<?
	echo $dni;
	?>2t" style="vertical-align: top;">
  <?
	$curso_tut = mysql_query ( "select nivel, grupo from FTUTORES, departamentos where tutor=nombre and dni='$dni'" );
	$curso_tut0 = mysql_fetch_array ( $curso_tut );
	$unidad = $curso_tut0 [0] . "-" . $curso_tut0 [1];
	?>
  <option><?
  if (strlen($unidad) > '1') {
  		echo $unidad;
  }
	?></option>
<?
	echo "<option></option>";
	$tipo = "select distinct unidad from alma order by nivel, grupo";
	$tipo1 = mysql_query ( $tipo );
	while ( $tipo2 = mysql_fetch_array ( $tipo1 ) ) {
		echo "<option>" . $tipo2 [0] . "</option>";
	}
	
	?>
  </select></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>3"
			value="3" id="dato0"
			<?
	if (stristr ( $car, '3' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>4"
			value="4" id="dato0"
			<?
	if (stristr ( $car, '4' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>9"
			value="9" id="dato0"
			<?
	if (stristr ( $car, '9' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>5"
			value="5" id="dato0"
			<?
	if (stristr ( $car, '5' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>6"
			value="6" id="dato0"
			<?
	if (stristr ( $car, '6' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>7"
			value="7" id="dato0"
			<?
	if (stristr ( $car, '7' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>8"
			value="8" id="dato0"
			<?
	if (stristr ( $car, '8' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
		<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>9"
			value="a" id="dato0"
			<?
	if (stristr ( $car, 'a' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
	<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>10"
			value="b" id="dato0"
			<?
	if (stristr ( $car, 'b' ) == TRUE) {
		echo "checked";
	}
	?> /></td>
	<td align="center"><input type="checkbox" name="<?
	echo $dni;
	?>11"
			value="c" id="dato0"
			<?
	if (stristr ( $car, 'c' ) == TRUE) {
		echo "checked";
	}
	?> /></td>

	</tr>
<?
	}
?>
</tbody>
</table><br /><center><input
			type="submit" name="enviar" value="Enviar" class="btn btn-primary" /></center>
            </form>
            </div></div></div>
<? include("../pie.php");?>
</body>
</html>
