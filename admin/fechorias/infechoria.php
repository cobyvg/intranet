<?
if ($submit1)
{
include("fechoria25.php");
	exit;
}
else
{
	session_start();
	include("../../config.php");
	if($_SESSION['autentificado']!='1')
	{
		session_destroy();
		header("location:http://$dominio/intranet/salir.php");
		exit;
	}
	registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
	?>
	<?php
	include("../../menu.php");
	include("menu.php");
	// Si se envian datos desde el campo de búsqueda de alumnos, se separa claveal para procesarlo.
	if ($submit2) {
	    mysql_query("update Fechoria set asunto = '$asunto', notas = '$notas', grave = '$grave', medida = '$medida' 
	    where id = '$id'");
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los datos se han actualizado correctamente.
          </div></div><br />';
	exit();
	}
	if ($seleccionado=="1") {
		$tr=explode(" --> ",$nombre_al);
		$claveal=$tr[1];
		$nombre=$tr[0];
		$ng_al0=mysql_query("select nivel, grupo from FALUMNOS where claveal = '$claveal'");
		$ng_al=mysql_fetch_array($ng_al0);
		$nivel=$ng_al[0];
		$grupo=$ng_al[1];
	}
	
	if ($id) {
		$result = mysql_query ("select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.inicio, Fechoria.fin, aula_conv, inicio_aula, fin_aula, Fechoria.horas from Fechoria, FALUMNOS, listafechorias where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC");
  if ($row = mysql_fetch_array($result))
        {

		$nombre = "$row[0], $row[1] --> $claveal";
		$nivel = $row[2];
		$grupo = $row[3];
		$fecha = $row[4];
		$notas = $row[5];
		
		$informa = $row[7];
		if ($asunto or $grave) {}else{
			$grave = $row[8];
			$asunto = $row[6];
		}
		
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
<div aligna="center">
<div class="page-header" align="center">
  <h1>Problemas de Convivencia <small> Registro de un problema</small></h1>
</div>
</div>
<br />

<br />
<div style="max-width: 420px; margin: auto">
<div class="well-2 well-large" align="left">
<FORM action="infechoria.php" method="POST" name="Cursos">
<label style="display: inline"> Nivel: 
<select name="nivel"
	onChange="submit()" class="input-small" class="form-inline">
	<option><? echo $nivel;?></option>
	<? if(stristr($_SESSION['cargo'],'1') == TRUE){echo "<option>Cualquiera</option>";} ?>
	<? nivel();?>
</select> 
</label> 
<label style="display: inline">&nbsp;&nbsp;&nbsp;Grupo: 
<select name="grupo" onChange="submit()"
	class="input-mini">
	<option><? echo $grupo;?></option>
	<? grupo($nivel);?>
</select> 
</label> 

<label> Alumno:<br />
	<?
	if ($nivel=="Cualquiera") {$alumno_sel=""; $nom = "nombre[]";  $opcion = "multiple = 'multiple' style='height:250px;width:340px;'";}else{$alumno_sel = "WHERE NIVEL like '$nivel%' and grupo = '$grupo'"; $nom = "nombre";}
	?> <select name="<? echo $nom;?>" class="input input-xlarge"
	<? echo $opcion;?>>
	<?

	if (!(is_array($nombre)) and $nombre !== "Selecciona un Alumno")
	{
		echo "<OPTION>$nombre</OPTION>";
	}

	if ($claveal == "")
	{
		$alumnos = mysql_query(" SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS $alumno_sel order by APELLIDOS asc");
		if ($nivel=="Cualquiera"){}else{echo "<OPTION>Selecciona un Alumno</OPTION>";}
		if ($nivel and $grupo)
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
</select> </label> 
<label>Fecha:<br />
<div class="input-append" >
  <input name="fecha" type="text" class="input input-small" data-date-format="dd-mm-yyyy" id="fecha" value="<?if($fecha){ echo $fecha;}?>" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> 
</label> 
<label> Gravedad:<br />
<select name="grave" onChange="submit()" class="span2">
	<option><? echo $grave;?></option>
	<?
	tipo();
	?>
</select> </label> <label>Asunto:<br />
<select name="asunto" onChange="submit()" class="span4">
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
</select> </label> <label>Medida Adoptada:<br />
	<?
	$tipo = "select distinct medidas from listafechorias where fechoria = '$asunto'";
	$tipo1 = mysql_query($tipo);
	while($tipo2 = mysql_fetch_array($tipo1))
	{
		if($tipo2[0] == "Amonestación escrita")
		{
			$medidaescr = $tipo2[0];
			echo "<input name='medida' type='hidden' value='$tipo2[0]'>";
		}
		else
		{
			echo "<input name='medida' type='hidden' value='$tipo2[0]'>";
		}
	}

	?> <input type="text" value="<? echo $medidaescr;?>" disabled
	class="span4" style="color: #9d261d" /> </label> <label>Medidas
Complementarias que deben tomarse:<br />
<textarea name='medidas' cols=80 rows=6 disabled="disabled"
	class="span4" style="color: #9d261d"><?if($medidas){ echo $medidad; }else{  medida2($asunto);} ?></textarea>
</label> <?
if($grave == 'grave' or $grave == 'muy grave'){
	?> <label><input type="checkbox" name="expulsionaula"
	id="expulsionaula" value="1"> <span style="color: #08c"> El Alumno ha
sido <u>expulsado</u> del Aula</span> <? } ?> </label> <label>
Descripci&oacute;n:<br />
<textarea name='notas' cols=80 rows=6 class="span4"><? echo $notas; ?></textarea>
</label> 

<? 
if ($id) {
	?>
<hr>
	<label>Profesor<br />
 <SELECT  name="informa" class="input input-xlarge">
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
  </label>
  <?
    }  
    else{  
if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'b') == TRUE){
	?>
	<hr>
	<label>Profesor<br />
 <SELECT  name="informa" class="input input-xlarge">
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
  </label>
	<?
}
else{
	?>
	 <input type="hidden" name="informa" value="<? echo $_SESSION['profi'];?>">	
	<?
}

    }

?>
<input type="hidden" name="claveal" id="checkbox"
	value="<? echo $claveal;?>"> 

<?
if ($id) {
echo '<input type="hidden" name="id" value="'.$id.'">';	
echo '<input type="hidden" name="claveal" value="'.$claveal.'">';	
echo '<input size=25 name = "submit2" type="submit" value="Actualizar datos" class="btn btn-primary">';
}
else{
	echo '<input size=25 name=submit1 type=submit value="Enviar datos" class="btn btn-primary">';
}
?>


</div>
</FORM>
</div>
	<? } ?>
	<?
	include("../../pie.php");
	?>
	<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});  
	</script>
</BODY>
</HTML>
