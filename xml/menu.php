<ul class="nav nav-pills nav-stacked">
	<li class="nav-header">Configuración</li> 
	<li><a href="../config/index.php">Cambiar Configuración</a></li>
	
	<li class="nav-header">A principio de curso...</li>
	<li><a href="jefe/index2.php">Importar Alumnos</a></li>
	<li><a href="jefe/asignaturas.php">Importar Asignaturas</a></li>
	<li><a href="jefe/index_xml.php">Importar datos del Centro</a></li>
	  <? if ($mod_horario) {?>
	<li><a href="jefe/horario.php">Importar/Preparar Horarios </a></li>
	<?}?>
	<li><a href="jefe/indexdepartamentos.php">Importar Departamentos y Especialidades</a></li>
	<li><a href="jefe/indexprofesores.php">Importar Profesores</a></li>
	<li><a href="../faltas/seneca/index_festivos.php">Importar días festivos</a></li>
	<li><a href="../faltas/seneca/index_jornada.php">Importar Jornada</a></li> 
	<li><a href="jefe/rof/index.php">Modificar ROF</a></li>


	<li class="nav-header">Profesores</li> 
	<li><a href="../config/cargos.php">Seleccionar Perfil de los Profesores</a></li>
	<li><a href="jefe/gest_dep.php">Gestión de los Departamentos</a></li>
	<li><a href="jefe/reset_password.php">Restablecer contraseñas</a></li>
	<li><a href="jefe/horarios/index.php">Modificar Horarios</a></li>
	<li><a href="jefe/index_hor.php">Copiar datos de un profesor a otro</a></li>
	<li><a href="jefe/index_fotos_profes.php">Subir fotos de profesores</a></li>
	<li><a href="jefe/informes/accesos.php">Informe de accesos</a></li>

	<li class="nav-header">Actualizaci&oacute;n</li>
	<li><a href="jefe/index.php">Actualizar Alumnos</a></li>
	<li><a href="jefe/horario.php">Actualizar Horarios</a></li>
	<li><a href="jefe/indexprofesores.php">Actualizar Profesores</a></li>
	<li><a href="jefe/indexdepartamentos2.php">Actualizar Departamentos</a></li>
	<? if ($mod_horario) {?>
	<li><a href="jefe/index_limpia.php">Limpiar Horarios</a></li>
	<?}?>

	<li class="nav-header">Notas de evaluaci&oacute;n</li>
	<li>
	<a href="jefe/index_notas.php">Importar Calificaciones</a></li>
	
	<? if ($mod_faltas) {?>

	<li class="nav-header">Faltas de asistencia</li>
	<li><a href="../faltas/seneca/importarSeneca.php?admin=1">Importar Faltas de Asistencia</a></li>
	<li><a href="../admin/cursos/horariototal_faltas.php" target="_blank">Parte de faltas completo (por días)</a></li>
	<li><a href="../admin/faltas/horario_semanal.php" target="_blank">Parte de faltas completo (semanal)</a></li>
	<li><a href="../admin/faltas/horario_semanal_div.php" target="_blank">Parte de faltas completo Diversificación</a></li>		
	<li><a href="../admin/cursos/horariofaltas.php">Horario de Faltas para Profesores</a> </li>
	<li><a href="../admin/faltas/cpadres.php">Informe de Faltas para Padres</a></li>
	<? if ($mod_sms) {?>
	<li><a href="../sms/sms_cpadres.php">SMS de Faltas para Padres</a></li>
	 <?}?>
	<li><a href="../faltas/absentismo/index.php">Alumnos Absentistas</a></li>
	<? }?>

	<li class="nav-header">Alumnos</li>
	<li><a href="../admin/cursos/listatotal.php">Listas de todos los Grupos</a></li>
	<li><a href="jefe/form_carnet.php">Carnet de los alumnos</a></li>
	<li><a href="jefe/index_fotos.php">Subir fotos de alumnos</a></li>
	</a></li>
	<li><a href="../admin/libros/indextextos.php">Libros de Texto Gratuitos
	</a></li>
	<? if ($mod_matriculas==1) { ?>
	<li><a href="../admin/matriculas/index.php">Matriculación de alumnos
	</a></li>
	<li><a href="./jefe/index_mayores.php">Alumnos mayores de 18 años
	</a></li>	
	<? } ?>
	<li><a href="jefe/informes/accesos_alumnos.php">Informe de accesos</a></li>

	<li class="nav-header">Bases de datos</li>
	<li><a href="jefe/copia_db/index.php">Copias de seguridad</a></li>
	</a></li>
</ul>