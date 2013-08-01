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

<?
include("../../menu.php");
include("../menu.php");
$trozos = explode("-->",$curso);
?>
<div align="center">
  <h3>Distribución del Grupo <? echo $trozos[0];?></h3><br />

<div class="row-fluid">
<div class="span2"></div>
<div class="span4">
<div class="well well-large" align="left">
<?          
if ($submit1){
$trozos=explode("-->",$alumno);
$codigo=$trozos[1];
     if ($posicion=='Absentista' or $posicion=='Sin asignación'){    
     	$upd=mysql_query("update AsignacionMesasTIC set no_mesa='00' where prof='$profe' and CLAVEAL='$codigo' and agrupamiento='$curso1'");
}
     else{
    $upd=mysql_query("update AsignacionMesasTIC set no_mesa='$posicion' where prof='$profe' and CLAVEAL='$codigo' and agrupamiento='$curso1'");
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Alumno ha cambiado su ordenador asignado en la lista.          
</div></div>';
     	}
}
if ($submit_nuevo=="Enviar datos del Alumno") {
	$tr=explode("-->",$n_alumno);
	$cl=$tr[1];
	mysql_query("insert into AsignacionMesasTIC values('','$profe','$asig','$agrup','$cl','$posicion0')");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El nuevo Alumno ha sido añadido a la lista del grupo.          
</div></div>';
}
// Extraemos las variables del Curso.
$trozos = explode("-->",$curso);
if ($asignatura) {
	$n_asig = $asignatura;
}
else{
	$asignatura=$trozos[1];
	$n_asig = $asignatura;
}

$trozos1 = explode(",",$trozos[0]); 
//hay clases puras, clases con dos grupos y los AGRUPAMIENTOS FLEXIBLES de Matemáticas y Lengua que van con tres grupos
if (substr_count($trozos[0], ",")==2){
	$curso1=$trozos1[0].':'.$trozos1[1].':'.$trozos1[2].':';   }
	elseif (substr_count($trozos[0], ",")==1){$curso1=$trozos1[0].':'.$trozos1[1].':';   }
    	else {$curso1 = $trozos[0].":";}
?>
<?
$al=mysql_query("select distinct apellidos, nombre, claveal from alma where (unidad='$trozos1[0]' or unidad = '$trozos1[1]'  or unidad = '$trozos1[2]') and claveal not in (select distinct claveal from AsignacionMesasTIC where prof='$profe' and c_asig='$n_asig') and combasi like '%$asignatura:%'");
if (mysql_num_rows($al)>0) {
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Hay nuevos alumnos para asignar en este grupo.
</div></div>';
?>
 <form action="distribucion.php?curso=<? echo $curso ?>&profe=<? echo $profe; ?>" method="post" name="form1" id="form1">
<h6>Añadir Alumno nuevo</h6>
<hr>
<label>Alumno<br />
         <select name="n_alumno" class="input-xlarge"> 
         <option></option> 
         <?
while($n_al=mysql_fetch_array($al)){
           echo "<option>$n_al[0], $n_al[1]-->$n_al[2]</option>";
}
?>
          </select>
          </label>
          
          <label>Ordenador<br />
          <select name="posicion0" class="input-small">
         <option></option>
          <option>Absentista</option>
         <option>Sin asignación</option>
         <?
         if (strstr($curso,"B-")==TRUE) {$niv=19;}else{$niv=19;}
for ($i=1;$i<$niv;$i++)
{  
	if ($i<10){echo "<option>0$i</option>";}
	else {echo "<option>$i</option>";}
}
         ?>
          </select>
          </label>
<input type="hidden" name="asignatura" value="<? echo $asignatura; ?>">
<input type="hidden" name="asig" value="<? echo $asignatura; ?>">
<input type="hidden" name="agrup" value="<? echo $curso1; ?>">
<br />
<input type="submit" name="submit_nuevo" value="Enviar datos del Alumno" id="filasecundaria" class="btn btn-primary">
<br />
</form>

<?
}
?>
 <form action="distribucion.php?curso=<? echo $curso ?>&profe=<? echo $profe; ?>" method="post" name="form1" id="form1">

 <h6>Cambio de asignacion de los Alumnos</h6>
 <hr>
        <label>Alumno:<br />

         <select name="alumno" class="input-xlarge">  
           <option><? echo $alumno; ?></option>
          <? alumno($curso1,$profe); ?>
          </select>
          </label>
          <label>Nueva Posición: <br />
         <select name="posicion" class="input-small">
         <option><? echo $posicion; ?></option>
         <option>Absentista</option>
         <option>Sin asignación</option>
         <?
if(strstr($curso,"B-")==TRUE) {$niv=19;}else{$niv=19;}
for ($i=1;$i<$niv;$i++)
{
	if ($i<10){echo "<option>0$i</option>";}
	else {echo "<option>$i</option>";}
}
         ?>
          </select>
          </label>
          <br />
          <input type="hidden" name="asignatura" value="<? echo $n_asig; ?>">
          <input type="hidden" name="curso1" value="<? echo $curso1; ?>">

       <input type="submit" name="submit1" value="Cambiar de posición" class="btn btn-primary">
 <br /><br /><br />      
<? 
//Si la clase es pura o formada por dos grupos, no pasa nada pues los alumnos correspondientes se han seleccionado en la tabla por codigo de asignatura. El problema lo tendríamos cuando el agrupamiento es flexible, con tres grupos, y sin la posibilidad de distinguir los codigos de las asignaturas. Todo esto nos lleva a tener un listado de casi 90 alumnos, por lo tanto, si el agrupamiento es flexible (tres grupos) se ofrecerá un menú diferente para poder selecciionar los alumnos que corresponden a cada profesor.
if (substr_count($trozos[0], ",")==2){ 
echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Si es la primera vez que utilizas los ordenadores en este Agrupamiento, primero deberías seleccionar tus alumnos pinchando en \'<em style="color:brown">Elegir alumnos del agrupamiento</em>\' más abajo.
</div></div>';
?>
     <a href="http://<? echo $dominio; ?>/intranet/TIC/distribucion/elegir.php?agrupamiento=<? echo $curso1; ?>&profe=<? echo $profe; ?>&asig=<? echo $n_asig; ?>"><button class="btn btn-primary">Elegir alumnos del Agrupamiento</button></a>
     <a href="http://<? echo $dominio; ?>/intranet/TIC/distribucion/intro.php"><button class="btn btn-primary">Elegir otro Grupo</button></a>
<?
 } 

 else {?>
 <div class="well" align="left"><div align="center">INSTRUCCIONES DE USO</div><br /><p>1. Si la distribución de alumnos y ordenadores no es adecuada para tí, puedes cambiarla seleccionando un alumno y asignándole otro ordenador. El cambio quedará registrado para el resto del año.</p><p> 2. Si aparece el mensaje <em>'Hay nuevos alumnos para asignar.'</em>, puedes registrarlos seleccionado un alumno y asignándole un ordenador. Si no le das clase a un alumno pero éste aparece en la lista, puedes hacerlo desaparecer seleccionándole y eligiendo la posición 'sin asignar'.</p><p>3. Si quieres que un alumno determinado desaparezca de la lista de distribución (porque no le das clase si se trata de un desdoble o porque no asiste a clase, por ejemplo), elige su nombre del menú desplegable y márcalo como 'absentista' o 'sin asignación'.</p></div>
 <br />
<a href="http://<? echo $dominio; ?>/intranet/TIC/distribucion/intro.php" ><button class="btn btn-success">Elegir otro Grupo</button></a>
<? }?>

</div>
</div>
<div class="span5">
<table class='table table-striped' style="width:auto"><tr>  
<th>Ordenador</th> 
<th>Nº Lista</th> 
<th>Alumno</th> 
<? if(is_dir("../../imag/fotos")){?><th>FOTO</th><? }?> 
<th>Grupo</th> 
</tr> 
<?  
//mostramos la tabla por defecto creada en las tablas. No mostraremos alumnos absentistas para simplificar, estos alumnos se marcan en la tabla mediante no_mesa=00. Mientras que los alumnos no seleccionados en el agrupamiento flexible son marcados como no_mesa=' ', estos alumnos son los que no pertenecen al profesor que hace la asignacion.
$sql=mysql_query("select distinct AsignacionMesasTIC.CLAVEAL,no_mesa, NC, NOMBRE, APELLIDOS, NIVEL, GRUPO from AsignacionMesasTIC , FALUMNOS where AsignacionMesasTIC.CLAVEAL = FALUMNOS.CLAVEAL and agrupamiento='$curso1' and prof='$profe'  and c_asig='$n_asig' and no_mesa not like '' and no_mesa not like '00' order by no_mesa, nc");
while ($sqlr=mysql_fetch_array($sql)){
$clave=$sqlr[0];
$ordenador=$sqlr[1];
$lista=$sqlr[2];
$nombre=$sqlr[4] .', '.$sqlr[3];
$clase=$sqlr[5].'-'.$sqlr[6]; 
?>	                
<td>Ordenador <? echo $sqlr[1]; ?> </td>
<td> <? echo $lista; ?></td>
<td><? echo $nombre;?></td>
<td> <? echo $clase;?></td>
<?
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<td>";
		echo "<img src='../../xml/fotos/$clave.jpg' border='2' width='50' height='60' style='margin-top:10px;border:1px solid #bbb;''  />";
		echo "</td>";
	}
?>														   
</tr>
<?
}
 ?>
</table>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>