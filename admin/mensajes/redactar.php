<?php
session_start();
include("../../config.php");
include("../../config/version.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$pr = $_SESSION['profi'];

if (isset($_POST['profes'])) {
	$profes = $_POST['profes'];
} 
elseif (isset($_GET['profes'])) {
	$profes = $_GET['profes'];
} 

$_SESSION['msg_block'] = 0;

if($_POST['token']) $token = $_POST['token'];
if(!isset($token)) $token = time(); 

$profeso = $_POST['profeso'];
$tutores = $_POST['tutores'];
$tutor = $_POST['tutor'];
$departamentos = $_POST['departamentos'];
$departamento = $_POST['departamento'];
$equipos = $_POST['equipos'];
$equipo = $_POST['equipo'];
$claustro = $_POST['claustro'];
$etcp = $_POST['etcp'];
$ca = $_POST['ca'];
$direccion = $_POST['direccion'];
$orientacion = $_POST['orientacion'];
$bilingue = $_POST['bilingue'];
$biblio = $_POST['biblio'];
$profesor = $_POST['profesor'];

if (isset($_POST['padres'])) {
	$padres = $_POST['padres'];
} 
elseif (isset($_GET['padres'])) {
	$padres = $_GET['padres'];
} 
else
{
$padres="";
}
if (isset($_POST['asunto'])) {
	$asunto = htmlspecialchars($_POST['asunto'], ENT_QUOTES, 'ISO-8859-1');
} 
elseif (isset($_GET['asunto'])) {
	$asunto = htmlspecialchars($_GET['asunto'], ENT_QUOTES, 'ISO-8859-1');
} 
else
{
$asunto="";
}
if (isset($_POST['texto'])) {
	$texto = htmlspecialchars($_POST['texto'], ENT_QUOTES, 'ISO-8859-1');
} 
elseif (isset($_GET['texto'])) {
	$texto = htmlspecialchars($_GET['texto'], ENT_QUOTES, 'ISO-8859-1');
} 
if (isset($_POST['origen'])) {
	$origen = $_POST['origen'];
} 
elseif (isset($_GET['origen'])) {
	$origen = $_GET['origen'];
} 
else
{
$origen="";
}


$verifica = $_GET['verifica'];
if($verifica){
 mysqli_query($db_con, "UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$verifica'");
}

if (isset($_GET['id'])) {
	
	if (isset($_POST['submit1'])) {
		$result = mysqli_query($db_con, "UPDATE mens_texto SET asunto='$asunto', texto='$texto' WHERE id=".$_GET['id']." LIMIT 1");
		
		if(!$result) {
			$msg_error = "No se ha podido editar el mensaje. Error: ".mysqli_error($db_con);
			$_SESSION['msg_block'] == 0;
		}
		else {
			unset($_SESSION['msg_block']);
			header('Location:'.'index.php?inbox=recibidos&action=send');
			exit;
		}
	}
	
	$result = mysqli_query($db_con, "SELECT ahora, asunto, texto, destino FROM mens_texto WHERE id=".$_GET['id']."");
	if (mysqli_num_rows($result)) {
		$row = mysqli_fetch_array($result);
		
		$ahora = $row['ahora'];
		$asunto = htmlspecialchars($row['asunto']);
		$texto = htmlspecialchars($row['texto']);
		$destino = trim($row['destino'],'; ');
		
		$num_seg = (strtotime(date('Y-m-d H:i:s')) - strtotime($ahora)) * 60;
		if ($num_seg > (60 * 60)) {
			header('Location:'.'index.php?inbox=enviados&action=exceeded');
		}
		
		$bloq_destinatarios = 1;
	}
	else {
		unset($_GET['id']);
	}
	
}
else {
	include("profesores.php");
}

include('../../menu.php');
include('menu.php');
$page_header = "Redactar mensaje";
?>
	<div class="container">
  	
  	
  	<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
	    <h2>Mensajes <small><?php echo $page_header; ?></small></h2>
	  </div>
	  
	  <!-- MENSAJES -->
	  <?php if (isset($msg_error)): ?>
	  <div class="alert alert-danger">
	  	<?php echo $msg_error; ?>
	  </div>
	  <?php endif; ?>
	  
	  
	  <form method="post" action="">
	  
	  <!-- SCALLFODING -->
		<div class="row">
    
    	<!-- COLUMNA IZQUIERDA -->
      <div class="col-sm-7">
      
      	<div class="well">
      		
      		<fieldset>
      			<legend>Redactar mensaje</legend>
      			
      			<input type="hidden" name="token" value="<?php echo $token; ?>">
      		
	      		<div class="form-group">
	      			<label for="asunto">Asunto</label>
	      			<input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del mensaje" value="<?php echo (isset($asunto)) ? $asunto : ''; ?>" maxlength="120" autofocus>
	      		</div>
	      		
	      		<div class="form-group">
	      			<label for="texto" class="sr-only">Contenido</label>
	      			<textarea class="form-control" id="texto" name="texto" rows="10" maxlength="3000"><?php echo (isset($texto) && $texto) ? $texto : ''; ?></textarea>
	      		</div>
	      		
	      		<button type="submit" class="btn btn-primary" data-loading-text="Loading..." name="submit1">Enviar mensaje</button>
	      		<a href="index.php" class="btn btn-default">Volver</a>
      		
      		</fieldset>
      		
      	</div><!-- /.well-->
         
      </div><!-- /.col-sm-7 -->
      
      <!-- COLUMNA DERECHA -->
      <div class="col-sm-5">
      
      	<div id="grupos_destinatarios" class="well">
      		
      		<fieldset>
      			<legend>Grupos de destinatarios</legend>
      			
      			<input type="hidden" name="profesor" value="<?php echo $pr; ?>">
      			
      			<?php if (!isset($bloq_destinatarios) && !$bloq_destinatarios): ?>
            <div class="row">
            	
            	<!-- COLUMNA IZQUIERDA -->
              <div class="col-sm-6">
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input name="profes" type="checkbox" value="1" onClick="submit()" <?php if($profes=='1' and !$claustro) echo 'checked'; ?>> Profesores
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input name="tutores" type="checkbox" value="1" onClick="submit()" <?php if($tutores=='1' and !$claustro) echo 'checked'; ?>> Tutores
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input name="departamentos" type="checkbox" value="1" onClick="submit()" <?php if($departamentos=='1' and !$claustro) echo 'checked'; ?>> Departamentos
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input name="equipos" type="checkbox" value="1" onClick="submit()" <?php if($equipos=='1' and !$claustro) echo 'checked'; ?>> Equipos educativos
                		</label>
                	</div>
                </div>
                
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input name="claustro" type="checkbox" value="1" onClick="submit()" <?php if($claustro=='1') echo 'checked'; ?>> Todo el claustro
                		</label>
                	</div>
                </div>
                
                <?php if(isset($mod_biblio) && $mod_biblio): ?>
                <div class="form-group">
                	<div class="checkbox">
                		<label>
                			<input name="biblio" type="checkbox" value="1" onClick="submit()" <?php if($biblio=='1' and !$claustro) echo 'checked'; ?>> Biblioteca
                		</label>
                	</div>
                </div>
                <?php endif; ?>
                
              </div>
              
              
              <!-- COLUMNA DERECHA -->
              <div class="col-sm-6">
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input name="etcp" type="checkbox" value="1" onClick="submit()" <?php if($etcp=='1' and !$claustro) echo 'checked'; ?>> Jefes Departamento
              			</label>
              		</div>
              	</div>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input name="ca" type="checkbox" value="1" onClick="submit()" <?php if($ca=='1' and !$claustro) echo 'checked'; ?>> Coordinadores Área
              			</label>
              		</div>
              	</div>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input name="direccion" type="checkbox" value="1" onClick="submit()" <?php if($direccion=='1' and !$claustro) echo 'checked'; ?>> Equipo directivo
              			</label>
              		</div>
              	</div>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input name="orientacion" type="checkbox" value="1" onClick="submit()" <?php if($orientacion=='1' and !$claustro) echo 'checked'; ?>> Orientación
              			</label>
              		</div>
              	</div>
              	
              	<?php if(isset($mod_bilingue) && $mod_bilingue): ?>
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input name="bilingue" type="checkbox" value="1" onClick="submit()" <?php if($bilingue=='1' and !$claustro) echo 'checked'; ?>> Profesores bilingüe
              			</label>
              		</div>
              	</div>
              	<?php endif; ?>
              	
              	<div class="form-group">
              		<div class="checkbox">
              			<label>
              				<input name="padres" type="checkbox" value="1" onClick="submit()" <?php if($padres=='1' and !$claustro) echo 'checked'; ?>> Familias y alumnos
              			</label>
              		</div>
              	</div>
              
              </div>
              <?php else: ?>
              
              <p class="help-block"><?php echo $destino; ?></p>
              
              <?php endif; ?>
            
      		</fieldset>
      	
      	</div>
      	
				
				<?php if(isset($profes) && $profes == 1 && !isset($claustro)): ?>
				<!-- PROFESORES -->
				<div id="grupo_profesores" class="well">
					
					<fieldset>
						<legend>Seleccione profesores</legend>
						
						<?php $s_origen = mb_strtoupper($origen); ?>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos ORDER BY nombre ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="profeso[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['nombre']; ?>" <?php echo (isset($origen) && mb_strtoupper($origen) == mb_strtoupper($row['nombre'])) ? 'selected' : ''; ?>><?php echo $row['nombre']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="profeso[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples profesores.</div>
						</div>
						
					</fieldset>
					
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
     
     
    		<?php if(isset($tutores) && $tutores == 1 && !isset($claustro)): ?>
				<!-- TUTORES -->
				<div id="grupo_tutores" class="well">
					
					<fieldset>
						<legend>Seleccione tutores</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT tutor, unidad FROM FTUTORES ORDER BY unidad ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="tutor[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['tutor']; ?> --> <?php echo $row['unidad']; ?>-"><?php echo $row['unidad']; ?> - <?php echo $row['tutor']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="tutor[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples tutores.</div>
						</div>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($departamentos) && $departamentos == 1 && !isset($claustro)): ?>
				<!-- JEFES DE DEPARTAMENTO -->
				<div id="grupo_departamentos" class="well">
					
					<fieldset>
						<legend>Seleccione departamentos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT departamento FROM departamentos ORDER BY departamento ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="departamento[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['departamento']; ?>"><?php echo $row['departamento']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="departamento[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples departamentos.</div>
						</div>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($equipos) && $equipos == 1 && !isset($claustro)): ?>
				<!-- EQUIPOS EDUCATIVOS -->
				<div id="grupo_equipos" class="well">
					
					<fieldset>
						<legend>Seleccione equipos educativos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT grupo FROM profesores ORDER BY grupo ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="equipo[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['grupo']; ?>"><?php echo $row['grupo']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="equipo[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples equipos educativos.</div>
						</div>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($claustro)): ?>
				<!-- CLAUSTRO DEL CENTRO -->
				<div id="grupo_claustro" class="well">
					
					<fieldset>
						<legend>Claustro de profesores</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($biblio) && $biblio == 1 && !isset($claustro)): ?>
				<!-- BIBLIOTECA -->
				<div id="grupo_biblioteca" class="well">
					
					<fieldset>
						<legend>Biblioteca</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%c%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($etcp) && $etcp == 1 && !isset($claustro)): ?>
				<!-- JEFES DE DEPARTAMENTO -->
				<div id="grupo_etcp" class="well">
					
					<fieldset>
						<legend>Jefes de departamento</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%4%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($ca) && $ca == 1 && !isset($claustro)): ?>
				<!-- COORDINADORES DE AREA -->
				<div id="grupo_coordinadores" class="well">
					
					<fieldset>
						<legend>Coordinadores de área</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%9%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($direccion) && $direccion == 1 && !isset($claustro)): ?>
				<!-- EQUIPO DIRECTIVO -->
				<div id="grupo_directivo" class="well">
					
					<fieldset>
						<legend>Equipo directivo</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%1%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(isset($orientacion) && $orientacion == 1 && !isset($claustro)): ?>
				<!-- ORIENTACION -->
				<div id="grupo_orientacion" class="well">
					
					<fieldset>
						<legend>Orientación</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%8%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				
				<?php if(isset($bilingue) && $bilingue == 1 && !isset($claustro)): ?>
				<!-- BILINGÜE -->
				<div id="grupo_bilingue" class="well">
					
					<fieldset>
						<legend>Profesores Bilinguismo</legend>
						
						<?php $result = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo LIKE '%a%' ORDER BY nombre ASC"); ?>
						<?php if(mysqli_num_rows($result)): ?>
						<ul style="height: auto; max-height: 520px; overflow: scroll;">
							<?php while($row = mysqli_fetch_array($result)): ?>
							<li><?php echo $row['nombre'] ; ?></li>
							<?php endwhile; ?>
							<?php mysqli_free_result($result); ?>
						</ul>
						<?php endif; ?>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				
				<?php if(stristr($_SESSION['cargo'],'1') == TRUE || stristr($_SESSION['cargo'],'2') == TRUE): ?>
				
				<?php $sql_where = ""; ?>
				
				<?php if(stristr($_SESSION['cargo'],'2')): ?>
					<?php $result = mysqli_query($db_con, "SELECT unidad FROM FTUTORES WHERE tutor='$pr'"); ?>
					<?php $unidad = mysqli_fetch_array($result); ?>
					<?php $unidad = $unidad['unidad']; ?>
					<?php mysqli_free_result($result); ?>
					
					<?php $sql_where = "WHERE unidad='$unidad'"; ?>
				<?php endif; ?>
										
				
				<?php if(isset($padres) && $padres == 1 && !isset($claustro)): ?>
				<!-- FAMILIAS Y ALUMNOS -->
				<div id="grupo_padres" class="well">
					
					<fieldset>
						<legend>Familias y alumnos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT apellidos, nombre, unidad FROM alma $sql_where ORDER BY unidad ASC, apellidos ASC, nombre ASC"); ?>
							<?php if(mysqli_num_rows($result)): ?>
							<select class="form-control" name="padres[]" multiple="multiple" size="23">
								<?php while($row = mysqli_fetch_array($result)): ?>
								<option value="<?php echo $row['apellidos'].', '.$row['nombre']; ?>" <?php echo (isset($origen) && $origen == $row['apellidos'].', '.$row['nombre']) ? 'selected' : ''; ?>><?php echo $row['unidad'].' - '.$row['apellidos'].', '.$row['nombre']; ?></option>
								<?php endwhile; ?>
								<?php mysqli_free_result($result); ?>
							</select>
							<?php else: ?>
							<select class="form-control" name="padres[]" multiple="multiple" disabled>
								<option value=""></option>
							</select>
							<?php endif; ?>
							
							<div class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples alumnos.</div>
						</div>
						
					</fieldset>
				</div>
				
				<?php $ocultar_grupos = 1; ?>
				<?php endif; ?>
				
				<?php endif; ?>
				
				<?php if(isset($ocultar_grupos)): ?>
				<button type="button" class="btn btn-primary btn-block" id="mostrar_grupos">Seleccionar otro grupo de destinatarios</button>
				<?php endif; ?>
				
				
<?php
//$perfil = $_SESSION['cargo'];
// Queda preparado para que todos los profesores puedan enviar mensajes a los padres en la página exterior.
//Solo hay que eliminar $perfil == '1', y añadir la posibilidad de responder al mensaje del profesor
//desde la página principal(actualmente solo es posible responder al tutor del grupo).
/*					
if (!($perfil == '1')) {
$extra0 = "where profesor = '$pr'";
}

if($padres == '1' and $perfil == '1') {
echo "<hr /><legend class='text-warning'>Padres de Alumnos</legend><div class='well well-transparent'>";
echo '<SELECT  name=padres[] multiple=multiple size=15 >';
$tut = mysqli_query($db_con, "select distinct grupo from profesores $extra0");
while ($tuto = mysqli_fetch_array($tut)) {
$unidad = $tuto[0];
echo "<OPTION style='color:brown;background-color:#cf9;' disabled>$unidad</OPTION>";
$extra = "where unidad='$unidad'";
$padre = mysqli_query($db_con, "SELECT distinct APELLIDOS, NOMBRE  FROM alma $extra order by unidad, apellidos");
while($filapadre = mysqli_fetch_array($padre))
{
$al_sel = "$filapadre[0], $filapadre[1]";
if ($al_sel==$origen) {
$seleccionado='selected';
}else{$seleccionado="";}
echo "<OPTION $seleccionado>$filapadre[0], $filapadre[1]</OPTION>";
}

}
}
echo  '</select>';
echo "</div>";
*/
?>

			</div><!-- /.col-sm-5 -->
			
		</div><!-- /.row -->
		
		</form>
	
	</div><!-- /.container -->
  

<?php include("../../pie.php"); ?>
	
	<script>
	$('[type=submit]').on('click', function() {
	    $(this).button('loading');
	});
	
	$(document).ready(function() {
		// EDITOR DE TEXTO
		$('#texto').summernote({
			height: 300,
			lang: 'es-ES',
			
			onChange: function(content) {
				var sHTML = $('#texto').code();
		    localStorage['summernote-<?php echo $token; ?>'] = sHTML;
			}
		});
		
		$('#texto').code(localStorage['summernote-<?php echo $token; ?>']);
	  
	  function ocultar_grupos() {
	  	$('#grupos_destinatarios').slideUp();
	  	
	  	$('#mostrar_grupos').show();
	  }
	  
	  function mostrar_grupos() {
	  	$('#grupos_destinatarios').slideDown();
	  	
	  	$('#grupo_profesores').slideUp();
	  	$('#grupo_tutores').slideUp();
	  	$('#grupo_departamentos').slideUp();
	  	$('#grupo_equipos').slideUp();
	  	$('#grupo_claustro').slideUp();
	  	$('#grupo_biblioteca').slideUp();
	  	$('#grupo_etcp').slideUp();
	  	$('#grupo_coordinadores').slideUp();
	  	$('#grupo_directivo').slideUp();
	  	$('#grupo_orientacion').slideUp();
	  	$('#grupo_padres').slideUp();
	  	
	  	$('#mostrar_grupos').hide();
	  }
	  
	  <?php if($ocultar_grupos): ?>
	  ocultar_grupos();
	  <?php endif; ?>
	  
	  $('#mostrar_grupos').click(function() {
	  	mostrar_grupos();
	  });
	  
	});
	</script>

</body>
</html>
