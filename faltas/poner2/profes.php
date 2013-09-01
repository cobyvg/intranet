<center> 
<table class="table table-striped table-condensed table-bordered" style="">
    <tr>
<td></td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">L</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">M</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">X</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">J</span></div>
</td>
<td valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">V</span></div>
</div></td>
  </tr>
<?php
// Nombres de los días y variable que recoge el nombre del dia.
// Días de la semana
$horas=array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5",6=>"6");
foreach($horas as $n_hora => $nombre) 
{
echo "<tr><th><div class='badge badge-warning'>$nombre</div></th>";
		for($z=1;$z<6;$z++) 
{
	
	if ($z == "1")
	{ $diafaltas = $lunes1;}
    elseif ($z == "2")
	{ $diafaltas = $martes;}
    elseif ($z == "3")
	{$diafaltas = $miercoles;}
    elseif ($z == "4")
	{$diafaltas = $jueves;}
    elseif ($z == "5")
	{ $diafaltas = $viernes;}


?>
    
  <td valign="top">  
    <div align=center>
      <?php 
 $trozos = explode("_ ",$profesor) ;
		  $id = $trozos[0];
		  $profesores = $trozos[1]; 
// Comienza la presentación de la tabla.
// Asignaturas del Curso en un día
// Abreviatura de la Asignatura
$asignatur1 = mysql_query("SELECT distinct  c_asig, a_asig FROM  horw where prof = '$profesores' and dia = '$z' and hora = '$n_hora'");
$rowasignatur1 = mysql_fetch_row($asignatur1);
if($rowasignatur1[0]){echo "<div class='badge badge-success' style='width:62%'>".$rowasignatur1[1]."</div><br />"; }
 
// Recorremos los grupos a los que da en ese hora.
	$asignaturas1 = mysql_query("SELECT distinct  c_asig, Nivel, n_grupo FROM  horw where prof = '$profesores' and dia = '$z' and hora = '$n_hora'");
  while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
    { 
    $n = strlen($rowasignaturas1[2]);

// Si no hay Nivel, pasamos del negocio y continuamos el Horario buscando las celdas que tienen datos.     	    	  
  if($rowasignaturas1[1] !== "") 
    	    {	

// Si hay más de un grupo, separamos para cada grupo un conjunto de variables distintas  	    	
    for ($i=0;$i<$n;$i++) 
    {   	    	  	    
 // Como esto es un formulario, y cada elemento del formulario debe tener una identificación única para poder convertirse en una variable válida, hay que producir un mogollón de nombres distintos para cada elemento del formulario. L estrucruraes: primera hora del lunes, del martes, etc. Y luego segunda hora del lunes, etc.	
  	$curso = substr($rowasignaturas1[2],$i,1);  
  	   // Fecha exacta de cada día, referida a los cálculos de nombres.php 
    echo "<INPUT type=hidden name=fecha".$z.$n_hora.$curso[0]." value=$diafaltas>";	
	// Nivel y Grupo en pantalla	
	echo "<span class='badge badge-warning'>" .$rowasignaturas1[1]."-".$curso[0]."</span>";      	
    echo "<INPUT type=hidden name=grupo".$z.$n_hora.$curso[0]." value=$curso[0]>";
    // Cambios de fecha entre PHP y MySQL, de española a internacional.
     if (isset($diafaltas)) {
    $fechanc = explode("-",$diafaltas);
    $dia10 = $fechanc[0];
    $mes10 = $fechanc[1];
    $ano10 = $fechanc[2];
    $fechanc0 = "$ano10-$mes10-$dia10";
    }
   
// Buscamos las faltas del profesor en esa semana y las clavamos en los campos de NC.
    $faltas10 = "select NC from FALTAS where FECHA = '$fechanc0' and FALTA = 'F' and PROFESOR = '$id' and HORA = '$n_hora' and NIVEL = '$rowasignaturas1[1]' and GRUPO = '$curso[0]' order by NC asc";	
    $faltas11 = mysql_query($faltas10);
    $faltas13 = "";
    while($faltas12 = mysql_fetch_array($faltas11))
    {	
// Unimos las faltas si son varias mediante un punto.
    $faltas13 .= $faltas12[0]. ".";
}
// Eliminamos el último punto de la serie, limpiando un poco.
$faltas14 = rtrim($faltas13, "."); 
	  
    echo " <INPUT type=text name=alumnos".$z.$n_hora.$curso[0]." value='$faltas14' class='input-mini'><br>";
    echo "<INPUT type=hidden name=nivel".$z.$n_hora.$curso[0]." value=$rowasignaturas1[1]>";
    echo "<INPUT type=hidden name=asignatura".$z.$n_hora.$curso[0]." value=$rowasignaturas1[0]>";
    echo "<INPUT type=hidden name=hora".$z.$n_hora.$curso[0]." value=$n_hora>";
    }}}
// Termina la presentación de la primera hora de todos los días de la semanana. El resto es lo mismo para las horas siguientes. 
?>
    </div></td>
  
  <? }?></tr><? }?>
</table>



