<?
if ( $_POST['unidad']) {
	 $unidad = $_POST['unidad'];
}

if (isset($_GET['id'])) { $id = $_GET['id'];}elseif (isset($_POST['id'])) { $id = $_POST['id'];}
if (isset($_GET['claveal'])) { $claveal = $_GET['claveal'];}elseif (isset($_POST['claveal'])) { $claveal = $_POST['claveal'];}

if (isset($_POST['submit1']))
{
$notas = $_POST['notas']; 
$grave = $_POST['grave'];
$nombre = $_POST['nombre']; 
$asunto = $_POST['asunto'];
$fecha = $_POST['fecha'];
$informa = $_POST['informa']; 
$medidaescr = $_POST['medidaescr']; 
$medida = $_POST['medida']; 
$claveal = $_POST['claveal']; 
$expulsionaula = $_POST['expulsionaula'];  
$id = $_POST['id'];

include("fechoria25.php");
	exit;
}
else
{
	session_start();
	include("../../config.php");
	// COMPROBAMOS LA SESION
	if ($_SESSION['autentificado'] != 1) {
		$_SESSION = array();
		session_destroy();
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
		exit();
	}
	
if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


	?>
	<?php
	include("../../menu.php");
	include("menu.php");
	?>
	<div class="container">
<div class="page-header">
  <h2>Problemas de convivencia <small>Registro de un problema</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-6 col-sm-offset-3">
	<?
$notas = $_POST['notas']; $grave = $_POST['grave']; $nombre = $_POST['nombre']; $asunto = $_POST['asunto'];$fecha = $_POST['fecha'];$informa = $_POST['informa']; $medidaescr = $_POST['medidaescr']; $medida = $_POST['medida']; $expulsionaula = $_POST['expulsionaula'];
// Actualizar datos
	if ($_POST['submit2']) {
	    mysqli_query($db_con, "update Fechoria set asunto = '$asunto', notas = '$notas', grave = '$grave', medida = '$medida', expulsionaula = '$expulsionaula', informa='$informa' where id = '$id'");
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han actualizado correctamente.
          </div></div><br />';
	exit();
	}
// Si se envian datos desde el campo de búsqueda de alumnos, se separa claveal para procesarlo.
	if ($_GET['seleccionado']=="1") {
		$tr=explode(" --> ",$_GET['nombre_al']);
		$claveal=$tr[1];
		$nombre=$tr[0];
		$ng_al0=mysqli_query($db_con, "select unidad from FALUMNOS where claveal = '$claveal'");
		$ng_al=mysqli_fetch_array($ng_al0);
		$unidad=$ng_al[0];
	}
	if ($_GET['id'] or $_POST['id']) {
		$result = mysqli_query($db_con, "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.inicio, Fechoria.fin, aula_conv, inicio_aula, fin_aula, Fechoria.horas, expulsionaula from Fechoria, FALUMNOS, listafechorias where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC");

  if ($row = mysqli_fetch_array($result))
        {

		$nombre = "$row[0], $row[1] --> $claveal";
		$unidad = $row[2];
		$fecha = $row[4];
		$notas = $row[5];
		
		$informa = $row[7];
		if ($asunto or $grave) {}else{
			$grave = $row[8];
			$asunto = $row[6];
		}
		$expulsionaula = $row[19];
		$medida = $row[9];
		$medidas2 = $row[10];
		$expulsion = $row[11];
		$tutoria = $row[12];
		$inicio = $row[13];
		$fin = $row[14];
		$convivencia = $row[15];
		$inicio_aula = $row[16];
		$fin_aula = $row[17];
		$horas = $row[18];
        }
	}
	?>	

<form method="post" action="infechoria.php" name="Cursos">

	<div class="well">
	
		<fieldset>
			<legend>Registrar un problema</legend>
		
				<div class="form-group">
				<label for="unidad">Unidad</label> 
				<select class="form-control" id="unidad" name="unidad" onchange="submit()">
					<option><? echo $unidad;?></option>
					<? if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<option>Cualquiera</option>";} ?>
					<? unidad($db_con);?>
				</select> 
				</div>
				
				<div class="form-group">
				<label for="nombre">Alumno/a</label>
					<?
					if ($unidad=="Cualquiera") {$alumno_sel=""; $nom = "nombre[]";  $opcion = "multiple = 'multiple' style='height:250px;width:340px;'";}else{$alumno_sel = "WHERE unidad like '$unidad%'"; $nom = "nombre";}
					?> <select class="form-control" id="nombre" name="<? echo $nom;?>">
					<? echo $opcion;?>>
					<?
				
					if (!(is_array($nombre)) and $nombre !== "Selecciona un Alumno")
					{
						echo "<OPTION>$nombre</OPTION>";
					}
				
					if ($claveal == "")
					{
						$alumnos = mysqli_query($db_con, " SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS $alumno_sel order by APELLIDOS asc");
						if ($unidad=="Cualquiera"){}else{echo "<OPTION>Selecciona un Alumno</OPTION>";}
						if ($unidad)
						{
							echo "<OPTION>Todos los alumnos</OPTION>";
						}
						 while($falumno = mysqli_fetch_array($alumnos))
						{
							$sel="";						
								if (is_array($nombre)) {
									foreach($nombre as $n_alumno){
										$tr1=explode(" --> ",$n_alumno);
										$datos_al="$tr1[0] --> $tr1[1]";
										if ($datos_al=="$falumno[0], $falumno[1] --> $falumno[2]"){
											$sel = " selected ";
										}						
									}
								}
								
									echo "<OPTION $sel>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>";
							
						}
					}
				
					else
					{
						$alumnos = mysqli_query($db_con, " SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE CLAVEAL = '$claveal' order by APELLIDOS asc");
				
						if ($falumno = mysqli_fetch_array($alumnos))
						{
							do {
				
				
							} while($falumno = mysqli_fetch_array($alumnos));
						}
					}
					?>
				</select> 
				</div> 
				
				<div class="form-group" id="datetimepicker1">
				<label for="fecha">Fecha</label>
				<div class="input-group">
				  <input name="fecha" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fecha" value="<?if($fecha == "") { echo date('d-m-Y'); } else { echo $fecha;}?>" >
				  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
				</div>
				
				<div class="form-group"> 
				<label for="grave"> Gravedad</label>
				<select class="form-control" id="grave" name="grave" onchange="submit()">
					<option><? echo $grave;?></option>
					<?
					tipo($db_con);
					?>
				</select> 
				</div>
				
				<div class="form-group">
				<label for="asunto">Conducta negativa</label>
				<select class="form-control" id="asunto" name="asunto" onchange="submit()">
					<option><? 
					
					$sql0 = mysqli_query($db_con, "select tipo from listafechorias where fechoria = '$asunto'");
					$sql1 = mysqli_fetch_array($sql0);
					if($sql1[0] !== $grave)
					{
						echo "<OPTION></OPTION>";
					}
					else
					{ echo $asunto;}  ?></option>
					<?
					fechoria($db_con, $grave);
					?>
				</select> 
				</div>
				
				<div class="form-group">
				<label class="medida">Medida Adoptada</label>
					<?
					
					$tipo = "select distinct medidas from listafechorias where fechoria = '$asunto'";
					$tipo1 = mysqli_query($db_con, $tipo);
					while($tipo2 = mysqli_fetch_array($tipo1))
					{
						if($tipo2[0] == "Amonestación escrita")
						{
							$medidaescr = $tipo2[0];
							echo '<input type="hidden" id="medida" name="medida" value="'.$tipo2[0].'">';
						}
						else
						{
							echo '<input  type="hidden"id="medida" name="medida" value="'.$tipo2[0].'">';
						}
					}
				
					?> <input type="text" value="<? echo $medidaescr;?>" readonly
					class="form-control"/> 
					</div> 
					
				<div class="form-group">
					<label for="medidas">Medidas complementarias que deben tomarse</label>
					<textarea class="form-control" id="medidas" name="medidas" rows="7" disabled><? if($medidas){ echo $medidad; }else{  medida2($db_con, $asunto);} ?></textarea>
				</div>
				
				 <?
				if($grave == 'grave' or $grave == 'muy grave'){
					?> 
					<div class="checkbox">
						<label>
							<input type="checkbox" id="expulsionaula" name="expulsionaula" value="1" <?  if ($expulsionaula == "1") { echo " checked ";}?>> El alumno ha sido <u>expulsado</u> del aula 
						</label>
					</div> 
					
				<? 
				}
				?> 
					
				<div class="form-group">	
					<label for="notas">Descripción:</label>
					<textarea class="form-control" id="notas" name="notas" rows="7" placeholder="Describe aquí los detalles del incidente..."><? echo $notas; ?></textarea>
				</div> 
				
				<? 
				if ($id) {
					?>
				
				<div class="form-group">
					<label for="informa">Profesor</label>
				 <select class="form-control" id="informa" name="informa">
				    <?
				    if ($id) {
				    echo "<OPTION>".$informa."</OPTION>";	
				    }
				      
				  $profe = mysqli_query($db_con, " SELECT distinct prof FROM horw order by prof asc");
				while($filaprofe = mysqli_fetch_array($profe)) {
					      echo"<OPTION>$filaprofe[0]</OPTION>";
					} 
					?>
				  </select>	
				  </div>
				  <?
				    }  
				    else{  
				if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'b') == TRUE){
					?>
				<div class="form-group">
				<label class="informa">Profesor</label>
				 <select class="form-control" id="informa" name="informa">
				    <?
				    if ($id) {
				    echo '<OPTION value="'.$informa.'">'.nomprofesor($informa).'</OPTION>';	
				    }
				    else{
				    	echo '<OPTION value="'.$_SESSION['profi'].'">'.nomprofesor($_SESSION['profi']).'</OPTION>';
				    }    
				  $profe = mysqli_query($db_con, " SELECT distinct prof FROM horw order by prof asc");
				while($filaprofe = mysqli_fetch_array($profe)) {
					      echo '<OPTION value="'.$filaprofe[0].'">'.nomprofesor($filaprofe[0]).'</OPTION>';
					} 
					?>
				  </select>	
				  </div>
					<?
				}
				else{
					?>
					 <input type="hidden" id="informa" name="informa" value="<? echo $_SESSION['profi'];?>">	
					<?
				}
				
				    }
				
				?>
				<input type="hidden" id="claveal" name="claveal" value="<? echo $claveal;?>"> 
				<hr />
				<?
				if ($id) {
				echo '<input type="hidden" name="id" value="'.$id.'">';	
				echo '<input type="hidden" name="claveal" value="'.$claveal.'">';	
				echo '<input size=25 name = "submit2" type="submit" value="Actualizar datos" class="btn btn-warning">';
				}
				else{
					echo '<input name=submit1 type=submit value="Registrar" class="btn btn-primary">';
				}
				?>
				
			</fieldset>
		
		</div>

	</form>
</div>
</div>
</div>
	<? } ?>
	<?
	include("../../pie.php");
	?>
	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	</script>
</BODY>
</HTML>
