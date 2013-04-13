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
?>
  <?php
include("../../menu.php");
include("menu.php");  
  ?>
  <div align="center">
    <h3>Selección de alumnos para la actividad</h3>
	<br />
    <div class="well-2 well-large" style="width:500px;"> 
    <div align="center">         
<a href="javascript:seleccionar_todo()" class="btn btn-success">Marcar todos los Alumnos</a>
<a href="javascript:deseleccionar_todo()" class="btn btn-warning">Desmarcarlos todos</a>
</div>
<br />
    <FORM action="imprimir.php" method="POST" name="imprime">

  <?
$cursos0 = mysql_query("select grupos, profesor from actividades where id = '$id'");
while($cursos = mysql_fetch_array($cursos0))
{
$profesor="";
$profes="";
$profes = explode(";",$cursos[1]);
foreach ($profes as $n_profe)
{
$profe = explode(", ",$n_profe);
$profesor.=$profe[1]." ".$profe[0].", ";
//$profesor.=$profeso.",";
}
$profesor = substr($profesor,0,-5);
$trozos = explode("-",$cursos[0]);
foreach($trozos as $valor)
{
$nivel = substr($valor,0,2);
$grupo = substr($valor,2,1); 
$alumnos0 = "select alma.nombre, alma.apellidos, NC, alma.claveal from alma, FALUMNOS where alma.claveal = FALUMNOS.claveal and alma.nivel = '$nivel' and alma.grupo = '$grupo' order by NC";
//echo $alumnos0;
$alumnos1 = mysql_query($alumnos0);
$num = mysql_num_rows($alumnos1);
if($alumno = mysql_fetch_array($alumnos1))
{
$datos0 = "select fecha, horario, profesor, actividad, descripcion from actividades where id ='$id'";
$datos1 = mysql_query($datos0);
$datos = mysql_fetch_array($datos1);
$fecha0 = explode("-",$datos[0]);
$fecha  = $fecha0[2]."-". $fecha0[1]."-". $fecha0[0];
$horario = $datos[1];
$actividad = $datos[3];
$descripcion = $datos[4];
?>
<input name="fecha" type="hidden" id="A" value="<? echo $fecha;?>">
<input name="horario" type="hidden" id="A" value="<? echo $horario;?>">
<input name="profesor" type="hidden" id="A" value="<? echo $profesor;?>">
<input name="actividad" type="hidden" id="A" value="<? echo $actividad;?>">
<input name="descripcion" type="hidden" id="A" value="<? echo $descripcion;?>">
<input name="id" type="hidden" id="A" value="<? echo $id;?>">   
<table class="table table-striped table-condensed" style="width:450px;" align="center">
<tr><td colspan="2"><h4><? echo "Alumnos de $nivel - $grupo";?></h4></td>
</tr>

<?
do{
$apellidos = $alumno[0];
$nombre = $alumno[1];
$nc = $alumno[2];
$claveal = $alumno[3];
?>
<tr><td >
<input name="<? echo $nc.$claveal;?>" type="checkbox" id="A" value="<? echo $claveal;?>"> </td>
<td>   
<?
echo " $nc. $apellidos $nombre</td></tr>";
}while($alumno = mysql_fetch_array($alumnos1));
?>
</table>
<?
}}
}
?>
<button type="submit" name="submit" value="Imprimir Carta para los Padres" class="btn btn-primary">Imprimir Carta para los Padres</button>
  </FORM>
  </div>
  <script>
function seleccionar_todo(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == "checkbox")	
			document.imprime.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.imprime.elements.length;i++)
		if(document.imprime.elements[i].type == "checkbox")	
			document.imprime.elements[i].checked=0
}
</script>
<? include("../../pie.php");?>
  </BODY>
</HTML>