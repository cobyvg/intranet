<?
session_start ();
include ("../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );

if (! (stristr ( $_SESSION ['cargo'], '1' ) == TRUE)) {
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}

include ("../menu.php");
// $datatables_activado = true;
?>
<div class='container'>

	<div class="page-header">
	  <h2>Administración <small> Perfiles de Profesores</small></h2>
	</div>
	
	<?php
	if ($_GET['borrar']=='1') {
		mysql_query("delete from departamentos where dni = '".$_GET['dni_profe']."'");
		echo '<div class="alert alert-success">
	            <button type="button" class="close" data-dismiss="alert">&times;</button>
	            El profesor ha sido borrado de la base de datos..
	          </div>';
	}
	if (isset($_POST['enviar'])) {
	mysql_query ( "truncate table FTUTORES" );
	mysql_query ( "truncate table cargos " );
		
		foreach ( $_POST as $dni => $cargo_profe ) {
			if ($cargo_profe == "Enviar") {
				continue;
			} elseif (strlen ( $cargo_profe ) > "1") {
				$dni = substr ( $dni, 0, -2 );
				$n_profe = mysql_query ( "select nombre from departamentos where dni='$dni'" );
				$n_prof = mysql_fetch_array ( $n_profe );
				$unidad = $cargo_profe;
				$n_tutor = mb_strtoupper ( $n_prof [0], 'iso-8859-1' );
				
				mysql_query ( "insert INTO `FTUTORES` ( `unidad` , `tutor` ) VALUES ('$unidad', '$n_tutor')" );
			
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
	echo '<div class="alert alert-success">
	Los perfiles han sido asignados correctamente a los profesores.
	          </div>';
	}
	?>
	
  <div class="row">
  	
   <div class="col-sm-12"> 
   
   <style type="text/css">
   thead th {
   	font-size: 0.8em;
   }
   </style>

		<?php
		$head = '<thead>
			<tr>
				<th>Profesor</th>
				<th><span rel="tooltip" title="Miembros del Equipo Directivo del Centro">Dirección</span></th>
				<th><span rel="tooltip" title="Tutores de Grupo de todos los niveles">Tutor</span></th>
				<th><span rel="tooltip" title="Tutores de faltas de asistencia. Estos tutores se encargan de pasar a la Intranet las faltas que los profesores registran en su parte personal (Administracción de la Intranet --> Faltas de Asistencia -> Horario de faltas para profesores), que entregan los viernes en Jefatura o Conserjería. ">Faltas</span></th>
				<th><span rel="tooltip" title="Jefes de los distintos Departamentos que el IES ha seleccionado.">JD</span></th>
				<th><span rel="tooltip" title="Miembros del Equipo Técnico de Coordinación Pedadgógica">ETCP</span></th>
				<th><span rel="tooltip" title="Miembro del departamento de Actividades Complementarias y Extraescolares.">DACE</span></th>
				<th><span rel="tooltip" title="Miembros del personal de Administracción y Servicios: Conserjes.">Conserje</span></th>
				<th><span rel="tooltip" title="Miembros del personal de Administracción y Servicios: Administrativos">Administ.</span></th>
				<th><span rel="tooltip" title="Todos los profesores que pertenecen al Equipo de Orientación, incluídos ATAL, Apoyo, PCPI, etc.">Orienta.</span></th>';
		if($mod_bilingue) $head .= '<th><span rel="tooltip" title="Profesores que participan en el Plan de Bilinguismo">Bilingüe</span></th>';
		$head .= '<th><span rel="tooltip" title="Profesores encargados de atender a los alumnos en el Aula de Convivencia del Centro, si este cuenta con ella.">Conv.</span></th>';
		if($mod_biblio) $head .= '<th><span rel="tooltip" title="Profesores que participan en el Plan de Bibliotecas o se encargan de llevar la Biblioteca del Centro">Biblio.</span></th>';
		$head .= '<th><span rel="tooltip" title="Profesor encargado de las Relaciones de Género">Género</span></th>
				<th>&nbsp;</th>
			</tr>
			</thead>';
		?>
		
		<form name="cargos" action="cargos.php" method="post">
		
		<p class="help-block">
			Si necesitas información sobre los distintos perfiles de los profesores, puedes conseguirla colocando el cursor del ratón sobre los distintos tipos de perfiles.
		</p>
		
		<div class="table-responsive">
		<table class="table table-bordered table-striped table-condensed">
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
				<td nowrap><small><?
			echo $pro;
			?></small></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>1"
					value="1" <?
			if (stristr ( $car, '1' ) == TRUE) {
				echo "checked";
			}
			?>
					id="dato0" /></td>
				<td class="form-inline" nowrap><input type="checkbox" name="<?
			echo $dni;
			?>2"
					value="2" id="dato0"
					<?
			if (stristr ( $car, '2' ) == TRUE) {
				echo "checked";
			}
			?> /> <select class="form-control" style="width: 80px;"
					name="<?
			echo $dni;
			?>2t">
		  <?
			$curso_tut = mysql_query ( "select unidad from FTUTORES, departamentos where tutor=nombre and dni='$dni'" );
			$curso_tut0 = mysql_fetch_array ( $curso_tut );
			$unidad = $curso_tut0 [0];
			?>
		  <option><?
		  if (strlen($unidad) > '1') {
		  		echo $unidad;
		  }
			?></option>
		<?
			echo "<option></option>";
			$tipo = "select distinct unidad from alma order by unidad";
			$tipo1 = mysql_query ( $tipo );
			while ( $tipo2 = mysql_fetch_array ( $tipo1 ) ) {
				echo "<option>" . $tipo2 [0] . "</option>";
			}
			
			?>
		  </select></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>3"
					value="3" id="dato0"
					<?
			if (stristr ( $car, '3' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>4"
					value="4" id="dato0"
					<?
			if (stristr ( $car, '4' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>9"
					value="9" id="dato0"
					<?
			if (stristr ( $car, '9' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>5"
					value="5" id="dato0"
					<?
			if (stristr ( $car, '5' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>6"
					value="6" id="dato0"
					<?
			if (stristr ( $car, '6' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>7"
					value="7" id="dato0"
					<?
			if (stristr ( $car, '7' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>8"
					value="8" id="dato0"
					<?
			if (stristr ( $car, '8' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php if($mod_bilingue) { ?>
				<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>9"
					value="a" id="dato0"
					<?
			if (stristr ( $car, 'a' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php } ?>
			<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>10"
					value="b" id="dato0"
					<?
			if (stristr ( $car, 'b' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php if($mod_biblio) { ?>
			<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>11"
					value="c" id="dato0"
					<?
			if (stristr ( $car, 'c' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<?php } ?>
			<td class="text-center"><input type="checkbox" name="<?
			echo $dni;
			?>11"
					value="d" id="dato0"
					<?
			if (stristr ( $car, 'd' ) == TRUE) {
				echo "checked";
			}
			?> /></td>
			<td class="text-center"><a href="cargos.php?borrar=1&dni_profe=<?echo $dni;?>"><span class="fa fa-trash-o fa-lg fa-fw" data-bb='confirm-delete'></span></a></td>
			</tr>
		<?
			}
		?>
		</tbody>
		</table>
		</div>

	<button type="submit" class="btn btn-primary" name="enviar">Guardar cambios</button>
	<a class="btn btn-default" href="../xml/index.php">Volver</a>
</form>
            </div></div></div>
<? include("../pie.php");?>
</body>
</html>
