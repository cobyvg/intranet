<?
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
if (isset($_GET['alumno'])) {$alumno = $_GET['alumno'];}elseif (isset($_POST['alumno'])) {$alumno = $_POST['alumno'];}else{$alumno="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['tutor'])) {$tutor = $_GET['tutor'];}elseif (isset($_POST['tutor'])) {$tutor = $_POST['tutor'];}else{$tutor="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['del'])) {$del = $_GET['del'];}elseif (isset($_POST['del'])) {$del = $_POST['del'];}else{$del="";}
if (isset($_GET['todos'])) {$todos = $_GET['todos'];}elseif (isset($_POST['todos'])) {$todos = $_POST['todos'];}else{$todos="";}
if (isset($_GET['id_del'])) {$id_del = $_GET['id_del'];}elseif (isset($_POST['id_del'])) {$id_del = $_POST['id_del'];}else{$id_del="";}
if (isset($_GET['id_alumno'])) {$id_alumno = $_GET['id_alumno'];}elseif (isset($_POST['id_alumno'])) {$id_alumno = $_POST['id_alumno'];}else{$id_alumno="";}
if (isset($_GET['c_asig'])) {$c_asig = $_GET['c_asig'];}elseif (isset($_POST['c_asig'])) {$c_asig = $_POST['c_asig'];}else{$c_asig="";}
if (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];}elseif (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];}else{$unidad="";}
$activo1="";
$activo2="";
$activo3="";
$activo5="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infotut.php')==TRUE) {$activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'buscar.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_buscar.php')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'control.php')==TRUE){ $activo5 = ' class="active" ';}
?>
		<div class="container hidden-print">
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li <? echo $activo1;?>> <a href="index.php">Página de Informes de Tutoría</a></li>
					
					<?php if (stristr($_SESSION ['cargo'],'2') == TRUE or stristr($_SESSION ['cargo'],'1') == TRUE): ?>
					<?php if (stristr($_SESSION ['cargo'],'2') == TRUE) $tutor = $_SESSION ['tut']; ?>
					<li <? echo $activo2;?>><a href="infotut.php?<? if (isset($_SESSION ['s_unidad'])) {echo  "unidad=".$_SESSION ['s_unidad'];}?>&tutor=<? echo $tutor;?>">Activar Nuevo Informe</a></li>
					<?php endif; ?>
					
					<li <? echo $activo3;?>> <a href="buscar.php?todos=1">Ver Todos los Informes</a></li>
					<li <? echo $activo4;?>> <a href="index_buscar.php">Buscar Informes</a></li>
					<?php if (stristr($_SESSION ['cargo'],'1') == TRUE): ?>
					<li <? echo $activo5;?>> <a href="control.php">Control de Informes</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
