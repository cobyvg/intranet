<?php
function redondeo($n){

	$entero10 = explode(".",$n);
	if (strlen($entero10[1]) > 2) {
		//redondeo o truncamiento según los casos

		if (substr($entero10[1],2,1) > 5){$n = $entero10[0].".". substr($entero10[1],0,2)+0.01;}
		else {$n = $entero10[0].".". substr($entero10[1],0,2);}
		echo $n;
	}
		
	else {echo $n;}
}

function media_ponderada($n){

	$entero10 = explode(".",$n);
	if (strlen($entero10[1]) > 2) {
		//redondeo o truncamiento según los casos

		if (substr($entero10[1],2,1) > 5){$n = $entero10[0].".". substr($entero10[1],0,2)+0.01;}
		else {$n = $entero10[0].".". substr($entero10[1],0,2);}
		return $n;
	}
		
	else {return $n;}
}

function tipo($db_con)
{
	$tipo = "select distinct tipo from listafechorias";
	$tipo1 = mysqli_query($db_con, $tipo);
	while($tipo2 = mysqli_fetch_array($tipo1))
	{
		echo "<OPTION>$tipo2[0]</OPTION>";
	}
}

function medida2($db_con, $tipofechoria)
{
	$tipo = "select distinct medidas2 from listafechorias where fechoria = '$tipofechoria'";
	$tipo1 = mysqli_query($db_con, $tipo);
	while($tipo2 = mysqli_fetch_array($tipo1))
	{
		$texto = trim($tipo2[0]);
		echo "$texto";
	}
}

function fechoria($db_con, $clase)
{
	$tipofechoria0 = "select fechoria from listafechorias where tipo = '$clase' order by fechoria";
	$tipofechoria1 = mysqli_query($db_con, $tipofechoria0);
	while($tipofechoria2 = mysqli_fetch_array($tipofechoria1))
	{
		echo "<option>$tipofechoria2[0]</option>";
	}
}

function unidad($db_con)
{
	// include("opt/e-smith/config.php");

	$tipo = "select distinct unidad, SUBSTRING(unidad, 2,1) AS orden from alma order by orden ASC";
	$tipo1 = mysqli_query($db_con, $tipo);
	while($tipo2 = mysqli_fetch_array($tipo1))
	{
		echo "<option>".$tipo2[0]."</option>";
	}
}
/*
 function nivel()
 {
 // include("opt/e-smith/config.php");

 $tipo = "select distinct NIVEL from alma order by NIVEL";
 $tipo1 = mysqli_query($db_con, $tipo);
 while($tipo2 = mysqli_fetch_array($tipo1))
 {
 echo "<option>".$tipo2[0]."</option>";
 }
 }

 function grupo($niveles)
 {
 // include("opt/e-smith/config.php");

 $tipo = "select distinct GRUPO from alma where NIVEL = '$niveles' order by GRUPO";
 $tipo1 = mysqli_query($db_con, $tipo);
 while($tipo2 = mysqli_fetch_array($tipo1))
 {
 echo "<option>".$tipo2[0]."</option>";
 }
 }
 */
function variables()
{
	foreach($_POST as $key => $val)
	{
		echo "$key --> $val<br>";
	}
}

// Comprueba si es fecha en formato dd/mm/aaaa o dd-mm-aaaa
// false si no true si si lo es
function es_fecha($fec)
{
	if (empty($fec))
	return false;
	else
	{
		# Tanto si es con / o con - la convertimos a -
		$fec = strtr($fec,"/","-");
		# la cortamos en trozos
		if (ereg("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $fec, $fec_ok)) {
			return checkdate($fec_ok[2],$fec_ok[1],$fec_ok[3]);
		} else {
			return false;
		}
	}
	#checkdate(mes,dia,año);
}

// DAR LA VUELTA A LA FECHA
function cambia_fecha($fec)
{
	if (empty($fec))
	return "";
	else
	{
		# Tanto si es con / o con - la convertimos a -
		$fec = strtr($fec,"/","-");
		# la cortamos en trozos
		$fec_ok=explode("-",$fec);
		# la devolvemos en el orden contrario
		return ($fec_ok[2]."-".$fec_ok[1]."-".$fec_ok[0]);
	}
}

/////////////
//Devuelve el numero de dia de la semana de la fecha
//////////////

function dia_dma($a)
{
if (es_fecha($a)){
					$a = strtr($a,"/","-");
					$a_ok=explode("-",$a);				
					$fecha = getdate(mktime(0,0,0,$a_ok[1],$a_ok[0],$a_ok[2]));
					if ($fecha['wday']!=0){return $fecha['wday'];}else{return 7;}
					}else{
					return '';
					}
}

function dia_amd($a)
{
$a=cambia_fecha($a);
return dia_dma($a);
}

function cambia_fecha_dia_mes($fec)
{
	if (empty($fec))
	return "";
	else
	{
		# Tanto si es con / o con - la convertimos a -
		$fec = strtr($fec,"/","-");
		# la cortamos en trozos
		$fec_ok=explode("-",$fec);
		# la devolvemos en el orden contrario
		return ($fec_ok[2]."-".$fec_ok[1]);
	}
}


function elmes($m){
	$mes["01"] = "enero";
	$mes["02"] = "febrero";
	$mes["03"] = "marzo";
	$mes["04"] = "abril";
	$mes["05"] = "mayo";
	$mes["06"] = "junio";
	$mes["07"] = "julio";
	$mes["08"] = "agosto";
	$mes["09"] = "septiembre";
	$mes["10"] = "octubre";
	$mes["11"] = "noviembre";
	$mes["12"] = "diciembre";
	return $mes[$m];
}

function formatea_fecha($fec){
	$fec = strtr($fec,"/","-");
	$fec_ok=explode("-",$fec);
	return ($fec_ok[2]." de ".elmes($fec_ok[1])." de ".$fec_ok[0]);
}

function formatDate($val)
{
	$arr = explode("-", $val);
	return date("d M Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));

}

function fecha_actual($valor_fecha){

	/*    if($valor_fecha == ""){
	 */	$mes = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
	8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	$dia = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado");
	$diames = date("j");
	$nmes = date("n");
	$ndia = date("w");
	$nano = date("Y");
	echo $diames." de ".$mes[$nmes].", ".$nano;
	/*	}
	 else{
	 $arr = explode("-", $valor_fecha);
	 $mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
	 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	 $dia0 = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado");
	 $diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	 $nmes0 = $arr[1];
	 if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}
	 // $ndia0 = $arr[2];
	 $ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	 $nano0 = $arr[0];
	 echo "$diames0 de ".$mes0[$nmes0].", $nano0";
	 }	*/
}

function fecha_actual3($valor_fecha){

	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
	$mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
	8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	$dia0 = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado");
	$diames0 = date("j",mktime($arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}
	// $ndia0 = $arr[2];
	$ndia0 = date("w",mktime($arr[1],$arr[2],$arr[0]));
	$nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0];
}

function fecha_actual2($valor_fecha){
	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
	$mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
	8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	$dia0 = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado");
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}
	// $ndia0 = $arr[2];
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nano0 = $arr[0];
	return "$diames0 de ".$mes0[$nmes0].", $nano0";
}

function fecha_sin($valor_fecha){
	/*    if($valor_fecha == ""){
	 $mes = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
	 8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	 $dia = array("domingo", "lunes","martes","miércoles","jueves","viernes","sábado");
	 $diames = date("j");
	 $nmes = date("n");
	 $ndia = date("w");
	 $nano = date("Y");
	 echo "$diames de ".$mes[$nmes].", $nano";
	 }
	 else{*/
	$arr0 = explode(" ", $valor_fecha);
	$arr = explode("-", $arr0[0]);
	$mes0 = array(1=>"enero",2=>"febrero",3=>"marzo",4=>"abril",5=>"mayo",6=>"junio",7=>"julio",
	8=>"agosto",9=>"septiembre",10=>"octubre",11=>"noviembre",12=>"diciembre");
	$diames0 = date("j",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nmes0 = $arr[1];
	if(substr($nmes0,0,1) == "0"){$nmes0 = substr($nmes0,1,1);}
	// $ndia0 = $arr[2];
	$ndia0 = date("w",mktime(0,0,0,$arr[1],$arr[2],$arr[0]));
	$nano0 = $arr[0];
	echo "$diames0 de ".$mes0[$nmes0].", $nano0";
	//}
}

//Asignacion de ordenadores a alumnos
function posicion($db_con, $curso, $profi){

	$sql=mysqli_query($db_con, "select distinct no_mesa from AsignacionMesasTIC where agrupamiento='$curso' and prof='$profi' order by no_mesa");
	while ($sqlr=mysqli_fetch_array($sql)){
		$posi=$sqlr[0];
		echo "<option>".$posi."</option>";
	}

}

function alumno($db_con, $curso,$profi){
	$sql=mysqli_query($db_con, "select CLAVEAL,no_mesa from AsignacionMesasTIC where agrupamiento='$curso' and prof='$profi' and no_mesa not like ' '");
	echo "select CLAVEAL,no_mesa from AsignacionMesasTIC where agrupamiento='$curso' and prof='$profi' and no_mesa not like ' '";
	while ($sqlr=mysqli_fetch_array($sql)){
		$al=mysqli_query($db_con, "select NOMBRE,APELLIDOS from FALUMNOS where CLAVEAL='$sqlr[0]' order by APELLIDOS");
		while ($alr=mysqli_fetch_array($al)){
			$nombre=$alr[1] .', '.$alr[0].'-->'.$sqlr[0];
			echo"<option>";
			echo $nombre;
			echo "</option>";}}
}

// Eliminar nombre de profesor con mayúsculas completo
function eliminar_mayusculas(&$n_profeso) {
	$n_profeso = mb_strtolower($n_profeso);
	$n_profeso = ucwords($n_profeso);
	//return $n_profeso;
	//echo "<span class='text-capitalize'>$minusc</span>";
}


function nomprofesor($nombre) {
	return mb_convert_case($nombre, MB_CASE_TITLE, "iso-8859-1");
}


function size_convert($size)
{
    $unit=array('B','KB','MB','GB','TB','PB');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}