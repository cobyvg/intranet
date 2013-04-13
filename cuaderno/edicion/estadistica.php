<? $nums_ids=0;
foreach ($_POST as $id => $valor) {
  if (is_numeric($id) and is_numeric($valor)){
$columnas = $columnas + 1;
 $num_ids +=1;
$celdas .= " id = '$id' or";
  		}
  		}
 $celdas = substr($celdas,0,strlen($celdas)-3);
	if (empty($num_ids)) {
 echo '<br /><div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar al menos una Columna del cuaderno para poder operar.
</div></div>';
 echo "<br /><INPUT TYPE='button' VALUE='Volver al Cuaderno' onClick='history.back(-1)' class='btn btn-primary'>";	
exit;			
		}
// Procesamos los datos
// Distintos códigos de la asignatura cuando hay varios grupos en una hora.
$n_c = mysql_query("SELECT distinct  a_grupo, asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'");
while($varias = mysql_fetch_array($n_c))
{
	if (substr($varias[0],3,2) == "Dd" ) {
	$varias[0] = substr($varias[0],0,4);
	}
	$curso_alma = mysql_query("select distinct curso from alma where unidad = '$varias[0]'");
	$curso_alma1 = mysql_fetch_row($curso_alma);
	$nombre_curso = $curso_alma1[0];
	$largo = strlen($varias[1]);
	if (strlen($varias[1]) > 10) {$nombre_asig = substr($varias[1],0,10);} else {$nombre_asig = substr($varias[1],0,6);}	
	$nombre_asig = trim($nombre_asig);
	$asig_sen0 = mysql_query("select codigo from asignaturas where curso = '$nombre_curso' and nombre like '$nombre_asig%' and abrev not like '%º'");
	while($asig_sen1 = mysql_fetch_row($asig_sen0)){
	if (strstr($asigna_a , $asig_sen1[0]) == false) 
	{
	$asigna_a .= $asig_sen1[0].",";
	}
	}
}
$asigna_c = explode(",",$asigna_a);
$asignatura0 = $asigna_c[0];
$asignatura1 = $asigna_c[1];
$asignatura2 = $asigna_c[2];
if (!(empty($asignatura1))) {
	$otras = " or combasi like '%$asignatura1:%' ";
}
if (!(empty($asignatura2))) {
	$otras .= " or combasi like '%$asignatura2:%' ";
}
// Tabla con las distintas notas_cuaderno y la mediaxx
  		
  // Todos los Grupos juntos
$n_cursos = mysql_query("SELECT distinct  a_grupo, c_asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'");
  while($n_cur = mysql_fetch_array($n_cursos))
  {
  	$curs .= $n_cur[0].", ";
  } 
// Eliminamos el espacio
  	$curs0 = substr($curs,0,(strlen($curs)-1));
// Eliminamos la última coma para el título.
	$curso_sin = substr($curs0,0,(strlen($curs0)-1));
//Número de columnas
	
	$col = "select distinct id, nombre, orden from notas_cuaderno where profesor = '$profesor' and curso = '$curso' and oculto = '0' and ($celdas)  order by orden asc";
	$col0 = mysql_query($col);
	
	$curso_sin = substr($curso,0,strlen($curso) - 1);
// Titulos

echo "<br /><table align='center' class='table table-striped' style='width:auto'>"; 
echo "<tr><th>NC</th><th colspan='2' >Alumno</th>";
// Número de las columnas de la tabla	
	while($col20 = mysql_fetch_array($col0)){
	$ident= $col20[2];
	$id = $col20[0];
	echo "<th align='center'>$ident</th>";
	}

// Tabla para cada Grupo
  $curso0 = "SELECT distinct  a_grupo, c_asig, asig FROM  horw where prof = '$profesor' and dia = '$dia' and hora = '$hora'";
  $curso20 = mysql_query($curso0);
  while ($curso11 = mysql_fetch_array($curso20))
    {
	$curso = $curso11[0];
	$asignatura = $curso11[1];
	$nombre = $curso11[2];
// Número de Columnas para crear la tabla
	$num_col = 4 + $num_ids;
	if(substr($curso,4,1) == 'd')
	{
	//	Problemas con Diversificación (4E-Dd)
		$curso_sin1 =  substr($curso,0,strlen($curso) - 1);
		$curso30 = substr($curso,0,strlen($curso) - 1).",";
		if(strstr($curs,$curso30)){$curso = "";}	
		else{
		$curso = $curso_sin1;
		echo "<tr><td colspan='$num_col'><h5 align='center'>";
   		echo $curso." ".$nombre;
   		echo "</h5></td></tr>";
		}
	}
else{
	echo "<tr><td colspan='$num_col'><h5 align='center'>";
   		echo $curso." ".$nombre;
   		echo "</h5></td></tr>";
	}
	mysql_select_db($db);
	$hay0 = "select alumnos from grupos where profesor='$profesor' and asignatura = '$asignatura' and curso = '$curso'";
	$hay1 = mysql_query($hay0);
	$hay = mysql_fetch_row($hay1);	
	
	if(mysql_num_rows($hay1) == "1"){
	$seleccionados = substr($hay[0],0,strlen($hay[0])-1);
	$t_al = explode(",",$seleccionados);
	$todos = " and (nc = '300'";
	foreach($t_al as $cadauno){
	$todos .=" or nc = '$cadauno'";
	}
	$todos .= ")";
	}	
	mysql_select_db($db);
	
// Alumnos para presentar que tengan esa asignatura en combasi
$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and unidad = '$curso' and (combasi like '%$asignatura0:%' $otras) ".$todos ." order by NC";
  $result = mysql_query ($resul);	
  $t_alumnos += mysql_num_rows ($result);
        while($row = mysql_fetch_array($result))
		{  		
		$claveal = $row[0];            	
echo "<tr><td>$row[1]</td><td colspan='2' nowrap >$row[2], $row[3]</td>";
  	
// Si hay datos escritos rellenamos la casilla correspondiente
	$colu10 = "select distinct id from notas_cuaderno where ";
	 foreach ($_POST as $id => $valor) {
  		if (is_numeric($id) and is_numeric($valor)){
  		$colu10 .= " id = '$id' or"; 
  		$n_1 = "1";
  		}
  		}
  	$colu10 = substr($colu10,0,strlen($colu10)-2);
	$colu10 .= "  and profesor = '$profesor' and curso like '%$curso%' and oculto = '0'order by id";
	$colu20 = mysql_query($colu10);
	$suma = "";
	while($colus10 = mysql_fetch_array($colu20)){
	$id = $colus10[0];
	$dato0 = mysql_query("select nota from datos where claveal = '$claveal' and id = '$id'");
	$dato1 = mysql_fetch_array($dato0);
	$suma += $dato1[0];
	if ($dato1[0]==''){$dato1[0]='0';} 
echo "<td align='center'>$dato1[0]</td>";}

mysql_select_db($db);
echo "</tr>"; 
        }  
	}
	$i=0;
	foreach ($_POST as $id => $valor2) {
if (is_numeric($id)){
$i+=1;
	$aprobados[$i]=0;
	$suspensos[$i]=0;
	$sumanotas[$i]=0;

$est=mysql_query("select nota from datos where id='$id'");	
while ($esta=mysql_fetch_array($est)){
	
	
		if(($esta[0] < 5) or ($esta[0]=='')){$suspensos[$i]+=1;  $sumanotas[$i]+=$esta[0];}
	else{$aprobados[$i]+=1;  $sumanotas[$i]+=$esta[0]; 
	     	
		}
				}
	
	}}
	
	//media del grupo
	echo "<tr><td></td><td></td><td align='right' style='font-weight:bold; '>Media del Grupo*</td>";
	for($j = 1;$j<=$i;$j++) {
	$x_real=$sumanotas[$j]/$t_alumnos;
	$x=$sumanotas[$j]/($aprobados[$j]+$suspensos[$j]);
	echo "<td align='center'><b>"; redondeo($x_real); echo"</b> ("; redondeo($x); echo")</td>";
							}


	echo "</tr><tr><td></td><td></td><td align='right' style='padding-right:20px;color:black;font-weight:bold; '>Aprobados</td>";
	for($j = 1;$j<=$i;$j++) {
	echo "<td style='background-color:#D6FFD8;' align='center'>$aprobados[$j]</td>";
							}


	echo "</tr><tr><td></td><td></td><td align='right' style='padding-right:20px;color:black;font-weight:bold;'>Suspensos*</td>";
	for($j = 1;$j<=$i;$j++) {
	  $t_s[$j]=$t_alumnos-$aprobados[$j];
	echo "<td style='background-color:#f2dede;' align='center'>$t_s[$j] ($suspensos[$j])</td>";
						}
  
	echo "</tr>";	
echo '</table>';
echo "<p class='help-block' align=center>(*)  ---> Entre par&eacute;ntesis si no contamos las notas que sean 0</p>";
echo "<br /><INPUT TYPE='button' VALUE='Volver al Cuaderno' onClick='history.back(-1)' class='btn btn-primary'>";	
?>
