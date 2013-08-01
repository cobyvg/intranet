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
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">   
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <link href="http://<? echo $dominio;?>/intranet/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet" href="http://<? echo $dominio;?>/intranet/font-awesome/css/font-awesome.min.css">  
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
    <!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->    
</head>

<body>
  
<?
include ("../../funciones.php");
$idea = $_SESSION ['ide'];
if (strstr($_SERVER['REQUEST_URI'],'index0.php')==TRUE) {$activ1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activ2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activ3 = ' class="active" ';}
?>
  <!-- Navbar
    ================================================== -->
<div class="navbar navbar-fixed-top navbar-inverse no_imprimir">
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
          <li <? echo $activ1;?>><a href="http://<? echo $dominio;?>/intranet/index0.php">Inicio</a></li>
          <li><a href="http://<? echo $dominio;	?>">Página del centro</a></li>
          <li<? echo $activ2;?>><a href="http://<? echo $dominio;	?>/intranet/admin/mensajes/"> Mensajes</a></li>
          <li<? echo $activ3;?>><a href="http://<? echo $dominio;	?>/intranet/upload/">Documentos</a></li>
          <li><a href="https://www.juntadeandalucia.es/educacion/seneca/" style="color:#51a351" target="_blank"> Séneca</a></li>
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
  <?php
include("menu.php");
$datatables_activado = true;
if(isset($_GET['id'])){$id = $_GET['id'];}
?>
  <?php
    echo "<div  align='center'>";
    
    echo ' <div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="icon-spinner icon-spin icon-2x pull-left"></i> Cargando los datos...
      </div>
   ';
    echo "</div>";
    echo "<div id='t_larga' style='display:none' >";

  echo "<div class='container-fluid'>";
  echo '<div class="row-fluid">
  <div class="span12">';
  echo '<div aligna="center">
<div class="page-header" align="center">
  <h2>Problemas de Convivencia <small> &Uacute;ltimos Problemas de Convivencia</small></h2>
</div>
</div>
<br />';
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
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, confirmado, horas from Fechoria, FALUMNOS, Fechcaduca where Fechcaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal  order by Fechoria.fecha desc limit 500";
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
		like '%$claveal%' and Fechoria.fecha >= '$inicio_curso' order by Fechoria.fecha"); 
		$rownumero= mysql_num_rows($numero);
		$rowcurso = $nivel."-".$grupo;
        $rowalumno = $nombre."&nbsp;".$apellidos;
				$bgcolor="style='background-color:transparent;'";
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
				if($recibido == '1'){$comentarios1="<i class='icon icon-ok' rel='tooltip'  title='El Tutor ha recibido la notificación.'> </i>";}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){$comentarios1="<i class='icon icon-warning-sign'  rel='tooltip' title='El Tutor NO ha recibido la notificación.'> </i>";}else{$comentarios1="";}
		echo "<tr>
		<td $bgcolor><a href='lfechorias2.php?clave=$claveal'>$rowalumno</a></td>
		<td>$rowcurso</td>
		<td nowrap>$fecha</td>
		<td>$asunto</td>
		<td><span  style='font-size:0.9em'>$informa</span></td>
		<td>$grave</td>
		<td><center>$rownumero</center></td>
		<td>$caducada</td>
		<td nowrap>$comentarios1 $comentarios</td><td nowrap>"; 
if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='lfechorias.php?id= $row[9]&borrar=1' style='margin-top:5px;color:brown;'><i class='icon icon-trash'  rel='tooltip' title='Borrar el registro' onClick='return confirmacion();'> </i></a>&nbsp;&nbsp;";}	

		echo " <A HREF='detfechorias.php?id=$id&claveal=$claveal'><i class='icon icon-search' rel='tooltip' title='Detalles del problema'> </i></A></td>
		<td>";
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
