
<li  class="nav-header">Menu General</li>
<? if (strstr($_SESSION ['cargo'],"7")) {?><li><a href="admin/matriculas/index.php" class="enlacelateral">Matriculación de alumnos<br /></a></li><?}?>
<li><a href="admin/cursos/ccursos.php">Listas de los Grupos</a></li>
<li><a href="admin/datos/cdatos.php">Datos de los Alumnos</a></li>
<li><a href="admin/cursos/chorarios.php">Horarios de Profesores/Grupos</a></li>
<li><a href="admin/fotos/index.php">Fotos de los Alumnos</a></li>
<li><a href="admin/fotos/fotos_profes.php">Fotos de los Profesores</a></li>
<li><A HREF="sms/index.php" target="_top">Enviar SMS</A></li>
<?
		if ($mod_tic) {
 ?>
<li><a data-toggle="collapse" data-target="#tic"> Centro TIC  <i class="icon-chevron-down pull-right"> </i> </a></li>
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
 <li><a data-toggle="collapse" data-target="#reservas"> Reservas de Medios  <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="reservas" class="collapse">
  <ul class="nav nav-list">
    <!-- dropdown menu links -->
    <li><a href="reservas/index.php?recurso=carrito" style="background-image: none;">Carritos TIC</a></li>
    <li><a href="reservas/index.php?recurso=aula">Aulas compartidas</a></li>
    <li><a href="reservas/index.php?recurso=medio">Medios Audiovisuales </a></li>
    <li><a	href="http://<?	echo $dominio;?>/intranet/reservas/informes.php">Estadísticas</a></li>
    </li>
  </ul>
</div>

<li><a href="admin/textos/intextos.php">Libros de Texto</a></li>
<li><A HREF="admin/actividades/consulta.php" target="_top">Actividades Extraescolares</A></li>

<li class="nav-header">Otras cosas..</li>
<li><a href="admin/cursos/calendario.php">Calendario Escolar</a></li>
<li><a href="http://<? echo $dominio; ?>/intranet/varios/resumen_licencias_y_permisos.php">Resumen
  sobre licencias y permisos</a></li>
<li><a href="clave.php">Cambiar Contrase&ntilde;a</a></li>

<li  class="nav-header">Otras p&aacute;ginas</li>
<li><a href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6&vismenu=0,0,1,1,1,1,1" target="_blank">Novedades de la Consejer&iacute;a</a></li>
<li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=442&vismenu=0,0,1,1,1,1,1" target="_blank">Delegaci&oacute;n de Educaci&oacute;n</a></li>
<li><a href="http://www.cep-marbellacoin.org/index.html" target="_blank">CEP de Marbella</a></li>
<li><a href="http://www.mec.es" target="_blank">P&aacute;gina del MEC </a></li>
<li><a href="http://www.juntadeandalucia.es/averroes/" target="_blank">Averroes</a></li>
