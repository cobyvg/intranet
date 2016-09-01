<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed');


if (date('G')>='9' and date('G')<='11') {

$hoy = date('Y-m-d');

$acc = mysqli_query($db_con,"select fecha from acceso_dias where date(fecha)='$hoy'");

if(mysqli_num_rows($acc)>0){ }

else{

// Restricciones de fecha: evitamos vacaciones y festivos.

$fiesta="";
$suma_dias="";

$fecha_actual = strtotime($hoy);
$ayer = strtotime($hoy)-86400;
$antesdeayer = strtotime($hoy)-172800;
$uno_antesdeayer = strtotime($hoy)-259200;

// Comenzamos 10 d�as despu�s del comienzo de curso para dar tiempo a que los Centros se organicen.
$fecha_inicio_curso = strtotime($config['curso_inicio'])+36000;
$fecha_fin_curso = strtotime($config['curso_fin']); 

//$fecha_fin_curso = "1491816800";

if ($fecha_actual > $fecha_inicio_curso and $fecha_actual < $fecha_fin_curso) {

//Si lunes, $suma_dias = 1;
//Si s�bado o domingo $fiesta=1;

if (date('N')>5) {
		$fiesta = 1;
	}	
if (date('N')==1) {
		$suma_dias = 1;
	}	

// Fiestas y Vacaciones

$fest = mysqli_query($db_con,"select distinct fecha, nombre from festivos");
while ($fstv = mysqli_fetch_array($fest)) {
	
	$festivo = strtotime($fstv[0]);
	$nombre_fiesta = $fstv[1];
	
	if ($fecha_actual==$festivo) {		
		$fiesta = 1;
		$suma_dias = 1;
	}	
	elseif ($ayer==$festivo) {
		$fiesta = 1;
	}
	elseif ($antesdeayer==$festivo and (stristr($nombre_fiesta, "Semana Blanca")==TRUE OR stristr($fnombre_fiesta, "Semana Santa")==TRUE OR stristr($nombre_fiesta, "Navidad")==TRUE)) {
		$fiesta2 = 1;
	}
	elseif ($uno_antesdeayer==$festivo and (stristr($nombre_fiesta, "Semana Blanca")==TRUE OR stristr($nombre_fiesta, "Semana Santa")==TRUE OR stristr($nombre_fiesta, "Navidad")==TRUE)) {
		$fiesta2 = 1;
	}
}

if ($fiesta<>1 and $fiesta2<>1) {

	// Mensaje a Profesores que llevan m�s de 5 d�as sin entra en la intranet							

	$result = mysqli_query($db_con, "select distinct profesor, max(fecha) from reg_intranet where profesor in (select idea from departamentos) group by profesor");
									
	while ($row = mysqli_fetch_array($result)) {
		$profe_ultima = $row[0];
		$ult= $row[1];
		$tr_ult = explode(" ", $row[1]);
		$ultima = $tr_ult[0];
		$dias = (strtotime($hoy)-strtotime($row[1]))/86400;
		$dias = abs($dias); 
		$dias = floor($dias);
		$suma = 4+$suma_dias;
		if ($dias>$suma) {
			$num++;
			mysqli_query($db_con,"insert into acceso VALUES ('','$profe_ultima','$hoy','1','$ultima')");
			}
		}
	}	


if ($fiesta<>1) {

// Mensajes sin leer de los profesores 

mysqli_query($db_con,"create table mens_temp select * from mens_profes where recibidoprofe='0' and profesor in (select idea from departamentos) limit 3000");

$result = mysqli_query($db_con, "select distinct idea from departamentos order by idea");
									
	while ($row = mysqli_fetch_array($result)) {
	$profe_mens = $row[0];	
	$result2 = mysqli_query($db_con, "select * from mens_temp where profesor = '$profe_mens' and recibidoprofe='0'");
			
		$sin_leer = mysqli_num_rows($result2);
		if ($sin_leer > 25) {
			$num++;
			mysqli_query($db_con,"insert into acceso VALUES ('','$profe_mens','$hoy','2','$sin_leer')");	
			}
		}
	}	
}



// Informes de Tareas a punto de cumplir


$grupo = "";
$id = "";
$claveal = "";
$profeso = "";
$codasi = "";
$curso = "";
$asignatura = "";
$idea = "";

$fchs = mysqli_query($db_con,"select * from tareas_alumnos where date(fecha) = '$hoy'");
while ($al_fecha = mysqli_fetch_array($fchs)) {
	
	$grupo = $al_fecha['unidad'];
	$id = $al_fecha['ID'];
	$claveal = $al_fecha['CLAVEAL'];

	$alma = mysqli_query($db_con,"select combasi, curso, nc from alma, FALUMNOS where alma.claveal=FALUMNOS.claveal and alma.claveal = '$claveal'");
	$combasi = mysqli_fetch_array($alma);
	
	$curso = $combasi[1];
	$asignaturas =substr($combasi[0],0,-1);
	$tr_combasi = explode(":", $asignaturas);
	foreach ($tr_combasi as $codasi) {
				
		$asigna1 = mysqli_query($db_con, "select nombre from asignaturas where codigo = '$codasi' and curso = '$curso' and abrev not like '%\_%'");
		$asigna2 = mysqli_fetch_array($asigna1);
		$asignatura = $asigna2[0];

		$profe_asig0 = mysqli_query($db_con,"select * from tareas_profesor where id_alumno = '$id' and asignatura = '$asignatura'");
		if (mysqli_num_rows($profe_asig0)>0) { }
			else{
				$hay_profe = mysqli_query($db_con,"select profesor, idea from profesores, departamentos where nombre=profesor and materia = '$asignatura' and grupo = '$grupo'");
				while ($hay_pr = mysqli_fetch_array($hay_profe)) {
					$idea = $hay_pr[1];
					$profeso = $hay_pr[0];
					$nc = $combasi[2];
					$sel = mysqli_query($db_con,"select alumnos from grupos where profesor = '$profeso' and curso = '$grupo' and asignatura = '$codasi'");
					$hay_grupo = mysqli_num_rows($sel);
					if ($hay_grupo>0) {
						$sel_al = mysqli_fetch_array($sel);
						$al_sel = explode(",",$sel_al[0]);
						$hay_al="";
						foreach($al_sel as $num_al){
							if ($num_al == $nc) {
								$hay_al = "1";;
							}
						}
					}
					if ($hay_al=="1" or $hay_grupo<1) {
						$num++;
						mysqli_query($db_con,"insert into acceso VALUES ('','$idea','$hoy','3','$id')");
					}					
				}
			}
		}
	}

// Informes de Tutor�a a punto de cumplir

$grupo = "";
$id = "";
$claveal = "";
$profeso = "";
$codasi = "";
$curso = "";
$asignatura = "";
$idea = "";

$fchs = mysqli_query($db_con,"select * from infotut_alumno where date(F_ENTREV) = '$hoy'");
while ($al_fecha = mysqli_fetch_array($fchs)) {
	
	$grupo = $al_fecha['unidad'];
	$id = $al_fecha['ID'];
	$claveal = $al_fecha['CLAVEAL'];

	$alma = mysqli_query($db_con,"select combasi, curso, nc from alma, FALUMNOS where alma.claveal=FALUMNOS.claveal and alma.claveal = '$claveal'");
	$combasi = mysqli_fetch_array($alma);
	
	$curso = $combasi[1];
	$asignaturas =substr($combasi[0],0,-1);
	$tr_combasi = explode(":", $asignaturas);
	foreach ($tr_combasi as $codasi) {
				
		$asigna1 = mysqli_query($db_con, "select nombre from asignaturas where codigo = '$codasi' and curso = '$curso' and abrev not like '%\_%'");
		$asigna2 = mysqli_fetch_array($asigna1);
		$asignatura = $asigna2[0];

		$profe_asig0 = mysqli_query($db_con,"select * from infotut_profesor where id_alumno = '$id' and asignatura = '$asignatura'");
		if (mysqli_num_rows($profe_asig0)>0) { }
			else{
				$hay_profe = mysqli_query($db_con,"select profesor, idea from profesores, departamentos where nombre=profesor and materia = '$asignatura' and grupo = '$grupo'");
				while ($hay_pr = mysqli_fetch_array($hay_profe)) {
					$idea = $hay_pr[1];
					$profeso = $hay_pr[0];
					$nc = $combasi[2];
					$sel = mysqli_query($db_con,"select alumnos from grupos where profesor = '$profeso' and curso = '$grupo' and asignatura = '$codasi'");
					$hay_grupo = mysqli_num_rows($sel);
					if ($hay_grupo>0) {
						$sel_al = mysqli_fetch_array($sel);
						$al_sel = explode(",",$sel_al[0]);
						$hay_al="";
						foreach($al_sel as $num_al){
							if ($num_al == $nc) {
								$hay_al = "1";;
							}
						}
					}
					if ($hay_al=="1" or $hay_grupo<1) {
						$num++;
						mysqli_query($db_con,"insert into acceso VALUES ('','$idea','$hoy','4','$id')");
					}					
				}
			}
		}
	}


// ENV�O DE MENSAJES SMS U OTROS A LOS PROFESORES

$pr_sms = mysqli_query($db_con,"select distinct profesor from acceso where date(fecha)='$hoy'");
while ($p_sms = mysqli_fetch_array($pr_sms)){

$clase="";	
$profe_sms = $p_sms[0];	

$SQL0 = "SELECT distinct clase FROM  acceso where profesor = '$profe_sms' and date(fecha)='$hoy'";
$result0 = mysqli_query($db_con, $SQL0);		
while ($row0 = mysqli_fetch_array($result0)){
	$clase.=$row0[0];			
	}	

	$movil="";
	$texto="";
	
	$text_0 = "La Direccion del Centro te recuerda que";
	$text_1 = " hace mas de 4 dias que no compruebas el estado de tus tareas en la Intranet y es necesario que lo hagas con regularidad;";
	$text_2 = " tienes mas de 25 mensajes pendientes que no has leido todavia;";
	$text_3 = " tienes trabajo pendiente: Informes de Tareas que debes presentar hoy;";
	$text_4 = " tienes trabajo pendiente: Informes de Tutoria que debes presentar hoy al Tutor.";
	$text_5 = " ".$config['centro_denominacion'];

	$texto = $text_0;

	if (strstr($clase,"1")==TRUE) { $texto.= $text_1; }
	if (strstr($clase,"2")==TRUE) { $texto.= $text_2; }
	if (strstr($clase,"3")==TRUE) { $texto.= $text_3; }
	if (strstr($clase,"4")==TRUE) { $texto.= $text_4; }

	$texto.= $text_5;

	$texto_ies = "; ".substr($config['centro_denominacion'],0,4);
	$nombre_ies = ". ".substr($config['centro_denominacion'],0,4);
	if (stristr($texto, $texto_ies)) {
		$texto = str_ireplace($texto_ies, $nombre_ies, $texto);
	}

	// Telefonos m�viles o sin telefono
	$tfn = mysqli_query($db_con,"select telefono from c_profes where idea = '$profe_sms'");
	$tfno = mysqli_fetch_array($tfn);
	$movil = $tfno[0];

	// El Centro tiene env�o de SMS
	if ($config['mod_sms']==1 and strlen($movil)==9) {

		include_once(INTRANET_DIRECTORY . '/lib/trendoo/sendsms.php');
		include_once(INTRANET_DIRECTORY . '/lib/trendoo/config.php');
        $sms = new Trendoo_SMS();
        $sms->sms_type = SMSTYPE_GOLD_PLUS;
        $sms->add_recipient('+34'.$movil);
        $sms->message = $texto;
        $sms->sender = $config['mod_sms_id'];
        $sms->set_immediate();

		if ($sms->validate()){  
	        $sms->send();				        
	    	}

	    	mysqli_query($db_con, "insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$movil','$texto','Direccion')");
		
			}

		// De lo contrario, enviamos un correo
		else{

			//Buscamos correo del profe
			$mail0=mysqli_query($db_con, "select correo, PROFESOR from c_profes where idea='$profe_sms'");
			if (mysqli_num_rows($mail0)>0) {
				$numcor++;
			}
			$mail1=mysqli_fetch_row($mail0);
			$direccion = $mail1[0];
			$cor_profes = $mail1[1];
			$tr_profes = explode(", ", $cor_profes);
			$nombre_profe = $tr_profes[1]." ".$tr_profes[0];

			$tema = "Comunicaci�n de Tareas pendientes en el Centro";
			$profe_envia = "Direcci�n del ".$config['centro_denominacion'];
			$mail_from = $config['centro_email'];
			
			$titulo = stripslashes(mysqli_real_escape_string($db_con, $tema));
			$contenido = stripslashes(mysqli_real_escape_string($db_con, $texto));

			include_once(INTRANET_DIRECTORY."/lib/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->Host = "localhost";
			$mail->From = $mail_from;
			$mail->FromName = $profe_envia;
			$mail->AddReplyTo($mail_from, $profe_envia);
			$mail->Sender = $mail_from;
			$mail->IsHTML(true);
			
			$message = file_get_contents(INTRANET_DIRECTORY.'/lib/mail_template/index.htm');
			$message = str_replace('{{dominio}}', $config['dominio'], $message);
			$message = str_replace('{{centro_denominacion}}', $config['centro_denominacion'], $message);
			$message = str_replace('{{centro_codigo}}', $config['centro_codigo'], $message);
			$message = str_replace('{{centro_direccion}}', $config['centro_direccion'], $message);
			$message = str_replace('{{centro_codpostal}}', $config['centro_codpostal'], $message);
			$message = str_replace('{{centro_localidad}}', $config['centro_localidad'], $message);
			$message = str_replace('{{centro_provincia}}', $config['centro_provincia'], $message);
			$message = str_replace('{{centro_telefono}}', $config['centro_telefono'], $message);
			$message = str_replace('{{centro_fax}}', $config['centro_fax'], $message);
			$message = str_replace('{{titulo}}', 'Nuevo mensaje de la '.$profe_envia.' para '.$nombre_profe, $message);
			$message = str_replace('{{contenido}}', '<strong>'.$titulo.'</strong><br>'.$contenido.'<br><br><small>Enviado por: '.$profe_envia.'</small>', $message);
			
			$mail->msgHTML($message);
			$mail->Subject = $config['centro_denominacion'].' - Mensaje de la '.$profe_envia;
			$mail->AltBody = $titulo.' '.$contenido;			
			$mail->AddAddress($direccion, $cor_profes);
			$mail->Send();

			}	
		}

	// Registramos la fecha para no volver a repetir 
	mysqli_query($db_con,"insert into acceso_dias VALUES ('','$hoy','$num')");

	}
}
