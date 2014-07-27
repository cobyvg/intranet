<div class="panel-group" id="menu">
  <div class="panel panel-default well">
    <div class="panel-heading">
      <a class="panel-group-toggle" data-toggle="collapse" data-parent="#menu" href="#trabajo">
        <i class="pull-right fa fa-chevron-down"></i>
        Trabajo
      </a>
    </div>
    <div id="trabajo" class="panel-collapse collapse in">
      <div class="panel-body">
        <ul class="nav nav-list">
          <? if (strstr($_SESSION ['cargo'],"7")) { ?>
          <li><a href="admin/matriculas/index.php">Matriculación de alumnos</a></li>
          <? } ?>
          
          <li><a href="admin/cursos/ccursos.php">Listas de los grupos</a></li>
          <li><a href="admin/datos/cdatos.php">Datos de los alumnos</a></li>
          <li><a href="admin/cursos/chorarios.php">Horarios de profesores/grupos</a></li>
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
          <li><a href="sms/index.php">Enviar SMS</a></li>
          <li>
            <a data-toggle="collapse" data-target="#tic" style="cursor:pointer">
              <i class="pull-right fa fa-chevron-down"></i>
              Centro TIC
            </a>
          </li>
          <div id="tic" class="panel-collapse collapse">
            <ul class="nav nav-list">
              <li><a href="TIC/usuarios/intro.php">Usuario alumno</a></li>
              <li><a href="TIC/usuarios/usuarioprofesor.php">Usuario profesor</a></li>
              <li><a href="TIC/documentos.php">Documentos</a></li>
              <li><a href="TIC/cpartes.php">Incidencias</a></li>
              <!--<li><a href="admin/recursos/">Recursos Educativos</a></li>-->    
              <li><a href="reservas/informes.php">Estadísticas </a></li>
            </ul>
          </div>
          <li>
            <a data-toggle="collapse" data-target="#reservas" style="cursor:pointer">
              <i class="pull-right fa fa-chevron-down"></i>
              Reservas de medios
            </a>
          </li>
          <div id="reservas" class="panel-collapse collapse">
            <ul class="nav nav-list">
              <li><a href="reservas/index.php?recurso=carrito">Carritos TIC</a></li>
              <li><a href="reservas/index.php?recurso=aula">Aulas compartidas</a></li>
              <? if ($mod_horario=="1") { ?>
              <li><a href="reservas/index_aula_grupo.php?recurso=aula_grupo">Aulas de grupo</a></li>
              <? } ?>
              <li><a href="reservas/index.php?recurso=medio">Medios audiovisuales</a></li>
              <li><a href="reservas/informes.php">Estadísticas</a></li>
            </ul>
          </div>
          <li><a href="admin/textos/intextos.php">Libros de texto</a></li>
          <li><a href="admin/actividades/consulta.php">Actividades extraescolares</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="panel panel-default well">
    <div class="panel-heading">
      <a class="panel-group-toggle" data-toggle="collapse" data-parent="#menu" href="#cosas">
        <i class="pull-right fa fa-chevron-down"></i>
        Otras cosas
      </a>
    </div>
    <div id="cosas" class="panel-collapse collapse">
      <div class="panel-body">
        <ul class="nav nav-list">
          <li><a href="http://www.juntadeandalucia.es/averroes/centros-tic/<? echo $codigo_del_centro; ?>/moodle/">Plataforma Moodle</a></li>
          <li><a href="admin/cursos/calendario.php">Calendario escolar</a></li>
          <li><a href="http://iesmonterroso.org/PC20122013/index.htm">Plan de Centro</a></li>
          <li><a href="clave.php">Cambiar contraseña</a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="panel panel-default well">
    <div class="panel-heading">
      <a class="panel-group-toggle" data-toggle="collapse" data-parent="#menu" href="#paginas">
        <i class="pull-right fa fa-chevron-down"></i>
        Otras páginas
      </a>
    </div>
    <div id="paginas" class="panel-collapse collapse">
      <div class="panel-body">
        <ul class="nav nav-list">
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
          
          <!--<li><a href="http://www.cep-marbellacoin.org/index.html" target="_blank">CEP de Marbella-Coín</a></li>-->
          <li><a href="http://www.mecd.gob.es" target="_blank">Página del MEC</a></li>
          <li><a href="http://www.juntadeandalucia.es/averroes/" target="_blank">Averroes</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>