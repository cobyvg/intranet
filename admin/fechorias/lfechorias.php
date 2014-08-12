<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$idea = $_SESSION ['ide'];
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activ1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activ2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activ3 = ' class="active" ';}

include("../../menu.php");
include("menu.php");
$datatables_activado = true;
if(isset($_GET['id'])){$id = $_GET['id'];}
?>
  <?php

  echo "<div class='container'>";
  echo '<div class="row">';
  echo '<div aligna="center">
<div class="page-header">
  <h2>Problemas de Convivencia <small> &Uacute;ltimos Problemas de Convivencia</small></h2>
</div>
</div>
<br />
<div class="col-sm-12">';
      
    echo ' <div align="center"><div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="fa fa-spin fa fa-spin fa-2x pull-left"></i> Cargando los datos...
      </div>
   ';
    echo "</div>";
    echo "<div id='t_larga' style='display:none' >";
  if (isset($_POST['confirma'])) {
  	foreach ($_POST as $clave => $valor){
  		if (strlen($valor) > '0' and $clave !== 'confirma') {
  		$actualiza = "update Fechoria set confirmado = '1' where id = '$clave'";
  		$act = mysql_query($actualiza);		
  		} 
  	}
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El registro ha sido confirmado.
          </div></div>';
  }
   if(isset($_GET['borrar']) and $_GET['borrar']=="1"){
$query = "DELETE FROM Fechoria WHERE id = '$id'";
$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El registro ha sido eliminado de la base de datos.
          </div></div>';	
}
  
  mysql_query("drop table Fechcaduca");
  mysql_query("create table Fechcaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria order by fecha desc limit 500");
  mysql_query("ALTER TABLE  `Fechcaduca` ADD INDEX (  `id` )");
  mysql_query("ALTER TABLE  `Fechcaduca` ADD INDEX (  `fecha` )");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, confirmado, horas from Fechoria, FALUMNOS, Fechcaduca where Fechcaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal  order by Fechoria.fecha desc limit 500";
  // echo $query0;
  $result = mysql_query ($query0);
 echo "<form action='lfechorias.php' method='post' name='cnf'>
 <table class='table table-bordered' style='width:auto' align='center'><tr><td style='background-color:#FFFF99'>Expulsión del Centro</td><td style='background-color:#CCFFCC'>Amonestación escrita</td><td style='background-color:#FF9900'>Expulsión del Aula</td><td style='background-color:#CCCCFF'>Aula de Convivencia: Jefatura</td><td style='background-color:#dea9cd'>Aula de Convivencia: Profesor</td></tr></table><br />";
		echo '<table class="table table-striped table-bordered tabladatos">';
		$fecha1 = (date("d").-date("m").-date("Y"));
        echo "<thead><tr>
		<th>ALUMNO</th>
		<th>CURSO</th>
		<th>FECHA</th>
		<th>TIPO</th>
		<th>INFORMA</th>
		<th>GRAV.</th>
		<th>NUM.</th>
		<th>CAD.</th>		
		<th></th>
		<th></th>
		<th></th>
		</tr></thead><tbody>";	
   while($row = mysql_fetch_array($result))
        {
        $marca = '';
		$apellidos = $row[0];
		$nombre = $row[1];
		$unidad = $row[2];
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
		$confirmado=$row[19];
		$horas=$row[20];
		if ($confirmado == '1') {
			$marca = " checked = 'checked'";
		}
		if(($dias > 30 and ($grave == 'leve' or $grave == 'grave')) or ($dias > 60 and $grave == 'muy grave'))
		{$caducada="Sí";} else {$caducada="No";}
		$numero = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '$inicio_curso' order by Fechoria.fecha"); 
		$rownumero= mysql_num_rows($numero);
		$rowcurso = $unidad;
        $rowalumno = $nombre."&nbsp;".$apellidos;
				$bgcolor="background-color:transparent;";
				if($medida == "Amonestación escrita" and $expulsionaula !== "1" and $expulsion == 0){$bgcolor="style='background-color:#CCFFCC;'";}
				if($expulsionaula == "1"){$bgcolor="background-color:#FF9900;";}
				
				if($aula_conv > 0){
					if ($horas == "123456") {
						$bgcolor="background-color:#CCCCFF;";
					}
					else{
						$bgcolor="background-color:#dea9cd;";
					}
				}	
				
				if($expulsion > 0){$bgcolor="style='background-color:#FFFF99;'";}		
				if($recibido == '1'){$comentarios1="<i class='fa fa-check' rel='tooltip'  title='El Tutor ha recibido la notificación.'> </i>";}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){$comentarios1="<i class='fa fa-exclamation-triangle'  rel='tooltip' title='El Tutor NO ha recibido la notificación.'> </i>";}else{$comentarios1="";}
		echo "<tr>
		<td nowrap>";
		$foto="";
		$foto = "<img src='../../xml/fotos/$claveal.jpg' width='55' height='64' class=''  />";
		echo $foto."&nbsp;&nbsp;";
		echo "<a href='lfechorias2.php?clave=$claveal'>$rowalumno</a></td>
		<td style='vertical-align:middle'>$rowcurso</td>
		<td nowrap style='vertical-align:middle'>$fecha</td>
		<td style='vertical-align:middle'>$asunto</td>
		<td style='vertical-align:middle'><span  style='font-size:0.9em'>$informa</span></td>
		<td  style='$bgcolor vertical-align:middle'>$grave</td>
		<td style='vertical-align:middle' style='vertical-align:middle'><center>$rownumero</center></td>
		<td style='vertical-align:middle'>$caducada</td>
		<td nowrap style='vertical-align:middle'>$comentarios1 $comentarios</td><td nowrap style='vertical-align:middle'>"; 
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='lfechorias.php?id= $row[9]&borrar=1' style='margin-top:5px;color:brown;'><i class='fa fa-trash-o'  rel='tooltip' title='Borrar el registro' data-bb='confirm-delete'> </i></a>&nbsp;&nbsp;";}	

		echo " <A HREF='detfechorias.php?id=$id&claveal=$claveal'><i class='fa fa-search' rel='tooltip' title='Detalles del problema'> </i></A></td>
		<td style='vertical-align:middle'>";
		//echo "$expulsion >  $expulsionaula";
		if (stristr($_SESSION['cargo'],'1')) {
			echo "<input type='checkbox' name='$id' value='1' $marca onChange='submit()' />";			
		}		
		echo "</td></tr>";
        }
        echo "</tbody></table>";
        echo "<input type='hidden' name='confirma' value='si' />";
        echo "</form>";
		echo "</div></div></div></div>";
  ?>
  <? include("../../pie.php");?>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>     
  </body>
  </html>
