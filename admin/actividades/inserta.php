<?
if ($fecha_act == "" or $actividad == "" or $departamento == "" or $hoy == "" or $horario == "" or $descripcion == "" or $justificacion == "") {
	echo '
<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
Todos los campos del formulario son obligatorios, así que vuelve atrás y rellena los que has dejado vacíos.
          </div></div>';
exit;	
}
$grupos="";
foreach($_POST as $key => $val){
if(substr($key,0,3) == "grt")
{
$grupos .= $val.";";
}
}
 if ($grupos == "") {
echo '
<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
			No has seleccionado ningún Grupo de Alumnos. Vuelve atrás y selecciona algún Grupo para la Actividad.
          </div></div>';
		  exit;	
}
   

  
$profesor=$_POST["profesor"]; 
if(empty($profesor))
{
echo '
<br /><div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
			No has seleccionado ningún Profesor como responsable de la Actividad. Vuelve atrás y selecciona algún Grupo para la Actividad.          
			</div></div>';
			exit;	
}
for ($i=0;$i<count($profesor);$i++)    
{     
$profe .= $profesor[$i].";";} 
$tr_f = explode("-",$fecha_act);  
$fecha = "$tr_f[2]-$tr_f[1]-$tr_f[0]";
$query="insert into actividades (grupos,actividad,descripcion,departamento,profesor,horario,fecha,hoy,confirmado, justificacion) values ('".$grupos."','".$actividad."','".$descripcion."','".$departamento."','".$profe."','".$horario."','".$fecha."','".$hoy."','0','".$justificacion."')";
mysql_query($query);
$texto = $descripcion  . "<br>Grupos que participan: " . $grupos;
$html = "1";
$datos10 = "select max(id) from actividades";
$datos11 = mysql_query($datos10);
$datos00=mysql_fetch_array($datos11);
echo '
<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la actividad extraescolar se han introducido correctamente.<br />Compruébalo en la tabla más abajo y modificalos si es necesario.
			</div></div><br />';
?>
<?
$datos0 = "select * from actividades where departamento = '$departamento' order by id desc ";
$datos1 = mysql_query($datos0);
?>
 <div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div align="center">
  <legend>Actividades registradas por el Departamento de <span style="color:#08c"><? echo $departamento ?></span></legend>
</div>
<br />
<table class="table table-striped" style="width:auto;" align="center">
  <thead><tr>
    <th>Grupos</th>
    <th>Actividad</th>
    <th>Departamento</th>
    <th>Profesor</th>
    <th>Horario</th>
    <th>Fecha</th>
  </tr></thead>
  <tbody>
<?
while($datos=mysql_fetch_array($datos1))
{
$fecha0 = explode("-",$datos[7]);
$fecha = "$fecha0[2]-$fecha0[1]-$fecha0[0]";
?>

  <tr>
    <td><? echo $datos[1];?></td>
    <td><? echo $datos[2];?></td>
    <td><? echo $datos[4];?></td>
    <td><? echo $datos[5];?></td>
    <td><? echo $datos[6];?></td>
    <td nowrap><? echo $fecha;?></td>
  </tr>
  <? }?>
</tbody>
</table>
