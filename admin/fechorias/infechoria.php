<?
if ( $_POST['unidad']) {
	 $unidad = $_POST['unidad'];
}
if ($_POST['submit1'])
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
  <h2>Problemas de Convivencia <small> Registro de un problema</small></h2>
</div>
<br />

<div class="row">

<div class="col-sm-6 col-sm-offset-3">
	<?
$notas = $_POST['notas']; $grave = $_POST['grave']; $nombre = $_POST['nombre']; $asunto = $_POST['asunto'];$fecha = $_POST['fecha'];$informa = $_POST['informa']; $medidaescr = $_POST['medidaescr']; $medida = $_POST['medida'];  $id = $_POST['id']; $claveal = $_POST['claveal']; $expulsionaula = $_POST['expulsionaula'];
// Actualizar datos
	if ($_POST['submit2']) {
	    mysql_query("update Fechoria set asunto = '$asunto', notas = '$notas', grave = '$grave', medida = '$medida', expulsionaula = '$expulsionaula'  where id = '$id'");
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
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
		$ng_al0=mysql_query("select unidad from FALUMNOS where claveal = '$claveal'");
		$ng_al=mysql_fetch_array($ng_al0);
		$unidad=$ng_al[0];
	}
	if ($_GET['id'] or $_POST['id']) {
		$id = $_GET['id'];
		$claveal = $_GET['claveal'];
		$result = mysql_query ("select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.inicio, Fechoria.fin, aula_conv, inicio_aula, fin_aula, Fechoria.horas, expulsionaula from Fechoria, FALUMNOS, listafechorias where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC");

  if ($row = mysql_fetch_array($result))
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

<FORM action="infechoria.php" method="POST" name="Cursos">

<div class="well" align="left">

<div class="form-group">
<label> Grupo:</label> 
<select name="unidad"
	onChange="submit()" class="form-control">
	<option><? echo $unidad;?></option>
	<? if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<option>Cualquiera</option>";} ?>
	<? unidad();?>
</select> 
</div>

<div class="form-group">
<label> Alumno:</label>
	<?
	if ($unidad=="Cualquiera") {$alumno_sel=""; $nom = "nombre[]";  $opcion = "multiple = 'multiple' style='height:250px;width:340px;'";}else{$alumno_sel = "WHERE unidad like '$unidad%'"; $nom = "nombre";}
	?> <select name="<? echo $nom;?>" class="form-control"
	<? echo $opcion;?>>
	<?

	if (!(is_array($nombre)) and $nombre !== "Selecciona un Alumno")
	{
		echo "<OPTION>$nombre</OPTION>";
	}

	if ($claveal == "")
	{
		$alumnos = mysql_query(" SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS $alumno_sel order by APELLIDOS asc");
		if ($unidad=="Cualquiera"){}else{echo "<OPTION>Selecciona un Alumno</OPTION>";}
		if ($unidad)
		{
			echo "<OPTION>Todos los alumnos</OPTION>";
		}
		 while($falumno = mysql_fetch_array($alumnos))
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
		$alumnos = mysql_query(" SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS WHERE CLAVEAL = '$claveal' order by APELLIDOS asc");

		if ($falumno = mysql_fetch_array($alumnos))
		{
			do {


			} while($falumno = mysql_fetch_array($alumnos));
		}
	}
	?>
</select> 
</div> 

<div class="form-group">
<label>Fecha:</label>
<div class="input-group" >
  <input name="fecha" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fecha" value="<?if($fecha == "") { echo date('d-m-Y'); } else { echo $fecha;}?>" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>

<div class="form-group"> 
<label> Gravedad:</label>
<select name="grave" onChange="submit()" class="form-control">
	<option><? echo $grave;?></option>
	<?
	tipo();
	?>
</select> 
</div>

<div class="form-group">
<label>Asunto:</label>
<select name="asunto" onChange="submit()" class="form-control">
	<option><? 
	
	$sql0 = mysql_query("select tipo from listafechorias where fechoria = '$asunto'");
	$sql1 = mysql_fetch_array($sql0);
	if($sql1[0] !== $grave)
	{
		echo "<OPTION></OPTION>";
	}
	else
	{ echo $asunto;}  ?></option>
	<?
	fechoria($grave);
	?>
</select> 
</div>

<div class="form-group">
<label>Medida Adoptada:</label>
	<?
	
	$tipo = "select distinct medidas from listafechorias where fechoria = '$asunto'";
	$tipo1 = mysql_query($tipo);
	while($tipo2 = mysql_fetch_array($tipo1))
	{
		if($tipo2[0] == "Amonestación escrita")
		{
			$medidaescr = $tipo2[0];
			echo '<input name="medida" type="hidden" value="'.$tipo2[0].'">';
		}
		else
		{
			echo '<input name="medida" type="hidden" value="'.$tipo2[0].'">';
		}
	}

	?> <input type="text" value="<? echo $medidaescr;?>" readonly
	class="form-control"/> 
	</div> 
	
<div class="form-group">
	<label>Medidas
Complementarias que deben tomarse:</label>
<textarea name='medidas' rows="6" disabled="disabled"
	class="form-control"><? if($medidas){ echo $medidad; }else{  medida2($asunto);} ?></textarea>
</div>

 <?
if($grave == 'grave' or $grave == 'muy grave'){
	?> 
	<div class="checkbox">
	<label>
	<input type="checkbox" name="expulsionaula" id="expulsionaula" value="1" <?  if ($expulsionaula == "1") { echo " checked ";}?>> El Alumno ha sido <u>expulsado</u> del aula 
		</div> 
	
<? 
}
?> 
	
<div class="form-group">	
<label>
Descripci&oacute;n:</label>
<textarea name='notas' rows="6" class="form-control"><? echo $notas; ?></textarea>
</div> 

<? 
if ($id) {
	?>

<div class="form-group">
	<label>Profesor</label>
 <SELECT  name="informa" class="form-control">
    <?
    if ($id) {
    echo "<OPTION>".$informa."</OPTION>";	
    }
      
  $profe = mysql_query(" SELECT distinct prof FROM horw order by prof asc");
while($filaprofe = mysql_fetch_array($profe)) {
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
<label>Profesor</label>
 <SELECT  name="informa" class="form-control">
    <?
    if ($id) {
    echo "<OPTION>".$informa."</OPTION>";	
    }
    else{
    	echo "<OPTION>".$_SESSION['profi']."</OPTION>";
    }    
  $profe = mysql_query(" SELECT distinct prof FROM horw order by prof asc");
while($filaprofe = mysql_fetch_array($profe)) {
	      echo"<OPTION>$filaprofe[0]</OPTION>";
	} 
	?>
  </select>	
  </div>
	<?
}
else{
	?>
	 <input type="hidden" name="informa" value="<? echo $_SESSION['profi'];?>">	
	<?
}

    }

?>
<input type="hidden" name="claveal" id="checkbox" value="<? echo $claveal;?>"> 
<hr />
<?
if ($id) {
echo '<input type="hidden" name="id" value="'.$id.'">';	
echo '<input type="hidden" name="claveal" value="'.$claveal.'">';	
echo '<input size=25 name = "submit2" type="submit" value="Actualizar datos" class="btn btn-warning btn-block">';
}
else{
	echo '<input name=submit1 type=submit value="Enviar datos" class="btn btn-primary btn-block">';
}
?>


</div>
</FORM>
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
		$('#fecha').datetimepicker({
			language: 'es',
			pickTime: false
		})
	});  
	</script>
</BODY>
</HTML>
