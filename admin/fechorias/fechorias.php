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
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">   
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <link href="http://<? echo $dominio;?>/intranet/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet">  
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css"> 
     <script type="text/javascript">
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar el registro de la base de datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>  
</head>
<body>
  
<?

$idea = $_SESSION ['ide'];
if (strstr($_SERVER['REQUEST_URI'],'index0.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activo3 = ' class="active" ';}
?>
 <!-- Navbar
    ================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top no_imprimir">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php">Intranet del <?php echo $nombre_del_centro; ?></a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li <? echo $activo1;?>><a href="http://<? echo $dominio;?>/intranet/index0.php">Inicio</a></li>
          <li><a href="http://<? echo $dominio;	?>">Página del centro</a></li>
          <li<? echo $activo2;?>><a href="http://<? echo $dominio;	?>/intranet/admin/mensajes/">Mensajes</a></li>
          <li<? echo $activo3;?>><a href="http://<? echo $dominio;	?>/intranet/upload/">Documentos</a></li>
          <li><a href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio" target="_blank">Séneca</a></li>
        </ul>
        
        <ul class="nav pull-right">
        	<li class="dropdown">
        		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
        			<i class="icon-user icon-white"></i> <? echo $idea; ?> <b class="caret"></b>
        		</a>
        		<ul class="dropdown-menu">
        			<li><a href="http://<? echo $dominio; ?>/intranet/clave.php"><i class="icon-edit"></i> Cambiar contraseña</a></li>
        			<li class="divider"></li>
        			<li><a href="http://<? echo $dominio;?>/intranet/salir.php"><i class="icon-off"></i> Cerrar sesión</a></li>
        		</ul>
        	</li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>


 <?
include("menu.php");
//$imprimir_activado = true;
?>
<div aligna="center">
<div class="page-header" align="center">
  <h2>Problemas de Convivencia <small> Consultas</small></h2>
</div>
</div>

 <div class='container-fluid'>
  <div class="row-fluid">
  <div class="span12">
 
 <?
// include '../../funciones.php';
// variables();
if(isset($_POST['submit1'])){$submit1 = $_POST['submit1'];}elseif(isset($_GET['submit1'])){$submit1 = $_GET['submit1'];}else{ $submit1=""; }
if(isset($_POST['nivel'])){$nivel = $_POST['nivel'];}else{ $nivel=""; }
if(isset($_POST['grupo'])){$grupo = $_POST['grupo'];}else{ $grupo=""; }
if(isset($_POST['c_escolar'])){$c_escolar = $_POST['c_escolar'];}else{ $c_escolar=""; }
if(isset($_POST['APELLIDOS'])){$APELLIDOS = $_POST['APELLIDOS'];}else{ $APELLIDOS=""; }
if(isset($_POST['NOMBRE'])){$NOMBRE = $_POST['NOMBRE'];}else{ $NOMBRE=""; }
if(isset($_POST['DIA'])){$DIA = $_POST['DIA'];}else{ $DIA=""; }
if(isset($_POST['MES'])){$MES = $_POST['MES'];}else{ $MES=""; }
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
	if(empty($NOMBRE) and empty($APELLIDOS) and empty($MES) and empty($DIA) and empty($nivel) and empty($grupo) and empty($claveal))
	   {
	   echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>ATENCIÓn:</h4>
            Debes seleccionar al menos un tipo de datos (Apellidos, Nombre, Nivel, etc.) para poder hacer la Consulta. Vuelve atrás y selecciona algún criterio de búsqueda.
          </div></div>';
	echo " <br />
<INPUT class='btn btn-primary' TYPE='button' VALUE='Volver atrás'
	onClick='history.back()'>";
exit();
    }
	$AUXSQL = "";
	$clase=$_POST["clase"]; 
  #Comprobamos si se han metido Apellidos o no, etc.
  if  (TRIM("$NOMBRE")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.nombre like '$NOMBRE%'";
    }
	  if  (TRIM("$claveal")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.claveal = '$claveal'";
    }
  if  (TRIM("$APELLIDOS")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.apellidos like '$APELLIDOS%'";
    }
  #Comprobamos d y mes.
  IF (TRIM("$MES")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and (month(Fechoria.fecha)) = $MES";
    }
      IF (TRIM("$DIA")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and (dayofmonth(Fechoria.fecha)) = $DIA";
    }
        if  (TRIM("$nivel")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.nivel like '$nivel'";
    }
        if  (TRIM("$grupo")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and FALUMNOS.grupo like '$grupo'";
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
	
if ($submit1)
	{	
mysql_query("drop table Fechcaduca");
mysql_query("create table if not exists Fechcaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, Fechoria.confirmado, horas from Fechoria, FALUMNOS, Fechcaduca where Fechcaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal " . $AUXSQL . " order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos";
  //echo $query0;
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
		$rowcurso = $nivel."-".$grupo;
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
				if($recibido == '1'){$comentarios1="<i class='icon icon-ok' title='recibido'> </i>";}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){$comentarios1="<i class='icon icon-warning-sign' title='No recibido'> </i>";}else{$comentarios1="";}
		echo "<tr>
		<td $bgcolor nowrap><a href='lfechorias2.php?clave=$claveal'>$rowalumno</a></td>
		<td>$rowcurso</td>
		<td nowrap>$fecha</td>
		<td>$asunto</td>
		<td><span style='font-size:0.9em'>$informa</span></td>
		<td nowrap>$grave</td>
		<td nowrap><center>$rownumero</center></td>
		<td nowrap>$caducada</td>
		<td nowrap>$comentarios1</td>
		<td  nowrap>"; 
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='fechorias.php?id=$id&borrar=1' style='margin-top:5px;color:brown;'><i class='icon icon-trash'  rel='tooltip' title='Borrar el registro' onClick='return confirmacion();' style='margin-right:10px;'> </i></a><A HREF='infechoria.php?id=$id&claveal=$claveal'><i class='icon icon-pencil' rel='tooltip' title='Editar el problema de convivencia' style='margin-right:5px;'> </i></A></div>";}	
		echo " <A HREF='detfechorias.php?id=$id&claveal=$claveal'><i class='icon icon-search'  rel='tooltip' title='Detalles concretos del problema' style='margin-right:5px;'> </i></A></td>
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
