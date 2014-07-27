<ul class="nav nav-pills nav-stacked">
	<li class="nav-header">Configuración</li> 
	<li><a href="../config/index.php" class="enlacelateral">Cambiar Configuración</a></li>

	
	<li class="nav-header">A principio de curso...</li>
	<li><a href="jefe/index2.php" class="enlacelateral">Importar Alumnos</a></li>
	<li><a href="jefe/index_xml.php" class="enlacelateral">Importar datos del Centro</a></li>
	  <? if ($mod_horario) {?>
	<li><a href="jefe/admin/" class="enlacelateral">Importar Horarios</a></li>
	<?}?>
	<li><a href="jefe/asignaturas.php" class="enlacelateral">Importar Asignaturas</a></li>
	<li><a href="jefe/indexprofesores.php" class="enlacelateral">Importar Profesores</a></li>
	<li><a href="jefe/horario_xml.php" class="enlacelateral">Exportación de los Horarios a Séneca</a></li>
	<li><a href="jefe/index_pendientes.php" class="enlacelateral">Lista de Alumnos con pendientes</a></li>
	  <? if ($mod_tic and $mod_horario) {?>
	<!--<li><a href="../TIC/distribucion/crea_tabla.php" class="enlacelateral">Crear Asignación TIC</a></li>-->
	<?}?>
	<li><a href="jefe/rof/index.php" class="enlacelateral">Modificar ROF</a></li>

	<li class="nav-header">Profesores</li> 
	<li><a href="../config/cargos.php" class="enlacelateral">Seleccionar Perfil de los Profesores</a></li>
	<li><a href="jefe/gest_dep.php" class="enlacelateral">Gestión de los Departamentos</a></li>
	<li><a href="jefe/reset_password.php" class="enlacelateral">Reiniciar Contraseña</a></li>
	<li><a href="jefe/index_hor.php" class="enlacelateral">Copiar datos de un profesor a otro</a></li>
	<li><a href="jefe/index_fotos_profes.php" class="enlacelateral">Subir fotos de profesores</a></li>
	<li><a href="jefe/informes/accesos.php" class="enlacelateral">Informe de accesos</a></li>

	<li class="nav-header">Actualizaci&oacute;n</li>
	<li><a href="jefe/index.php" class="enlacelateral">Actualizar Alumnos</a></li>
	<li><a href="jefe/admin/actualiza_horario.php" class="enlacelateral">Actualizar Horarios</a></li>
	<li><a href="jefe/indexprofesores.php" class="enlacelateral">Actualizar Profesores</a></li>
	<li><a href="jefe/indexdepartamentos2.php" class="enlacelateral">Actualizar Departamentos</a></li>
	<? if ($mod_horario) {?>
	<li><a href="jefe/index_limpia.php" class="enlacelateral">Limpiar Horarios</a></li>
	<?}?>

	<li class="nav-header">Notas de evaluaci&oacute;n</li>
	<li>
	<a href="jefe/index_notas.php" class="enlacelateral">Importar Calificaciones</a></li>
	
	<? if ($mod_faltas) {?>

	<li class="nav-header">Faltas de asistencia</li>
	<li><a href="../faltas/absentismo/index.php" class="enlacelateral">Alumnos Absentistas</a></li>
	<li><a href="../admin/cursos/horariototal_faltas.php" class="enlacelateral" target="_blank">Parte de faltas completo (por días)</a></li>
	<li><a href="../admin/faltas/horario_semanal.php" class="enlacelateral" target="_blank">Parte de faltas completo (semanal)</a></li>
	<li><a href="../admin/faltas/cpadres.php" class="enlacelateral">Informe de Faltas para Padres</a></li>
	<? }?>
	<? if ($mod_horario and $mod_faltas) {?>
	<li><a href="../admin/cursos/horariofaltas.php" class="enlacelateral">Horario de Faltas para Profesores</a> </li>
	<? }?>
	<? if ($mod_sms and $mod_faltas) {?>
	<li><a href="../sms/sms_cpadres.php" class="enlacelateral">SMS
	    de Faltas para Padres</a></li>
	    <?}?>

	<li class="nav-header">Alumnos</li>
	<li><a href="../admin/cursos/listatotal.php" class="enlacelateral">Listas de todos los Grupos</a></li>
	<li><a href="jefe/form_carnet.php" class="enlacelateral">Carnet de los alumnos</a></li>
	<li><a href="jefe/index_fotos.php" class="enlacelateral">Subir fotos de alumnos</a></li>
	</a></li>
	<li><a href="../admin/libros/indextextos.php" class="enlacelateral">Libros de Texto Gratuitos
	</a></li>
	<li><a href="../admin/matriculas/index.php" class="enlacelateral">Matriculación de alumnos
	</a></li>
	<li><a href="jefe/informes/accesos_alumnos.php" class="enlacelateral">Informe de accesos</a></li>

	<li class="nav-header">Bases de datos</li>
	<li><a href="jefe/copia_db/dump_db.php" class="enlacelateral">Copia de seguridad de la Base de datos</a></li>
	<li><a href="jefe/copia_db/restaurar_bd.php" class="enlacelateral">Restaurar Base de datos</a></li>
	</a></li>
</ul>