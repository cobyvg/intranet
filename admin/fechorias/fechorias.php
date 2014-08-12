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



include("../../menu.php");
include("menu.php");
$imprimir_activado = true;
?>

	<div class="container">
	
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
		  <h2>Problemas de Convivencia <small> Consultas</small></h2>
		</div>
		
		
		<!-- SCAFFOLDING -->
  	<div class="row">
  		
  		<!-- COLUMNA CENTRAL -->
  		<div class="col-sm-12">
 
<?php
if(isset($_POST['submit1'])){$submit1 = $_POST['submit1'];}elseif(isset($_GET['submit1'])){$submit1 = $_GET['submit1'];}else{ $submit1=""; }
if(isset($_POST['unidad'])){$unidad = $_POST['unidad'];}else{ $unidad=""; }
if(isset($_POST['c_escolar'])){$c_escolar = $_POST['c_escolar'];}else{ $c_escolar=""; }
if(isset($_POST['apellidos'])){$APELLIDOS = $_POST['apellidos'];}else{ $APELLIDOS=""; }
if(isset($_POST['nombre'])){$NOMBRE = $_POST['nombre'];}else{ $NOMBRE=""; }
if(isset($_POST['dia'])){$DIA = $_POST['dia'];}else{ $DIA=""; }
if(isset($_POST['mes'])){$MES = $_POST['mes'];}else{ $MES=""; }
if(isset($_POST['clase'])){$clase = $_POST['clase'];}else{ $clase=""; }
if(isset($_POST['confirma'])){$confirma = $_POST['confirma'];}else{ $confirma=""; }
if(isset($_GET['claveal'])){$claveal = $_GET['claveal'];}elseif(isset($_POST['claveal'])){$claveal = $_POST['claveal'];}else{$claveal="";}
if(isset($_GET['id'])){$id = $_GET['id'];}

if (!(empty($confirma))) {
 	foreach ($_POST as $clave => $valor){
  		if (strlen($valor) > '0' and $clave !== 'confirma') {
  		$actualiza = "update Fechoria set confirmado = '1' where id = '$clave'";
  		//echo $actualiza;
  		$act = mysql_query($actualiza);
  		} 
  	}
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El problema de convivencia ha sido confirmado correctamente. <br />No te olvides de recargar la página si decides volver atrás a los resultados de la consulta.
          </div><br />
<INPUT class="btn btn-primary" TYPE="button" VALUE="Volver atrás"
	onClick="history.back()"></div>';
exit();
  }
  
   if(isset($_GET['borrar']) and $_GET['borrar']=="1"){
$query = "DELETE FROM Fechoria WHERE id = '$id'";
$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El registro ha sido eliminado de la base de datos.
          </div></div>';	
exit();
}
	if(empty($NOMBRE) and empty($APELLIDOS) and empty($MES) and empty($DIA) and empty($unidad) and empty($claveal) and empty($clase))
	   {
	   echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓN:</h4>
            Debes seleccionar al menos un tipo de datos (Apellidos, Nombre, unidad, etc.) para poder hacer la Consulta. Vuelve atrás y selecciona algún criterio de búsqueda.
          </div></div>';
	echo " <br /><center>
<INPUT class='btn btn-primary' TYPE='button' VALUE='Volver atrás'
	onClick='history.back()'></center>";
exit();
    }
	$AUXSQL = "";
	$clase=$_POST["clase"]; 
  #Comprobamos si se han metido Apellidos o no, etc.
  if  (TRIM("$NOMBRE")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.nombre like '$NOMBRE%'";
    }
	  if  (TRIM("$claveal")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.claveal = '$claveal'";
    }
  if  (TRIM("$APELLIDOS")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.apellidos like '$APELLIDOS%'";
    }
  #Comprobamos d y mes.
  IF (TRIM("$MES")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and (month(Fechoria.fecha)) = '$MES'";
    }
      IF (TRIM("$DIA")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $DIA = cambia_fecha($DIA);
    $AUXSQL .= " and (date(Fechoria.fecha)) = '$DIA'";
    }
        if  (TRIM("$unidad")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    else
    {
    $AUXSQL .= " and FALUMNOS.unidad like '$unidad'";
    }

	     if  ($clase[0] == "Expulsion del Centro")
    {
    $AUXSQL .= " AND expulsion > '0' ";
    }
		     if  ($clase[0] == "Expulsion del Aula")
    {
    $AUXSQL .= " AND expulsionaula = '1' ";
    }
		     if  ($clase[0] == "Aula de Convivencia")
    {
    $AUXSQL .= " AND aula_conv > '0' ";
    }
		     if  ($clase[0] == "Falta Grave")
    {
    $AUXSQL .= " AND grave = 'grave' ";
    }
		     if  ($clase[0] == "Falta Muy Grave")
    {
    $AUXSQL .= " AND grave = 'muy grave' ";
    }
	
if (isset($submit1))
	{	
mysql_query("drop table Fechcaduca");
mysql_query("create table if not exists Fechcaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, Fechoria.confirmado, horas from Fechoria, FALUMNOS, Fechcaduca where Fechcaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal " . $AUXSQL . " order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos";

  $result = mysql_query ($query0);
 echo "<br /><center>
 <form action='fechorias.php' method='post' name='cnf'>
 <table class='table table-bordered' style='width:auto'><tr><td style='background-color:#FFFF99'>Expulsión del Centro</td><td style='background-color:#CCFFCC'>Amonestación escrita</td><td style='background-color:#FF9900'>Expulsión del Aula</td><td style='background-color:#CCCCFF'>Aula de Convivencia: Jefatura</td><td style='background-color:#dea9cd'>Aula de Convivencia: Profesor</td></tr></table></center>";
		echo "<center><form action='fechorias.php' method='post' name='cnf'>
		<table class='table table-bordered table-striped tabladatos'>";
		$fecha1 = (date("d").-date("m").-date("Y"));
		echo "<thead><tr>
		<th>ALUMNO</th>
		<th width='60'>CURSO</th>
		<th>FECHA</th>
		<th>TIPO</th>
		<th>INFORMA</th>
		<th>GRAV.</th>
		<th width='48'>NUM.</th>
		<th width='48'>CAD.</th>
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
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' order by Fechoria.fecha"); 
		$rownumero= mysql_num_rows($numero);
		$rowcurso = $unidad;
        $rowalumno = $nombre."&nbsp;".$apellidos;
			$bgcolor="style='background-color:white;'";
				if($medida == "Amonestación escrita" and $expulsionaula !== "1" and $expulsion == 0){$bgcolor="style='background-color:#CCFFCC;'";}
				if($expulsionaula == "1"){$bgcolor="style='background-color:#FF9900;'";}
				if($aula_conv > 0){
					if ($horas == "123456") {
						$bgcolor="style='background-color:#CCCCFF;'";
					}
					else{
						$bgcolor="style='background-color:#dea9cd;'";
					}
				}	
				
				if($expulsion > 0){$bgcolor="style='background-color:#FFFF99;'";}		
				if($recibido == '1'){$comentarios1="<i class='fa fa-check' title='recibido'> </i>";}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){$comentarios1="<i class='fa fa-exclamation-triangle' title='No recibido'> </i>";}else{$comentarios1="";}
		echo "<tr>
		<td nowrap >";
		$foto="";
		$foto = "<img src='../../xml/fotos/$claveal.jpg' width='55' height='64' class=''  />";
		echo $foto."&nbsp;&nbsp;";
		echo "$rowalumno</td>
		<td>$rowcurso</td>
		<td nowrap>$fecha</td>
		<td>$asunto</td>
		<td><span style='font-size:0.9em'>$informa</span></td>
		<td nowrap $bgcolor>$grave</td>
		<td nowrap><center>$rownumero</center></td>
		<td nowrap>$caducada</td>
		<td nowrap>$comentarios1</td>
		<td  nowrap>"; 
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='fechorias.php?id=$id&borrar=1' style='margin-top:5px;color:brown;'><i class='fa fa-trash-o'  rel='tooltip' title='Borrar el registro' data-bb='confirm-delete' style='margin-right:10px;'> </i></a><A HREF='infechoria.php?id=$id&claveal=$claveal'><i class='fa fa-pencil' rel='tooltip' title='Editar el problema de convivencia' style='margin-right:5px;'> </i></A></div>";}	
		echo " <A HREF='detfechorias.php?id=$id&claveal=$claveal'><i class='fa fa-search'  rel='tooltip' title='Detalles concretos del problema' style='margin-right:5px;'> </i></A></td>
		<td>";
		//echo "$expulsion >  $expulsionaula";
		if (stristr($_SESSION['cargo'],'1')) {
			echo "<input type='checkbox' name='$id' value='1'  $marca onChange='submit()' />";			
		}

		
		echo "</td></tr>";
        }
        echo "</tbody></table>
        <input type='hidden' name='confirma' value='si' />
        </form></center>\n";
 	}	
  ?>
  </div>
  </div>
  </div>
  <? include("../../pie.php");?>
</body>
</html>
