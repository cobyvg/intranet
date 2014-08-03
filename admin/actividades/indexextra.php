<?                                                                                                                             
session_start();                                                                                                               
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}                                                                                       

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if(!(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE OR stristr($_SESSION['cargo'],'4') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}                                                                                    
?>  
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?
 include("../../menu.php");
  include("menu.php");
   $imprimir_activado = true;  
?>
  <div class='container-fluid'>
  <div class="row">
<div align="center">
<div class="page-header">
  <h2>Actividades Complementarias y Extraescolares <small> Administración</small></h2>
</div>
  <div class="col-sm-1"> </div>
  <div class="col-sm-10">
<?   
if ($_GET['eliminar']=="1") {
  	mysql_query("delete from actividades where id = '".$_GET['id']."'");
  	if (mysql_affected_rows()>'0') {
echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			La actividad ha sido borrada correctamente de la base de datos.         
			</div></div>';  	
			}
  }	
  if($calendario == '1')
  {
 $datos0 = "select fecha, actividad, grupos, descripcion from actividades where id = '$id'";
 $datos1 = mysql_query($datos0);
$datos = mysql_fetch_array($datos1);
  $idact = $id.";";
  $eventdate = $datos[0];
  $title = str_replace("'","",$datos[1]);
  $title = str_replace("\\","",$datos[1]);
  $event = str_replace("'","",$datos[3]). "<br>Grupos que participan: " . $datos[2];
  
$html = "1"; 
$querycal = "insert into cal (eventdate,title,event,html,idact) values ('".$eventdate."','".$title."','".$event."','".$html."','".$idact."')";
mysql_query($querycal);
//echo $querycal;
echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La Actividad ha sido registrada en el Calendario del Centro.
			</div></div>'; 
   }
  
  
  
    if($act_calendario == '1')
  {
  $datos0 = "select fecha, actividad, grupos, descripcion from actividades where id = '$id'";
  $datos1 = mysql_query($datos0);
  $datos = mysql_fetch_array($datos1);
  $idact = $id.";";
  $eventdate = $datos[0];
  $title = str_replace("'","",$datos[1]);
  $title = str_replace("\\","",$datos[1]);
  $event = str_replace("'","",$datos[3]). "<br>Grupos que participan: " . $datos[2];
  $cal0 = "select id, title, event, idact from cal where eventdate = '$eventdate'";
  $cal1 = mysql_query($cal0);
  $cal2 = mysql_fetch_array($cal1);
  $title0 = $cal2[1];
  $event0 = $cal2[2];
  $idact0 = $cal2[3];
  $html = "1";
  $titulo = "$title0<br>$title";
  $texto = "$event0<br>$event";
  $id_idact = "$idact0$idact";
  $actualiza_datos0 = "update cal set title = '$titulo', event = '$texto', idact = '$id_idact' where eventdate = '$eventdate'";
  //echo $actualiza_datos0;
  mysql_query($actualiza_datos0);
  echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La Actividad se ha actualizado para esa fecha del Calendario.
			</div></div>'; 
  }  
 
  if($confirmado == '1')
  {
  mysql_query("UPDATE  actividades SET  confirmado =  '1' WHERE id = '$id'");
   echo '
<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
La Actividad ha sido confirmada por la Autoridad.
			</div></div>'; 
  
  }
  if($detalles == '1')
  {
  ?>
    <?
  $datos0 = "select * from actividades where id = '$id'";
  $datos1 = mysql_query($datos0);
  $datos = mysql_fetch_array($datos1);
  $fecha0 = explode("-",$datos[7]);
  $fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
  $fecha1 = explode("-",$datos[8]);
  $registro = "$fecha1[2]-$fecha1[1]-$fecha1[0]";
  ?>
    <div align="center">
  <h3>Información completa de Actividad Extraescolar</h3><br />
</div>
  <div align="center">
<table class="table table-striped" style="width:750px;" align="center">
  <tr>
   <th colspan="2"><h4 align="center"><? echo $datos[2];?></h4></th>
  </tr>
  <tr>
    <th>Grupos</th><td><? echo substr($datos[1],0,-1);?></td>
  </tr>
  <tr>
    <th>Descripción</th><td><? echo $datos[3];?></td>
  </tr>
  <tr>
    <th>Departamento</th><td><? echo $datos[4];?></td>
  </tr>
  <tr>
    <th>Profesor</th><td><? echo $datos[5];?></td>
  </tr>
  <tr>
    <th>Horario</th><td><? echo $datos[6];?></td>
  </tr>
  <tr>
    <th>Fecha</th><td><? echo $fecha;?></td>
  </tr>
  <tr>
    <th>Registro</th><td><? echo $registro;?></td>
  </tr>
      <tr>
    <th>Justificación</th><td><? echo $datos[10];?></td>
  </tr>
    <tr>
    <th>Autorizada</th><td><? echo $datos[9];?></td>
  </tr>
</table></div>
<br />


  <?
 } 
?>

<br />
<table class="table table-striped tabladatos" align="center">
  <thead>
  <tr>
    <th>Fecha</th>
    <th>Actividad</th>
    <th>Alumnos</th>
    <th>Mes</th>
    <th></th>
    <th></th>
  </tr>
  </thead>
  <tbody>
<?
$meses = "select distinct month(fecha) from actividades order by fecha";
$meses0 = mysql_query($meses);
while ($mes = mysql_fetch_array($meses0))
{
$mes1 = $mes[0];
  if($mes1 ==  "01") $mes2 = "Enero";
  if($mes1 ==  "02") $mes2 = "Febrero";
  if($mes1 ==  "03") $mes2 = "Marzo";
  if($mes1 ==  "04") $mes2 = "Abril";
  if($mes1 ==  "05") $mes2 = "Mayo";
  if($mes1 ==  "06") $mes2 = "Junio";
  if($mes1 ==  "09") $mes2 = "Septiembre";
  if($mes1 ==  "10") $mes2 = "Octubre";
  if($mes1 ==  "11") $mes2 = "Noviembre";
  if($mes1 ==  "12") $mes2 = "Diciembre";
$datos0 = "select * from actividades where month(fecha) = '$mes1' order by fecha";
 $datos1 = mysql_query($datos0);
while($datos = mysql_fetch_array($datos1))
{
$fecha0 = explode("-",$datos[7]);
$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
$autoriz = $datos[9];
$datos[2]= str_replace("\\","",$datos[2]);
  ?>
  <tr>
    <td nowrap="nowrap"><? echo $fecha;?></td>
    <td><? echo $datos[2];?></td>
    <td nowrap>
  
        <?
	if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['dpt'] == $datos[4])){
?>
 <?  if($datos[9] == '1'){echo ' <i class="fa fa-check-circle" title="Confirmada"> </i> ';}else{echo ' <i class="fa fa-question-circle title="Sin confirmar""> </i> ';}?>
    <a href="extraescolares.php?id=<? echo $datos[0];?>"><span style="color:#269">Seleccionar</a>
    <? } ?>
    </td>
    <td><? echo $mes2;?></td>
    <td nowrap><a href="indexextra.php?id=<? echo $datos[0];?>&detalles=1"> <i class="fa fa-search" title='Ver detalles de activida'> </i> </a>
          <?
		 // echo  $_SESSION['dpt']." == ".$datos[4];
	if(stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE  OR (stristr($_SESSION['cargo'],'4') == TRUE and $_SESSION['dpt'] == $datos[4])){
?>  
    <a href="indexextra.php?id=<? echo $datos[0];?>&eliminar=1"> <i class="fa fa-trash-o" title='Eliminar actividad' onClick='return confirmacion();'> </i> </a>
  <? } ?>
  
      <?
	if((stristr($_SESSION['cargo'],'1') == TRUE OR stristr($_SESSION['cargo'],'5') == TRUE)){
?>
  
   <? if($autoriz=="1"){}else{ ?> 
    <a href="indexextra.php?id=<? echo $datos[0];?>&confirmado=1"> <i class="fa fa-check-circle" title='Autorizar actividad'> </i> </a>
    <? } ?>
</td>
<td nowrap>	
	   <? 
	   $id_repe = "select id, idact from cal where eventdate = '$datos[7]'";
	   $repe0 = mysql_query($id_repe);
	   $id = mysql_fetch_array($repe0);
	   $br = "$id[1]";
	   $cal_idact = $datos[0].";";
	   if(ereg($cal_idact, $br)) {$si = "1";} else{$si = "0";}
	   $n_idact = strstr($br,$cal_idact);
// No hay nada registrado para ese día en el Calendario
	    if(strlen($id[0]) == 0){echo " <a href='indexextra.php?id=$datos[0]&calendario=1'> <i class='fa fa-calendar'  title='Enviar al Calendario'> </i> </a>";}
// hay datos en el Calendario pero la actividad no ha sido registrada.	
		if(strlen($id[0]) > 0 and ($si == "0")){echo " <a href='indexextra.php?id=$datos[0]&act_calendario=1'> <i class='fa fa-arrow-o-up' title='Actualizar el Calendario'> </i> </a>";}?>
		
	  </td>
      <? }?>
      </tr>
<? 
}
}
?>
</tbody>
</table>
<? include("../../pie.php");?>
</body>
</html>
