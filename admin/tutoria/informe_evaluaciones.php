<?php
session_start();
include("../../config.php");
include_once('../../config/version.php');

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

// COMPROBACION DE ACCESO AL MODULO
if ((stristr($_SESSION['cargo'],'1') == false) && (stristr($_SESSION['cargo'],'2') == false) && (stristr($_SESSION['cargo'],'8') == false)) {
	
	if (isset($_SESSION['mod_tutoria'])) unset($_SESSION['mod_tutoria']);
	die ("<h1>FORBIDDEN</h1>");
	
}
else {
	
	// COMPROBAMOS SI ES EL TUTOR, SINO ES DEL EQ. DIRECTIVO U ORIENTADOR
	if (stristr($_SESSION['cargo'],'2') == TRUE) {
		
		$_SESSION['mod_tutoria']['tutor']  = $_SESSION['tut'];
		$_SESSION['mod_tutoria']['unidad'] = $_SESSION['s_unidad'];
		
	}
	else {
	
		if(isset($_POST['tutor'])) {
			$exp_tutor = explode('==>', $_POST['tutor']);
			$_SESSION['mod_tutoria']['tutor'] = trim($exp_tutor[0]);
			$_SESSION['mod_tutoria']['unidad'] = trim($exp_tutor[1]);
		}
		else{
			if (!isset($_SESSION['mod_tutoria'])) {
				header('Location:'.'tutores.php');
			}
		}
		
	}
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

mysqli_query($db_con, "
CREATE TABLE IF NOT EXISTS `evalua_tutoria` (
`id` int(11) NOT NULL,
  `unidad` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  `evaluacion` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  `alumno` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `campo` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `valor` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;
");

$curso = $_SESSION['mod_tutoria']['unidad'];
$evaluacion = $_POST['evaluacion'];

// ENVIO DEL FORMULARIO
if (isset($_POST['submit'])) {

	$curso = $_SESSION['mod_tutoria']['unidad'];
	$evaluacion = $_POST['evaluacion'];

	foreach ($_POST as $campo => $valor) {
		if ($campo != 'submit' and $valor!=="" and $campo !=="unidad" and $campo !=="evaluacion") {	
			
			$exp_campo = explode('-', $campo);

			$al_campo = $exp_campo[0];

			$claveal = $exp_campo[1];
			
$chk = mysqli_query($db_con, "select id from evalua_tutoria where unidad = '$curso' and evaluacion = '$evaluacion' and alumno = '$claveal' and campo = '$al_campo'");	
if (mysqli_num_rows($chk)>0) {
$result = mysqli_query($db_con, "update evalua_tutoria set valor = '$valor' where unidad = '$curso' and evaluacion = '$evaluacion' and alumno = '$claveal' and campo = '$al_campo'");	
}		
else{			
$result = mysqli_query($db_con, "INSERT INTO evalua_tutoria (unidad, evaluacion, alumno, campo, valor) VALUES ('$curso', '$evaluacion', '$claveal', '$al_campo', '$valor')");
}			
		}
	}
}

include("../../menu.php");
include("menu.php");
?>

<div
	class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Evaluaciones del Tutor <small> <?php echo $evaluacion; ?></small></h2>
</div>

<!-- MENSAJES --> <?php if (isset($msg_error)): ?>
<div class="alert alert-danger"><?php echo $msg_error; ?></div>
<?php endif; ?> <?php if (isset($msg_success)): ?>
<div class="alert alert-success"><?php echo $msg_success; ?></div>
<?php endif; ?>


<div class="row hidden-print">

<div class="col-sm-6 col-sm-offset-3">

<form method="post" action="">

<fieldset>

<div class="well">

<div class="row">

<div class="col-sm-12">
<input type='hidden' name='unidad' value='<?php echo $curso; ?>' />
<legend>Seleccione evaluación</legend>
<div class="form-group">
<select class="form-control" id="evaluacion" name="evaluacion" onchange="submit()">
	<option><? if (isset($_POST['evaluacion'])) {
		echo $evaluacion;
	} ?></option>
	<option>Ev. Inicial</option>
	<option>1ª Evaluacion</option>
	<option>2ª Evaluacion</option>
	<option>Ev.Ordinaria</option>
	<option>Ev.Extraordinaria</option>
	</select>
	</div>

</div>

</div>


</div>
<!-- /.well --></fieldset>

</form>

</div>
<!-- /.col-sm-12 -->
</div>
</div>
<div class="container-fluid">
<!-- /.row --> <?php if (isset($curso)  && isset($evaluacion)): ?>
<div class="row-fluid">

<div class="col-sm-12">

<div class="visible-print">
<h3><?php echo $evaluacion; ?> de <?php echo $curso; ?></h3>
</div>

<form method="post" action="">

<input type="hidden" name="unidad" value="<?php echo $curso; ?>"> 
<input type="hidden" name="evaluacion" value="<?php echo $evaluacion; ?>">

<table
	class="table table-bordered table-striped table-hover table-vcentered">
	<thead>
		<tr>
			<th style="width:25px"></th>
			<th style="width:15px">NC</th>
			<th style="width:150px">Alumno/a</th>
			<th style="width:80px">Fecha</th>
			<th style="width:100px">Repeticion</th>
			<th style="width:35px">PIL</th>
<?
if (strstr($curso,"1")==TRUE or strstr($curso,"2")==TRUE) {
?>			
			<th style="width:15px">Exen.</th>
			<th style="width:40px">Ref.</th>
<?
}
?>
			<th style="width:50px">Pend.</th>
			<th>Atención a la Diversidad</th>
			<th>Observaciones</th>
		</tr>
	</thead>
	<tbody>
	<?php $result = mysqli_query($db_con, "SELECT alma.apellidos, alma.nombre, alma.claveal, FALUMNOS.nc, fecha, edad FROM alma, FALUMNOS WHERE alma.claveal=FALUMNOS.claveal and FALUMNOS.unidad='$curso' order by nc"); 
	?>
	<?php while ($row = mysqli_fetch_array($result)): $claveal = $_POST['claveal'];?>
		<tr>
		<?php $foto = '../../xml/fotos/'.$row['claveal'].'.jpg'; ?>
		<?php if (file_exists($foto)): ?>
			<td class="text-center"><img 
				src="<?php echo $foto; ?>"
				alt="<?php echo $row['apellidos'].', '.$row['nombre']; ?>"
				width="54"></td>
				<?php else: ?>
			<td class="text-center"><span class="fa fa-user fa-fw fa-3x"></span></td>
			<?php endif; ?>
			
			<td><? echo $row['nc'];?></td>
			
			<td><?php echo $row['apellidos'].', '.$row['nombre']; ?></td>
			
			<td><?php echo $row['fecha'].'<br><span class="text-success">('.$row['edad'].')</span>'; ?></td>
			
			<td>			
<?
$repite = "";
$chk1 = mysqli_query($db_con, "select valor from evalua_tutoria where unidad = '$curso' and alumno = '".$row['claveal']."' and campo = 'rep'");
if (mysqli_num_rows($chk1)>0) {
	$rep0 = mysqli_fetch_array($chk1);
	$repite = $rep0[0];
}
else{
$index = substr($curso_actual,0,4)+1;
$repi_db=mysqli_query($db_con,"select matriculas, curso from $db.alma where claveal='".$row['claveal']."' and matriculas > '1'");

if (mysqli_num_rows($repi_db)>0) {
$repit_db = mysqli_fetch_array($repi_db);
$repite=substr($repit_db[1],0,1)."º, ";
}
	for ($i = 0; $i < 4; $i++) {
	$ano = $db."".($index-$i);
		$repi=mysqli_query($db_con,"select matriculas, curso from $ano.alma where claveal='".$row['claveal']."' and matriculas>'1'");
		if (mysqli_num_rows($repi)>0) {
		$repit = mysqli_fetch_array($repi);	
		$repite.=substr($repit[1],0,1)."º, ";
	}
	}
	if (strlen($repite)>0) {
		$repite=substr($repite,0,-2)." ESO";
	}

}
?>
				<textarea class="form-control" name="rep-<?php echo $row['claveal']; ?>" rows="2"><?php echo $repite; ?></textarea>
			</td>
			
			<td>
			<?

$pil = "";			
$chk2 = mysqli_query($db_con, "select valor from evalua_tutoria where unidad = '$curso' and alumno = '".$row['claveal']."' and campo = 'pil'");
if (mysqli_num_rows($chk2)>0) {
	$pil0 = mysqli_fetch_array($chk2);
	$pil = $pil0[0];
}
	else{		
			$pil1 = mysqli_query($db_con,"select promociona from matriculas where promociona='2' and claveal = '".$row['claveal']."'");
			if (mysqli_num_rows($pil1)>0) {
	$pil="PIL";
			}
	}
echo "<input type='text' class='form-control input-sm' style='width:45px' maxlength='3' name='pil-".$row['claveal']."' value='$pil' />";
			?>
			</td>

<?
if (strstr($curso,"1")==TRUE or strstr($curso,"2")==TRUE) {
?>
<td>
			<?

$exen = "";			
$chk21 = mysqli_query($db_con, "select valor from evalua_tutoria where unidad = '$curso' and alumno = '".$row['claveal']."' and campo = 'exen'");
if (mysqli_num_rows($chk21)>0) {
	$exen0 = mysqli_fetch_array($chk21);
	$exen = $exen0[0];
}
	else{		
			$exen0 = mysqli_query($db_con,"select exencion from matriculas where exencion='1' and claveal = '".$row['claveal']."'");
			if (mysqli_num_rows($exen0)>0) {
	$exen="1";
			}
	}
echo "<input type='text' class='form-control input-sm' style='width:30px' maxlength='3' name='exen-".$row['claveal']."' value='$exen' />";
			?>
			</td>

			<td>
	<?

$ref = "";			
$chk22 = mysqli_query($db_con, "select valor from evalua_tutoria where unidad = '$curso' and alumno = '".$row['claveal']."' and campo = 'ref'");
if (mysqli_num_rows($chk22)>0) {
	$ref0 = mysqli_fetch_array($chk22);
	$ref = $ref0[0];
}
	else{		
			$ref1 = mysqli_query($db_con,"select act1 from matriculas where claveal = '".$row['claveal']."'");
			if (mysqli_num_rows($pil1)>0) {
			$refu = mysqli_fetch_array($ref1);
			
			if ($refu[0]=="1") {$ref="Leng";}
			if ($refu[0]=="2") {$ref="Mat";}
			if ($refu[0]=="3") {$ref="Ingl";}
	
			}
	}
echo "<input type='text' class='form-control input-sm' style='width:50px' maxlength='3' name='ref-".$row['claveal']."' value='$ref' />";
			?>
			</td>
<?
}
?>						
			<td>
			<?
			$pendiente="";
			$pend = mysqli_query($db_con,"select distinct pendientes.codigo, abrev from pendientes, asignaturas where pendientes.codigo=asignaturas.codigo and abrev like '%\_%' and claveal = '".$row['claveal']."'");
			while ($pendi = mysqli_fetch_row($pend)) {
				$pendiente.= $pendi[1]." ";
			}
			echo "<span class='text-danger'>$pendiente</span>";
			?>
			</td>
			
			
			<td>
<?
$div = "";			
$chk3 = mysqli_query($db_con, "select valor from evalua_tutoria where unidad = '$curso' and alumno = '".$row['claveal']."' and campo = 'div'");
//echo "select valor from evalua_tutoria where unidad = '$curso' and evaluacion = '$evaluacion' and alumno = '$claveal' and campo = 'div'";

if (mysqli_num_rows($chk3)>0) {
	$div0 = mysqli_fetch_array($chk3);
	$div = $div0[0];
}
?>
			<textarea class="form-control" name="div-<?php echo $row['claveal']; ?>" rows="3"><?php echo $div; ?></textarea>
			</td>
			
			<td>
<?
$obs = "";			
$chk4 = mysqli_query($db_con, "select valor from evalua_tutoria where unidad = '$curso' and evaluacion = '$evaluacion' and alumno = '".$row['claveal']."' and campo = 'obs'");
if (mysqli_num_rows($chk4)>0) {
	$obs0 = mysqli_fetch_array($chk4);
	$obs = $obs0[0];
}
?>
			<textarea class="form-control" name="obs-<?php echo $row['claveal']; ?>" rows="3"><?php echo $obs; ?></textarea>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<div class="hidden-print">
<button type="submit" class="btn btn-primary" name="submit" value="Registrar">Registrar</button>
<button type="reset" class="btn btn-default">Cancelar</button>
<a href="#" class="btn btn-info" onclick="javascript:print();">Imprimir</a>
</div>

</form>

</div>
<!-- /.col-sm-12 --></div>
<!-- /.row --> <?php endif; ?></div>
<!-- /.container -->

		<?php include("../../pie.php"); ?>

</body>
</html>
