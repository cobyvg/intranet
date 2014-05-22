<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
$pr = $_SESSION['profi'];

$prof1 = "SELECT distinct no_prof FROM horw where prof = '$pr'";
$prof0 = mysql_query($prof1);
$filaprof0 = mysql_fetch_array($prof0);
$profesi = $filaprof0[0]."_ ".$pr;
$_SESSION['todo_profe'] = $profesi;
// Datos de curso, codigo, hora, nº de dia y codasi.
	$hora = date("G");// hora
    $ndia = date("w");// nº de día de la semana (1,2, etc.)
	if($ndia == "1"){$nom_dia = "Lunes";}
	if($ndia == "2"){$nom_dia = "Martes";}
	if($ndia == "3"){$nom_dia = "Miércoles";}
	if($ndia == "4"){$nom_dia = "Jueves";}
	if($ndia == "5"){$nom_dia = "Viernes";}
	
	$minutos = date("i");
	$diames = date("j");
    $nmes = date("n");
	$nano = date("Y");
	$hoy = $nano."-".$nmes."-".$diames;
	if(empty($hora_dia)){
	if(($hora == '8' and $minutos > 15 ) or ($hora == '9' and $minutos < 15 ) ){$hora_dia = '1';}
	elseif(($hora == '9' and $minutos > 15 ) or ($hora == '10' and $minutos < 15 ) ){$hora_dia = '2';}
	elseif(($hora == '10' and $minutos > 15 ) or ($hora == '11' and $minutos < 15 ) ){$hora_dia = '3';}
	elseif(($hora == '11' and $minutos > 15 ) or ($hora == '11' and $minutos < 45 ) ){$hora_dia = 'Recreo';}
	elseif(($hora == '11' and $minutos > 45 ) or ($hora == '12' and $minutos < 45 ) ){$hora_dia = '4';}
	elseif(($hora == '12' and $minutos > 45 ) or ($hora == '13' and $minutos < 45 ) ){$hora_dia = '5';}
	elseif(($hora == '13' and $minutos > 45 ) or ($hora == '14' and $minutos < 45 ) ){$hora_dia = '6';}
	else{ $hora_dia = "Fuera del Horario Escolar";}
	}

//$nl_curs10 = "select distinct a_grupo from horw where no_prof = '59' and dia = '1' and hora = '5'";
$nl_curs10 = "select distinct a_grupo from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
$nl_curs11 = mysql_query($nl_curs10); 
$nml0 = mysql_fetch_array($nl_curs11); 
$nml = $nml0[0];
	if (($ndia == '6' or $ndia == '0' or $hora_dia == "Fuera del Horario Escolar" or empty($nml)) and !(stristr($_SESSION['cargo'],'3') == TRUE)){
		header('Location:poner/index.php');
		exit;
	}
	registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

?>
<?
if ($mod_faltas) {
include("../menu.php");
include("menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Poner faltas</small></h2>
</div>
<br />
<?
	// Unir todos los grupos para luego comprobar que no hay duplicaciones (4E-E,4E-Dd)
//$n_curs0 = "select distinct a_grupo, c_asig from horw where no_prof = '59' and dia = '1' and hora = '5'";
$n_curs0 = "select distinct a_grupo, c_asig from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
$n_curs1 = mysql_query($n_curs0);
while($n_cur = mysql_fetch_array($n_curs1))
  {
  	$curs .= $n_cur[0].", ";
  	 $niv =  substr($n_cur[0],0,1);
  	 $niv2 = substr($n_cur[0],1,1);
  	 $cod.=$n_cur[1]." ";
  } 
 if($mensaje){
	echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Las Faltas han sido registradas correctamente.
          </div></div>'; 
	}  

  	$t_grupos = $curs;
	if(!($t_grupos=="")){
	echo "<p class='lead'><span style='color:#9d261d'>Día</span>: $nom_dia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#9d261d'>Hora:</span> $hora_dia";
	if(!($hora_dia == "Fuera del Horario Escolar")){echo "ª hora";}
	echo "</p>";
	}
	
	//$hora1 = "select distinct c_asig, a_grupo, asig from horw where no_prof = '59' and dia = '1' and hora = '5'";
	$hora1 = "select distinct c_asig, a_grupo, asig, nivel, n_grupo from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
	$hora0 = mysql_query($hora1); 
	while($hora2 = mysql_fetch_row($hora0))
	{
	$codasi= $hora2[0];
	$curso = $hora2[1];
	$asignatura = $hora2[2];
	?>
	<div class="btn-group" style="margin-bottom:15px;">
<a href="javascript:seleccionar_todo()" class="btn btn-success">Marcar todos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-warning">Desmarcar todos</a> </div>
	<?
	echo "<table align='center' class='table table-striped table-bordered table-condensed' style='width:auto'>\n";  			     
        	$filaprincipal = "<tr><th colspan='4'><br /><p class='lead text-info' align='center'>$curso $asignatura</p></th></tr>";  
	// Diversificación
if(substr($curso,4,1) == 'd')
	{
		$curso30 = substr($curso,0,strlen($curso) - 1).",";
		if(strstr($t_grupos,$curso30)){$curso = "";}
		else {
	//	Problemas con Diversificación (4E-Dd)
		$curso_sin1 =  substr($curso,0,strlen($curso) - 1);
		$curso = $curso_sin1;
		echo $filaprincipal;
		}
	}
	else {
		$curso = $hora2[1];
		echo $filaprincipal;
	}
?>
<form action="poner_falta.php" method="post" name="Cursos">
  <?php

  // Codigo del profe
  	echo '<input name=nprofe type=hidden value="'; 
	echo $filaprof0[0];
	echo '" />';
	// Hora escolar
	echo '<input name=hora type=hidden value="'; 
	echo $hora_dia; 		
	echo '" />';
	// dia de la semana
	echo '<input name=ndia type=hidden value="'; 
	echo $ndia; 
	echo '" />';
	// Hoy
	echo '<input name=hoy type=hidden value="'; 
	echo $hoy; 
	echo '" />';
	// Codigo asignatura
	echo '<input name=codasi type=hidden value="'; 
	echo $codasi; 
	echo '" />';
	// Profesor
	echo '<input name=profesor type=hidden value="'; 
	echo $pr; 
	echo '" />';
	// Clave
	echo '<input name=clave type=hidden value="'; 
	echo $clave; 
	echo '" />';
  	$c_a="";
$res = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and unidad = '$curso' and ( ";	 
//$n_curs10 = "select distinct c_asig from horw where no_prof = '59' and dia = '1' and hora = '5'";
$n_curs10 = "select distinct c_asig from horw where no_prof = '$filaprof0[0]' and dia = '$ndia' and hora = '$hora_dia'";
$n_curs11 = mysql_query($n_curs10); 
$nm = mysql_num_rows($n_curs11); 
  while ($nm_asig0=mysql_fetch_array($n_curs11)){
	$c_a.="combasi like '%".$nm_asig0[0]."%' or ";
  }		
	
	$res.=substr($c_a,0,strlen($c_a)-3);
	$res.=") order by NC";
	$result = mysql_query ($res);


        while($row = mysql_fetch_array($result)){ 
        	$chk="";  
        	$combasi = $row[5];         	
					if ($row[5] == "") {}
					else{
				echo "<tr>";
				$foto="";
				$foto = "<img src='../xml/fotos/$row[0].jpg' width='50' height='60' class=''  />";
				echo "<td>".$foto."</td>";
				
				echo "<td style='vertical-align:middle'>$row[1]</td><td style='vertical-align:middle'>$row[2], $row[3]";			   
 				 if ($row[4] == "2" or $row[4] == "3") {echo " (R)";}
				} 
				echo "</td><td style='vertical-align:middle'>";
				

$fecha_hoy = date('Y')."-".date('m')."-".date('d');
$falta_d = mysql_query("select distinct falta from FALTAS where dia = '$ndia' and hora = '$hora_dia' and claveal = '$row[0]' and fecha = '$fecha_hoy'");
$falta_dia = mysql_fetch_array($falta_d);
if ($falta_dia[0] == "F") {
	$chk = "checked";
}				
?>
      <input name="falta_<? echo $row[1]."_".$curso;?>" type="checkbox" <? echo $chk; ?>	value="F" />

<?				
				echo "</td></tr>";
                }   	
                } 
        echo '</table><br />';
		if(!(empty($codasi))){echo '<input name="enviar" type="submit" value="Enviar datos" class="btn btn-primary btn-large"/>';} 

  ?>
  
    </FORM>
    <?
	}

 else {
	 echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El módulo de Faltas de Asistencia debe ser activado en la Configuración general de la Intranet para poder accede a estas páginas, y ahora mismo está desactivado
          </div></div>'; 
	echo "<div style='color:brown; text-decoration:underline;'>Las Faltas han sido registradas.</div>";
 }
    ?>
    
    <? 
include("../pie.php");
?>
<script>

function seleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.Cursos.elements.length;i++)
		if(document.Cursos.elements[i].type == "checkbox")	
			document.Cursos.elements[i].checked=0
}
</script>
</body>
</html>
