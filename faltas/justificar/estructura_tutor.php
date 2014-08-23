                 <?
$profesor = $_SESSION['profi'];
if (empty($today)) {	
$year=date("Y");
$month=date("m");
$today=date("d");
}
?>
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-5">
    
      <?
echo "<h4 align='center'>FECHA SELECCIONADA: &nbsp;<span style='font-size:1.0em; color:#08c'>$today-$month-$year</span></h4><br />
";			        
if ($mens_fecha) {
echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_fecha.'</div></div>';	}
$numerodia = getdate(mktime(0,0,0,$month,$today,$year));
	if ($numerodia['wday']==0)
		{
echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
			El día que has seleccionado es <b>DOMINGO</b>
          </div></div>';
		}
	if ($numerodia['wday']==6)
		{
echo '<div align="center"><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
			El día que has seleccionado es <b>SÁBADO</b>
          </div></div>';
		}

		        echo '<div class="well-trasparent well-large">'; 
		        include("cal.php"); 
?>                   
                   </center>  
     <br />
      <table style="width:auto">
        <tr>
          <td style="background-color:#46a546;width:30px;"></td>
          <td>&nbsp;Faltas Justificadas&nbsp;</td>
          <td style="width:10px;"></td>
          <td style="background-color:#9d261d;width:30px;"></td>
          <td>&nbsp;Faltas sin Justificar&nbsp;</td>
        </tr>
      </table>
<? 
if ($alumno) {
$alu0 = "SELECT NC, CLAVEAL, apellidos, nombre FROM FALUMNOS WHERE claveal = '$alumno'";
$tr = mysql_query($alu0);
$tr1 = mysql_fetch_array($tr);
echo "<hr><table align='center' style='width:auto'><tr><td>";

$apel=$tr[2];
$nom=$tr[3];
   	$foto = '../../xml/fotos/'.$alumno.'.jpg';
	if (file_exists($foto)) {
		echo "<h5>$tr1[3] $tr1[2]</h5><br /><div align=center><img src='../../xml/fotos/$alumno' border='2' width='120' height='143' style='border:1px solid #bbb;'  /></div>";
	}    
echo "</td></tr></table><br />";		        
}
?>
 </div>
  </div>
  <div class="col-sm-5">

           <? 
           if (empty($profesor)) {
           	echo "<br><h6>Selecciona Tutor:</h6><hr>";
           }
          if ($profesor) {
// Buscamos el grupo del que $profesor es tutor.
	$tutor = mysql_query("SELECT unidad FROM FTUTORES WHERE TUTOR = '$profesor'") ;

	if($filatutor = mysql_fetch_row($tutor))  
	{     			
		$unidad = $filatutor[0];
		echo "<h4> $profesor: &nbsp;<span style='font-size:1.0em; color:#08c'>$unidad</span></h4><br />";
		echo '<div class="well well-large">';
// Datos del Profesor que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
		$nivelgrupo0 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, NC FROM FALUMNOS WHERE unidad = '$unidad' order by NC asc");
		$todos = mysql_num_rows($nivelgrupo0);
	function IS_ODD($number) { return($number & 1); }
		if(IS_ODD($todos))
		{ 
		$todos = $todos + 1;}
		$mitad = $todos /2;	
		$resto = $todos +1;	

		if ($alumno) {
	$nivelgrupo1 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, NC FROM FALUMNOS WHERE claveal = '$alumno' order by NC asc limit 0,$mitad");
	$nivelgrupo = mysql_query("SELECT distinct APELLIDOS, NOMBRE, NC FROM FALUMNOS WHERE claveal = '$alumno' order by NC asc limit $mitad, $resto");
		if (mysql_num_rows($nivelgrupo1)>0) {
			$ncselec1 = mysql_fetch_array($nivelgrupo1);
			$numselec = $ncselec1[2];
		}  
		elseif(mysql_num_rows($nivelgrupo)>0) {			
			$ncselec0 = mysql_fetch_array($nivelgrupo);
			$numselec = $ncselec0[2];
		}
		}
$nivelgrupo1 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, NC, claveal FROM FALUMNOS WHERE unidad = '$unidad' order by NC asc limit 0,$mitad");
$nivelgrupo = mysql_query("SELECT distinct APELLIDOS, NOMBRE, NC, claveal FROM FALUMNOS WHERE unidad = '$unidad' order by NC asc limit $mitad, $resto");

echo "<div class='row'><div class='col-sm-6' align='left'>";

while($filanivelgrupo1 = mysql_fetch_array($nivelgrupo1))
		        {		        	
$completo1 =  "$filanivelgrupo1[0], $filanivelgrupo1[1]";
$alumno1 =  $filanivelgrupo1[3];
$clave1 = $filanivelgrupo1[3];
echo "<input style='vertical-align:bottom' name='alumno' type='radio'";
if($alumno == $alumno1){echo " checked";}
echo " value = '$clave1' onclick=submit() /> $filanivelgrupo1[2]. $completo1 <br>";
		        	} 
		        	echo "</div>";
		        	echo "<div class='col-sm-6' align='left'>";
		         	while ($filanivelgrupo = mysql_fetch_array($nivelgrupo))
		        {		        	
$completo2 =  "$filanivelgrupo[0], $filanivelgrupo[1]";
$alumno2 =  $filanivelgrupo[3];
$clave2 = $filanivelgrupo[3];
echo "<input style='vertical-align:bottom' name='alumno' type='radio'";
if($alumno == $alumno2){echo " checked";}
echo " value = '$clave2' onclick=submit() /> $filanivelgrupo[2]. $completo2 <br>";
		        }		         	 
	echo "</div>";
	echo "</div>";	
		        }
	?>
   <?
          	echo "<input type=hidden name=profesor value= \"$profesor\">";
          	echo "<input type=hidden name=unidad value= \"$unidad\">";
          }     
            ?>
