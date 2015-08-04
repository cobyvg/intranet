<?php 
include('version.php');


function crear_archivo($filename) {
	if($file = fopen($filename, 'w+')) {
		fclose($file);
		unlink($filename);
		return 1;
	}
	else {
		return 0;
	}
}

function crear_directorio($dirname) {
	mkdir($dirname);
	if(! file_exists($dirname)) {
		return 0;
	}
	else {
		rmdir($dirname);
		return 1;
	}
}

function generador_password($long) {
	$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
	$cad = '';
	
	for($i=0;$i<($long+1);$i++) {
		$cad .= substr($str,rand(0,62),1);
	}
	return $cad;
}

function limpiar_caracteres($string) {
	$string = trim($string);
	return $string;
}

$provincias = array('Almería', 'Cádiz', 'Córdoba', 'Granada', 'Huelva', 'Jaén', 'Málaga', 'Sevilla');


$page_header = 'Instalación de la Intranet';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1">
	<title><?php echo $page_header; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Intranet del <?php echo $nombre_del_centro; ?>">
	<meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
	
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/otros.css" rel="stylesheet">
	
	<style type="text/css">
	.dl-horizontal dt {
		width: 230px;
	}
	
	.dl-horizontal dd {
		margin-left: 250px;
	}
	
	.searchable-container{margin:20px 0 0 0}
	.searchable-container label.btn-default.active{background-color:#007ba7;color:#FFF}
	.searchable-container label.btn-default{width:100%; border:1px solid #efefef; margin:5px;}
	.searchable-container label .bizcontent{width:100%;}
	.searchable-container .btn-group{width:100%}
	.searchable-container .btn span.glyphicon{
	    opacity: 0;
	}
	.searchable-container .btn.active span.glyphicon {
	    opacity: 1;
	}
	
	
	</style>
</head>

<body style="padding-top: 0;">

	<!--[if lte IE 9 ]>
	<div id="old-ie" class="modal">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<br>
	        <p class="lead text-center">Estás utilizando una versión de Internet Explorer demasiado antigua. <br>Actualiza tu navegador o cámbiate a <a href="http://www.google.com/chrome/">Chrome</a> o <a href="https://www.mozilla.org/es-ES/firefox/new/">Firefox</a>.</p>
	        <br>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<![endif]-->
	
	
	<div class="container">
		
		<div class="page-header">
			<h1 class="text-center">
				<span class="fa fa-dashboard fa-2x"></span><br>
				<?php echo $page_header; ?>
			</h1>
		</div>
		
		<form id="form-instalacion" class="form-horizontal" data-toggle="validator" role="form">
		
		<div class="row">
			
			<div class="col-sm-offset-2 col-sm-8">
				
				<div id="tabs-instalacion" class="tab-content">
				
					<!-- TERMINOS Y CONDICIONES DE USO -->
				    <div role="tabpanel" class="tab-pane active" id="terminos">
				    
				    	<div class="well">
				    		<h3>Términos y condiciones de uso</h3>
				    		<br>
				    		<object type="text/html" data="../LICENSE.md" style="width: 100%; min-height: 300px; border: 1px solid #dedede; background-color: #fff;"></object>
				    		
				    		<div class="checkbox">
				    			<label for="terms-accept">
				    				<input type="checkbox" name="terms-accept" id="terms-accept" value="YES">
				    				Acepto los términos y condiciones de uso de esta aplicación.
				    			</label>
				    		</div>
				    		
				    		<br>
				    		
				    		<div class="pull-right">
				    			<a href="#php-config" aria-controls="php-config" data-toggle="tab" class="btn btn-primary disabled">Continuar <span class="fa fa-chevron-right fa-fw"></span></a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    
				    </div>
				    
				    <!-- COMPROBACIÓN CONFIGURACIÓN PHP -->
				    <div role="tabpanel" class="tab-pane" id="php-config">
				    
				    	<div class="well">
				    		<h3>Configuración de PHP</h3>
				    		<br>
				    		
				    		<p class="text-center text-info">Para una mejor experiencia en el uso de la Intranet, es recomendable que las variables de configuración de PHP estén marcadas en verde. En el caso de que aparezca marcada en rojo, modifique la configuración en <em>php.ini</em> o póngase en contacto con su proveedor de alojamiento Web y vuelva a iniciar esta instalación.</p>
				    		<br>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Versión de PHP</dt>
				    		  <dd><?php echo (phpversion() < '5.3.0') ? '<span class="text-danger">Versión actual: '.phpversion().'. Actualice a la versión 5.3.0 o superior</span>' : '<span class="text-success">'.phpversion().'</span>'; ?></dd>
				    		</dl>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Display errors</dt>
				    		  <dd><?php echo (ini_get('display_errors') == 0) ? '<span class="text-success">Deshabilitado</span>' : '<span class="text-danger">Valor actual: Habilitado. Por seguridad, deshabilite la variable <em>display_errors</em></span>'; ?></dd>
				    		</dl>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Register globals</dt>
				    		  <dd><?php echo (ini_get('register_globals') == 0) ? '<span class="text-success">Deshabilitado</span>' : '<span class="text-danger">Valor actual: Habilitado. Por seguridad, deshabilite la variable <em>register_globals</em></span>'; ?></dd>
				    		</dl>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Upload max filesize</dt>
				    		  <dd><?php echo (substr(ini_get('upload_max_filesize'),0,-1) < '16') ? '<span class="text-danger">Valor actual: '.ini_get('upload_max_filesize').'B. Aumente el tamaño máximo de archivos a 16 MB o superior.</span>' : '<span class="text-success">'.ini_get('upload_max_filesize').'B</span>'; ?></dd>
				    		</dl>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Memory limit</dt>
				    		  <dd><?php echo (substr(ini_get('memory_limit'),0,-1) < '32') ? '<span class="text-danger">Valor actual: '.ini_get('memory_limit').'B. Aumente el tamaño de memoria a 32 MB o superior.</span>' : '<span class="text-success">'.ini_get('memory_limit').'B</span>'; ?></dd>
				    		</dl>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Escritura/lectura de archivos</dt>
				    		  <dd><?php echo (crear_archivo('install_tmp.txt')) ? '<span class="text-success">Habilitado</span>' : '<span class="text-danger">Valor actual: Deshabilitado. Debe crear el archivo <em>configuracion.php</em> en el directorio principal de la Intranet con permisos de escritura y lectura.</span>'; ?></dd>
				    		</dl>
				    		
				    		<dl class="dl-horizontal">
				    		  <dt>Escritura/lectura de directorios</dt>
				    		  <dd><?php echo (crear_directorio('install_tmp')) ? '<span class="text-success">Habilitado</span>' : '<span class="text-danger">Valor actual: Deshabilitado. Debe dar permisos de escritura y lectura a todos los directorios de la Intranet.</span>'; ?></dd>
				    		</dl>
				    		
				    		<br>
				    		
				    		<div class="pull-left">
				    			<a href="#terminos" aria-controls="terminos" data-toggle="tab" class="btn btn-default"><span class="fa fa-chevron-left fa-fw"></span> Anterior</a>
				    		</div>
				    		<div class="pull-right">
				    			<a href="#informacion" aria-controls="informacion" data-toggle="tab" class="btn btn-primary disabled">Continuar <span class="fa fa-chevron-right fa-fw"></span></a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    
				    </div>
				    
				    
				    <!-- INFORMACIÓN CENTRO EDUCATIVO -->
				    <div role="tabpanel" class="tab-pane" id="informacion">
				    	
				    	<div class="well">
				    		<h3>Información de su centro educativo</h3>
				    		<br>
				    		
				    		<?php $tam_label = 3; ?>
				    		<?php $tam_control = 8; ?>
				    			
				    		  <input type="hidden" name="dominio_centro" value="<?php echo ($_SERVER['SERVER_PORT'] != 80) ? $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'] : $_SERVER['SERVER_NAME']; ?>">
				    		  
				    		  <div class="form-group">
				    		    <label for="nombre_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Denominación</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="nombre_centro" name="nombre_centro" placeholder="I.E.S. Monterroso" data-error="La denominación del centro no es válida" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="codigo_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Centro código</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="codigo_centro" name="codigo_centro" placeholder="29002885" maxlength="8" data-minlength="8" data-error="El código del centro no es válido" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="email_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Correo electrónico</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="email" class="form-control" id="email_centro" name="email_centro" placeholder="29002885.edu@juntadeandalucia.es" data-error="La dirección de correo electrónico no es válida" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="direccion_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Dirección postal</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="direccion_centro" name="direccion_centro" placeholder="Calle Santo Tomás de Aquino, s/n" data-error="La dirección postal no es válida" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="codpostal_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Código postal</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="codpostal_centro" name="codpostal_centro" placeholder="29680" maxlength="5" data-minlength="5" data-error="El código postal no es válido" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="localidad_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Localidad</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="localidad_centro" name="localidad_centro" placeholder="Estepona" data-error="La localidad no es válida" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="provincia_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Provincia</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <select class="form-control" id="provincia_centro" name="provincia_centro" data-error="La provincia no es válida" required>
				    		      	<option value=""></option>
				    		      	<?php foreach($provincias as $provincia): ?>
				    		      	<option value="<?php echo $provincia; ?>"><?php echo $provincia; ?></option>
				    		      	<?php endforeach; ?>
				    		      </select>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="telefono_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Teléfono</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="tel" class="form-control" id="telefono_centro" name="telefono_centro" placeholder="952795802" maxlength="9" data-minlength="9" data-error="El télefono no es válido" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="fax_centro" class="col-sm-<?php echo $tam_label; ?> control-label">Fax</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="tel" class="form-control" id="fax_centro" name="fax_centro" placeholder="952795802" maxlength="9" data-minlength="9" data-error="El fax no es válido">
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		
				    		<br>
				    		
				    		<div class="pull-left">
				    			<a href="#php-config" aria-controls="php-config" data-toggle="tab" class="btn btn-default"><span class="fa fa-chevron-left fa-fw"></span> Anterior</a>
				    		</div>
				    		<div class="pull-right">
				    			<a href="#base-datos" aria-controls="base-datos" data-toggle="tab" class="btn btn-primary disabled">Continuar <span class="fa fa-chevron-right fa-fw"></span></a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	
				    </div>
				    
				    
				    <!-- CONFIGURACIÓN DE LA BASE DE DATOS -->
				    <div role="tabpanel" class="tab-pane" id="base-datos">
				    	
				    	<div class="well">
				    		<h3>Configuración de la base de datos</h3>
				    		<br>
				    		  
				    		  <?php $tam_label = 3; ?>
				    		  <?php $tam_control = 8; ?>
				    		  
				    		  <div class="form-group">
				    		    <label for="db_host" class="col-sm-<?php echo $tam_label; ?> control-label">Servidor</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="db_host" name="db_host" placeholder="localhost" data-error="La dirección servidor de base de datos no es válida" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="db_name" class="col-sm-<?php echo $tam_label; ?> control-label">Base de datos</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="db_name" name="db_name" placeholder="intranet" data-error="El nombre de la base de datos no es válido" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="db_user" class="col-sm-<?php echo $tam_label; ?> control-label">Usuario</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="db_user" name="db_user" data-error="El nombre de usuario de la base de datos no es válido" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="db_pass" class="col-sm-<?php echo $tam_label; ?> control-label">Contraseña</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="password" class="form-control" id="db_pass" name="db_pass" data-error="La contraseña de la base de datos no es válido" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		
				    		<br>
				    		
				    		<div class="pull-left">
				    			<a href="#informacion" aria-controls="informacion" data-toggle="tab" class="btn btn-default"><span class="fa fa-chevron-left fa-fw"></span> Anterior</a>
				    		</div>
				    		<div class="pull-right">
				    			<a href="#curso-escolar" aria-controls="curso-escolar" data-toggle="tab" class="btn btn-primary disabled">Continuar <span class="fa fa-chevron-right fa-fw"></span></a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	
				    </div>
				    
				    
				    <!-- INFORMACIÓN CURSO ESCOLAR -->
				    <div role="tabpanel" class="tab-pane" id="curso-escolar">
				    	
				    	<div class="well">
				    		<h3>Información del curso escolar</h3>
				    		<br>
				    		  
				    		  <?php $tam_label = 3; ?>
				    		  <?php $tam_control = 8; ?>
				    		  
				    		  <div class="form-group">
				    		    <label for="curso_escolar" class="col-sm-<?php echo $tam_label; ?> control-label">Curso escolar</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="curso_escolar" name="curso_escolar" value="<?php echo (date('n') > 6) ?  date('Y').'/'.(date('y')+1) : (date('Y')-1).'/'.date('y'); ?>" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="fecha_inicio" class="col-sm-<?php echo $tam_label; ?> control-label">Fecha de inicio</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo (date('n') > 6) ?  date('Y').'-09-15' : (date('Y')-1).'-09-15'; ?>" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		  
				    		  <div class="form-group">
				    		    <label for="fecha_final" class="col-sm-<?php echo $tam_label; ?> control-label">Fecha final</label>
				    		    <div class="col-sm-<?php echo $tam_control; ?>">
				    		      <input type="text" class="form-control" id="fecha_final" name="fecha_final" value="<?php echo (date('n') > 6) ?  (date('Y')+1).'-06-23' : date('Y').'-06-23'; ?>" required>
				    		      <div class="help-block with-errors"></div>
				    		    </div>
				    		  </div>
				    		
				    		<br>
				    		
				    		<div class="pull-left">
				    			<a href="#base-datos" aria-controls="base-datos" data-toggle="tab" class="btn btn-default"><span class="fa fa-chevron-left fa-fw"></span> Anterior</a>
				    		</div>
				    		<div class="pull-right">
				    			<a href="#modulos" aria-controls="modulos" data-toggle="tab" class="btn btn-primary disabled">Continuar <span class="fa fa-chevron-right fa-fw"></span></a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	
				    </div>
				    
				    <!-- SELECCIÓN DE MÓDULOS -->
				    <div role="tabpanel" class="tab-pane" id="modulos">
				    	
				    	<div class="well">
				    		<h3>Configuración de módulos</h3>
				    		
							<br>
	    		            
				    		<div class="row">
				    			<div class="col-sm-4" style="border-right: 3px solid #dce4ec; margin-right: 25px;">
									<ul class="nav nav-pills nav-stacked" role="tablist">
										<li class="active"><a href="#mod_biblioteca" aria-controls="mod_biblioteca" role="tab" data-toggle="tab">Biblioteca</a></li>
										<li><a href="#mod_bilingue" aria-controls="mod_bilingue" role="tab" data-toggle="tab">Centro Bilingüe</a></li>
										<li><a href="#mod_centrotic" aria-controls="mod_centrotic" role="tab" data-toggle="tab">Centro TIC</a></li>
										<li><a href="#mod_documentos" aria-controls="mod_documentos" role="tab" data-toggle="tab">Documentos</a></li>
										<li><a href="#mod_sms" aria-controls="mod_sms" role="tab" data-toggle="tab">Envío SMS</a></li>
										<li><a href="#mod_asistencia" aria-controls="mod_asistencia" role="tab" data-toggle="tab">Faltas de Asistencia</a></li>
										<li><a href="#mod_horarios" aria-controls="mod_horarios" role="tab" data-toggle="tab">Horarios</a></li>
										<li><a href="#mod_matriculacion" aria-controls="mod_matriculacion" role="tab" data-toggle="tab">Matriculación</a></li>
									</ul>
								</div>
								
				    			<div class="tab-content col-sm-7">
				    				
				    				<!-- MÓDULO: BIBLIOTECA -->
				    			    <div role="tabpanel" class="tab-pane active" id="mod_biblioteca">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
						    			    		<input type="checkbox" name="mod_biblioteca" value="1">
						    			    		<strong>Biblioteca</strong>
						    			    		<p class="help-block">Si el Centro dispone de Biblioteca que funciona con Abies, y cuenta con un equipo de profesores dedicados a su mantenimiento, puedes activar este módulo. Permite consultar e importar los fondos, lectores y préstamos, así como hacer un seguimiento de los alumnos morosos.</p>
						    			    	</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    	<br>
				    			    	
				    			    	<div class="form-group">
				    			    		<label for="mod_biblioteca_web">Página web de la Biblioteca</label>
				    			    		<div class="input-group">
			    			    		      <div class="input-group-addon">http://</div>
			    			    		      <input type="text" class="form-control" id="mod_biblioteca_web" name="mod_biblioteca_web" placeholder="iesmonterroso.org/biblioteca/">
			    			    		    </div>
				    			    	</div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: CENTRO BILINGÜE -->
				    			    <div role="tabpanel" class="tab-pane" id="mod_bilingue">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
						    			    		<input type="checkbox" name="mod_bilingue" value="1">
						    			    		<strong>Centro Bilingüe</strong>
						    			    		<p class="help-block">Activa características para los Centros Bilingües, como el envío de mensajes a los profesores que pertenecen al programa bilingüe.</p>
						    			    	</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: CENTRO TIC -->
				    			    <div role="tabpanel" class="tab-pane" id="mod_centrotic">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
						    			    		<input type="checkbox" name="mod_centrotic" value="1">
						    			    		<strong>Centro TIC</strong>
						    			    		<p class="help-block">Aplicaciones propias de un Centro TIC: Incidencias, usuarios, etc.</p>
						    			    	</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: DOCUMENTOS --> 
				    			    <div role="tabpanel" class="tab-pane" id="mod_documentos">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
					    			    			<input type="checkbox" name="mod_documentos" value="1" checked>
					    			    			<strong>Documentos</strong>
					    			    			<p class="help-block">Directorio en el Servidor local donde tenemos documentos públicos que queremos administrar (visualizar, eliminar, subir, compartir, etc.) con la Intranet.</p>
					    			    		</label>
					    			    	</div>
					    			    </div>
				    			    				    			    	
				    			    	<div class="form-group">
				    			    		<label for="mod_documentos_dir">Directorio público</label>
				    			    	    <input type="text" class="form-control" id="mod_documentos_dir" name="mod_documentos_dir" placeholder="<?php echo __DIR__; ?>">
				    			    	</div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: ENVÍO DE SMS -->
				    			    <div role="tabpanel" class="tab-pane" id="mod_sms">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
					    			    			<input type="checkbox" name="mod_sms" value="1">
					    			    			<strong>Envío de SMS</strong>
					    			    			<p class="help-block">Pone en funcionamiento el envío de SMS en distintos lugares de la Intranet (Problemas de convivencia, faltas de asistencia, etc.). La aplicación está preparada para trabajar con la API de <a href="http://www.trendoo.es/" target="_blank">Trendoo</a>.</p>
					    			    		</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    	<div class="form-group">
				    			    		<label for="mod_sms_id">Nombre de identificación</label>
				    			    	    <input type="text" class="form-control" id="mod_sms_id" name="mod_sms_id" placeholder="P. ej. IMonterroso">
				    			    	</div>
				    			    	
				    			    	<div class="form-group">
				    			    		<label for="mod_sms_user">Usuario</label>
				    			    	    <input type="text" class="form-control" id="mod_sms_user" name="mod_sms_user">
				    			    	</div>
				    			    	
				    			    	<div class="form-group">
				    			    		<label for="mod_sms_pass">Contraseña</label>
				    			    	    <input type="password" class="form-control" id="mod_sms_pass" name="mod_sms_pass">
				    			    	</div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: FALTAS DE ASISTENCIA -->
				    			    <div role="tabpanel" class="tab-pane" id="mod_asistencia">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
					    			    			<input type="checkbox" id="check_asistencia" name="mod_asistencia" value="1">
					    			    			<strong>Faltas de Asistencia</strong>
					    			    			<p class="help-block">El módulo de faltas permite gestionar las faltas a través de la Intranet para luego exportarlas a Séneca. Es posible también descargar las faltas desde Séneca para utilizar los módulo de la aplicación basados en faltas de asistencia (Informes de alumnos, Tutoría, Absentismo, etc.).</p>
					    			    		</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    	<div class="alert alert-warning">Este módulo depende del módulo de Horarios. Si decide utilizarlo se activará el módulo de Horarios automáticamente.</div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: HORARIOS -->
				    			    <div role="tabpanel" class="tab-pane" id="mod_horarios">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
					    			    			<input type="checkbox" id="check_horarios" name="mod_horarios" value="1">
					    			    			<strong>Horarios</strong>
					    			    			<p class="help-block">Si disponemos de un archivo de Horario en formato XML (como el que se utiliza para subir a Séneca) o DEL (como el que genera el programa Horw) para importar sus datos a la Intranet. Aunque no obligatoria, esta opción es necesaria si queremos hacernos una idea de todo lo que la aplicación puede ofrecer.</p>
					    			    		</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    </div>
				    			    
				    			    
				    			    <!-- MÓDULO: MATRICULACIÓN -->
				    			    <div role="tabpanel" class="tab-pane" id="mod_matriculacion">
				    			    	
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
					    			    			<input type="checkbox" name="mod_matriculacion" value="1">
					    			    			<strong>Matriculación</strong>
					    			    			<p class="help-block">Este módulo permite matricular a los alumnos desde la propia aplicación o bien desde la página pública del Centro incluyendo el código correspondiente.</p>
					    			    		</label>
					    			    	</div>
					    			    </div>
					    			    
				    			    	<div class="form-group">
					    			    	<div class="checkbox">
					    			    		<label>
					    			    			<input type="checkbox" name="mod_transporte_escolar" value="1">
					    			    			<strong>Transporte escolar</strong>
					    			    			<p class="help-block">Activa la selección de transporte escolar</p>
					    			    		</label>
					    			    	</div>
					    			    </div>
				    			    	
				    			    </div>
				    			  </div>
				    		</div>
				    		
				    		<br><br>
				    		
				    		<div class="pull-left">
				    			<a href="#base-datos" aria-controls="base-datos" data-toggle="tab" class="btn btn-default"><span class="fa fa-chevron-left fa-fw"></span> Anterior</a>
				    		</div>
				    		<div class="pull-right">
				    			<a href="#instalacion" aria-controls="instalacion" data-toggle="tab" class="btn btn-primary disabled">Continuar <span class="fa fa-chevron-right fa-fw"></span></a>
				    		</div>
				    		<div class="clearfix"></div>
				    	</div>
				    	
				    </div>
				    
				    <!-- INSTALACION -->
				    <div role="tabpanel" class="tab-pane" id="instalacion">
				    	
				    	<div class="well">
				    		<h3>
				    			<span class="fa fa-"></span>
				    			¡Enhorabuena!
				    		</h3>
				    		<br>
				    		  
				    		<code class="lead"><?php echo generador_password(12); ?></code>	
				    		
				    		    			
				    		<div class="pull-right">
				    			<button type="submit" class="btn btn-primary" name="instalar">Instalar</button>
				    		</div>
				    		
				    		<div class="text-center">
				    			<a href="#" class="btn btn-primary">Iniciar sesión</a>
				    		</div>
				    	</div>
				    </div>
				    
				  </div><!-- /.tab-content -->
				
			</div><!-- /.col-sm-offset-2 .col-sm-8 -->
			
		</div><!-- /.row -->
		
		</form>
		
		
	</div><!-- /.container -->
	
	
	<footer class="hidden-print">
		<div class="container-fluid" role="footer">
			<hr>
			
			<p class="text-center">
				<small class="text-muted">Versión <?php echo INTRANET_VERSION; ?> - Copyright &copy; <?php echo date('Y'); ?> IESMonterroso</small><br>
				<small class="text-muted">Este programa es software libre, liberado bajo la GNU General Public License.</small>
			</p>
			<p class="text-center">
				<small>
					<a href="//<?php echo $dominio; ?>/intranet/LICENSE.md" target="_blank">Licencia de uso</a>
					&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;
					<a href="https://github.com/IESMonterroso/intranet" target="_blank">Github</a>
				</small>
			</p>
		</div>
	</footer>
	
	
	<script src="../js/jquery-1.11.3.min.js"></script>  
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/validator/validator.min.js"></script>
	

	<script>
	$(document).ready(function() {
		
		$('#old-ie').modal({
			backdrop: true,
			keyboard: false,
			show: true
		});
		
		
		$("#terms-accept").click(function() {  
	        if($("#terms-accept").is(':checked')) {  
	            $("a").removeClass("disabled"); 
	        } else {  
	            $("a").addClass("disabled");   
	        }  
	    });
	    
	    $("#check_asistencia").click(function() {  
	        if($("#check_asistencia").is(':checked')) {  
	            $("#check_horarios").prop('checked', true);
	        } else {  
	            $("#check_horarios").prop('checked', false);
	        }  
	    });
	    
	    $("#check_horarios").click(function() {  
	        if(! $("#check_horarios").is(':checked')) {  
	            $("#check_asistencia").prop('checked', false);
	        }
	    });
	    
	    $('#form-instalacion').validator();
		
	});
	</script>
	
</body>
</html>
