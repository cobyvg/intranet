<script>
function CambiarEstilo(id) {
	var elemento = document.getElementById(id);
	elemento.className = "visible-xs";
}
</script>
<div class="visible-xs">
<ul class="nav nav-pills">
  <? if ($mod_faltas) { ?>
  <li>
      <a class="btn btn-link" href="faltas/index.php">
        <span class="fa fa-clock-o fa-2x"></span><br>
        <h6>Asistencia</h6>
      </a>
    </li>
  <?php } ?>
   <li>
      <a class="btn btn-link" href="admin/fechorias/infechoria.php">
        <span class="fa fa-gavel fa-2x"></span><br>
        <h5>Convivencia</h5>
      </a>
    </li>    
   <li>
      <a class="btn btn-link" href="admin/mensajes/redactar.php">
        <span class="fa fa-comments fa-2x"></span><br>
        <h5>Mensaje</h5>
      </a>
    </li>
   <li>
      <a class="btn btn-link" href="javascript:CambiarEstilo('menu')">
        <span class="fa fa-cogs fa-2x"></span><br>
        <h5>&nbsp;Menú&nbsp;&nbsp;</h5>
      </a>
    </li>
    </ul>
</div>

<div class="panel-group hidden-xs" id="menu">
<?
if (stristr ( $carg, '1' ) == TRUE) {
?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#direccion">
        <i class="pull-right fa fa-chevron-down"></i>
        Dirección del centro
      </a>
    </div>
    <div id="direccion" class="panel-collapse collapse in">
      <div class="panel-body">
        <ul class="nav nav-list">
          <li><a href="xml/index.php">Administración de la Intranet</a></li>
          <li><a href="admin/jefatura/tutor.php">Diario de jefatura</a></li>
 <?
 if (date("m")>5 and date("m")<12) {
 ?>
           <li><a href="admin/matriculas/index.php">Matriculación de Alumnos</a></li>
 <?	
 }
 ?>
        </ul>
      </div>
    </div>
  </div>

<?
}
if (stristr ( $carg, '4' ) == TRUE) { $j_d = 'in'; } else { $j_d = ''; }
$menu_dep = '
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#departamento">
      <i class="pull-right fa fa-chevron-down"></i>
      Departamento
    </a>
  </div>
  <div id="departamento" class="panel-collapse collapse '.$j_d.'">
    <div class="panel-body">
      <ul class="nav nav-list">';
if (stristr($carg, '1')==FALSE) {
$menu_dep.='
        <li><a href="admin/rd/add.php">Actas del departamento</a></li>
        <li><a href="admin/textos/intextos.php">Libros de texto</a></li>
        <li><a href="admin/inventario/introducir.php">Inventario de material</a></li>';
if (stristr ( $carg, '4' ) == TRUE){
	$menu_dep.='<li><a href="admin/actividades/index.php">Actividades extraescolares</a></li>';
}
else{
	$menu_dep.='<li><a href="admin/actividades/consulta.php">Actividades extraescolares</a></li>';
}
}
else{
	$menu_dep.='       
        <li><a href="admin/rd/index_admin.php">Actas de los departamentos</a></li>
        <li><a href="admin/textos/intextos.php">Libros de texto</a></li>
        <li><a href="admin/inventario/introducir.php">Inventario de material</a></li>
        <li><a href="admin/actividades/indexextra.php">Actividades extraescolares</a></li>';
}

$menu_dep.='        
				<li><a href="admin/departamento/memoria.php">Memoria del departamento</a></li>
      </ul>
    </div>
  </div>
</div>';

// Menu del Jefe de Departamehto
if (stristr ( $carg, '4' ) == TRUE) {
	echo $menu_dep;
}

if (stristr ( $carg, '5' ) == TRUE) {
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#extraescolares">
      <i class="pull-right fa fa-chevron-down"></i>
      Extraescolares
    </a>
  </div>
  <div id="extraescolares" class="panel-collapse collapse in">
    <div class="panel-body">
      <ul class="nav nav-list">
        <li><a href="./admin/actividades/indexextra.php">Administrar actividades</a></li>
        <li><a href="./admin/actividades/index.php">Introducir actividades</a></li>
        <li><a href="./admin/actividades/consulta.php">Consultar actividades</a></li>
      </ul>
    </div>
  </div>
</div>
<?
}
if (stristr ( $carg, '8' ) == TRUE) {
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#orientacion">
      <i class="pull-right fa fa-chevron-down"></i>
      Orientación
    </a>
  </div>
  <div id="orientacion" class="panel-collapse collapse in">
    <div class="panel-body">
      <ul class="nav nav-list">
        <li><a href="admin/orientacion/tutor.php">Página de Orientación</a></li>
        <li><a href="./admin/tutoria/">Página del tutor </a></li>
        <li><a href="admin/actividades/index.php">Actividades extraescolares</a></li>
      </ul>
    </div>
  </div>
</div>
<?
}
if (stristr ( $carg, '2' ) == TRUE) {
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#tutoria">
      <i class="pull-right fa fa-chevron-down"></i>
      Tutoría
    </a>
  </div>
  <div id="tutoria" class="panel-collapse collapse in">
    <div class="panel-body">
      <ul class="nav nav-list">
        <li><a href="admin/tutoria/global.php">Página del tutor</a></li>
      </ul>
    </div>
  </div>
</div>
<?
}
?>
<?
if (stristr ( $carg, 'c' ) == TRUE and $mod_biblio=="1") {
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#tutoria">
      <i class="pull-right fa fa-chevron-down"></i>
      Biblioteca
    </a>
  </div>
  <div id="tutoria" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="nav nav-list">
        <li><a href="<? echo $p_biblio;?>" target="_blank">Página de la Biblioteca</a></li>	
        <li><a href="admin/cursos/hor_aulas.php?aula=Biblioteca" target="_blank">Horario de la Biblioteca</a></li>	
        <li><a href="admin/biblioteca/index_morosos.php">Gestión de los Préstamos</a></li>
        <li><a href="admin/biblioteca/index.php">Consultar fondos de la Biblioteca</a></li>
        
        <li><a href="admin/biblioteca/index_biblio.php">Importar datos de Abies</a></li>
      </ul>
    </div>
  </div>
</div>
<?
}
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#consultas">
      <i class="pull-right fa fa-chevron-down"></i>
      Consultas
    </a>
  </div>
  <div id="consultas" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="nav nav-list">
              <li><a href="admin/datos/cdatos.php">Datos de los alumnos</a></li>
      <? if ($mod_horario) { ?>
        <li><a href="admin/cursos/chorarios.php">Horarios</a></li>
        <? } ?>
         <li>
        <a data-toggle="collapse" data-target="#listas" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Listas
          </a>
        </li>
        <div id="listas" class="panel-collapse collapse">
          <ul class="nav nav-list">
        <li><a href="admin/cursos/ccursos.php">Listas de los Grupos</a></li>
            <li><a href="admin/pendientes/index.php">Listas de Pendientes</a></li>
          </ul>
        </div>

       
        <li>
          <a data-toggle="collapse" data-target="#fotos" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Fotografías
          </a>
        </li>
        <div id="fotos" class="panel-collapse collapse">
          <ul class="nav nav-list">
            <li><a href="admin/fotos/index.php">Fotos de los alumnos</a></li>
            <li><a href="admin/fotos/fotos_profes.php">Fotos de los profesores</a></li>
          </ul>
        </div>
        <li>
          <a data-toggle="collapse" data-target="#estadisticas" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Estadísticas y datos
          </a>
        </li>
        <div id="estadisticas" class="panel-collapse collapse">
          <ul class="nav nav-list">
            <li><a href="admin/informes/informe_notas1.php">Informes sobre las Evaluaciones</a></li>
            <li><a href="admin/fechorias/informe_convivencia.php">Informes sobre Convivencia</a></li>

      <? if ($mod_horario) { ?>
                <li><a href="admin/cursos/hor_guardias.php">Informes sobre Guardias</a></li>  
	  <? } ?>
          </ul>
        </div>
      </ul>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#trabajo">
      <i class="pull-right fa fa-chevron-down"></i>
      Trabajo
    </a>
  </div>
  <div id="trabajo" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="nav nav-list">
        <li>
          <a data-toggle="collapse" data-target="#convivencia" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Problemas de convivencia
          </a>
        </li>
        <div id="convivencia" class="panel-collapse collapse">
          <ul class="nav nav-list">
            <li><a href="admin/fechorias/infechoria.php">Registrar problema</a></li>
            <li><a href="admin/fechorias/cfechorias.php">Consultar problemas</a></li>
            <li><a href="admin/fechorias/lfechorias.php">Últimos problemas</a></li>
            <li><a href="admin/fechorias/expulsados.php">Alumnos expulsados</a></li>
            <? 
        	$conv = mysql_query("SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr'");
        	if (mysql_num_rows($conv) > '0' or stristr ( $carg, '1' ) == TRUE) { 
        	if(stristr ( $carg, '1' ) == TRUE){
        	?>
        	<li><a href="admin/fechorias/convivencia_jefes.php">Aula de convivencia</a></li>
        	<?
        	}
        	else{
        	?>
        	<li><a href="admin/fechorias/convivencia.php">Aula de convivencia</a></li>
        	<? 
        	} 
        	}
        	?>
          </ul>
        </div>
        
        <? if ($mod_faltas) { ?>
        <li>
          <a data-toggle="collapse" data-target="#asistencia" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Faltas de asistencia
          </a>
        </li>
        <div id="asistencia" class="panel-collapse collapse">
          <ul class="nav nav-list">
            <li><a href="faltas/index.php">Poner faltas</a></li>
            <? if (stristr ( $_SESSION ['cargo'], '2' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE or stristr ( $_SESSION ['cargo'], '3' ) == TRUE) { ?>
            <li><a href="faltas/justificar/index.php">Justificar faltas</a></li>
            <? } ?>
            <li><a href="http://<? echo $dominio; ?>/intranet/admin/faltas/index.php">Consultas</a></li>
            <? if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE) { ?>
            <li><a href="faltas/seneca/">Importar faltas a Séneca</a></li>
            <? } ?>
            </li>
            <? 
            if (stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
            ?>
            <li><a href="http://<? echo $dominio; ?>/intranet/admin/faltas/ccursos.php"> Partes de Faltas de Grupo</a></li>
            <? 
            }
            ?>
    		</li>
          </ul>
        </div>
        <? } ?>
        
        <li>
          <a data-toggle="collapse" data-target="#informes" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Informes
          </a>
        </li>
        <div id="informes" class="panel-collapse collapse">
          <ul class="nav nav-list">
            <li><a href="admin/informes/cinforme.php">Informe de un alumno</a></li>
            <li><a href="admin/tareas/index.php">Informe de tareas</a></li>
            <li><a href="admin/infotutoria/index.php">Informe de tutoría </a></li>
          </ul>
        </div>
        
        <? if ($mod_tic) { ?>
        <li>
          <a data-toggle="collapse" data-target="#tic" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Centro TIC
          </a>
        </li>
        <div id="tic" class="panel-collapse collapse">
          <ul class="nav nav-list">
          	<li><a href="TIC/index.php">Nueva incidencia</a></li>
          	<li><a href="TIC/incidencias.php">Listado de incidencias</a></li>
            <li><a href="TIC/perfiles_alumnos.php">Perfiles alumnos</a></li>
            <li><a href="TIC/perfiles_profesores.php">Perfiles profesores</a></li>
            <li><a href="TIC/documentos.php">Documentos y manuales</a></li>
            <li><a href="TIC/protocolo.php">Protocolo de uso</a></li> 
            <li><a href="TIC/estadisticas.php">Estadísticas TIC</a></li>
          </ul>
        </div>
        <? } ?>
        
        <li>
          <a data-toggle="collapse" data-target="#reservas" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Reservas
          </a>
        </li>
        <div id="reservas" class="panel-collapse collapse">
          <ul class="nav nav-list">
	          <? if ($mod_horario=="1") { ?>
	          <li><a href="reservas/index_aula.php?recurso=aula_grupo">Aulas de grupo</a></li>
	          <? } ?>
            <li><a href="reservas/index.php?recurso=carrito">Carritos TIC</a></li>
            <li><a href="reservas/index.php?recurso=medio">Medios audiovisuales</a></li>
          </ul>
        </div>
        
        <li>
          <a data-toggle="collapse" data-target="#mensajeria" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Mensajería
          </a>
        </li>
        <div id="mensajeria" class="panel-collapse collapse">
          <ul class="nav nav-list">
            <? if ($mod_sms) { ?>
            <li><a href="sms/index.php">Enviar SMS</a></li>
            <? } ?>
            <li><a href="admin/mensajes/correo.php">Enviar correo</a></li>
            <li><a href="admin/mensajes/">Enviar mensaje</a></li>
          </ul>
        </div>
        
        <li>
          <a data-toggle="collapse" data-target="#prueba" style="cursor:pointer">
            <i class="pull-right fa fa-chevron-down"></i>
            Registro de Examen/Actividad
          </a>
        </li>
        <div id="prueba" class="panel-collapse collapse">
          <ul class="nav nav-list">
        <li><a href="admin/calendario/diario/index.php">Nuevo Examen/Actividad</a></li>
        <li><a href="admin/calendario/diario/index_cal.php">Calendario por Grupos</a></li>
          </ul>
        </div>
        
        <? if (stristr ( $carg, '1' ) == TRUE) { ?>
        <li><a href="admin/tutoria/">Página del tutor</a></li>
        <li><a href="admin/guardias/admin.php">Registro de guardias</a></li>
        <? } ?>
        <li><a href="admin/ausencias/index.php">Registrar ausencia</a></li>
      </ul>
    </div>
  </div>
</div>
<?
if (stristr ( $carg, '4' ) == FALSE and stristr ( $carg, '1' ) == FALSE) {
	echo $menu_dep;
}
if (stristr ( $carg, '1' ) == TRUE) {
	echo $menu_dep;
}
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#cosas">
      <i class="pull-right fa fa-chevron-down"></i>
      Otras cosas
    </a>
  </div>
  <div id="cosas" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="nav nav-list">
        <li><a href="http://www.juntadeandalucia.es/averroes/centros-tic/<? echo $codigo_del_centro; ?>/moodle/">Plataforma Moodle</a></li>
        <?
        if ($mod_biblio==1) {
        	echo '<li><a href="admin/biblioteca/index.php">Fondos de la Biblioteca</a></li>';
        }
        ?>
        <li><a href="admin/cursos/calendario.php">Calendario escolar</a></li>
        <li><a href="http://iesmonterroso.org/PC/index.htm">Plan de Centro</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <a class="accordion-toggle" data-toggle="collapse" data-parent="#menu" href="#paginas">
      <i class="pull-right fa fa-chevron-down"></i>
      Páginas de interés
    </a>
  </div>
  <div id="paginas" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="nav nav-list">
      	<li><a href="http://<? echo $dominio;	?>">P&aacute;gina del centro</a></li>
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6" target="_blank">Novedades de la Consejería</a></li>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="04") { ?>
        <!-- Almería -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=436" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="11") { ?>
        <!-- Cádiz -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=437" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="14") { ?>
        <!-- Córdoba -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=438" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="18") { ?>
        <!-- Granada -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=439" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="21") { ?>
        <!-- Huelva -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=440" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="23") { ?>
        <!-- Jaén -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=441" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="29") { ?>
        <!-- Málaga -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=442" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <? if(substr($codigo_postal_del_centro,0,2)=="41") { ?>
        <!-- Sevilla -->
        <li><a href="http://www.juntadeandalucia.es/educacion/nav/delegaciones.jsp?delegacion=443" target="_blank">Delegación de Educación</a></li>
        <? } ?>
        
        <li><a href="https://www.juntadeandalucia.es/educacion/portaldocente/" target="_blank">Portal del Personal Docente</a></li>
        <!--<li><a href="http://www.cep-marbellacoin.org/index.html" target="_blank">CEP de Marbella-Coín</a></li>-->
        <li><a href="http://www.mecd.gob.es" target="_blank">Página del MEC</a></li>
        <li><a href="http://www.juntadeandalucia.es/averroes/" target="_blank">Averroes</a></li>
      </ul>
    </div>
  </div>
</div>
</div>                                                                                                                                                              