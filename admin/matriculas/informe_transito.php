<?
session_start();
include("../../config.php");
include_once('../../config/version.php');

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
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'7') == TRUE))
{
header('Location:'.'http://'.$dominio.'/intranet/salir.php');
exit;	
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>

<? include("../../menu.php");?>
<? include("./menu.php");?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Informes de Tránsito <small>Consulta de alumnos</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-12">
		
<? if (isset($_GET['claveal'])) {$claveal = $_GET['claveal'];}elseif (isset($_POST['claveal'])) {$claveal = $_POST['claveal'];} ?>

<?
// Actualizar de datos
if ($_POST['submit0']=="Actualizar datos") {
	mysqli_query($db_con,"delete from transito_datos where claveal='$claveal'");
	foreach ($_POST as $clave=>$valor){
		if ($clave!=="claveal" and $clave!=="submit0") {
			if (is_array($valor)) {
				$valo="";
				foreach ($valor as $key=>$val){
					$valo.=$val;
					}
					$valor=$valo;
			}
			mysqli_query($db_con,"insert into transito_datos values ('','$claveal','$clave','$valor')");
		}
	}
	echo '<br /><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente.
</div>';
}

$cl = mysqli_query($db_con,"select distinct claveal, apellidos, nombre, colegio, unidad from alma_primaria where claveal = '$claveal'");
$clav = mysqli_fetch_array($cl);
?>
<h2 align="center" class="text-info"><? echo $clav[2]." ".$clav[1];?><br><small>Colegio <? echo $clav[3];?> (<? echo $clav[4];?>)</small></h2>
<br>
<?
$ya_hay=mysqli_query($db_con,"select * from transito_datos where claveal='$claveal'");
if (mysqli_num_rows($ya_hay)>0) {
	$proc=1;
	while ($ya=mysqli_fetch_array($ya_hay)) {
		${$ya[2]}=$ya[3];
		//echo "${$ya[2]} => $ya[3]<br>";
	}
}
?>
<? 
 if ($rep2) {$r2="checked";}
 if ($rep4) {$r4="checked";}
 if ($rep6) {$r6="checked";}
?>
<? if ($asiste==1) {$as1="checked";}elseif ($asiste==2) {$as2="checked";}elseif ($asiste==3) {$as3="checked";}else{$asiste=="";} ?>
<? 
 if ($dif1) {$d1="checked";}
 if ($dif2) {$d2="checked";}
 if ($dif3) {$d3="checked";}
 if ($dif4) {$d4="checked";}
 if ($dif5) {$d5="checked";}
 if ($dif6) {$d6="checked";}
 if ($dif7) {$d7="checked";}
?>
<? 
 if ($reflen) {$ref1="checked";}
 if ($refmat) {$ref2="checked";}
 if ($refing) {$ref3="checked";}
?>
<? 
 if ($aclen) {$ac1="checked";}
 if ($acmat) {$ac2="checked";}
 if ($acing) {$ac3="checked";}
?>
<? 
 if ($acompanamiento) {$acomp="checked";}
 if ($exento) {$exen="checked";}
?>
<? if ($nacion==1) {$n1="checked";}elseif ($nacion==2) {$n2="checked";}elseif ($nacion==3) {$n3="checked";}elseif ($nacion==4) {$n4="checked";} ?>
<? if ($integra==1) {$int1="checked";}elseif ($integra==2) {$int2="checked";}elseif ($integra==3) {$int3="checked";}elseif ($integra==4) {$int4="checked";}elseif ($integra==5) {$int5="checked";} ?>
<? if ($relacion==1) {$rel1="checked";}elseif ($relacion==2) {$rel2="checked";}elseif ($relacion==3) {$rel3="checked";}?>
<? if ($disruptivo==1) {$dis1="checked";}elseif ($disruptivo==2) {$dis2="checked";}elseif ($disruptivo==3) {$dis3="checked";}?>
<? if ($expulsion==1) {$exp1="checked";}elseif ($expulsion==2) {$exp2="checked";}?>

<? 
 if (stristr($repeticion,"2")==TRUE) {$r2="checked";}
 if (stristr($repeticion,"4")==TRUE) {$r4="checked";}
 if (stristr($repeticion,"6")==TRUE) {$r6="checked";}
 ?>
<? if ($asiste==1) {$as1="checked";}elseif ($asiste==2) {$as2="checked";}elseif ($asiste==3) {$as3="checked";}else{$asiste=="";} ?>
<? 
 if (stristr($dificultad,"1")==TRUE) {$d1="checked";}
 if (stristr($dificultad,"2")==TRUE) {$d2="checked";}
 if (stristr($dificultad,"3")==TRUE) {$d3="checked";}
 if (stristr($dificultad,"4")==TRUE) {$d4="checked";}
 if (stristr($dificultad,"5")==TRUE) {$d5="checked";}
 if (stristr($dificultad,"6")==TRUE) {$d6="checked";}
 if (stristr($dificultad,"7")==TRUE) {$d7="checked";}
?>
<? 
 if (stristr($refuerzo,"Leng")==TRUE) {$ref1="checked";}
 if (stristr($refuerzo,"Mat")==TRUE) {$ref2="checked";}
 if (stristr($refuerzo,"Ing")==TRUE) {$ref3="checked";}
?>
<? 
 if (stristr($adcurr,"Len")==TRUE) {$ac1="checked";}
 if (stristr($adcurr,"Mat")==TRUE) {$ac2="checked";}
 if (stristr($adcurr,"Ing")==TRUE) {$ac3="checked";}
?>
<? 
 if ($acompanamiento) {$acomp="checked";}
 if ($exento) {$exen="checked";}
?>
<? if ($nacion==1) {$n1="checked";}elseif ($nacion==2) {$n2="checked";}elseif ($nacion==3) {$n3="checked";}elseif ($nacion==4) {$n4="checked";} ?>
<? if ($integra==1) {$int1="checked";}elseif ($integra==2) {$int2="checked";}elseif ($integra==3) {$int3="checked";}elseif ($integra==4) {$int4="checked";}elseif ($integra==5) {$int5="checked";} ?>
<? if ($relacion==1) {$rel1="checked";}elseif ($relacion==2) {$rel2="checked";}elseif ($relacion==3) {$rel3="checked";}?>
<? if ($disruptivo==1) {$dis1="checked";}elseif ($disruptivo==2) {$dis2="checked";}elseif ($disruptivo==3) {$dis3="checked";}?>
<? if ($expulsion==1) {$exp1="checked";}elseif ($expulsion==2) {$exp2="checked";}?>


<form class="form-inline" method="post">

<input type="hidden" name="claveal" value="<? echo $claveal;?>" />

<legend class="muted">ÁMBITO ACADÉMICO</legend>

<h5 class="text-info">Cursos Repetidos</h5>
<label class="checkbox inline">
  <input type="checkbox" name="repeticion[]" value="2 " <? echo $r2;?>> 2º Curso
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="repeticion[]" value="4 " <? echo $r4;?>> 4º Curso
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="repeticion[]" value="6 " <? echo $r6;?>> 6º Curso
</label>
<hr>
<h5 class="text-info">Nº de Suspensos</h5>
<label>1ª Evaluación</label>
<select name="susp1">
  <option><? echo $susp1;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
</select>
&nbsp;&nbsp;
<label>2ª Evaluación</label>
<select name="susp2">
  <option><? echo $susp2;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
</select>
&nbsp;&nbsp;
<label>3ª Evaluación</label>
<select name="susp3">
  <option><? echo $susp3;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  </select>
<hr>
<h5 class="text-info">Notas Finales</h5>
<label>Lengua</label>
<select name="leng" class="input input-mini">
<option><? echo $leng;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Matemáticas</label>
<select name="mat" class="input input-mini">
  <option><? echo $mat;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Inglés</label>
<select name="ing" class="input input-mini">
<option><? echo $ing;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Conocimiento</label>
<select name="con" class="input input-mini">
<option><? echo $con;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>8</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Ed. Física</label>
<select name="edfis" class="input input-mini">
<option><? echo $edfis;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Música</label>
<select name="mus" class="input input-mini">
<option><? echo $mus;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
&nbsp;&nbsp;
<label>Plástica</label>
<select name="plas" class="input input-mini">
<option><? echo $plas;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
  <option>6</option>
  <option>7</option>
  <option>8</option>
  <option>9</option>
  <option>10</option>
</select>
<hr>
<h5 class="text-info">Asistencia</h5>
<label class="radio inline">
  <input type="radio" name="asiste" value="1" <?echo $as1;?>> Presenta faltas de asistencia
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="asiste" value="2" <?echo $as2;?>> Falta más de lo normal
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="asiste" value="3" <?echo $as3;?>> Absentismo
</label>
<hr>
<h5 class="text-info">Dificultades de Aprendizaje</h5>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="1" <? echo $d1;?>> Tiene carencias en aprendizajes básicos: "falta de base"
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="2" <? echo $d2;?>>  Tiene dificultades en la lectura
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="3" <? echo $d3;?>>  Tiene dificultades de comprensión oral / escrita
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="4" <? echo $d4;?>>  Tiene dificultades de expresión oral / escrita
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="5" <? echo $d5;?>>  Tiene dificultades de razonamiento matemático
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="6" <? echo $d6;?>>  Tiene dificultades en hábitos /  método de estudio
</label><br>
<label class="checkbox">
  <input type="checkbox" name="dificultad[]" value="7" <? echo $d7;?>>  Tiene dificultades de cálculo.
</label>
<hr>

<h5 class="text-info">Refuerzos o Adaptaciones</h5>
<h6 class="text-success">Ha tenido Refuerzo:</h6>
<label class="checkbox inline">
  <input type="checkbox" name="refuerzo[]" value="Lengua " <? echo $ref1;?>> Lengua
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="refuerzo[]" value="Matemáticas " <? echo $ref2;?>> Matemáticas
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="refuerzo[]" value="Inglés " <? echo $ref3;?>> Inglés
</label>
<h6 class="text-success">Necesita Refuerzo:</h6>
<p class="help-block">En caso necesario señalar orden de preferencia del Refuerzo.</p>
<label>Lengua</label>
<select name="necreflen">
<option><? echo $necreflen;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
&nbsp;&nbsp;
<label>Matemáticas</label>
<select name="necrefmat">
<option><? echo $necrefmat;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
&nbsp;&nbsp;
<label>Inglés</label>
<select name="necrefing">
<option><? echo $necrefing;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
<h6 class="text-success">Ha tenido Adaptación Curricular:</h6>
<label class="checkbox inline">
  <input type="checkbox" name="adcurr[]" value="Lengua " <? echo $ac1;?>> Lengua
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="adcurr[]" value="Matemáticas " <? echo $ac2;?>> Matemáticas
</label>
&nbsp;
<label class="checkbox inline">
  <input type="checkbox" name="adcurr[]" value="Inglés " <? echo $ac3;?>> Inglés
</label>
<h6 class="text-success">Necesita Adaptación:</h6>
<p class="help-block">En caso necesario señalar orden de preferencia del Refuerzo.</p>
<label>Lengua</label>
<select name="necaclen">
<option><? echo $necaclen;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
&nbsp;&nbsp;
<label>Matemáticas</label>
<select name="necacmat">
<option><? echo $necacmat;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
&nbsp;&nbsp;
<label>Inglés</label>
<select name="necacing">
<option><? echo $necacing;?></option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
</select>
<h6 class="text-success">Exención</h6>
<label class="checkbox inline">
  <input type="checkbox" name="exento" value="1" <? echo $exen;?>> Alumnado que por sus dificultades no se le recomienda cursar optativa
</label>

<h6 class="text-success">Programa de Acompañamiento Escolar</h6>
<label class="checkbox inline">
  <input type="checkbox" name="acompanamiento" value="1" <? echo $acomp;?>> Se aconseja asistencia al Programa de Acompañamiento Escolar
</label>
<hr>
<h5 class="text-info">Alumnado de otra nacionalidad</h5>
<label class="radio inline">
  <input type="radio" name="nacion" value="4" <? echo $n4;?>> No conoce el español
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="nacion" value="1" <? echo $n1;?>> Nociones básicas de español
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="nacion" value="2" <? echo $n2;?>> Dificultades en lectura y escritura
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="nacion" value="3" <? echo $n3;?>> Puede seguir el Currículo
</label>
<hr>
<br>

<legend class="muted">ÁMBITO SOCIAL Y DE LA PERSONALIDAD</legend>
<h5 class="text-info">Integración en el Aula</h5>
<label class="radio inline">
  <input type="radio" name="integra" value="5" <? echo $int5;?>> Líder
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="1" <? echo $int1;?>> Integrado
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="2" <? echo $int2;?>> Poco integrado
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="3" <? echo $int3;?>> Se aísla
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="integra" value="4" <? echo $int4;?>> Alumno rechazado
</label>
<hr>
<h5 class="text-info">Actitud, comportamiento, estilo de aprendizaje</h5>
<p class="help-block">Colaborador/a, Trabajador, Atento, Impulsivo.. Indicar los aspectos más significativos</p>
<textarea name="actitud" rows="5"cols="80"><? echo $actitud;?></textarea>
<hr>
<h5 class="text-info">Lo que mejor "funciona" con el Alumno</h5>
<textarea name="funciona" rows="5"cols="80"><? echo $funciona;?></textarea>
<hr>
<br>

<legend class="muted">RELACIÓN COLEGIO - FAMILIA</legend>
<h5 class="text-info">Tipo de relación con el Colegio</h5>
<label class="radio">
  <input type="radio" name="relacion" value="3" <? echo $rel3;?>> Colaboración constante
</label>
<br>
<label class="radio">
  <input type="radio" name="relacion" value="1" <? echo $rel1;?>> Colaboración sólo cuando el Centro la ha solicitado
</label>
<br>
<label class="radio">
  <input type="radio" name="relacion" value="2" <? echo $rel2;?>> Demanda constante por parte de los Padres
</label>
<hr>
<h5 class="text-info">Razones para la ausencia de relación con el Colegio</h5>
<p class="help-block">En caso de ausencia completa de relación de los padres con el Colegio señalar si es posible las razones de la misma.</p>
<textarea name="norelacion" rows="3"cols="80"><? echo $norelacion;?></textarea>
<hr>
<br>

<legend class="muted">DISCIPLINA</legend>
<h5 class="text-info">Comportaiento disruptivo</h5>
<label class="radio inline">
  <input type="radio" name="disruptivo" value="3" <? echo $dis3;?>> Nunca
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="disruptivo" value="1" <? echo $dis1;?>> Ocasionalmente
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="disruptivo" value="2" <? echo $dis2;?>> Alumno disruptivo
</label>
<hr>
<h5 class="text-info">El alumno ha sido expulsado en alguna ocasión</h5>
<label class="radio inline">
  <input type="radio" name="expulsion" value="1" <? echo $exp1;?>> No
</label>
&nbsp;
<label class="radio inline">
  <input type="radio" name="expulsion" value="2" <? echo $exp2;?>> Sí
</label>
<hr>
<br>
<legend class="muted">OBSERVACIONES</legend>
<p class="help-block">Otros aspectos a reseñar (agrupamientos, datos médicos, autonomía, etc).</p>
<textarea name="observaciones" rows="10"cols="80"><? echo $observaciones;?></textarea>
<hr>
<input type="submit" class="btn btn-large btn-info" name="submit0" value="Actualizar datos">
</form>


		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>

