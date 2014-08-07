<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'2') == TRUE)) {
	echo "<div class='well' align='center'><p class='text-danger'>La página a la que estás accediendo está restringida.</p>";
	echo '<p class="text-info">Si piensas que es un error consulta con el administrador.</p>';
	echo "<a class='btn' href='../index.php'>Volver a la Intranet</a></div>";
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$profe = $_SESSION ['tut'];
if(isset($_SESSION['s_unidad'])) $unidad = $_SESSION['s_unidad'];
else $unidad = $_GET['unidad'];


// ESTRUCTURA DE LA CLASE, SE AJUSTA AL NUMERO DE ALUMNOS
$result = mysql_query("SELECT apellidos, nombre, claveal FROM alma WHERE unidad='$unidad' ORDER BY apellidos ASC, nombre ASC");
$n_alumnos = mysql_num_rows($result);
mysql_free_result($result);

if ($n_alumnos <= 36) $estructura_clase = '222';
elseif ($n_alumnos > 36 && $n_alumnos <= 42) $estructura_clase = '232';
elseif ($n_alumnos > 42) $estructura_clase = '242';


if ($estructura_clase == '242') { $mesas_col = 9; $mesas = 48; $col_profesor = 9; }
if ($estructura_clase == '232') { $mesas_col = 8; $mesas = 42; $col_profesor = 8; }
if ($estructura_clase == '222') { $mesas_col = 7; $mesas = 36; $col_profesor = 7; }


function al_con_nie($var_nie,$var_grupo) {
	$result = mysql_query("SELECT nombre, apellidos FROM alma WHERE unidad='".$var_grupo."' AND claveal='".$var_nie."' ORDER BY apellidos ASC, nombre ASC LIMIT 1");
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	return($row['apellidos'].', '.$row['nombre']);
}


// OBTENEMOS LOS PUESTOS
$result = mysql_query("SELECT * FROM puestos_alumnos WHERE unidad='".$unidad."' limit 1");
$row = mysql_fetch_array($result);
$cadena_puestos = $row[1];
mysql_free_result($result);

$matriz_puestos = explode(';', $cadena_puestos);

foreach ($matriz_puestos as $value) {
	$los_puestos = explode('|', $value);
	
	if ($los_puestos[0] == 'allItems') {
		$sin_puesto[] = $los_puestos[1];
	}
	else {
		$con_puesto[$los_puestos[0]] = $los_puestos[1];
	}

}

?>
<html>
<head>
	<meta charset="iso-8859-1">  
	<title>Intranet &middot; <? echo $nombre_del_centro; ?></title>  
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<meta name="description" content="Intranet del <? echo $nombre_del_centro; ?>">  
	<meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
	 
	<!-- BOOTSTRAP CSS CORE -->
	<link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- CUSTOM CSS THEME -->
	<link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
	
	<style class="text/css">
	
	table tr td {
		vertical-align: top;
	}
	
	table tr td.divisor {
		background-color: #333;
	}
	
	table tr td div {
		border: 1px solid #ecf0f1;
		margin: 0 5px 10px 5px;
	}
	
	table tr td div {
		width: 130px;
	}
	
	table tr td div p {
		background-color: #2c3e50;
		color: #fff;
		font-weight: bold;
		padding: 4px 2px;
		margin-bottom: 4px;
	}
	
	table tr td div ul {
		margin: 0 4px 4px 4px;
		min-height: 50px;
	}
	
	.text-sm {
		font-size: 0.9em;
	}
	
	</style>
</head>

<body>
	
	<div class="container">
	
		<div class="page-header">
			<h2>Asignación de puestos en el aula <?php echo $unidad; ?></h2>
		</div>
		
		<table>
			<?php for ($i = 1; $i < 7; $i++): ?>
			<tr>
				<?php for ($j = 1; $j < $mesas_col; $j++): ?>
				<td>
					<div><p class="text-center">Mesa <?php echo $mesas; ?></p>
						<ul id="<?php echo $mesas; ?>" class="list-unstyled text-sm">
							<?php if (isset($con_puesto[$mesas])): ?>
								<li id="<?php echo $con_puesto[$mesas]; ?>"><?php echo al_con_nie($con_puesto[$mesas],$unidad); ?></li>		 
							<?php endif; ?>  
						</ul>
					</div>
				</td>
				<?php if ($j == 2 || $j == $mesas_col-3): ?>
				<td class="text-center divisor">|</td>
				<?php endif; ?>
				<?php $mesas--; ?>
				<?php endfor; ?>
			</tr>
			<?php endfor; ?>
			<tr>
				<td colspan="<?php echo $col_profesor; ?>"></td>
				<td class="text-center">
					<div>
						<p>Profesor/a</p>
						<br><br><br>
					</div>
				</td>
			</tr>
		</table>
		
	</div>
	
<?php include("../../pie.php"); ?>

	<script>
	$(document).ready(function() {
		print();
	});
	</script>
	
</body>
</html>