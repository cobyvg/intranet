<?
session_start();
include("../../config.php");
if(empty($profe)){
	$profe = $_SESSION['profi'];
}

if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Eleccion de los alumnos de un agrupamiento flexible</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
<?
include("../../menu.php");
include("../menu.php");
?>
<div align="center">
<? 
if ($enviar=="Enviar datos") {
include("actualumno.php");
echo '<br><input type="button" name="volver" value="Volver a la lista de distribución" onclick="history.back(-2)">';
}
else {
	echo '<input type="button" name="volver" value="Volver a la lista de distribución" onclick="history.back(-1)">';
}
$trozos=explode(":",$agrupamiento);
$trozos1=explode("-",$trozos[0]);
$trozos2=explode("-",$trozos[1]);
$trozos3=explode("-",$trozos[2]);
$nivel=$trozos1[0]; 
$grupo1=$trozos1[1]; 
$grupo2=$trozos2[1];
$grupo3=$trozos3[1];
//mostramos los casi 90 alumnos de los tres grupos para poder seleccionarles mediante radiobotones para poder cazar tanto los alumnos seleccionados como los exluidos
$sql=mysql_query("select FALUMNOS.CLAVEAL,NOMBRE,APELLIDOS,NC,NIVEL,GRUPO , no_mesa from FALUMNOS, AsignacionMesasTIC where FALUMNOS.claveal=AsignacionMesasTIC.claveal and prof='$profe' and c_asig='$asig' and agrupamiento='$agrupamiento' and NIVEL='$nivel' and (GRUPO='$grupo1' or GRUPO='$grupo2' or GRUPO='$grupo3') order by GRUPO,NC") or die ("imposible seleccionar alumnado");
$count= mysql_num_rows ($sql);
?>
 <div class=titulogeneral style="margin:auto;margin-top:15px;margin-bottom:20px;width:600px;">DISTRIBUCI&Oacute;N DEL GRUPO <? echo $nivel.'-'.$grupo1.'-'.$grupo2.'-'.$grupo3 ;?></div>
<p id='texto_en_marco' style="text-align:justify;width:500px;"><b style="color:brown">LEE ATENTAMENTE ANTES DE PROCEDER:</b><br>1.- Si es la primera vez que vas a elegir los alumnos de tu agrupamiento flexible deberías seleccionar, sólo como 'NO', los alumnos a los que no les das clase.<br />
2.- Si lo que quieres es añadir alumnos nuevos a tu agrupamiento, elige como 'SI' sólo a esas nuevas incorporaciones.</p>
<form action="elegir.php" method="post">
	<input name=asig type=hidden value="<? echo $asig;?>" />
	<input name=profe type=hidden value="<? echo $profe;?>" />
	<input name=agrupamiento type=hidden value="<? echo $agrupamiento;?>" />
       <table class='tabla' align="center"> <tr>

       <td id='filaprincipal' colspan='5' align='center'>Alumnos del Agrupamiento Flexible <? echo $nivel.'-'.$grupo1.'-'.$grupo2.'-'.$grupo3 ;?></td></tr>  
       	  <tr>
          <td id='filasecundaria' align='center'>NC</td>
          <? if(is_dir("../../imag/fotos")){?><td id="filasecundaria"  align="center">FOTO</td><? }?> 
          <td id='filasecundaria' align='center'>GRUPO</td>
               <td id='filasecundaria' align='center' colspan='2'>ALUMNO</td>  
           </tr>
<? while ($row=mysql_fetch_array($sql)){ 
if (is_numeric($row[6])) {	$sel="";}else {$sel=" checked";}
	?>	       
   <tr>
   <td align='center' style="vertical-align:middle; background-color: #E0E8FF"><? echo $row[3];?></td>
   <? if(file_exists("../../imag/fotos/$row[0].jpg")){?><td align='center'><img width="55" height="68" src="../../imag/fotos/<? echo $row[0].'.jpg';?>"></td><? }?>
               <td align='center' style="vertical-align:middle; background-color: #E0E8FF"><? echo $nivel."-".$row[5];?></td>
               <td style="vertical-align:middle"><? echo $row[2].", ".$row[1];?></td>
			   <td style='margin:0px;padding:0px; vertical-align:middle; background-color: #E0E8FF' >			
      SÍ  <input name="checkbox[]_<? echo $row[0]; ?>" type="radio" value="SI_<? echo $row[0].'-'.$row[3];?>" style="margin:0px;padding:0px;"  /> | 
      NO  <input name="checkbox[]_<? echo $row[0]; ?>" type="radio" value="NO_<? echo $row[0].'-'.$row[3];?>" style="margin:0px;padding:0px;"  <? echo $sel;?> /> 	   
         </td> </tr>  		  
<?
} ?>
     </table><br>
			<div align=center><input name="enviar" type="submit" value="Enviar datos" /></div><br>
</form>
</div>
</body>
</html>
