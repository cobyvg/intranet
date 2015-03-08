<?
if (strstr($_SERVER['REQUEST_URI'],'fotos')==FALSE){registraPagina($_SERVER['REQUEST_URI'],$clave_al);}		
$activo1 = "";
$activo2 = "";
$activo3 = "";
$activo4 = "";
$activo5 = "";
$activo6 = "";
$activo7 = "";
$activo8 = "";
$activo9 = "";
$activo10 = "";
$activo11 = "";
$activo12 = "";
$activo13 = "";

if (strstr($_SERVER['REQUEST_URI'],'datos')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'actividades')==TRUE) {$activo2 = ' class="active" ';}else{$activo2="";}
if (strstr($_SERVER['REQUEST_URI'],'faltas')==TRUE) {$activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'fotos')==TRUE) {$activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'horario')==TRUE) {$activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'materias')==TRUE) {$activo6 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE) {$activo7 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'textos')==TRUE) {$activo8 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'xmlnotas')==TRUE) {$activo9 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'calendario')==TRUE) {$activo10 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'evaluables')==TRUE) {$activo11 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'matr')==TRUE) {$activo12 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infotut')==TRUE) {$activo13 = ' class="active" ';}
?>
<div class="span3">    
<div class="well well-large">
<li class="nav-header" style="margin-bottom:5px;"> Información general<i class="icon icon-info-sign icon-large icon-border pull-right"> </i></li>
<ul class="nav nav-list"> 
    <li <? echo $activo1;?>><a  href="http://<? echo $dominio;?>notas/datos.php"><i class='icon icon-user'> </i> Datos</a></li>
    <li <? echo $activo6;?>><a  href="http://<? echo $dominio;?>notas/materias.php"><i class='icon icon-edit'> </i> Profesores y Asignaturas</a></li>
    <li <? echo $activo5;?>><a  href="http://<? echo $dominio;?>notas/horario.php"><i class='icon icon-calendar'> </i> Horario</a></li>
    <li <? echo $activo8;?>><a  href="http://<? echo $dominio;?>notas/textos.php"><i class='icon icon-book'> </i> Textos</a></li>
    <li <? echo $activo2;?>><a  href="http://<? echo $dominio;?>notas/actividades.php"><i class='icon icon-plus-sign-alt'> </i> Actividades Extraescolares</a></li>
    <?
$eventQuery = mysql_query("SELECT id, fecha, grupo, materia, tipo, titulo FROM diario WHERE grupo like '%".$unidad."%'");
if (mysql_num_rows($eventQuery)>0) {
	?>
    <li <? echo $activo10;?>><a  href="http://<? echo $dominio;?>notas/calendario.php"><i class='icon icon-calendar'> </i> Calendario de Exámenes</a></li>	
	<?
}
    ?>
</ul>
<hr />
<li class="nav-header" style="margin-bottom:5px;"> Información privada<i class="icon icon-lock icon-large pull-right"> </i></li>
<ul class="nav nav-list"> 
    <li <? echo $activo3;?>><a  href="http://<? echo $dominio;?>notas/faltas.php"><i class='icon icon-bug'> </i>  Asistencia y Convivencia</a></li>
    <li <? echo $activo11;?>><a  href="http://<? echo $dominio;?>notas/evaluables.php"><i class='icon icon-th-list'> </i> Actividades Evaluables</a></li>
	<li <? echo $activo13;?>><a  href="http://<? echo $dominio;?>notas/infotutoria.php"><i class='icon icon-bug'> </i>  Informes de Tutoría</a></li>
    <li <? echo $activo9;?>><a  href="http://<? echo $dominio;?>notas/xmlnotas.php"><i class='icon icon-gears'> </i> Evaluaciones</a></li>
	<li <? echo $activo7;?>><a  href="http://<? echo $dominio;?>notas/mensajes.php"><i class='icon icon-comment'> </i> Mensajes</a></li>
    <li <? echo $activo4;?>><a  href="http://<? echo $dominio;?>notas/fotos.php"><i class='icon icon-picture'> </i> Fotografía</a></li>
    <?
    if(date('month')=="06"){
if (stristr($nivel,"1E")==TRUE or stristr($nivel,"2E")==TRUE or stristr($nivel,"3E")==TRUE){
    ?>
    <li <? echo $activo12;?>><a  href="http://<? echo $dominio;?>matriculas/matriculas.php?curso=1"><i class='icon icon-book'> </i> Matrícula del Alumno</a></li>
    <?
}
else{
    ?>
        <li <? echo $activo12;?>><a  href="http://<? echo $dominio;?>matriculas/matriculas_bach.php?curso=1"><i class='icon icon-book'> </i> Matrícula del Alumno</a></li>
	<?
}
}
	?>

</ul>
<hr />
<ul class="nav nav-list"> 
    <li><a  href="http://<? echo $dominio;?>notas/salir.php"><i class="icon icon-signout icon-large"> </i> Cerrar Sesión</a></li>
</ul>
</div>
</div>

