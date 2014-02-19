<?
// Fechas y demás...
  $fechasp0=explode("-",$fecha12);
  $fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
  $fechasp11=$fechasp0[0]."-".$fechasp0[1]."-".$fechasp0[2];
  $fechasp2=explode("-",$fecha22);
  $fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
  $fechasp31=$fechasp2[0]."-".$fechasp2[1]."-".$fechasp2[2];

 $SQLTEMP = "create table faltastemp2 SELECT FALTAS.CLAVEAL, falta, (count(*)) AS numero FROM  FALTAS, alma, hermanos where FALTAS.claveal = alma.claveal and alma.telefono = hermanos.telefono and falta = 'F'  and FALTAS.fecha >= '$fechasp1' and FALTAS.fecha <= '$fechasp3' group by FALTAS.claveal";
 // echo $SQLTEMP;
  $num='0';
  $resultTEMP= mysql_query($SQLTEMP);
  mysql_query("ALTER TABLE faltastemp2 ADD INDEX ( claveal ) ");
  $SQL0 = "SELECT distinct CLAVEAL FROM  faltastemp2";
  $result0 = mysql_query($SQL0);
while ($row0 = mysql_fetch_array($result0)): 
$claveal = $row0[0]; 			
	$SQL3 = "SELECT distinct alma.claveal, alma.telefono, alma.telefonourgencia, alma.apellidos, alma.nombre, alma.nivel, alma.grupo 
	from alma where alma.claveal like '$claveal'";
	$result3 = mysql_query($SQL3);	
	$rowsql3 = mysql_fetch_array($result3);
	$tfno2 = $rowsql3[1];	
	$tfno_u2 = $rowsql3[2];
	$apellidos = $rowsql3[3];
	$nombre = $rowsql3[4];
	$nivel = $rowsql3[5];
	$grupo = $rowsql3[6];	
	// Telefonos móviles
	if(substr($tfno2,0,1)=="6" OR substr($tfno2,0,1)=="7"){$mobil2=$tfno2;}elseif((substr($tfno_u2,0,1)=="6" OR substr($tfno_u2,0,1)=="7") and !(substr($tfno2,0,1)=="6" OR substr($tfno2,0,1)=="7")){$mobil2=$tfno_u2;}else{$mobil2="";}
	//echo $mobil2;	
	// Variables para la acción de tutoría
	$causa = "Faltas de Asistencia";	
	$observaciones = "Comunicación de Faltas de Asistencia a la familia del Alumno.";
	$accion = "Envío de SMS";
	$tuto = "Jefatura de Estudios";
	$fecha2 = date('Y-m-d');
	mysql_query("insert into tutoria (apellidos, nombre, tutor,nivel,grupo,observaciones,causa,accion,fecha,claveal) values ('".$apellidos."','".$nombre."','".$tuto."','".$nivel."','".$grupo."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$claveal."')");
$nombrecor = explode(" ",$nombre);
$nombrecorto = $nombrecor[0];
$text = "Le comunicamos que su hijo/a $nombrecorto tiene Faltas de Asistencia sin justificar dentro del periodo del ".$fecha12." al ".$fecha22.". Contacte con su Tutor";
$login = $usuario_smstrend;
$password = $clave_smstrend;
// Identificador del mensaje
$sms_n = mysql_query("select max(id) from sms");
$n_sms =mysql_fetch_array($sms_n);
$extid = $n_sms[0]+1;
?>
<script language="javascript">
function enviarForm()
{
ventana=window.open("", "ventanaForm<? echo $num;?>", "top=100, left=100, toolbar=no,location=no, status=no,menubar=no,scrollbars=no, resizable=no, width=300,height=66,directories=no")
document.enviar<? echo $num;?>.submit()
/*AQUÕ PUEDES PONER UN TIEMPO*/
/*ventana.close()*/
}
</script>
<form action="http://www.smstrend.net/esp/sendMessageFromPost.oeg" method="post" name="enviar<? echo $num;?>" target="ventanaForm<? echo $num;?>">
			<input name="login" type="hidden" value="<? echo $login;?>" />
            <input name="password" type="hidden" value="<? echo $password;?>"  />   
            <input name="extid" type="hidden" value="<? echo $extid;?>" /> 
            <input name="tpoa" type="hidden" value="<? echo $nombre_corto; ?>" /> 
            <input name="mobile" type="hidden" value="<?echo $mobil2;?>"/>
 			<input name="messageQty" type="hidden" value="GOLD" />
            <input name="messageType" type="hidden" value="PLUS" />        
			<input name="message" type="hidden" value="<?echo $text;?>"/>    
</form>
<script>
enviarForm();
</script>
<?
mysql_query("insert into sms (fecha,telefono,mensaje,profesor) values (now(),'$mobil2','$text','Jefatura de Estudios')");
$num=$num+1;
endwhile;
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;" align="left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El mensaje SMS se ha enviado correctamente para los hermanos del mismo nivel con faltas sin justificar.<br>Una nueva acción tutorial ha sido también registrada.
          </div></div><br />';
$fecha_inicio_0 = mysql_query("select date_add(curdate(),interval -21 day)");
$fecha_inicio = mysql_fetch_array($fecha_inicio_0);
$anterior = $fecha_inicio[0];
$fc1 = explode("-",$anterior);
$fech1 = "$fc1[2]-$fc1[1]-$fc1[0]";
$fecha_fin_0 = mysql_query("select date_add(curdate(),interval -7 day)");
$fecha_fin = mysql_fetch_array($fecha_fin_0);
$posterior = $fecha_fin[0];
$fc2 = explode("-",$posterior);
$fech2 = "$fc2[2]-$fc2[1]-$fc2[0]";

// Tabla temporalñ y recogida de datos
 mysql_query("DROP table `faltastemp2`");
?>
