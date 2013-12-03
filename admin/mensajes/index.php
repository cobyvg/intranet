<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$pr = $_SESSION['profi'];
//$profesor = $_SESSION ['profi'];
?>
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet &middot; <?php echo $nombre_del_centro; ?></title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del <?php echo $nombre_del_centro; ?>o">  
    <meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
      
    <link href="//<?php echo $dominio; ?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="//<?php echo $dominio; ?>/intranet/css/otros.css" rel="stylesheet">
    <link href="//<?php echo $dominio; ?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">    
    <link href="//<?php echo $dominio; ?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="//<?php echo $dominio; ?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">    
    <link href="//<?php echo $dominio; ?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <link href="//<?php echo $dominio; ?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <script type="text/javascript" src="//<?php echo $dominio; ?>/intranet/js/buscarAlumnos.js"></script>                 

	<!-- TinyMCE -->
	<script src="//<?php echo $dominio; ?>/intranet/js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
	        selector: "textarea",
	        language: "es",
	        plugins: [
	                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
	                "searchreplace wordcount visualblocks visualchars code fullscreen",
	                "insertdatetime media nonbreaking save table contextmenu directionality",
	                "emoticons template paste textcolor filemanager"
	            ],
	
	        toolbar1: "bold italic underline strikethrough | forecolor backcolor | emoticons | alignleft aligncenter alignright alignjustify | bullist numlist",
	        toolbar2: "outdent indent blockquote | link unlink image media",
	        
	        relative_urls: false,
	        filemanager_title:"Administrador de archivos",
	        external_filemanager_path:"../../filemanager/",
	        external_plugins: { "filemanager" : "../../filemanager/plugin.min.js"},
	
	        menubar: false
	});
	</script>
	<!-- /TinyMCE -->

</head>

<body>
<?
?>
<?php
		include ("../../menu_solo.php");
		include ("menu.php");
		
if (isset($_POST['profes'])) {
	$profes = $_POST['profes'];
} 
elseif (isset($_GET['profes'])) {
	$profes = $_GET['profes'];
} 
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
$texto = $_POST['texto'];
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
	$asunto = $_POST['asunto'];
} 
elseif (isset($_GET['asunto'])) {
	$asunto = $_GET['asunto'];
} 
else
{
$asunto="";
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
 mysql_query("UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$verifica'");
}
?>
<div class="page-header" align="center">
  <h2>Centro de Mensajes <small> Enviar mensajes...</small></h2>
</div>
<br />
<? 
include("profesores.php");
?>  

<form id="form" name="form" method="post" action="index.php">
  <fieldset>
<div class="row-fluid">
  <div class="span4 offset1">
      <div class="well well-large">
        <legend class='text-warning'>Destinatario(s)</legend>
        <div class="row-fluid">
          <div class="span6" align="left">
            <input
			type="hidden" name="profesor" value="<? echo $pr; ?>" />
            <label class="checkbox">
              <input name="profes" type="checkbox" value="1" onClick="submit()"
<? if($profes=='1' and !$claustro) echo 'checked'; ?> />
              Profesores</label>
            <label class="checkbox">
              <input name="tutores" type="checkbox" value="1"
					onClick="submit()"
<? if($tutores=='1' and !$claustro) echo 'checked'; ?> />
              Tutores</label>
            <label class="checkbox">
              <input name="departamentos" type="checkbox" value="1"
					onClick="submit()"
<? if($departamentos=='1' and !$claustro) echo 'checked'; ?> />
              Departamentos</label>
            <label class="checkbox">
              <input name="equipos" type="checkbox" value="1" onClick="submit()"
<? if($equipos=='1' and !$claustro) echo 'checked'; ?> />
              Equipos
              Educativos</label>
            <label class="checkbox">
              <input name="claustro" type="checkbox" value="1"
					onClick="submit()" <? if($claustro=='1') echo 'checked'; ?> />
              Todo
              el Claustro</label>
            <label class="checkbox">
              <input name="biblio" type="checkbox" value="1" onClick="submit()"
<? if($biblio=='1' and !$claustro) echo 'checked'; ?> />
              Biblioteca</label>
          </div>
          <div class="span6" align="left">
            <label class="checkbox">
              <input name="etcp" type="checkbox" value="1" onClick="submit()"
<? if($etcp=='1' and !$claustro) echo 'checked'; ?> />
              JD</label>
            <label class="checkbox">
              <input name="ca" type="checkbox" value="1" onClick="submit()"
<? if($ca=='1' and !$claustro) echo 'checked'; ?> />
              CA</label>
            <label class="checkbox">
              <input name="direccion" type="checkbox" value="1" onClick="submit()"
<? if($direccion=='1' and !$claustro) echo 'checked'; ?> />
              Equipo
              Directivo</label>
            <label class="checkbox">
              <input name="orientacion" type="checkbox" value="1"
					onClick="submit()"
<? if($orientacion=='1' and !$claustro) echo 'checked'; ?> />
              Orientación</label>
            <label class="checkbox">
              <input name="bilingue" type="checkbox" value="1" onClick="submit()"
<? if($bilingue=='1' and !$claustro) echo 'checked'; ?> />
              Centro
              Bilingue</label>
   
            <label class="checkbox">
              <input name="padres" type="checkbox"
					value="1" onClick="submit()"
<? if($padres=='1' and !$claustro) echo 'checked'; ?> />
              Padres de
              Alumnos</label>
 <br />
 </div>
 
            <?

					if($profes == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Selecciona los Profesores</legend>
						<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
						<div class='well well-transparent'>";
						$s_origen=mb_strtoupper($origen);
						echo '
						<SELECT  name=profeso[] multiple=multiple size=27 class="span10">';
						// Datos del Profesor que hace la consulta. No aparece el nombre del aÃ±o de la nota. Se podrÃ­a incluir.
						// echo "SELECT distinct PROFESOR  FROM profesores order by PROFESOR asc";
						$profe = mysql_query("SELECT distinct nombre  FROM departamentos order by nombre asc");
						while($filaprofe = mysql_fetch_array($profe))
						{
							$profe_sel = mb_strtoupper($filaprofe[0]);
							if ($profe_sel==$s_origen) {
								$seleccionado='selected';
							}else{$seleccionado="";}
							echo "<OPTION $seleccionado>$filaprofe[0]</OPTION>";
						}
						echo  '</select></div>';
					}

					if($tutores == '1' and !$claustro) {echo "<hr /><legend class='text-warning'>Selecciona los Tutores de Grupo</legend>
					<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
					<div class='well well-transparent'>";
					echo '<SELECT  name=tutor[] multiple=multiple size=25  style="width:100%">';
					// Datos del Profesor que hace la consulta. No aparece el nombre del aÃ±o de la nota. Se podrÃ­a incluir.
					$tutor = mysql_query(" SELECT distinct tutor, nivel, grupo  FROM FTUTORES order by nivel, grupo asc");
					while($filatutor = mysql_fetch_array($tutor))
					{
						$fondo = "";
						if($filatutor[1] == "1E"){$fondo = "style=background-color:#ffFFCC;";}
						if($filatutor[1] == "2E"){$fondo = "style=background-color:#99FF88;";}
						if($filatutor[1] == "3E"){$fondo = "style=background-color:#bbFFCC;";}
						if($filatutor[1] == "4E"){$fondo = "style=background-color:#88FFCC;";}
						if($filatutor[1] == "1B"){$fondo = "style=background-color:#ddFFCC;";}
						if($filatutor[1] == "2B"){$fondo = "style=background-color:#FFCC66;";}
						if($filatutor[1] == "1P"){$fondo = "style=background-color:#eeaaCC;";}
						echo "<OPTION $fondo>$filatutor[0] --> $filatutor[1]-$filatutor[2]</OPTION>";
					}
					echo  '</select></div>';
					}

					if($departamentos == '1' and !$claustro) {echo "<hr /><legend class='text-warning'>Selecciona los Departamentos o Áreas</legend>
					<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
					<div class='well well-transparent'>";
					echo '<SELECT  name=departamento[] multiple=multiple size=25 class="span9" >';
					$dep = mysql_query("SELECT distinct departamento FROM departamentos order by departamento asc");
					while($filadep = mysql_fetch_array($dep))
					{
						echo "<OPTION>$filadep[0]</OPTION>";
					}
					echo  '</select></div>';
					}

					if($equipos == '1' and !$claustro) {echo "<hr /><legend class='text-warning'>Selecciona Equipos Educativos</legend>
					<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
					<div class='well well-transparent'>";
					echo '<SELECT  name=equipo[] multiple=multiple size=25 class="span9"  >';
					$eq = mysql_query("SELECT distinct grupo  FROM profesores order by grupo asc");
					while($filaeq = mysql_fetch_array($eq))
					{
						$fondo = "";
						if(substr($filaeq[0],0,2) == "1E"){$fondo = "style=background-color:#ffFFCC;";}
						if(substr($filaeq[0],0,2) == "2E"){$fondo = "style=background-color:#99FF88;";}
						if(substr($filaeq[0],0,2) == "3E"){$fondo = "style=background-color:#bbFFCC;";}
						if(substr($filaeq[0],0,2) == "4E"){$fondo = "style=background-color:#88FFCC;";}
						if(substr($filaeq[0],0,2) == "1B"){$fondo = "style=background-color:#ddFFCC;";}
						if(substr($filaeq[0],0,2) == "2B"){$fondo = "style=background-color:#FFCC66;";}
						if(substr($filaeq[0],0,2) == "1P"){$fondo = "style=background-color:#eeaaCC;";}
						echo "<OPTION $fondo>$filaeq[0]</OPTION>";
					}
					echo  '</select></div>';
					}

					if($claustro == '1') {
						echo "<hr /><legend class='text-warning'>Claustro de Profesores</legend>";
						$cl = mysql_query("SELECT distinct nombre FROM departamentos WHERE nombre NOT LIKE 'admin'");
						while($filacl = mysql_fetch_array($cl))
						{
							$t_cl .= $filacl[0].",";
							$ok = explode(", ",$filacl[0]);
							$t_cl2 = "<li align='left'>".$ok[1]." ".$ok[0]."</li>";
							echo "$t_cl2";
						}
						echo "";
						}

					if($orientacion == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Departamento de Orientación</legend><div class='well well-transparent'>";
						$orienta = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%8%'");
						while($filaor = mysql_fetch_array($orienta))
						{
							echo "<li align='left'>$filaor[0] </li>";
							$t_or .= $filaor[0].",";
						}
						$t_or = substr($t_or,0,strlen($t_or)-1);
						echo "</div>";
					}

					if($bilingue == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Centro Bilingue</legend><div class='well well-transparent'>";
						$bilingue = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%a%'");
						while($filabi = mysql_fetch_array($bilingue))
						{
							echo "<li align='left'>$filabi[0] </li>";
							$t_bi .= $filabi[0].",";
						}
						$t_bi = substr($t_bi,0,strlen($t_bi)-1);
					echo "</div>";
					}
					
					if($biblio == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Biblioteca</legend><div class='well well-transparent'>";
						$bibliote = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%c%'");
						while($filabiblio = mysql_fetch_array($bibliote))
						{
							echo "<li align='left'>$filabiblio[0] </li>";
							$t_biblio .= $filabiblio[0].",";
						}
						$t_biblio = substr($t_biblio,0,strlen($t_biblio)-1);
					echo "</div>";
					}					



					if($etcp == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Equipo Técnico de Coordinación Pedagógica</legend><div class='well well-transparent'>";
						$etc = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%4%'");
						while($filaetc = mysql_fetch_array($etc))
						{
							echo "<li align='left'>$filaetc[0] </li>";
							$t_etcp .= $filaetc[0];
						}
						$t_etcp = substr($t_etcp,0,strlen($t_etcp)-1);
						echo "</div>";
					}

					if($ca == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Coordinación de Área</legend><div class='well well-transparent'>";
						$ca0 = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%9%'");
						while($filaca = mysql_fetch_array($ca0))
						{
							echo "<li align='left'>$filaca[0] </li>";
							$t_ca .= $filaca[0];
						}
						$t_ca = substr($t_ca,0,strlen($t_ca)-1);
						echo "</div>";
					}

					if($direccion == '1' and !$claustro) {
						echo "<hr /><legend class='text-warning'>Equipo Directivo</legend><div class='well well-transparent'>";
						$dir = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like'%1%' AND nombre NOT LIKE 'admin'");
						while($filadir = mysql_fetch_array($dir))
						{
							echo "<li align='left'>$filadir[0] </li>";
							$t_dir .= $filadir[0].",";
						}
						$t_dir = substr($t_dir,0,strlen($t_dir)-1);
						echo "</div>";
					}


					$perfil = $_SESSION['cargo'];
					// Queda preparado para que todos los profesores puedan enviar mensajes a los padres en la página exterior.
					//Sólo hay que eliminar $perfil == '1', y añadir la posibilidad de responder al mensaje del profesor
					//desde la página principal(actualmente sólo es posible responder al tutor del grupo).
					/*					
					 	if (!($perfil == '1')) {
						$extra0 = "where profesor = '$pr'";
						}
					
					if($padres == '1' and $perfil == '1') {
						echo "<hr /><legend class='text-warning'>Padres de Alumnos</legend><div class='well well-transparent'>";
						echo '<SELECT  name=padres[] multiple=multiple size=15 >';
						$tut = mysql_query("select distinct grupo from profesores $extra0");
						while ($tuto = mysql_fetch_array($tut)) {
						$unidad = $tuto[0];
						echo "<OPTION style='color:brown;background-color:#cf9;' disabled>$unidad</OPTION>";
						$extra = "where unidad='$unidad'";
						$padre = mysql_query("SELECT distinct APELLIDOS, NOMBRE  FROM alma $extra order by unidad, apellidos");
						while($filapadre = mysql_fetch_array($padre))
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

					if(stristr($perfil,'2') == TRUE or stristr($perfil,'1') == TRUE)
					{
						$tut = mysql_query("select nivel, grupo from FTUTORES where tutor = '$pr'");
						$tuto = mysql_fetch_array($tut);
						$unidad = "$tuto[0]-$tuto[1]";

						if(stristr($perfil,'2') == TRUE){$extra = "where unidad='$unidad'";}
						if($padres == '1') {echo "<hr /><legend class='text-warning'>Padres de Alumnos</legend>
						<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
						<div class='well well-transparent'>";
						echo '<SELECT  name=padres[] multiple=multiple size=27 class="span10" >';
						$padre = mysql_query("SELECT distinct APELLIDOS, NOMBRE  FROM alma $extra order by apellidos");
						while($filapadre = mysql_fetch_array($padre))
						{
							$al_sel = "$filapadre[0], $filapadre[1]";
							if ($al_sel==$origen) {
								$seleccionado='selected';
							}else{$seleccionado="";}
							echo "<OPTION $seleccionado>$filapadre[0], $filapadre[1]</OPTION>";
						}
						echo  '</select>';
						echo "</div>";
						}
					}
					?>
          </div>
        </div>
      </div>
       
      <div class="span6 well">
        <div class="control-group" align="left">
          <input type="hidden" name="profesor"
					value="<? echo $pr; ?>" />
          <label class="control-label" for="asunto">Asunto</label>
          <input name="asunto" type="text" value="<? echo $asunto;?>" class="input" style="width:97%"/>
          <hr />
          <label class="control-label" for="texto">Texto</label>
          <div class="controls">
          <textarea name="texto" id="editor" style="height: 200px; width: 100%;">
		<? echo $texto;?>
      </textarea>
      
            <hr />
            <input type="submit" class="btn btn-primary btn-block" name="submit1" value="Enviar Mensaje" />
          </div>
        </div>
</div>
</div>

  </fieldset>
</form>
</div>
<? include("../../pie.php");
if ($verifica) {
?>
<script> 
document.form.texto.focus() 
</script>
<?
}
?>
</body></html>