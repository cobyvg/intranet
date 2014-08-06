<?php
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

$HorExpSen = $_FILES['HorExpSen']['tmp_name'];

if (isset($_POST['s_seneca']) and isset($_FILES['HorExpSen'])) {
	include("exportarHorariosSeneca.php");
	exit();
}
$TITULO_SECCION = "Importar horarios";
?>
<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="iso-8859-1">
<title>Intranet &middot; <? echo $nombre_del_centro; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Intranet del <? echo $nombre_del_centro; ?>">
<meta name="author"
	content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">

<link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css"
	rel="stylesheet">
<link href="http://<? echo $dominio;?>/intranet/css/otros.css"
	rel="stylesheet">

<link href="http://<? echo $dominio;?>/intranet/css/datepicker.css"
	rel="stylesheet">
<link
	href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css"
	rel="stylesheet">
<link
	href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css"
	rel="stylesheet">

<script src="http://<? echo $dominio;?>/intranet/js/jquery.js"></script>
<script src="http://<? echo $dominio;?>/intranet/js/bootstrap.min.js"></script>
<script>
    function callprogress ( valor , tabla ) {
      var job = document.getElementById("progress_job");
      var bar = document.getElementById("progress");
      
      job.innerHTML = 'Importando '+tabla+'...';
      bar.innerHTML = '<div class="progress-bar" role="progressbar" aria-valuenow="'+valor+'" aria-valuemin="0" aria-valuemax="100" style="width: '+valor+'%;"><span class="sr-only">'+valor+'% Completado</span></div>';
      
      if (valor == 100) {
      	job.className = 'hidden';
      	bar.className = 'hidden';
      }
    }
    </script>

</head>

<body>


<nav class="navbar navbar-default navbar-fixed-top hidden-print"
	role="navigation">
<div class="container-fluid"><!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse"
	data-target="#navbar"><span class="sr-only">Cambiar navegación</span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> <span
	class="icon-bar"></span></button>
<a class="navbar-brand" href="http://localhost/intranet/">I.E.S.
Monterroso</a></div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="navbar">
<ul class="nav navbar-nav">
	<li><a href="http://localhost/intranet/index.php">Inicio</a></li>
	<li><a href="http://localhost/intranet/upload/">Documentos</a></li>
	<li><a
		href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio"
		target="_blank">Séneca</a></li>
</ul>

<div class="navbar-right">
<ul class="nav navbar-nav">
	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"> <span class="fa fa-envelope "></span> <b
		class="caret"></b> </a>
	<ul class="dropdown-menu dropdown-messages">
		<li><a class="text-center"
			href="http://localhost/intranet/admin/mensajes/"><strong>Ver todos
		los mensajes <span class="fa fa-angle-right"></span></strong></a></li>
	</ul>
	</li>

	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"> <span class="fa fa-user fa-fw"></span>
	mgargon732 <b class="caret"></b> </a>
	<ul class="dropdown-menu">
		<li><a href="http://localhost/intranet/clave.php"><i
			class="fa fa-key fa-fw"></i> Cambiar contraseña</a></li>
		<li><a href="http://localhost/intranet/admin/fotos/fotos_profes.php"><i
			class="fa fa-camera fa-fw"></i> Cambiar fotografía</a></li>
		<li><a href="http://localhost/intranet/salir.php"><i
			class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
	</ul>
	</li>
</ul>
<p class="navbar-text"
	style="margin-top: 7px; margin-bottom: 7px; color: #ffffff;"><small><i
	class="fa fa-clock-o fa-lg"></i> Última conexión:<br class="hidden-xs">
02-08-2014 &nbsp; 08:48:18 </small></p>
</div>

</div>
<!-- /.navbar-collapse --></div>
<!-- /.container-fluid --></nav>

<div class="container"><!-- TITULO DE LA PAGINA -->
<div class="page-header">
<h2>Administración <small>Importación del Horario / Preparación de datos
para subir a Séneca</small></h2>
</div>

<!-- SCAFFOLDING -->
<div class="row"><!-- COLUMNA IZQUIERDA -->
<div class="col-sm-6">

<div class="well"><?php

if (!$HorExpSen) {

	?>

<form method="POST" action="horario.php" enctype="multipart/form-data">
<fieldset>
<legend>Archivo XML generado por Horw o GHC</legend> <input
	class="input" type="file" name="HorExpSen" accept="text/xml">
<hr />
<button type="submit" class="btn btn-primary btn-block" name='s_horario'>Importar Horarios</button>
<hr />	
<div class="checkbox">
<label for="depurar"> <input type="checkbox" id="depurar"	name="depurar" value='1'> Depurar archivo XML para subir a Séneca </label>
</div>
<button type="submit" class="btn btn-default btn-block" name='s_seneca'>Preparar
archivo XML</button>

</fieldset>
</form>

	<?php
}
else {

	$porcentaje=0;
	echo '<p id="progress_job"></p>';
	echo '<div id="progress" class="progress">';
	echo '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"> <span class="sr-only">0% Completado</span></div>';
	echo '</div>';


	$xml = simplexml_load_file($HorExpSen);

	$total += $xml->BLOQUE_DATOS->grupo_datos[1]->attributes()->registros;
	$unid = 100/$total;

	$tabla = 'horw';


	// Borramos y creamos la tabla de los horarios Creamos copia de seguridad de la tabla por si acaso
	mysql_query("drop table horw_seg");
	mysql_query("create table horw_seg select * from horw");
	mysql_query("drop table horw");
	$crea ="CREATE TABLE IF NOT EXISTS `horw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` char(1) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `hora` char(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_asig` varchar(8) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `asig` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `c_asig` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `prof` varchar(50) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `no_prof` tinyint(4) DEFAULT NULL,
  `c_prof` varchar(30) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_aula` varchar(5) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `n_aula` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `a_grupo` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nivel` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `n_grupo` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `clase` varchar(16) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `prof` (`prof`),
  KEY `c_asig` (`c_asig`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci";
	mysql_query($crea) or die ('<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se ha podido crear la tabla <strong>Horw</strong>. Ponte en contacto con quien pueda resolver el problema.
</div></div><br />
<div align="center">
  <input type="button" value="Volver atrás" name="boton" onClick="history.back(2)" class="btn btn-inverse" />
</div>');


	$i=0;
	foreach ($xml->BLOQUE_DATOS->grupo_datos[1]->grupo_datos as $profesor) {

		$idprofesor = utf8_decode($profesor->dato[0]);
		$num_prof+=1;
		foreach ($xml->BLOQUE_DATOS->grupo_datos[1]->grupo_datos[$i]->grupo_datos as $horario) {
			$nombre_asignatura="";
			$abrev = "";
			$codigo_asig="";

			$diasemana = utf8_decode($horario->dato[0]);
			$idtramo = utf8_decode($horario->dato[1]);
			$tram = mysql_query("select hora from tramos where tramo = '$idtramo'");
			$tram_hor = mysql_fetch_row($tram);
			$hora = $tram_hor[0];

			if (utf8_decode($horario->dato[2]) == "") $iddependencia = "NULL";
			else $iddependencia = utf8_decode($horario->dato[2]);

			if (utf8_decode($horario->dato[3]) == "") {$idunidad=""; $grupo=''; $curso='';}
			else {
				$idunidad = utf8_decode($horario->dato[3]);
				$unid = mysql_query("select nomunidad, nomcurso from unidades, cursos where  cursos.idcurso = unidades.idcurso
AND unidades.idunidad  = '$idunidad'");
				$unidad = mysql_fetch_row($unid);
				$grupo = $unidad[0];
				$curso = $unidad[1];
			}

			$idactividad = utf8_decode($horario->dato[10]);

			if (utf8_decode($horario->dato[5]) == "") {$idmateria="";}
			else {$idmateria = utf8_decode($horario->dato[5]);}

			if (utf8_decode($horario->dato[4]) == "") {$idcurso="";}
			else {$idcurso = utf8_decode($horario->dato[4]);}

			if ($idunidad == "" or $idmateria =="") {

				$activ = mysql_query("select nomactividad, idactividad from actividades_seneca where idactividad = '$idactividad'");
				$activida = mysql_fetch_row($activ);
				$nombre_asigna = $activida[0];
				$idactividad = $activida[1];
				$nombre_asignatura = $activida[0];

				$nombre_asigna = str_replace(" de "," ",$nombre_asigna);
				$nombre_asigna = str_replace("/","",$nombre_asigna);
				$nombre_asigna = str_replace(" y "," ",$nombre_asigna);
				$nombre_asigna = str_replace(" á"," a",$nombre_asigna);
				$nombre_asigna = str_replace(" a "," ",$nombre_asigna);
				$nombre_asigna = str_replace(" la "," ",$nombre_asigna);
				$nombre_asigna = str_replace("(","",$nombre_asigna);
				$nombre_asigna = str_replace(")","",$nombre_asigna);

				$codigo_asig = $idactividad;

				$tr_abrev = explode(" ",$nombre_asigna);

				$letra1 = strtoupper(substr($tr_abrev[0],0,1));
				$letra2 = strtoupper(substr($tr_abrev[1],0,1));
				$letra3 = strtoupper(substr($tr_abrev[2],0,1));
				$letra4 = strtoupper(substr($tr_abrev[3],0,1));


				$abrev = $letra1.$letra2.$letra3.$letra4;

			}
			else{
				$nom_asig = mysql_query("select abrev, nombre from asignaturas where codigo = '$idmateria' and abrev not like '%\_%' and codigo is not NULL and codigo not like ''");
				$nom_asigna = mysql_fetch_row($nom_asig);
				$abrev = $nom_asigna[0];
				$nombre_asignatura = $nom_asigna[1];
				$codigo_asig = $idmateria;
			}


			$nom_prof = mysql_query("select concat(ape1profesor,' ',ape2profesor,', ',nomprofesor) from profesores_seneca where idprofesor = '$idprofesor'");
			$nom_profe = mysql_fetch_row($nom_prof);
			$nombre_profesor = $nom_profe[0];

			mysql_query ("INSERT horw (`dia`, `hora`, `a_asig`, `asig`, `c_asig`, `prof`, `no_prof`, `c_prof`, `a_aula`, `n_aula`, `a_grupo`) VALUES ('$diasemana', '$hora', '$abrev', '$nombre_asignatura', '$codigo_asig', '$nombre_profesor', '$num_prof', '$idprofesor', '$iddependencia', '$iddependencia', '$grupo')");

			$asig = mysql_query("select codigo, nombre from asignaturas where curso = '$curso' and curso not like '' and nombre = '$nombre_asignatura' and abrev = '$abrev' and codigo not like '2'");

			if (mysql_num_rows($asig)>0) {
				$asignatur = mysql_fetch_array($asig);
				$asignatura=$asignatur[0];

				if (!($asignatura==$idmateria)) {
					$codasi = $asignatura;
					mysql_query("update horw set c_asig = '$codasi' where c_prof = '$idprofesor' and a_grupo = '$grupo' and c_asig = '$idmateria'");
				}
				else{
					$codasi="";
				}
			}
		}

		$i++;
			
		$porcentaje += $unid;
			
		echo '<script>callprogress('.round($porcentaje).' , \''.$tabla.'\');</script>';

	}


	// Actualizamos nombre de las materias / actividades para hacerlas más intuitivas y ajustarlas al patrón antiguo
	mysql_query("update horw set a_asig = 'TUT' where c_asig = '2'");
	mysql_query("update asignaturas set abrev = 'TUT' where codigo = '2'");
	mysql_query("update horw set a_asig = 'GU' where c_asig = '25'");
	mysql_query("update horw set a_asig = 'GURE' where c_asig = '353'");
	mysql_query("update horw set a_asig = 'GUBIB' where c_asig = '26'");

	// Separamos Nivel y Grupo si sigue el modelo clásico del guión (1E-F, 2B-C, etc)
	$SQL_1 = "SELECT a_grupo  FROM  horw where a_grupo is not null and a_grupo not like ''";
	$result_1 = mysql_query($SQL_1);
	$row_1 = mysql_fetch_row($result_1);

	if (strstr($row_1[0],"-")==TRUE) {
		$SQL0 = "SELECT a_grupo, id FROM  horw";
		$result0 = mysql_query($SQL0);

		while  ($row0 = mysql_fetch_array($result0))
		{
			if (is_numeric(substr($row0[0],0,1)))
			{
				$nivel0 = substr($row0[0], 0, 2);
				$grupo0 = substr($row0[0], 3, 1);
				$actualiza= "UPDATE horw SET nivel = '$nivel0', n_grupo = '$grupo0' where id = '$row0[1]'";
			}
			/* 	else {
			 $actualiza= "UPDATE horw SET nivel = '', n_grupo = '' where a_grupo = '$row0[0]'";
			 }*/
			mysql_query($actualiza);
		}
	}

	// Eliminamos el Recreo como 4ª Hora.
	$hora0 = "UPDATE  horw SET  hora =  'R' WHERE  hora = '4'";
	mysql_query($hora0);
	$hora4 = "UPDATE  horw SET  hora =  '4' WHERE  hora = '5'";
	mysql_query($hora4);
	$hora5 = "UPDATE  horw SET  hora =  '5' WHERE  hora = '6'";
	mysql_query($hora5);
	$hora6 = "UPDATE  horw SET  hora =  '6' WHERE  hora = '7'";
	mysql_query($hora6);
	mysql_query("OPTIMIZE TABLE  `horw`");

	// Metemos a los profes en la tabla profesores hasta que el horario se haya exportado a Séneca y consigamos los datos reales de los mismos
	$tabla_profes = mysql_query("select * from profesores");
	if (mysql_num_rows($tabla_profes) > 0) {}
	else{
		// Recorremos la tabla Profesores bajada de Séneca
		$pro = mysql_query("select distinct asig, a_grupo, prof from horw where a_grupo in (select distinct nomunidad from unidades) order by prof");
		while ($prf = mysql_fetch_array($pro)) {
			$materia = $prf[0];
			$grupo = $prf[1];
			$profesor = $prf[2];
			$niv = mysql_query("select distinct curso from alma where unidad = '$grupo'");
			$nive = mysql_fetch_array($niv);
			$nivel = $nive[0];

			mysql_query("INSERT INTO  profesores (
`nivel` ,
`materia` ,
`grupo` ,
`profesor`
) VALUES ('$nivel', '$materia', '$grupo', '$profesor')");
		}
	}


	// Cargos varios

	$carg = mysql_query("select distinct prof from horw");
	while ($cargo = mysql_fetch_array($carg)) {
		$cargos="";

		$profe_dep = mysql_query("select distinct c_asig from horw where prof = '$cargo[0]' and (a_grupo = '' or c_asig = '2' or c_asig = '279' or c_asig = '117')");
		while ($profe_dpt = mysql_fetch_array($profe_dep)) {
			if ($profe_dpt[0]=="44") {
				$cargos="1";
			}
			if ($profe_dpt[0]=="45") {
				$cargos.="4";
			}
			if ($profe_dpt[0]=="50") {
				$cargos.="8";
			}
			if ($profe_dpt[0]=="376") {
				$cargos.="a";
			}
			if ($profe_dpt[0]=="384") {
				$cargos.="9";
			}

			if ($profe_dpt[0]=="26") {
				$cargos.="c";
			}

			if ($profe_dpt[0]=="2") {
				$cargos.="2";
			}
		}
		// Tutores
		$tabla_tut = mysql_query("select * from FTUTORES where tutor = '$cargo[0]'");
		if(mysql_num_rows($tabla_tut) > 0){}
		else{
			if(strstr($cargos,"2")==TRUE)
			{
				mysql_query("insert into FTUTORES (unidad, tutor) select distinct a_grupo, prof from horw where c_asig like '2' and prof = '$cargo[0]' and prof in (select nombre from departamentos)");
			}
		}
		mysql_query("update departamentos set cargo = '$cargos' where nombre = '$cargo[0]'");
	}

	//Primera version de Profesores.
	$pr0 = mysql_query("select profesor from profesores");
	if (mysql_num_rows($pr0)>1) {}
	else{
		mysql_query("truncate table profesores");
		mysql_query("insert into profesores SELECT DISTINCT asignaturas.curso, asignaturas.nombre, a_grupo, prof FROM asignaturas, horw WHERE asignaturas.codigo = c_asig and abrev not like '%\_%'");
		mysql_query("truncate table reservas.profesores");
		mysql_query("insert into reservas.profesores SELECT DISTINCT alma.curso, asignaturas.nombre, a_grupo, prof FROM alma, asignaturas, horw WHERE alma.unidad = horw.a_grupo AND asignaturas.codigo = c_asig");
	}


	//
	// Creamos horw_faltas
	//
	mysql_query("create table horw_faltas select * from horw");

	// Eliminamos residuos y cambiamos alguna cosa.

	$sin = mysql_query("SELECT nombre FROM departamentos WHERE nombre not in (select profesor from profesores)");
	if(mysql_num_rows($sin) > "0"){
		while($sin_hor=mysql_fetch_array($sin))
		{
			$prof_sin.=" prof like '%$sin_hor[0]%' or";
		}
	}
	$prof_sin = " and ".substr($prof_sin,0,strlen($prof_sin)-3);

	// mysql_query("delete from horw_faltas where (1=1 $prof_sin or c_asig  like '118' or c_asig  like '117')");

	mysql_query("delete from horw_faltas where a_grupo = ''");

	// Cambiamos los numeros de Horw para dejarlos en orden alfabético.
	$hor = mysql_query("select distinct prof from horw order by prof");
	while($hor_profe = mysql_fetch_array($hor)){
		$np+=1;
		$sql = "update horw set no_prof='$np' where prof = '$hor_profe[0]'";
		$sql0 = "update horw_faltas set no_prof='$np' where prof = '$hor_profe[0]'";
		//echo "$sql<br>";
		$sql1 = mysql_query($sql);
		$sql2 = mysql_query($sq0);
	}

	mysql_query("OPTIMIZE TABLE  `horw_faltas`");

	// Copia del horario en Reservas
	mysql_query("DROP TABLE IF EXISTS  `reservas`.`horw`");

	mysql_query("create table reservas.horw select * from horw_faltas");


	echo '<p class="lead">Los datos han sido importados correctamente.</p>';

}

?></div>
</div>
<div class="col-sm-6">

<h3>Información sobre la importación</h3>

<p>Este módulo realiza dos funciones. En ambos casos es necesario tener a mano el archivo en formato XML que se
exporta desde Horwin para subir los horarios a Séneca.</p>
<p>
La primera función (<strong>Importar Horarios</strong>) incorpora el Horario de
los Profesores a la Base de datos y modifica los registros pbuscando la mayor
compatibilidad con Séneca. El resultado es la creación de la tabla <u>Horw</u> en la Base de datos. </p>

<p>La segunda función (<strong>Preparar archivo XML</strong>) se encarga de preparar el
archivo que crean los programas de Horarios (Horwin, etc.) para subirlo
a Séneca, evitando tener que registrar manualmente los horarios de cada
profesor. El resultado de esta operación es la descarga del
archivo modificado (<strong>Importacion_horarios_seneca.xml</strong>)
preparado para subir a Séneca.</p>

<p>La opción <strong>Modo Depuración </strong> sólo afecta a la preparación de la subidad de los horarios a Séneca. Permite ver los mensajes
de error y advertencias varias que afectan al horario de Horwin y podrían dar problemas con Séneca. También
presenta los cambios que se han realizado en el archivo
XML. Es conveniente echarle
un vistazo antes de subir los Horarios. Con esta opción
activada no se descarga ningún archivo, sólo se ven los problemas.</p>

</div>


</div>

</body>
</html>
