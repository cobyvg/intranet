<? 
if(!(file_exists("../config.php")) OR filesize("../config.php")<10){
$mens_bd = "No se encuentra el fichero de configuracion. Debes crearlo en primer lugar."; 
header("location:index.php?mens_bd=1");
exit;
}
else
{
?>
<?php
session_start();
include("../config.php");
?>
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet &middot; <? echo $nombre_del_centro; ?></title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del <? echo $nombre_del_centro; ?>">  
    <meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
      
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <script type="text/javascript" src="http://<? echo $dominio;?>/intranet/js/buscarAlumnos.js"></script>
</head>
<body>	
<?
// Conexion de datos
mysql_connect ($db_host, $db_user, $db_pass) or die('<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
No ha sido posible conectar con el Servidor de las Bases de datos. Esto quiere decir que los datos que has escrito en la página de configuración (usuario y contraseña para acceder al servidor MySql) no son correctos, o bien que el servidor de MySql no está activado en este momento. Corrige el error e inténtalo de nuevo.
          </div></div>');

// Creamos Base de dtos principal
mysql_query("CREATE DATABASE IF NOT EXISTS $db");
mysql_select_db ($db);

// Extructura de FALTAS

//
// Estructura de tabla para la tabla `absentismo`
//

mysql_query("CREATE TABLE IF NOT EXISTS `absentismo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claveal` varchar(12) NOT NULL DEFAULT '',
  `mes` char(2) NOT NULL DEFAULT '',
  `numero` bigint(21) NOT NULL DEFAULT '0',
  `nivel` varchar(5) DEFAULT NULL,
  `grupo` char(1) DEFAULT NULL,
  `jefatura` text,
  `tutoria` text,
  `orientacion` text,
  PRIMARY KEY (`id`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `actividadalumno`
//

mysql_query("CREATE TABLE IF NOT EXISTS `actividadalumno` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `claveal` varchar(12) NOT NULL DEFAULT '',
  `cod_actividad` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `actividades`
//

mysql_query("CREATE TABLE IF NOT EXISTS `actividades` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `grupos` varchar(156) NOT NULL DEFAULT '',
  `actividad` varchar(164) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `departamento` varchar(48) NOT NULL DEFAULT '',
  `profesor` varchar(196) NOT NULL DEFAULT '',
  `horario` varchar(64) NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `hoy` date NOT NULL DEFAULT '0000-00-00',
  `confirmado` tinyint(1) NOT NULL DEFAULT '0',
  `justificacion` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `almafaltas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `almafaltas` (
  `CLAVEAL` varchar(12) NOT NULL DEFAULT '',
  `NOMBRE` varchar(30) DEFAULT NULL,
  `APELLIDOS` varchar(40) DEFAULT NULL,
  `NIVEL` varchar(5) DEFAULT NULL,
  `GRUPO` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`CLAVEAL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");


// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `alumnos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `alumnos` (
  `nombre` varchar(71) DEFAULT NULL,
  `unidad` varchar(255) DEFAULT NULL,
  `claveal` varchar(8) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `AsignacionMesasTIC`
//

mysql_query("CREATE TABLE IF NOT EXISTS `AsignacionMesasTIC` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prof` varchar(50) NOT NULL DEFAULT '',
  `c_asig` varchar(6) NOT NULL DEFAULT '',
  `agrupamiento` varchar(50) NOT NULL DEFAULT '',
  `CLAVEAL` varchar(8) NOT NULL DEFAULT '',
  `no_mesa` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `prof` (`prof`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `asignaturas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `asignaturas` (
  `CODIGO` varchar(10) DEFAULT NULL,
  `NOMBRE` varchar(96) DEFAULT NULL,
  `ABREV` varchar(10) DEFAULT NULL,
  `CURSO` varchar(64) DEFAULT NULL,
  KEY `CODIGO` (`CODIGO`),
  KEY `ABREV` (`ABREV`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `ausencias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `ausencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor` varchar(64) NOT NULL DEFAULT '',
  `inicio` date NOT NULL DEFAULT '0000-00-00',
  `fin` date NOT NULL DEFAULT '0000-00-00',
  `horas` int(11) NOT NULL DEFAULT '0',
  `tareas` text NOT NULL,
  `ahora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `archivo` VARCHAR( 186 ) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `cal`
//

mysql_query("CREATE TABLE IF NOT EXISTS `cal` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `eventdate` date NOT NULL DEFAULT '0000-00-00',
  `html` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `event` text NOT NULL,
  `idact` varchar(32) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `eventdate` (`eventdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `calificaciones`
//

mysql_query("CREATE TABLE IF NOT EXISTS `calificaciones` (
  `codigo` varchar(5) NOT NULL DEFAULT '',
  `nombre` varchar(64) DEFAULT NULL,
  `abreviatura` varchar(4) DEFAULT NULL,
  `orden` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `cargos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `cargos` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `cargo` varchar(8) NOT NULL DEFAULT '0',
  KEY `dni` (`dni`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `categorias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(30) NOT NULL DEFAULT '',
  `apartado` varchar(30) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `competencias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `competencias` (
  `id` int(11) NOT NULL DEFAULT '0',
  `idc` int(1) NOT NULL DEFAULT '0',
  `claveal` int(12) NOT NULL DEFAULT '0',
  `materia` int(5) NOT NULL DEFAULT '0',
  `nota` varchar(10) NOT NULL DEFAULT '1',
  `fecha` datetime DEFAULT '0000-00-00 00:00:00',
  `profesor` varchar(48) NOT NULL DEFAULT '',
  `curso` varchar(7) NOT NULL DEFAULT '',
  `grupo` varchar(6) NOT NULL DEFAULT '',
  KEY `claveal` (`claveal`),
  KEY `materia` (`materia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `competencias_lista`
//

mysql_query("CREATE TABLE IF NOT EXISTS `competencias_lista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL DEFAULT '',
  `abreviatura` varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `convivencia`
//

mysql_query("CREATE TABLE IF NOT EXISTS `convivencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claveal` int(8) NOT NULL DEFAULT '0',
  `dia` int(1) NOT NULL DEFAULT '0',
  `hora` int(1) NOT NULL DEFAULT '0',
  `trabajo` int(1) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `c_profes`
//

mysql_query("CREATE TABLE IF NOT EXISTS `c_profes` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `pass` varchar(48) DEFAULT NULL,
  `PROFESOR` varchar(48) DEFAULT NULL,
  `dni` varchar(9) NOT NULL DEFAULT '',
  `idea` varchar(12) NOT NULL DEFAULT '',
  `correo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `PROFESOR` (`PROFESOR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// Usuario admin y conntraseña
$ya_adm = mysql_query("select * from c_profes, departamentos where departamentos.idea = c_profes.idea and (c_profes.PROFESOR='admin' or departamentos.cargo='%1%')");
if (mysql_num_rows($ya_adm)>0) {
}
else {
$adm=sha1("12345678");
mysql_query("INSERT INTO c_profes ( `pass` , `PROFESOR` , `dni`, `idea` )
VALUES (
'$adm', 'admin', '12345678', 'admin'
);");
}


// Conserjes 
if($num_conserje > '0')
{
mysql_select_db($db);
for($i=1;$i<$num_conserje+1;$i++)
{
$conserje = ${'conserje'.$i};
$dnic = ${'dnic'.$i};
mysql_query("insert into c_profes (profesor, dni, pass, idea) values ('$conserje', '$dnic', '$dnic','$conserje')");
}
}
// y Administrativos
if($num_administ > '0')
{
mysql_select_db($db);
for($i=1;$i<$num_administ+1;$i++)
{
$administ = ${'administ'.$i};
$dnia = ${'dnia'.$i};
$idea = ${'idea'.$i};
mysql_query("insert into c_profes (profesor, dni, pass, idea) values ('$administ', '$dnia', '$dnia', '$idea')");
}
}

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `datos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `datos` (
  `id` int(4) NOT NULL DEFAULT '0',
  `nota` varchar(5) NOT NULL DEFAULT '',
  `ponderacion` char(3) DEFAULT NULL,
  `claveal` varchar(12) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `departamentos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `departamentos` (
  `NOMBRE` varchar(48) NOT NULL DEFAULT '',
  `DNI` varchar(10) NOT NULL DEFAULT '',
  `DEPARTAMENTO` varchar(48) NOT NULL DEFAULT '',
  `CARGO` varchar(5) DEFAULT NULL,
  `idea` varchar(12) NOT NULL DEFAULT '',
  KEY `NOMBRE` (`NOMBRE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");


// Usuario admin y conntraseña
$ya_adm = mysql_query("select * from c_profes, departamentos where departamentos.idea = c_profes.idea and (c_profes.PROFESOR='admin' or departamentos.cargo='%1%')");
if (mysql_num_rows($ya_adm)>0) {
}
else {
mysql_query("insert into departamentos (nombre, dni, departamento, cargo, idea) values ('admin', '12345678', 'Admin', '1', 'admin')");
}

// Conserjes y Administrativos
if($num_conserje > '0')
{
mysql_query("delete from departamentos where cargo like '%6%'");
mysql_select_db($db);
for($i=1;$i<$num_conserje+1;$i++)
{
$conserje = ${'conserje'.$i};
$dnic = ${'dnic'.$i};
mysql_query("insert into departamentos (nombre, dni, departamento, cargo, idea) values ('$conserje', '$dnic', 'Conserjeria', '6', '$conserje')");
}
}
if($num_administ > '0')
{
mysql_query("delete from departamentos where cargo like '%7%'");
mysql_select_db($db);
for($i=1;$i<$num_administ+1;$i++)
{
$administ = ${'administ'.$i};
$idea = ${'idea'.$i};
$dnia = ${'dnia'.$i};
mysql_query("insert into departamentos (nombre, dni, departamento, cargo, idea) values ('$administ', '$dnia', 'Administracion', '7', '$idea')");
}
}

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `direcciones`
//

mysql_query("CREATE TABLE IF NOT EXISTS `direcciones` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(30) NOT NULL DEFAULT '',
  `apartado` varchar(30) NOT NULL DEFAULT '',
  `nombre` varchar(60) NOT NULL DEFAULT '',
  `http` varchar(200) NOT NULL DEFAULT '',
  `comentario` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `FALTAS`
//

mysql_query("CREATE TABLE IF NOT EXISTS `FALTAS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CLAVEAL` varchar(8) NOT NULL DEFAULT '',
  `NIVEL` char(2) DEFAULT NULL,
  `GRUPO` char(1) DEFAULT NULL,
  `NC` tinyint(2) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `DIA` tinyint(1) NOT NULL DEFAULT '0',
  `HORA` tinyint(1) DEFAULT NULL,
  `PROFESOR` char(2) DEFAULT NULL,
  `CODASI` varchar(5) DEFAULT NULL,
  `FALTA` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NIVEL` (`NIVEL`),
  KEY `GRUPO` (`GRUPO`),
  KEY `NC` (`NC`),
  KEY `FECHA` (`FECHA`),
  KEY `FALTA` (`FALTA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `FALTASJ`
//

mysql_query("CREATE TABLE IF NOT EXISTS `FALTASJ` (
  `fecha` date DEFAULT NULL,
  `claveal` varchar(8) NOT NULL DEFAULT '',
  KEY `claveal` (`claveal`),
  KEY `fecha` (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

//
// Estructura de tabla para la tabla `FALUMNOS`
//

mysql_query("CREATE TABLE IF NOT EXISTS `FALUMNOS` (
  `CLAVEAL` char(12) NOT NULL DEFAULT '',
  `NC` double DEFAULT NULL,
  `APELLIDOS` char(30) DEFAULT NULL,
  `NOMBRE` char(24) DEFAULT NULL,
  `NIVEL` char(5) DEFAULT NULL,
  `GRUPO` char(1) DEFAULT NULL,
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `NC` (`NC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `FechCaduca`
//

mysql_query("CREATE TABLE IF NOT EXISTS `FechCaduca` (
  `id` int(11) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `dias` int(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `Fechoria`
//

mysql_query("CREATE TABLE IF NOT EXISTS `Fechoria` (
  `CLAVEAL` varchar(12) NOT NULL DEFAULT '',
  `FECHA` date NOT NULL DEFAULT '0000-00-00',
  `ASUNTO` text NOT NULL,
  `NOTAS` text NOT NULL,
  `INFORMA` varchar(48) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grave` varchar(10) NOT NULL DEFAULT '',
  `medida` varchar(148) NOT NULL DEFAULT '',
  `expulsion` tinyint(2) NOT NULL DEFAULT '0',
  `inicio` date DEFAULT '0000-00-00',
  `fin` date DEFAULT '0000-00-00',
  `tutoria` text,
  `expulsionaula` tinyint(1) DEFAULT NULL,
  `enviado` char(1) NOT NULL DEFAULT '1',
  `recibido` char(1) NOT NULL DEFAULT '0',
  `aula_conv` tinyint(1) DEFAULT '0',
  `inicio_aula` date DEFAULT NULL,
  `fin_aula` date DEFAULT NULL,
  `horas` int(11) DEFAULT '123456',
  `confirmado` tinyint(1) DEFAULT NULL,
  `tareas` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `FECHA` (`FECHA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `festivos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `festivos` (
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `nombre` varchar(64) NOT NULL DEFAULT '',
  `docentes` char(2) NOT NULL DEFAULT '',
  `ambito` varchar(10) NOT NULL DEFAULT '',
  KEY `fecha` (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `fotocopias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `fotocopias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(48) NOT NULL DEFAULT '',
  `numero` int(11) NOT NULL DEFAULT '0',
  `observaciones` text NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `FTUTORES`
//

mysql_query("CREATE TABLE IF NOT EXISTS `FTUTORES` (
  `NIVEL` char(3) NOT NULL DEFAULT '',
  `GRUPO` char(1) NOT NULL DEFAULT '',
  `TUTOR` varchar(48) NOT NULL DEFAULT '',
  `observaciones1` text NOT NULL,
  `observaciones2` text NOT NULL,
  KEY `TUTOR` (`TUTOR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `grupos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `profesor` varchar(48) NOT NULL DEFAULT '',
  `asignatura` int(6) NOT NULL DEFAULT '0',
  `curso` varchar(5) NOT NULL DEFAULT '',
  `alumnos` varchar(124) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `guardias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `guardias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor` varchar(64) NOT NULL DEFAULT '',
  `profe_aula` varchar(64) NOT NULL DEFAULT '',
  `dia` tinyint(1) NOT NULL DEFAULT '0',
  `hora` tinyint(1) NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_guardia` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `hermanos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `hermanos` (
  `telefono` varchar(255) DEFAULT NULL,
  `telefonourgencia` varchar(255) DEFAULT NULL,
  `hermanos` bigint(21) NOT NULL DEFAULT '0',
  KEY `telefono` (`telefono`),
  KEY `telefonourgencia` (`telefonourgencia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `horw`
//

mysql_query("CREATE TABLE IF NOT EXISTS `horw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` char(1) NOT NULL DEFAULT '',
  `hora` char(1) NOT NULL DEFAULT '',
  `a_asig` varchar(8) NOT NULL DEFAULT '',
  `asig` varchar(64) NOT NULL DEFAULT '',
  `c_asig` varchar(30) NOT NULL DEFAULT '',
  `prof` varchar(50) NOT NULL DEFAULT '',
  `no_prof` tinyint(4) DEFAULT NULL,
  `c_prof` varchar(30) NOT NULL DEFAULT '',
  `a_aula` varchar(5) NOT NULL DEFAULT '',
  `n_aula` varchar(64) NOT NULL DEFAULT '',
  `a_grupo` varchar(10) NOT NULL DEFAULT '',
  `nivel` varchar(10) NOT NULL DEFAULT '',
  `n_grupo` varchar(10) NOT NULL DEFAULT '',
  `clase` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `prof` (`prof`),
  KEY `c_asig` (`c_asig`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `horw_faltas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `horw_faltas` (
  `id` int(11) NOT NULL DEFAULT '0',
  `dia` char(1) NOT NULL DEFAULT '',
  `hora` char(1) NOT NULL DEFAULT '',
  `a_asig` varchar(8) NOT NULL DEFAULT '',
  `asig` varchar(64) NOT NULL DEFAULT '',
  `c_asig` varchar(30) NOT NULL DEFAULT '',
  `prof` varchar(50) NOT NULL DEFAULT '',
  `no_prof` tinyint(4) DEFAULT NULL,
  `c_prof` varchar(30) NOT NULL DEFAULT '',
  `a_aula` varchar(5) NOT NULL DEFAULT '',
  `n_aula` varchar(64) NOT NULL DEFAULT '',
  `a_grupo` varchar(10) NOT NULL DEFAULT '',
  `nivel` varchar(10) NOT NULL DEFAULT '',
  `n_grupo` varchar(10) NOT NULL DEFAULT '',
  `clase` varchar(16) NOT NULL DEFAULT '',
  KEY `prof` (`prof`),
  KEY `c_asig` (`c_asig`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `infotut_alumno`
//

mysql_query("CREATE TABLE IF NOT EXISTS `infotut_alumno` (
  `ID` smallint(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `CLAVEAL` varchar(12) NOT NULL DEFAULT '',
  `APELLIDOS` varchar(30) NOT NULL DEFAULT '',
  `NOMBRE` varchar(24) NOT NULL DEFAULT '',
  `NIVEL` varchar(5) NOT NULL DEFAULT '',
  `GRUPO` char(1) NOT NULL DEFAULT '',
  `F_ENTREV` date NOT NULL DEFAULT '0000-00-00',
  `TUTOR` varchar(40) NOT NULL DEFAULT '',
  `FECHA_REGISTRO` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`ID`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `APELLIDOS` (`APELLIDOS`),
  KEY `NOMBRE` (`NOMBRE`),
  KEY `NIVEL` (`NIVEL`),
  KEY `CURSO` (`GRUPO`),
  KEY `F_ENTREV` (`F_ENTREV`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `infotut_profesor`
//

mysql_query("CREATE TABLE IF NOT EXISTS `infotut_profesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumno` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(48) NOT NULL DEFAULT '',
  `asignatura` varchar(64) NOT NULL DEFAULT '',
  `informe` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_alumno` (`id_alumno`,`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `inventario`
//

mysql_query("CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase` varchar(48) NOT NULL DEFAULT '',
  `lugar` varchar(48) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `marca` varchar(32) NOT NULL DEFAULT '',
  `modelo` varchar(48) NOT NULL DEFAULT '',
  `serie` varchar(24) NOT NULL DEFAULT '',
  `unidades` int(11) NOT NULL DEFAULT '0',
  `fecha` varchar(10) NOT NULL DEFAULT '',
  `ahora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `departamento` varchar(48) NOT NULL DEFAULT '',
  `profesor` varchar(48) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `inventario_clases`
//

mysql_query("CREATE TABLE IF NOT EXISTS `inventario_clases` (
  `id` int(11) NOT NULL auto_increment,
  `familia` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  `clase` varchar(64) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

mysql_query("INSERT INTO `inventario_clases` (`id`, `familia`, `clase`) VALUES 
(0, 'Mobiliario', 'Amarios'),
(3, 'Mobiliario', 'Estanterías'),
(5, 'Mobiliario', 'Sillas'),
(6, 'Mobiliario', 'Mesas'),
(7, 'Mobiliario', 'Pupitre'),
(8, 'Mobiliario', 'Mesas profesorado '),
(9, 'Mobiliario', 'Otras mesas'),
(10, 'Mobiliario', 'Ficheros y archivadores'),
(11, 'Mobiliario', 'Pizarras'),
(12, 'Mobiliario', 'Otros'),
(13, 'Informática y comunicaciones', 'Ordenador'),
(14, 'Informática y comunicaciones', 'Monitor'),
(15, 'Informática y comunicaciones', 'Impresora'),
(16, 'Informática y comunicaciones', 'Escáner'),
(17, 'Informática y comunicaciones', 'Grabadoras de CD'),
(18, 'Informática y comunicaciones', 'DVD'),
(19, 'Informática y comunicaciones', 'Telefono'),
(20, 'Informática y comunicaciones', 'Router'),
(21, 'Informática y comunicaciones', 'Switch'),
(22, 'Informática y comunicaciones', 'Otros'),
(23, 'Material Audiovisual', 'Proyector de diapositivas'),
(24, 'Material Audiovisual', 'Altavoces'),
(25, 'Material Audiovisual', 'Reproductor de video'),
(26, 'Material Audiovisual', 'Proyector de video'),
(27, 'Material Audiovisual', 'Reproductor de música'),
(28, 'Material Audiovisual', 'Micrófono'),
(29, 'Material Audiovisual', 'Cámara fotográfica'),
(30, 'Material Audiovisual', 'Cámara de Vídeo'),
(31, 'Material Audiovisual', 'Otros'),
(32, 'Material de laboratorio, talleres y departamentos', 'Mapas y cartografía'),
(33, 'Material de laboratorio, talleres y departamentos', 'Material variado'),
(34, 'Material deportivo', 'Porterías'),
(35, 'Material deportivo', 'Canastas'),
(36, 'Material deportivo', 'Colchonetas'),
(37, 'Material deportivo', 'Vallas'),
(38, 'Material deportivo', 'Otros'),
(39, 'Material de papelería y oficina', 'Varios'),
(40, 'Botiquín y material de farmacia', 'Varios'),
(41, 'Extintores y material de autoprotección', 'Normales'),
(42, 'Extintores y material de autoprotección', 'Polvo seco (CO2)'),
(43, 'Extintores y material de autoprotección', 'Otros'),
(44, 'Equipos de seguridad', 'Cámaras'),
(45, 'Equipos de seguridad', 'Sensores'),
(46, 'Equipos de seguridad', 'Sirenas y timbres'),
(47, 'Equipos de seguridad', 'Otros'),
(48, 'Otros', 'Varios')");

mysql_query("CREATE TABLE  IF NOT EXISTS `inventario_lugares` (
  `id` int(11) NOT NULL auto_increment,
  `lugar` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE latin1_spanish_ci");

mysql_query("INSERT INTO `inventario_lugares` (`id`, `lugar`) VALUES 
(1, 'Aulas planta baja ed. Antiguo.'),
(2, 'Aulas 1ª planta ed. Antiguo'),
(3, 'Aulas 2ª planta ed. Antiguo'),
(4, 'Aulas módulo bachillerato '),
(5, 'Aulas módulo nuevo'),
(6, 'Audiovisuales 1'),
(7, 'Audiovisuales 2'),
(8, 'Biblioteca'),
(9, 'Bar - Cafetería'),
(10, 'Laboratorio o Taller de Especialidad'),
(11, 'Gimnasio'),
(12, 'Carrito Nº'),
(13, 'Departamento'),
(14, 'Despacho'),
(15, 'Aseos'),
(16, 'Zona Patios'),
(17, 'Almacen'),
(18, 'Otros'),
(19, 'Conserjería'),
(20, 'Conserjería')");

//
// Estructura de tabla para la tabla `listafechorias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `listafechorias` (
  `ID` int(4) NOT NULL DEFAULT '0',
  `fechoria` varchar(255) DEFAULT NULL,
  `medidas` varchar(64) DEFAULT NULL,
  `medidas2` mediumtext,
  `tipo` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// Datos de listafechorias

mysql_query("INSERT INTO `listafechorias` (`ID`, `fechoria`, `medidas`, `medidas2`, `tipo`) VALUES 
(2, 'La falta de puntualidad en la entrada a clase', 'Amonestación oral', 'El alumno siempre entrará en el aula. Caso de ser reincidente, se contactará con la familia y se le comunicará al tutor', 'leve'),
(4, 'La falta de asistencia a clase', 'Llamada telefónica. Comunicación escrita', 'Se contactará con la familia para comunicar el hecho (teléfono o SMS) Grabación de la falta en el módulo informático.  Caso de reincidencia, seguir el protocolo: a) comunicación escrita, b)acuse de recibo, c) traslado del caso a Asuntos Sociales', 'leve'),
(6, 'Llevar gorra, capucha, etc en el interior del edificio', 'Amonestación oral', 'Hacer que el alumno se quite la gorra o capucha, llegando, si es preciso, a requisar gorra y entregar en Jefatura para que la retire al final de la jornada.', 'leve'),
(8, 'Llevar ropa indecorosa en el Centro', 'Amonestación oral. Llamada telefónica.', 'Contactar con la familia para que aporte ropa adecuada o traslade al alumno/a a su domicilio para el oportuno cambio de indumentaria.', 'leve'),
(12, 'Mascar chicle en clase', 'Amonestación oral', 'Que tire el chicle a la papelera', 'leve'),
(13, 'Llevar teléfono móvil, cámara, aparatos de sonido, etc en el Centro', 'Amonestación oral', 'Requisar el aparato y entregar en Jefatura para que sea retirado por la familia.', 'leve'),
(14, 'Arrojar al suelo papeles o basura en general', 'Amonestación oral', 'Hacer que se retiren los objetos.  Ningún profesor permitirá que el aula esté sucia. Si es así, obligar al alumnado a la limpieza oportuna.', 'leve'),
(16, 'Hablar en clase', 'Amonestación oral', 'Cambiar al alumno de sitio, o aislarlo en el aula o, si es reincidente,  sancionarlo con pérdida de', 'leve'),
(18, 'Lanzar objetos, sin peligrosidad o agresividad, a un compañero', 'Amonestación oral', 'Hacer que el compañero le devuelva el objeto, que el alumno solicite permiso al profesor para que éste le permita, levantándose, entregar el objeto a su compañero.', 'leve'),
(20, 'No traer el material exigido para el desarrollo de una clase', 'Amonestación oral', 'Si reincide, contactar telefónicamente con la familia para que le aporte el material. Caso de existir alguna causa social que impida que el alumno tenga el material, solicitar la colaboración del centro o de las instituciones sociales oportunas.', 'leve'),
(22, 'No realizar las actividades encomendadas por el profesor', 'Amonestación oral', 'Contactar con la familia.', 'leve'),
(23, 'Beber o comer en el aula, en el transcurso de una clase', 'Amonestación oral', 'Obligar a que guarde la bebida o la arroje a la basura.', 'leve'),
(24, 'Comer en el aula', 'Amonestación oral', 'Obligar a que guarde la comida.', 'leve'),
(25, 'Permanecer en el pasillo entre clase y clase', 'Amonestación oral', 'Repercutir la acción en su evaluación académica.', 'leve'),
(26, 'Falta de cuidado, respeto y protección de los recursos personales o del Centro', 'Amonestación oral', 'Pedir disculpas públicamente y resarcir del posible daño a la persona o institución afectada.', 'leve'),
(27, 'Interrumpir la clase indebidamente', 'Amonestación oral', 'Cambiar al alumno de sitio, o aislarlo en el aula o, si es reincidente,  sancionarlo con pérdida de recreo o permaneciendo en el aula algunos minutos al final de la jornada o  viniendo el lunes por la tarde.', 'leve'),
(29, 'No realizar aquellas tareas que son planteadas en las distintas asignaturas', 'Amonestación oral', 'Contactar con la familia.', 'leve'),
(31, 'Faltas reiteradas de puntualidad o asistencia que no estén justificadas', 'Amonestación escrita', 'Seguir protocolo: a) Llamada telefónica a la familia b) Escrito a la familia c) Escrito certificado con acuse de recibo a la familia d) Traslado del caso a Asuntos Sociales.', 'grave'),
(32, 'Conductas graves que impidan o dificulten a otros compañeros el ejercicio del estudio', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase (medida extraordinaria). El tutor tratará el caso con Jefatura  para adoptar medidas.', 'grave'),
(34, 'Actos graves de incorrección con los miembros del Centro', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase  (medida extraordinaria que debe ir acompañada con escrito del profesor a los padres). La petición de excusas se considerará un atenuante a valorar. El tutor tratará el caso con la familia y propondrá a Jefatura medidas a adoptar.', 'grave'),
(36, 'Actos graves de indisciplina que perturben el desarrollo normal de las actividades', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); expulsarlo de clase (medida extraordinaria que debe ir acompañada con escrito del profesor a los padres). El tutor tratará el caso con la familia y propondrá a Jefatura medidas a adoptar.', 'grave'),
(38, 'Causar daños leves intencionados en las instalaciones o el material del centro', 'Amonestación escrita', 'El tutor tratará el caso con la familia y el alumno y familia realizará trabajos complementarios para la comunidad y  restaurará los daños o pagará los gastos de reparación.', 'grave'),
(39, 'Causar daños intencionadamente en las pertenencias de los miembros del Centro', 'Amonestación escrita', 'El tutor tratará el caso con la familia y el alumno y familia realizará trabajos complementarios para la comunidad y  restaurará los daños o pagará los gastos de reparación o restitución.', 'grave'),
(40, 'Incitación o estímulo a la comisión de una falta contraria a las Normas de Convivencia', 'Amonestación escrita', 'El tutor tratará el caso con la familia y propondrá a Jefatura las medidas correctoras a adoptar.', 'grave'),
(41, 'Reiteración en el mismo trimestre de cinco o más faltas leves', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(42, 'Incumplimiento de la sanción impuesta por la Dirección del Centro por una falta leve', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(45, 'Grabación, a través de cualquier medio, de miembros del Centro sin su autorización', 'Amonestación escrita', 'Entrega de la grabación y posibles copias en Jefatura de Estudios. Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(47, 'Abandonar el Centro sin autorización antes de concluir el horario escolar', 'Amonestación escrita', 'Comunicación urgente con la familia.  Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(49, 'Fumar en el Centro (tanto en el interior del edificio como en los patios)', 'Amonestación escrita', 'Comunicación urgente con la familia.  Entrega de trabajo relacionado con tabaco y salud. Si es reincidente, imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(51, 'Mentir o colaborar para encubrir faltas propias o ajenas', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(52, 'Cualquier incorrección de igual gravedad que no constituya falta muy grave', 'Amonestación escrita', 'Imponer correcciones como: pérdida de recreo; quedarse algunos minutos al final del periodo lectivo; obligarlo a que venga por la tarde (lunes); realizar trabajos para la comunidad; o estancia en el Aula de Convivencia entre 1 y 3 días.', 'grave'),
(54, 'Actos graves de indisciplina, insultos o falta de respeto con los Profesores y personal del centro', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente.', 'grave'),
(55, 'Las injurias y ofensas contra cualquier miembro de la comunidad educativa', 'Amonestación escrita', 'Petición publica de disculpas. Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente', 'muy grave'),
(56, 'El acoso físico o moral a los compañeros', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer correcciones como: estancia en el Aula de Convivencia varios días; o expulsión del centro entre 1 y 29  dependiendo de la gravedad', 'muy grave'),
(58, 'Amenazas o coacciones contra cualquier miembro de la comunidad educativa', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer correcciones como: estancia en el Aula de Convivencia varios días; o expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(61, 'Uso de la violencia, ofensas y actos que atenten contra la intimidad o dignidad de los miembros del Centro', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(63, 'Discriminación a cualquier miembro del centro, por razón de raza, sexo, religión, orientación sexual, etc.', 'Amonestación escrita', 'Petición publica de disculpas y comunicación con la familia. Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(65, 'Grabación, publicidad o difusión de agresiones o humillaciones cometidas contra miembros del centro', 'Amonestación escrita', 'Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(66, 'Daños graves causados en las instalaciones, materiales y documentos del centro, o en las pertenencias de sus miembros', 'Amonestación escrita', 'Jefatura de Estudios tratará el caso con la familia y el alumno y familia realizará trabajos complementarios para la comunidad y  restaurará los daños o pagará los gastos de reparación o restitución.', 'muy grave'),
(67, 'Suplantación de personalidad en actos de la vida docente y la falsificación o sustracción de documentos académicos', 'Amonestación escrita', 'Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.) Imponer expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(68, 'Uso, incitación al mismo o introducción en el centro de sustancias perjudiciales para la salud', 'Amonestación escrita', 'Si el hecho es grave, iniciar los trámites legales oportunos (Asuntos Sociales, Policía Nacional, etc.).  Entrega de trabajo relacionado con el hecho y la salud. Imponer sanción de estancia en el Aula de Convivencia o  expulsión del centro entre 1 y 29 dependiendo de la gravedad.', 'muy grave'),
(70, 'Perturbación grave del desarrollo de las actividades y cualquier incumplimiento grave de las normas de conducta', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad.', 'muy grave'),
(71, 'La reiteración en el mismo trimestre de tres o más faltas graves', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente.', 'muy grave'),
(72, 'El incumplimiento de la sanción impuesta por la Dirección por una falta grave', 'Amonestación escrita', 'Imponer correcciones como: estancia en el Aula de Convivencia varios días; o expulsión del centro entre 4 y 29 días, según gravedad del hecho.', 'muy grave'),
(73, 'Asistir al centro o a actividades programadas por el Centro en estado de embriaguez o drogado', 'Amonestación escrita', 'Jefatura de Estudios tratará el caso con la familia y el alumno.  Trabajo sobre el hecho y la salud. Derivar el caso a Dep. Orientación o Asuntos Sociales si es grave. Imponer correcciones como: estancia en el Aula de Convivencia varios días; expulsión del centro entre 1 y 3 días o entre 4 y 29 si es reincidente', 'muy grave'),
(76, 'Cometer actos delictivos penados por nuestro Sistema Jurídico', 'Amonestación escrita', 'Jefatura tratará el caso con la familia y, si es grave, denunciar en la Policía. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave'),
(78, 'Cometer o encubrir hurtos', 'Amonestación escrita', 'Jefatura tratará el caso con la familia. Proceder a la devolución de lo hurtado.  Realización por parte del alumno y la familia de  trabajos para la comunidad.', 'muy grave'),
(79, 'Promover el uso de bebidas alcohólicas, sustancias psicotrópicas y material pornográfico', 'Amonestación escrita', 'Jefatura tratará el caso con la familia y, si es grave, denunciar en la Policía. Traslado del caso al Dep. de Orientación o Asuntos Sociales. Trabajo sobre hábitos saludables. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave'),
(81, 'Cualquier acto grave dirigido directamente a impedir el normal desarrollo de las actividades', 'Amonestación escrita', 'Jefatura tratará el caso con la familia. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave'),
(82, 'No realizar las tareas encomendadas durante el periodo de expulsión', 'Amonestación escrita', 'Jefatura tratará el caso con la familia. Imponer correcciones como: estancia en el Aula de Convivencia varios días; estancia de un familiar en el aula, con el alumno, durante varios días; o expulsión del centro entre 1 y 29 días en función de la gravedad', 'muy grave')");


// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `maquinas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `maquinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lugar` char(3) NOT NULL DEFAULT '',
  `serie` varchar(15) NOT NULL DEFAULT '',
  `numero` int(2) DEFAULT NULL,
  `observaciones` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `materias`
//

mysql_query("CREATE TABLE IF NOT EXISTS `materias` (
  `CODIGO` varchar(10) DEFAULT NULL,
  `NOMBRE` varchar(64) DEFAULT NULL,
  `ABREV` varchar(10) DEFAULT NULL,
  `CURSO` varchar(64) DEFAULT NULL,
  `GRUPO` varchar(6) DEFAULT NULL,
  KEY `CODIGO` (`CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `mensajes`
//

mysql_query("CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dni` varchar(10) NOT NULL DEFAULT '',
  `claveal` int(12) NOT NULL DEFAULT '0',
  `asunto` text NOT NULL,
  `texto` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `recibidotutor` tinyint(1) NOT NULL DEFAULT '0',
  `recibidopadre` tinyint(1) NOT NULL DEFAULT '0',
  `correo` varchar(72) DEFAULT NULL,
  `nivel` char(2) NOT NULL DEFAULT '',
  `grupo` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `mens_profes`
//

mysql_query("CREATE TABLE IF NOT EXISTS `mens_profes` (
  `id_profe` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_texto` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(42) NOT NULL DEFAULT '0',
  `recibidoprofe` tinyint(1) NOT NULL DEFAULT '0',
  `recibidojefe` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_profe`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `mens_texto`
//

mysql_query("CREATE TABLE IF NOT EXISTS `mens_texto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `origen` varchar(42) NOT NULL DEFAULT '0',
  `asunto` text NOT NULL,
  `texto` text NOT NULL,
  `destino` text NOT NULL,
  `oculto` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `profesor` (`origen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `nombres_maquinas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `nombres_maquinas` (
  `IP` varchar(18) DEFAULT NULL,
  `MAC` varchar(24) DEFAULT NULL,
  `NOMBRE` varchar(24) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `notas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `notas` (
  `claveal` varchar(12) NOT NULL DEFAULT '0',
  `notas1` varchar(200) DEFAULT NULL,
  `notas2` varchar(200) DEFAULT NULL,
  `notas3` varchar(200) DEFAULT NULL,
  `notas4` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `notas_cuaderno`
//

mysql_query("CREATE TABLE IF NOT EXISTS `notas_cuaderno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor` varchar(48) NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `nombre` varchar(64) NOT NULL DEFAULT '',
  `texto` text NOT NULL,
  `texto_pond` text NOT NULL,
  `asignatura` int(6) NOT NULL DEFAULT '0',
  `curso` varchar(36) NOT NULL DEFAULT '',
  `oculto` tinyint(1) NOT NULL DEFAULT '0',
  `visible_nota` int(1) NOT NULL DEFAULT '0',
  `orden` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `partestic`
//

mysql_query("CREATE TABLE IF NOT EXISTS `partestic` (
  `parte` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nivel` varchar(4) DEFAULT NULL,
  `grupo` char(1) DEFAULT NULL,
  `carro` char(2) DEFAULT NULL,
  `nserie` varchar(15) NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `hora` char(2) DEFAULT '',
  `alumno` varchar(35) DEFAULT NULL,
  `profesor` varchar(64) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `estado` varchar(12) NOT NULL DEFAULT 'activo',
  `nincidencia` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`parte`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `profes`
//

mysql_query("CREATE TABLE IF NOT EXISTS `noticias` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `slug` text NOT NULL,
  `content` text NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `clase` varchar(48) DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `pagina` TINYINT(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `profesores`
//

mysql_query("CREATE TABLE IF NOT EXISTS `profesores` (
  `nivel` varchar(255) DEFAULT NULL,
  `materia` varchar(255) DEFAULT NULL,
  `grupo` varchar(255) DEFAULT NULL,
  `profesor` varchar(255) DEFAULT NULL,
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `recursos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `recursos` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(32) NOT NULL DEFAULT '',
  `departamento` varchar(24) NOT NULL DEFAULT '',
  `subclase` varchar(64) DEFAULT NULL,
  `profesor` varchar(32) NOT NULL DEFAULT '',
  `titulo` varchar(128) NOT NULL DEFAULT '',
  `direccion` varchar(128) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `nivel` varchar(48) DEFAULT NULL,
  `asignatura` varchar(32) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `reg_intranet`
//

mysql_query("CREATE TABLE IF NOT EXISTS `reg_intranet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor` varchar(48) NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `reg_paginas`
//

mysql_query("CREATE TABLE IF NOT EXISTS `reg_paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reg` int(11) NOT NULL DEFAULT '0',
  `pagina` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reg` (`id_reg`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `reg_principal`
//

mysql_query("CREATE TABLE IF NOT EXISTS `reg_principal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pagina` text NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `dni` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `sistcal`
//

mysql_query("CREATE TABLE IF NOT EXISTS `sistcal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sistcal` varchar(5) NOT NULL DEFAULT '',
  `codigo` varchar(5) NOT NULL DEFAULT '',
  `nota` varchar(72) DEFAULT NULL,
  `abrev` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `sms`
//

mysql_query("CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `telefono` text NOT NULL,
  `mensaje` varchar(160) NOT NULL DEFAULT '',
  `profesor` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `tareas_alumnos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `tareas_alumnos` (
  `ID` smallint(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `CLAVEAL` varchar(12) NOT NULL DEFAULT '',
  `APELLIDOS` varchar(30) NOT NULL DEFAULT '',
  `NOMBRE` varchar(24) NOT NULL DEFAULT '',
  `NIVEL` varchar(5) NOT NULL DEFAULT '',
  `GRUPO` char(1) NOT NULL DEFAULT '',
  `FECHA` date NOT NULL DEFAULT '0000-00-00',
  `FIN` date NOT NULL DEFAULT '0000-00-00',
  `DURACION` smallint(2) NOT NULL DEFAULT '3',
  `PROFESOR` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `CLAVEAL` (`CLAVEAL`),
  KEY `APELLIDOS` (`APELLIDOS`),
  KEY `NOMBRE` (`NOMBRE`),
  KEY `NIVEL` (`NIVEL`),
  KEY `CURSO` (`GRUPO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `tareas_profesor`
//

mysql_query("CREATE TABLE IF NOT EXISTS `tareas_profesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumno` int(11) NOT NULL DEFAULT '0',
  `profesor` varchar(48) NOT NULL DEFAULT '',
  `asignatura` varchar(64) NOT NULL DEFAULT '',
  `tarea` text NOT NULL,
  `confirmado` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_alumno` (`id_alumno`,`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `Textos`
//

mysql_query("
CREATE TABLE IF NOT EXISTS `Textos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Autor` varchar(128) DEFAULT NULL,
  `Titulo` varchar(128) NOT NULL DEFAULT '',
  `Editorial` varchar(64) NOT NULL DEFAULT '',
  `Nivel` varchar(64) NOT NULL DEFAULT '',
  `Grupo` varchar(10) NOT NULL DEFAULT '',
  `Notas` text,
  `Departamento` varchar(48) NOT NULL DEFAULT '',
  `Asignatura` varchar(48) NOT NULL DEFAULT '',
  `Obligatorio` varchar(12) NOT NULL DEFAULT '',
  `Clase` varchar(8) NOT NULL DEFAULT 'Texto',
  `isbn` varchar(18) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `textos_alumnos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `textos_alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claveal` int(12) NOT NULL DEFAULT '0',
  `materia` int(5) NOT NULL DEFAULT '0',
  `estado` char(1) NOT NULL DEFAULT '',
  `devuelto` char(1) DEFAULT '0',
  `fecha` datetime DEFAULT '0000-00-00 00:00:00',
  `curso` varchar(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `textos_gratis`
//

mysql_query("CREATE TABLE IF NOT EXISTS `textos_gratis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `materia` varchar(64) NOT NULL DEFAULT '',
  `isbn` int(10) NOT NULL DEFAULT '0',
  `ean` int(14) NOT NULL DEFAULT '0',
  `editorial` varchar(32) NOT NULL DEFAULT '',
  `titulo` varchar(96) NOT NULL DEFAULT '',
  `ano` year(4) NOT NULL DEFAULT '0000',
  `caducado` char(2) NOT NULL DEFAULT '',
  `importe` int(11) NOT NULL DEFAULT '0',
  `utilizado` char(2) NOT NULL DEFAULT '',
  `nivel` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `tramos`
//

mysql_query("CREATE TABLE IF NOT EXISTS `tramos` (
  `hora` int(1) NOT NULL DEFAULT '0',
  `tramo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hora`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `tutoria`
//

mysql_query("CREATE TABLE IF NOT EXISTS `tutoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claveal` varchar(12) NOT NULL DEFAULT '',
  `apellidos` varchar(42) NOT NULL DEFAULT '',
  `nombre` varchar(24) NOT NULL DEFAULT '',
  `tutor` varchar(48) NOT NULL DEFAULT '',
  `nivel` char(2) NOT NULL DEFAULT '',
  `grupo` char(1) NOT NULL DEFAULT '',
  `observaciones` text NOT NULL,
  `causa` varchar(42) NOT NULL DEFAULT '',
  `accion` varchar(200) NOT NULL DEFAULT '',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `orienta` tinyint(1) NOT NULL DEFAULT '0',
  `prohibido` tinyint(1) NOT NULL DEFAULT '0',
  `jefatura` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `claveal` (`claveal`),
  KEY `tutor` (`tutor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `user`
//

mysql_query("CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `usuarioalumno`
//

mysql_query("CREATE TABLE IF NOT EXISTS `usuarioalumno` (
  `usuario` varchar(18) DEFAULT NULL,
  `pass` varchar(16) NOT NULL DEFAULT '',
  `nombre` varchar(48) DEFAULT NULL,
  `perfil` char(1) NOT NULL DEFAULT '',
  `unidad` varchar(5) NOT NULL DEFAULT '',
  `claveal` varchar(12) NOT NULL DEFAULT '',
  KEY `claveal` (`claveal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// ////////////////////////////////////////////////////////

//
// Estructura de tabla para la tabla `usuarioprofesor`
//

mysql_query("CREATE TABLE IF NOT EXISTS `usuarioprofesor` (
  `usuario` varchar(16) DEFAULT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `perfil` varchar(10) DEFAULT NULL,
  KEY `usuario` (`usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");


// Base de datos de Reservas

// Creamos Base de dtos principal

mysql_query("CREATE DATABASE IF NOT EXISTS reservas");
mysql_select_db ($db_reservas);

for($ci=1;$ci<$num_aula+1;$ci++){

// Tabla de Aulas

mysql_query("CREATE TABLE IF NOT EXISTS `aula".$ci."` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `eventdate` date default NULL,
  `dia` tinyint(1) NOT NULL default '0',
  `html` tinyint(1) NOT NULL default '0',
  `event1` varchar(64) default NULL,
  `event2` varchar(64) NOT NULL default '',
  `event3` varchar(64) NOT NULL default '',
  `event4` varchar(64) NOT NULL default '',
  `event5` varchar(64) NOT NULL default '',
  `event6` varchar(64) NOT NULL default '',
  `event7` varchar(64) NOT NULL default '',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `date` (`eventdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// Estructura de tabla para la tabla `aulahor`

mysql_query("CREATE TABLE IF NOT EXISTS `aula".$ci."hor` (
  `dia` tinyint(1) NOT NULL default '0',
  `hora1` varchar(24) default NULL,
  `hora2` varchar(24) default NULL,
  `hora3` varchar(24) default NULL,
  `hora4` varchar(24) default NULL,
  `hora5` varchar(24) default NULL,
  `hora6` varchar(24) default NULL,
  `hora7` varchar(24) default NULL,
  KEY `dia` (`dia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1");
}

for($ci=1;$ci<$num_medio+1;$ci++){

// Tabla de Medios

mysql_query("CREATE TABLE IF NOT EXISTS `medio".$ci."` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `eventdate` date default NULL,
  `dia` tinyint(1) NOT NULL default '0',
  `html` tinyint(1) NOT NULL default '0',
  `event1` varchar(64) default NULL,
  `event2` varchar(64) NOT NULL default '',
  `event3` varchar(64) NOT NULL default '',
  `event4` varchar(64) NOT NULL default '',
  `event5` varchar(64) NOT NULL default '',
  `event6` varchar(64) NOT NULL default '',
  `event7` varchar(64) NOT NULL default '',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `date` (`eventdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");

// Estructura de tabla para la tabla `mediohor`

mysql_query("CREATE TABLE IF NOT EXISTS `medio".$ci."hor` (
  `dia` tinyint(1) NOT NULL default '0',
  `hora1` varchar(24) default NULL,
  `hora2` varchar(24) default NULL,
  `hora3` varchar(24) default NULL,
  `hora4` varchar(24) default NULL,
  `hora5` varchar(24) default NULL,
  `hora6` varchar(24) default NULL,
  `hora7` varchar(24) default NULL,
  KEY `dia` (`dia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1");
}

for($ci=1;$ci<$num_carrito+1;$ci++){

// Tabla de Carritos

mysql_query("CREATE TABLE IF NOT EXISTS `carrito".$ci."` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `eventdate` date default NULL,
  `dia` tinyint(1) NOT NULL default '0',
  `html` tinyint(1) NOT NULL default '0',
  `event1` varchar(64) default NULL,
  `event2` varchar(64) NOT NULL default '',
  `event3` varchar(64) NOT NULL default '',
  `event4` varchar(64) NOT NULL default '',
  `event5` varchar(64) NOT NULL default '',
  `event6` varchar(64) NOT NULL default '',
  `event7` varchar(64) NOT NULL default '',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `date` (`eventdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
}

// Tabla de Usuarios TIC

mysql_query("CREATE TABLE IF NOT EXISTS `usuario` (
  `profesor` varchar(48) NOT NULL default '',
  `c1` smallint(3) default NULL,
  `c2` smallint(3) default NULL,
  `c3` smallint(3) default NULL,
  `c4` smallint(3) default NULL,
  `c5` smallint(3) default NULL,
  `c6` smallint(3) default NULL,
  `c7` smallint(3) default NULL,
  `c8` smallint(3) default NULL,
  `c9` smallint(3) default NULL,
  `c10` smallint(3) default NULL,
  `c11` smallint(3) default NULL,
  `c12` smallint(6) default NULL,
  `c13` smallint(6) default NULL,
  `c14` smallint(6) default NULL,
  `c15` smallint(6) default NULL,
  PRIMARY KEY  (`profesor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");


echo '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />';

echo '<div align="center"><div class="well" style="max-width:500px" align="justify">
Las Bases de datos y sus tablas han sido creadas correctamente. Ahora debes ir a la página principal y continuar con la importación de los datos de Séneca hacia la Intranet. Esto lo haces identificándote como Administrador (usuario: <em>admin</em>; Clave de acceso: <em>12345678</em>), y yendo a la página de Administración de la Intranet (en el Menú de la Izquierda).<br><br /><div align="center"><a href="http://'.$dominio.'/intranet/" class="btn btn-primary">Ir a la Página Principal</a></div>
          </div></div>';
}
?> 
