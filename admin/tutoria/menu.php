	<div class="container">
			
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'global.php')==TRUE) ? ' class="active"' : ''; ?>><a href="global.php?tutor=<?php echo $tutor; ?>">Resumen global</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'intervencion.php')==TRUE) ? ' class="active"' : ''; ?>><a href="intervencion.php?tutor=<?php echo $tutor; ?>">Intervenciones tutoriales</a></li>
			<?php if (isset($mod_sms) && $mod_sms): ?>
			<li><a href="../../sms/index.php?unidad=<?php echo $unidad;?>">Enviar SMS</a></li>
			<?php endif; ?>
			<li class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		      Consultas <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu" role="menu">
		    	<li><a href="../datos/datos.php?unidad=<?php echo $unidad ?>">Datos de alumnos/as</a></li>
		      <li><a href="../cursos/ccursos.php?unidad=<?php echo $unidad; ?>&submit1=1">Listado de alumnos/as</a></li>
		      <li><a href="../fotos/grupos.php?curso=<?php echo $unidad; ?>">Fotografías de alumnos/as</a></li>
		      <li><a href="">Importar fotografías</a></li>
		      <li><a href="absentismo.php?tutor=<?php echo $tutor; ?>">Alumnos absentistas</a></li>
		      <li><a href="../../upload/index.php?index=publico&direction=0&order=&directory=programaciones/Orientacion">Material de orientación</a></li>
		    </ul>
		  </li>
		  <li class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		      Informes <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu" role="menu">
		    	<li><a href="../informes/cinforme.php?unidad=<?php echo $unidad; ?>">Informe de un alumno/a</a></li>
		      <li><a href="../infotutoria/index.php">Informes de tutoría</a></li>
		      <li><a href="../tareas/index.php">Informes de tareas</a></li>
		      <li class="divider"></li>
		      <li><a href="memoria.php?unidad=<?php echo $unidad; ?>&tutor=<?php echo $tutor; ?>">Memoria de tutoría</a></li>
		    </ul>
		  </li>
		  <li<?php echo (strstr($_SERVER['REQUEST_URI'],'puestos.php')==TRUE) ? ' class="active"' : ''; ?>><a href="puestos.php?unidad=<?php echo $unidad; ?>&tutor=<?php echo $tutor; ?>">Asignación de mesas</a></li>
		  <li><a href="../../xml/jefe/form_carnet.php">Credenciales de alumnos</a></li>
		  <?php if(substr($unidad,1,1) == "E"): ?>
		  <li><a href="../libros/libros.php?unidad=<?php echo $unidad; ?>&tutor=1">Libros de Texto</a></li>
		  <?php endif; ?>
		</ul>
		
	</div>
