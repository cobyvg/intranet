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
 // $imprimir_activado = true;
if(isset($_GET['clave'])){$clave = $_GET['clave'];}else{$clave="";}
  
 $nom = mysql_query("select nombre, apellidos, unidad from alma where claveal = '$clave'");
   $nom0 = mysql_fetch_array($nom);
  mysql_query("drop table FechCaduca");
  mysql_query("create table FechCaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, Fechoria.id from Fechoria, FALUMNOS, FechCaduca where FechCaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal and Fechoria.claveal = '$clave' order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos";
  $result = mysql_query ($query0);
  echo "<div class='container-fluid'>";
  echo '<div class="row-fluid">
  <div class="span10 offset1">';
  
  echo '<div aligna="center">
<div class="page-header" align="center">
  <h2>Problemas de Convivencia <small> &Uacute;ltimos Problemas de Convivencia</small></h1>
  <h3 style="color:#08c" align=center>';
 echo "$nom0[0] $nom0[1] ($nom0[2])";
  echo '</h3>
</div>
</div>
<br />';

 echo "<table class='table table-bordered' style='width:auto' align='center'><tr><td style='background-color:#FFFF99'>Expulsión del Centro</td><td style='background-color:#CCFFCC'>Amonestación escrita</td><td style='background-color:#FF9900'>Expulsión del Aula</td><td style='background-color:#CCCCFF'>Expulsión al Aula de Convivencia</td></tr></table><br />";
		echo "<table class='table table-striped' style='width:100%'>";
		$fecha1 = (date("d").-date("m").-date("Y"));
       echo "<thead>
		<th>CURSO</th>
		<th>FECHA</th>
		<th>TIPO</th>
		<th>INFORMA</th>
		<th>GRAV.</th>
		<th width='48'>NUM.</th>
		<th width='45'>CAD.</th>		
		<th></th>
		<th></th>
		</thead><tbody>";	
   while($row = mysql_fetch_array($result))
        {
		$apellidos = $row[0];
		$nombre = $row[1];
		$nivel = $row[2];
		$grupo = $row[3];
		$fecha = $row[4];
		$asunto = $row[5];
		$informa = $row[6];
		$grave = $row[7];
		$claveal = $row[8];
		$id = $row[9];
		$expulsion=$row[10];
		$expulsionaula=$row[11];
		$medida=$row[12];
		$tutoria=$row[13];
		$recibido=$row[14];
		$dias=$row[15];
		$aula_conv=$row[16];
		$inicio_aula=$row[17];
		$fin_aula=$row[18];
		$ident=$row[19];
		if(($dias > 30 and ($grave == 'leve' or $grave == 'grave')) or ($dias > 60 and $grave == 'muy grave'))
		{$caducada="Sí";} else {$caducada="No";}
		$numero = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' order by Fechoria.fecha"); 
		$rownumero= mysql_num_rows($numero);
		$rowcurso = $nivel."-".$grupo;
        $rowalumno = $nombre."&nbsp;".$apellidos;
				$bgcolor="style='background-color:white;'";
				if($medida == "Amonestación escrita" and $expulsionaula !== "1" and $expulsion == 0){$bgcolor="style='background-color:#CCFFCC;'";}
				if($expulsionaula == "1"){$bgcolor="style='background-color:#FF9900;'";}
				if($aula_conv > 0){$bgcolor="style='background-color:#CCCCFF;'";}	
				if($expulsion > 0){$bgcolor="style='background-color:#FFFF99;'";}		
				if($recibido == '1'){
					$comentarios1="<i class='fa fa-check' title='recibido'> </i>";
				}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){
					$comentarios1="<i class='fa fa-exclamation-triangle' title='No recibido'> </i>";
				}else{
					$comentarios1="";
				}
		echo "<tr>
		<td >$rowcurso</td>
		<td >$fecha</td>
		<td >$asunto</td>
		<td ><span  style='font-size:0.9em'>$informa</span></td>
		<td $bgcolor>$grave</td>
		<td ><center>$rownumero</center></td>
		<td >$caducada</td>
		<td  nowrap>$comentarios1 $comentarios</td>
		<td  nowrap>"; 
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='delfechorias.php?id= $row[9]' style='margin-top:5px;color:brown;'><i class='fa fa-trash-o' title='Borrar' onClick='return confirmacion();'> </i></a></div>";}	
		echo " <A HREF='detfechorias.php?id=$id&claveal=$claveal'><i class='fa fa-search' title='Detalles'> </i></A></td>";
		echo "</tr>";
        }
        echo "</tbody></table>";
 
  ?>
  <? include("../../pie.php");?>
</body>
</html>
