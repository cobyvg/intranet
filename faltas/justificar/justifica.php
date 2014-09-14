<?
// Aquí empieza la justificación.
// Buscamos registros siguiendo a cal.php
// Datos complementarios para el formulario
$borrajusti = "SELECT NC, CLAVEAL, apellidos, nombre FROM FALUMNOS WHERE claveal = '$alumno'";
$borrajusti0 = mysqli_query($db_con, $borrajusti);
// Borrado de faltas justificadas
if ($falta=="J") 
{
$borrajusti1 = mysqli_fetch_array($borrajusti0);
$nombreal = trim($borrajusti1[3]);
$apellidoal = trim($borrajusti1[2]);
$deljusti = "DELETE FROM FALTAS WHERE FECHA = '$year-$month-$today' and CLAVEAL = '$alumno' and FALTA = 'J'";
mysqli_query($db_con, $deljusti) or die("No se ha podido eliminar la Falta Justificada.<br> Ponte en contacto con quien pueda arreglarlo..");		
}
// Aquí empieza la justificación.
else 
{
$justifica0 = "SELECT FALTA, FALTAS.NC, FALUMNOS.CLAVEAL, FALTAS.HORA, FALTAS.CODASI FROM FALTAS, FALUMNOS WHERE FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.FECHA = '$year-$month-$today' and FALTAS.claveal = '$alumno'";
// echo $justifica0."<br>";
    $justifica1 = mysqli_query($db_con, $justifica0);
// echo mysqli_num_rows($justifica1)."<br>";
    if (mysqli_num_rows($justifica1) > 0) {    	
    	while ($faltones = mysqli_fetch_array($justifica1)) {
$justificacion = "UPDATE  FALTAS SET  FALTA =  'J' WHERE  FECHA = '$year-$month-$today' and FALTAS.claveal = '$alumno' and FALTAS.FALTA = 'F'";
mysqli_query($db_con, $justificacion);
// echo $justificacion."<br>";
    	}    	
    }
// S i el tutor quiere justificar una falta antes de que haya sido introducida en la base de datos, procedemos a rellenar todas las horas de ese día con la "J".   
    else {
	
	$fecha2 = mktime(0,0,0,$month,$today,$year);
	$fecha22 = mktime(0,0,0,9,15,2008);
	$diames = date("j");
    $nmes = date("n");
	$nano = date("Y");
	$hoy1 = mktime(0,0,0,$nmes,$diames,$nano);	
	$a = '$month-$today-$year';	
    $ndia = getdate(mktime(0,0,0,$month,$today,$year));
	$fecha33 = $year."-".$month."-".$today;
	$fecha44 = $today."-".$month."-".$year;
	$fecha_fiesta= strtotime($fecha33);
		
 // Fiestas del Año, Vacaciones, etc.
 	$comienzo_del_curso = strtotime($inicio_curso);
	$final_del_curso = strtotime($fin_curso);
	$dia_festivo="";
	$mens_fecha="";
$repe=mysqli_query($db_con, "select fecha from festivos where date(fecha) = date('$fecha33')");
if (mysqli_num_rows($repe) > '0') {	
	$dia_festivo='1';
		}
if($dia_festivo=='1')	
	{
	$mens_fecha = "No es posible poner o justificar Faltas en un <b>Día Festivo</b> o en <b>Vacaciones</b>. Comprueba la Fecha: <b>$fecha11</b>";
		if($year and $month and $today){$mens_fecha.=": ".$fecha44;}
		$mens_fecha.=".</p>";
	}
	elseif (($fecha2 < $comienzo_del_curso) and !($month == "" or $today == "" or $year == "")) {
		$mens_fecha = "No es posible poner Faltas del <b>Curso Anterior</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
	}
	elseif ($fecha2 > $hoy1) {
		$mens_fecha = "No es posible poner Faltas en el <b>Futuro</b>.<br>Comprueba la Fecha: <b>$fecha11</b>.";
	}			
		
// Excluimos Sábados y Domingos;
    	elseif (($ndia ['wday']== "0") or ($ndia ['wday']== "6")) {
    	}
    	else {
    
    		
    		
    		for ($i=1;$i<7;$i++)
    {
$codasi="";
$profeso="";
$num_dia = $ndia['wday'];
    $unica = "select combasi from alma where alma.claveal = '$alumno'";
    $unica0 = mysqli_query($db_con, $unica);
    $unica1 = mysqli_fetch_row($unica0);
    $combasi=$unica1[0];
    //echo $combasi."<br>";
$codasi10 = "select prof, a_asig, c_asig, no_prof from horw_faltas where a_grupo like '%$unidad%' and dia = '$num_dia' and hora = '$i'";
//echo $codasi10."<br>";
$codasi0 = mysqli_query($db_con, $codasi10);
	while ($codasi1 = mysqli_fetch_row($codasi0)) {
		if ($codasi1[1]=="TUT") {
    		$codasi = "TUT";
    		$profeso = $codasi1[3];    			
    		} 
    		else {
       		if (strlen(strstr($combasi,$codasi1[2]))>0) {
    		$codasi = $codasi1[2];
    		$profeso = $codasi1[3];    			
    		}   			
    		}
	}    	
    	$clavenc = "SELECT NC FROM FALUMNOS WHERE claveal = '$alumno'";
    	$clavenc0 = mysqli_query($db_con, $clavenc);
    	$clavenc1 = mysqli_fetch_row($clavenc0);
    	$nc = $clavenc1[0];   	
    	$enviada = "$year-$month-$today";
// Excluimos otras posibilidades de error.
    	if (($unidad == "") or ($today == "")) {
    	}
    	else {
$semana = date( mktime(0, 0, 0, $month, $today, $year));
$hoy = getdate($semana);
$nombredia = $hoy[wday];	

// Insertamos la justificación en todas las horas de esa fecha para ese alumno. Si hay varias asignaturas y profesores en una hora, esos campos quedan vacío. Asunto por rematar.
$justifica10 = "insert INTO  FALTAS (  CLAVEAL , unidad  ,  NC ,  FECHA ,  HORA , DIA,  PROFESOR ,  CODASI ,  FALTA ) VALUES ('$alumno',  '$unidad', '$nc',  '$year-$month-$today', '$i', '$nombredia', '$profeso',  '$codasi', 'F')";	
mysqli_query($db_con, $justifica10) or die("No se ha podido justificar las faltas.");	
// echo $justifica10."<br>";

    	} 	
    }
    }
    }
}
$borrapend = mysqli_query($db_con, "select combasi, claveal, curso from alma where curso like '%bach%'order by curso");
while ($com=mysqli_fetch_array($borrapend)) {
	if (strlen($com[0])<49) {	
		mysqli_query($db_con, "delete from FALTAS where claveal='$com[1]' and codasi='' and profesor=''");		
	}
}
    ?>