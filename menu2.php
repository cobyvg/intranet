<style>
<!--
ul .nav-list{
	padding-bottom:2px;
	padding-top:12px;
}
-->
</style>
<?
if (stristr ( $carg, '1' ) == TRUE) {
	?>
<li class="active"><a data-toggle="collapse" data-target="#direccion" style="cursor:pointer"> Dirección del Centro<i class="icon-chevron-down pull-right"></i> </a></li>
<div id="direccion" class="collapse in">
  <ul class="nav nav-list">
<li><a href="xml/index.php">Administración de la Intranet</a></li>
<li><a href="admin/jefatura/tutor.php">Diario de Jefatura</a></li>
<li><A HREF="xml/jefe/mem_jefatura.php" target="_top">Informes sobre Convivencia</A></li>
<br />
</ul>
</div>
<?
}
?>
<?
if (stristr ( $carg, '4' ) == TRUE) {
	?>
<li class="active"><a data-toggle="collapse" data-target="#Departamento" style="cursor:pointer"> Departamento<i class="icon-chevron-down pull-right"></i></a></li>
<div id="Departamento" class="collapse in">
  <ul class="nav nav-list">
  <li><a href="admin/rd/add.php">Actas del Departamento</a></li>
<li><a href="admin/textos/intextos.php">Libros de Texto</a></li>
<li><a href="admin/inventario/introducir.php">Inventario de Material</a></li>
<li><a href="admin/actividades/index.php" target="_top">Actividades Extraescolares</a></li>
<li><a href="admin/departamento/memoria.php" target="_top">Memoria del Departamento</a></li>
<br />
</ul>
</div>
<?
}
?>
<?

if (stristr ( $carg, '5' ) == TRUE) {
	?>
<li class="active"><a data-toggle="collapse" data-target="#Extraescolares" class="text-sucess" style="cursor:pointer"> Extraescolares<i class="icon-chevron-down pull-right"></i></a></li>
<div id="Extraescolares" class="collapse in">
  <ul class="nav nav-list">
<li><a href="./admin/actividades/indexextra.php">Administrar
  Actividades</a></li>
<li><a href="./admin/actividades/index.php">Introducir Actividades</a></li>
<li><a href="./admin/actividades/consulta.php">Consultar Actividades</a></li>
<br />
</ul>
</div>
<?
}
?>
<?

if (stristr ( $carg, '8' ) == TRUE) {
	?>
<li class="active"><a data-toggle="collapse" data-target="#Orientacion"  class="text-sucess" style="cursor:pointer"> Orientación<i class="icon-chevron-down pull-right"></i></a></li>
<div id="Orientacion" class="collapse in">
  <ul class="nav nav-list">
  <li><a href="admin/orientacion/tutor.php">Página de Orientación</a></li>
<li><a href="./admin/tutoria/">Página del Tutor </a></li>
<li><a href="admin/actividades/index.php" target="_top">Actividades
  Extraescolares</a></li>
  <li><A HREF="xml/jefe/mem_jefatura.php" target="_top">Informes sobre Convivencia</A></li>
<br />
</ul>
</div>
<?
}
?>

<?
if (stristr ( $carg, '2' ) == TRUE) {
	?>
<li class="active"><a data-toggle="collapse" data-target="#tutoria" class="text-sucess" style="cursor:pointer"> Tutoría<i class="icon-chevron-down pull-right"></i></a></li>
<div id="tutoria" class="collapse in">
  <ul class="nav nav-list">
  <li><a href="admin/tutoria/global.php">Página del Tutor</a></li>
<br />
</ul>
</div>
<?
}
?>
<li><a data-toggle="collapse" data-target="#Consultas" style="cursor:pointer"> Consultas<i class="icon-chevron-down pull-right"></i></a></li>
<div id="Consultas" class="collapse">
  <ul class="nav nav-list">
  <li><a href="admin/cursos/ccursos.php">Listas de los Grupos</a></li>
<li><a href="admin/datos/cdatos.php">Datos de los Alumnos</a></li>
<?
				if ($mod_horario) {
					?>
<li><a href="admin/cursos/chorarios.php">Horarios de
  Profesores/Grupos</a></li>
<?
				}
				?>
<li><a data-toggle="collapse" data-target="#fotos" style="cursor:pointer"> Fotografías <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="fotos" class="collapse">
  <ul class="nav nav-list">				
<li><a href="admin/fotos/index.php">Fotos de los Alumnos</a></li>
<li><a href="admin/fotos/fotos_profes.php">Fotos de los Profesores</a></li>
</ul>
</div>
<br />
</ul>
</div>

<li><a data-toggle="collapse" data-target="#Trabajo" style="cursor:pointer"> Trabajo<i class="icon-chevron-down pull-right"></i></a></li>
<div id="Trabajo" class="collapse">
  <ul class="nav nav-list">
  <li><a data-toggle="collapse" data-target="#convivencia" style="cursor:pointer"> Problemas de Convivencia <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="convivencia" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <li><a
			href="http://<?
			echo $dominio;
			?>/intranet/admin/fechorias/infechoria.php"> Registrar Problema</a></li>
    <li><a
			href="http://<?
			echo $dominio;
			?>/intranet/admin/fechorias/cfechorias.php"> Consultar Problemas</a></li>
    <li><a
			href="http://<?
			echo $dominio;
			?>/intranet/admin/fechorias/lfechorias.php"> Últimos Problemas</a></li>
    <li><a
			href="http://<?	echo $dominio;?>/intranet/admin/fechorias/expulsados.php"> Alumnos expulsados</a></li>
			 <?
					if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE or stristr ( $_SESSION ['cargo'], 'c' ) == TRUE) {
						?>
    <li><a href="http://
			<?
						echo $dominio;
						?>/intranet/admin/morosos/">Morosos de la Biblioteca </a></li>
    <?
					}
					
$conv = mysql_query("select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr'");
if (mysql_num_rows($conv) > '0' or stristr ( $carg, '1' ) == TRUE) {
?>
<li><a href="admin/fechorias/convivencia.php">Aula de Convivencia</a></li>
<?
}
					?>
  </ul>
</div>

<?
	if ($mod_faltas) {
  ?>
<li><a data-toggle="collapse" data-target="#faltas" style="cursor:pointer"> Faltas de Asistencia <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="faltas" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <li><a
			href="http://<?
					echo $dominio;
					?>/intranet/faltas/index.php"> Poner Faltas</a></li>
    <?
					if (stristr ( $_SESSION ['cargo'], '2' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE or stristr ( $_SESSION ['cargo'], '3' ) == TRUE) {
						?>
    <li><a
			href="http://<?
						echo $dominio;
						?>/intranet/faltas/justificar/index.php"> Justificar Faltas</a></li>
    <?
					}
					?>
    <li><a
			href="http://<?
					echo $dominio;
					?>/intranet/admin/faltas/index.php"> Consultas</a></li>
    <?
					if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
						?>
    <li><a href="http://
			<?
						echo $dominio;
						?>/intranet/faltas/seneca/"> Importar Faltas a S&eacute;neca </a></li>
    <?
					}
					?>
    </li>
        <?
					if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
						?>
    <li><a href="http://
			<?
						echo $dominio;
						?>/intranet/admin/faltas/ccursos.php"> Partes de Faltas de Grupo</a></li>
    <?
					}
					?>
    </li>
  </ul>
</div>
<?
				}
  ?>
<li><a data-toggle="collapse" data-target="#Informes" style="cursor:pointer"> Informes  <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="Informes" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <li><a href="admin/informes/cinforme.php"
			style="background-image: none;">Informe de un Alumno</a></li>
    <li><a href="admin/tareas/index.php">Informe de Tareas</a></li>
    <li><a href="admin/infotutoria/index.php">Informe
      de Tutoría </a></li>
  </ul>
</div>
<?
		if ($mod_tic) {
 ?>
<li><a data-toggle="collapse" data-target="#tic" style="cursor:pointer"> Centro TIC  <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="tic" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <li><a href="http://<? echo $dominio;?>/intranet/TIC/usuarios/intro.php">Usuario Alumno</a></li>
    <li><a href="http://<? echo $dominio;?>/intranet/TIC/usuarios/usuarioprofesor.php">Usuario Profesor</a></li>
    <li><a href="http://<? echo $dominio;?>/intranet/TIC/documentos.php">Documentos</a></li>
    <li><a href="http://<? echo $dominio;?>/intranet/TIC/cpartes.php">Incidencias</a></li>
	<!--<li><a href="http://<? echo $dominio;?>/intranet/admin/recursos/">Recursos Educativos</a></li>-->    
	<li><a	href="http://<?	echo $dominio;?>/intranet/reservas/informes.php">Estadísticas </a></li>
  </ul>
</div>
<?
	}
 ?>
<li><a data-toggle="collapse" data-target="#reservas" style="cursor:pointer"> Reservas de Medios  <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="reservas" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <li><a href="reservas/index.php?recurso=carrito" style="background-image: none;">Carritos TIC</a></li>
    <li><a href="reservas/index.php?recurso=aula">Aulas compartidas</a></li>
    <?
if ($mod_horario=="1") {
?>
    <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index_aula_grupo.php?recurso=aula_grupo">Aulas de Grupo</a></li>
<?
}
?>
    <li><a href="reservas/index.php?recurso=medio">Medios Audiovisuales </a></li>
    <li><a	href="http://<?	echo $dominio;?>/intranet/reservas/informes.php">Estadísticas</a></li>
    </li>
  </ul>
</div>

<li><a data-toggle="collapse" data-target="#Mensajes" style="cursor:pointer"> Mensajería  <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="Mensajes" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <?
	if ($mod_sms) {
		?>
<li><a href="sms/index.php" target="_top">Enviar SMS</a></li>
<?
	}
	?>
	<li><a href="admin/mensajes/correo.php" target="_top">Enviar Correo</a></li>
    <li><a href="admin/mensajes/">Enviar Mensaje </a></li>
  </ul>
</div>


<?
if (stristr ( $carg, '1' ) == TRUE) {
	?>
<li><a href="./admin/tutoria/">Página del Tutor </a></li>

<?
}
?>
<li><a href="admin/ausencias/index.php">Registrar Ausencia</a></li>
<?
				if (stristr ( $carg, '1' ) == TRUE and stristr ( $carg, '4' ) == FALSE) {
					?>
<li><a href="admin/rd/index_admin.php">Actas de los Departamentos</a></li>
<li><a href="admin/textos/intextos.php">Libros de Texto</a></li>
<li><a href="admin/inventario/introducir.php">Inventario de Material</a></li>
<li><a href="admin/actividades/indexextra.php" target="_top">Actividades
  Extraescolares</a></li>
<li><a href="admin/guardias/admin.php" target="_top">Registro de
  Guardias</a></li>
<?
				} elseif(stristr ( $carg, '1' ) == FALSE and stristr ( $carg, '4' ) == FALSE) {
					?>
<li><a href="admin/textos/intextos.php">Libros de Texto</a></li>
<li><a href="admin/actividades/consulta.php" target="_top">Actividades
  Extraescolares</a></li>
<?
				}
				?>
<?
				if (stristr ( $carg, '7' ) == TRUE) {
					?>
<?
				}
				?>
<br />
</ul>
</div>					
<li><a data-toggle="collapse" data-target="#cosas" style="cursor:pointer"> Otras cosas<i class="icon-chevron-down pull-right"></i></a></li>
<div id="cosas" class="collapse">
  <ul class="nav nav-list">
  <li><a
		href="http://www.juntadeandalucia.es/averroes/centros-tic/29002885/moodle/">Palataforma
  Moodle</a></li>
<li><a href="admin/cursos/calendario.php">Calendario Escolar</a></li>
<li><a href="http://iesmonterroso.org/PC20122013/index.htm"
		target="_blank">Plan de Centro</a></li>
<li><a href="clave.php">Cambiar Contrase&ntilde;a</a></li>
<br />
</ul>
</div>

<li><a data-toggle="collapse" data-target="#paginas" style="cursor:pointer"> Otras p&aacute;ginas<i class="icon-chevron-down pull-right"></i></a></li>
<div id="paginas" class="collapse">
  <ul class="nav nav-list">
<li><a
		href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6&vismenu=0,0,1,1,1,1,1"
		target="_blank">Novedades de la Consejer&iacute;a</a></li>
<li><a
		href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=442&vismenu=0,0,1,1,1,1,1"
		target="_blank">Delegaci&oacute;n de Educaci&oacute;n</a></li>
<li><a href="http://www.cep-marbellacoin.org/index.html"
		target="_blank">CEP de Marbella</a></li>
<li><a href="http://www.mec.es" target="_blank">P&aacute;gina del MEC </a></li>
<li><a href="http://www.juntadeandalucia.es/averroes/" target="_blank">Averroes</a></li>
<br />
</ul>
</div>

