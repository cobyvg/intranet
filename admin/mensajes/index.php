<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$pr = $_SESSION['profi'];
?>
<?
include("../../menu.php");
include("menu.php");
if($verifica){
 mysql_query("UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$verifica'");
}
?>
<div class="page-header" align="center">
  <h1>Centro de Mensajes <small> Enviar mensajes...</small></h1>
</div>
<br />
<? 
include("profesores.php");
?>  

<form id="form" name="form" method="post" action="index.php">
  <fieldset>
<div class="row-fluid">
<div class="span2"></div>

  <div class="span4">
      <div class="well-2  well-large">
        <h4>Destinatario(s)</h4>
        <br />
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
						echo "<h4>Selecciona los Profesores</h4>
						<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
						<br /><div class='well'>";
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

					if($tutores == '1' and !$claustro) {echo "<h4>Selecciona los Tutores de Grupo</h4>
					<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div><br />
					<div class='well'>";
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

					if($departamentos == '1' and !$claustro) {echo "<h4>Selecciona los Departamentos o Áreas</h4>
					<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
					<br /><div class='well'>";
					echo '<SELECT  name=departamento[] multiple=multiple size=25 class="span9" >';
					$dep = mysql_query("SELECT distinct departamento FROM departamentos order by departamento asc");
					while($filadep = mysql_fetch_array($dep))
					{
						echo "<OPTION>$filadep[0]</OPTION>";
					}
					echo  '</select></div>';
					}

					if($equipos == '1' and !$claustro) {echo "<h4>Selecciona Equipos Educativos</h4>
					<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div><br />
					<div class='well'>";
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
						echo "<h4>Claustro de Profesores</h4><br /><div class='well'>";
						$cl = mysql_query("SELECT distinct nombre FROM departamentos");
						while($filacl = mysql_fetch_array($cl))
						{
							$t_cl .= $filacl[0].",";
							$ok = explode(", ",$filacl[0]);
							$t_cl2 = "<li align='left'>".$ok[1]." ".$ok[0]."</li>";
							echo "$t_cl2";
						}
						echo "</div>";
						}

					if($orientacion == '1' and !$claustro) {
						echo "<h4>Departamento de Orientación</h4><br /><div class='well'>";
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
						echo "<h4>Centro Bilingue</h4><br /><div class='well'>";
						$bilingue = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%a%'");
						while($filabi = mysql_fetch_array($bilingue))
						{
							echo "<li align='left'>$filabi[0] </li>";
							$t_bi .= $filabi[0].",";
						}
						$t_bi = substr($t_bi,0,strlen($t_bi)-1);
					echo "</div>";
					}
					



					if($etcp == '1' and !$claustro) {
						echo "<h4>Equipo Técnico de Coordinación Pedagógica</h4><br /><div class='well'>";
						$etc = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like '%4%'");
						while($filaetc = mysql_fetch_array($etc))
						{
							echo "<li align='left'>$filaetc[0] </li>";
							$t_etcp .= $filaetc[0];
						}
						$t_etcp = substr($t_etcp,0,strlen($t_etcp)-1);
						
					}

					if($ca == '1' and !$claustro) {
						echo "<h4>Coordinación de Área</h4><br /><div class='well'>";
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
						echo "<h4>Equipo Directivo</h4><br /><div class='well'>";
						$dir = mysql_query("SELECT distinct nombre  FROM departamentos where cargo like'%1%'");
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
						echo "<h4>Padres de Alumnos</h4><br /><div class='well'>";
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
						if($padres == '1') {echo "<h4>Padres de Alumnos</h4>
						<div class='help-block'>* Puedes seleccionar varios manteniendo pulsada la tecla Control.</div>
						<br /><div class='well'>";
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
       
      <div class="span4 well-2 well-large">
        <div class="control-group" align="left">
          <input type="hidden" name="profesor"
					value="<? echo $pr; ?>" />
          <label class="control-label" for="asunto">Asunto</label>
          <input name="asunto" type="text" value="<? echo $asunto;?>" class="input-xlarge"/>
          <label class="control-label" for="texto">Texto</label>
          <div class="controls">
            <textarea id="texto" name="texto" class="input-xlarge" id="textarea" rows="8"><? echo $texto;?></textarea>
            <br />
            <input type="submit" class="btn btn-primary" name="submit1" value="Enviar Mensaje" />
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