<?
if (stristr ( $carg, '1' ) == TRUE) {
	?>

<li class="nav-header"> Dirección del Centro</li>
<li><a href="xml/index.php">Administración de la Intranet</a></li>
<li><a href="admin/jefatura/tutor.php">Diario de Jefatura</a></li>
<li><A HREF="xml/jefe/mem_jefatura.php" target="_top">Informes sobre Convivencia</A></li>
<hr />
<?
}
?>
<?
if (stristr ( $carg, '4' ) == TRUE) {
	?>
<li class="nav-header">Departamento</li>
<li><a href="admin/rd/add.php">Actas del Departamento</a></li>
<li><a href="admin/textos/intextos.php">Libros de Texto</a></li>
<li><a href="admin/inventario/introducir.php">Inventario de Material</a></li>
<li><a href="admin/actividades/index.php" target="_top">Actividades Extraescolares</a></li>
<li><a href="admin/departamento/memoria.php" target="_top">Memoria del Departamento</a></li>
<hr />
<?
}
?>
<?

if (stristr ( $carg, '5' ) == TRUE) {
	?>
<li class="nav-header">Extraescolares</li>
<li><a href="./admin/actividades/indexextra.php">Administrar
  Actividades</a></li>
<li><a href="./admin/actividades/index.php">Introducir Actividades</a></li>
<li><a href="./admin/actividades/consulta.php">Consultar Actividades</a></li>
<hr />
<?
}
?>
<?

if (stristr ( $carg, '8' ) == TRUE) {
	?>
<li class="nav-header">Orientación</li>
<li><a href="admin/orientacion/tutor.php">Página de Orientación</a></li>
<li><a href="./admin/tutoria/">Página del Tutor </a></li>
<li><a href="admin/actividades/index.php" target="_top">Actividades
  Extraescolares</a></li>
  <li><A HREF="xml/jefe/mem_jefatura.php" target="_top">Informes sobre Convivencia</A></li>
<?
	if ($mod_sms) {
		?>
<?
	}
	?>
    <hr />
<?
}
?>

<?
if (stristr ( $carg, '2' ) == TRUE) {
	?>
<li class="nav-header">Tutoría</li>
<li><a href="admin/tutoria/global.php">Página del Tutor</a></li>
<hr />
<?
}
?>
<li class="nav-header">Consultas</li>
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
<hr />

<li class="nav-header">Trabajo</li>
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
<?
$conv = mysql_query("select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr'");
if (mysql_num_rows($conv) > '0') {
?>
<li><a href="admin/fechorias/convivencia.php">Aula de Convivencia</a></li>
<?
}
if (stristr ( $carg, '1' ) == TRUE) {
	?>
<li><a href="./admin/tutoria/">Página del Tutor </a></li>
<li><a href="admin/fechorias/convivencia_jefes.php">Aula de Convivencia</a></li>
<?
	if ($mod_sms) {
		?>
<li><a href="sms/index.php" target="_top">Enviar SMS</a></li>
<?
	}
	?>

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
					if ($mod_sms) {
						?>
<li><a href="sms/index.php" target="_top">Enviar SMS</a></li>
<?
					}
				}
				?>
					<li><a href="admin/mensajes/correo.php" target="_top">Enviar Correo</a></li>
<?

				if (date ( 'm' ) == '06' or date ( 'm' ) == '09') {
					?>
<li><a href="sms/index.php" target="_top">Enviar SMS</a></li>
<?
				}
				?>
                <hr />
<li class="nav-header">Otras cosas</li>
<li><a
		href="http://www.juntadeandalucia.es/averroes/centros-tic/29002885/moodle/">Palataforma
  Moodle</a></li>
<li><a href="admin/cursos/calendario.php">Calendario Escolar</a></li>
<li><a href="ftp://ftp.iesmonterroso.org/departamentos/Documentos del Centro/PC20122013/index.htm"
		target="_blank">Plan de Centro</a></li>
<li><a href="clave.php">Cambiar Contrase&ntilde;a</a></li>
<hr />
<li class="nav-header">Otras p&aacute;ginas</li>
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
