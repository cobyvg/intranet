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


$tutor = $_SESSION['profi'];
?>
<?php
//include("../../funciones.php");
//variables();
include("../../menu.php");
include("menu.php");
?>
	<div class="container">
<div class="page-header">
  <h2>Problemas de convivencia <small> Informe personal del Problema</small></h2>
</div>

<?
if(!($_POST['id'])){$id = $_GET['id'];}else{$id = $_POST['id'];}
if(!($_POST['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}
if (isset($_POST['expulsion'])) { $expulsion = $_POST['expulsion']; }
if (isset($_POST['inicio'])) { $inicio = $_POST['inicio']; }
if (isset($_POST['fin'])) { $fin = $_POST['fin']; }
if (isset($_POST['mens_movil'])) { $mens_movil = $_POST['mens_movil']; }
if (isset($_POST['submit'])) { $submit = $_POST['submit']; }
if (isset($_POST['convivencia'])) { $convivencia = $_POST['convivencia']; }
if (isset($_POST['horas'])) { $horas = $_POST['horas']; }
if (isset($_POST['fechainicio'])) { $fechainicio = $_POST['fechainicio']; }
if (isset($_POST['fechafin'])) { $fechafin = $_POST['fechafin']; }
if (isset($_POST['tareas'])) { $tareas = $_POST['tareas']; }
if (isset($_POST['imprimir4'])) { $imprimir4 = $_POST['imprimir4']; }
if (isset($_POST['imprimir'])) { $imprimir = $_POST['imprimir']; }
if (isset($_POST['imprimir5'])) { $imprimir5 = $_POST['imprimir5']; }
if (isset($_POST['imprimir2'])) { $imprimir2 = $_POST['imprimir2']; }
if (isset($_POST['imprimir3'])) { $imprimir3 = $_POST['imprimir3']; }
if (isset($_POST['inicio_aula'])) { $inicio_aula = $_POST['inicio_aula']; }
if (isset($_POST['fin_aula'])) { $fin_aula = $_POST['fin_aula']; }
if (isset($_POST['convivencia'])) { $convivencia = $_POST['convivencia']; }

include("expulsiones.php");
if (strlen($mensaje)>"0") {
echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>'.
            $mensaje.'
          </div></div>';
}
$result = mysql_query ("select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.inicio, Fechoria.fin, aula_conv, inicio_aula, fin_aula, Fechoria.horas from Fechoria, FALUMNOS, listafechorias where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC");
  if ($row = mysql_fetch_array($result))
        {
		$apellidos = $row[0];
		$nombre = $row[1];
		$unidad = $row[2];
		$fecha = $row[4];
		$notas = $row[5];
		$asunto = $row[6];
		$informa = $row[7];
		$grave = $row[8];
		$medida = $row[9];
		$medidas2 = $row[10];
		$expulsion = $row[11];
		$tutoria = $row[12];
		$inicio = $row[13];
		$fin = $row[14];
		$convivencia = $row[15];
		$inicio_aula = $row[16];
		$fin_aula = $row[17];
		$horas = $row[18];
 	if($inicio){ $inicio1 = explode("-",$inicio); $inicio = $inicio1[2] . "-" . $inicio1[1] ."-" . $inicio1[0];}
    if($fin){ $fin1 = explode("-",$fin); $fin = $fin1[2] . "-" . $fin1[1] ."-" . $fin1[0];}
	 if($inicio_aula){ $inicio1 = explode("-",$inicio_aula); $inicio_aula = $inicio1[2] . "-" . $inicio1[1] ."-" . $inicio1[0];}
    if($fin_aula){ $fin1 = explode("-",$fin_aula); $fin_aula = $fin1[2] . "-" . $fin1[1] ."-" . $fin1[0];}
		}
		$numero = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' order by Fechoria.fecha"); 
		$numerototal= mysql_num_rows($numero);
		$numerograves0 = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' and grave = 'grave' order by Fechoria.fecha"); 
		$numerograves= mysql_num_rows($numerograves0);
		$numeromuygraves0 = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' and grave = 'muy grave' order by Fechoria.fecha"); 
		$numeromuygraves= mysql_num_rows($numeromuygraves0);
		$numeroexpulsiones0 = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '2006-09-15' and expulsion >= '1' order by Fechoria.fecha"); 
		$numeroexpulsiones= mysql_num_rows($numeroexpulsiones0);
?>
<legend align="center">
  <? echo "$nombre $apellidos ($unidad)";?>
  </legend>
  <br />
<div class="row">
  <div class="col-sm-7">
      <div class="well well-large">
      <?
            if(file_exists("../../xml/fotos/".$claveal.".jpg")){
echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-bottom:-145px' class='img-thumbnail img-circle pull-right hidden-phone' />";
            }
            ?>
        <table class="table table-striped">
          <tr>
            <th colspan="5"><h4>Información detallada sobre el Problema</h4></th>
          </tr>
          <tr>
            <th>NOMBRE</th>
            <td colspan="4"><? echo $nombre." ".$apellidos; ?>
            </td>
          </tr>
          <tr>
            <th>GRUPO</th>
            <td colspan="4"><? echo $unidad; ?></td>
          </tr>
          <tr>
            <th>FECHA</th>
            <td colspan="4"><? echo $fecha; ?></td>
          </tr>
          <tr>
            <th>OBSERVACIONES</th>
            <td colspan="4"><? echo $notas; ?></td>
          </tr>
          <tr>
            <th>ASUNTO</th>
            <td colspan="4"><? echo $asunto; ?></td>
          </tr>
          <tr>
            <th>MEDIDAS</th>
            <td colspan="4"><? echo $medida; ?></td>
          </tr>
          <tr>
            <th>GRAVEDAD</th>
            <td colspan="4"><? echo $grave; ?></td>
          </tr>
          <tr>
            <th>ANTECEDENTES</th>
            <td >Total: <? echo $numerototal; ?></td>
            <td >Graves: <? echo $numerograves; ?></td>
            <td >Muy Graves: <? echo $numeromuygraves; ?></td>
            <td >Expulsiones: <? echo $numeroexpulsiones; ?></td>
          </tr>
          <tr>
            <th>PROTOCOLOS</th>
            <td colspan="4"><? echo $medidas2; ?></td>
          </tr>
          <tr>
            <th>PROFESOR</th>
            <td colspan="4"><? echo $informa; ?></td>
          </tr>
        </table>
        <br />
        <div align="center"><a href="../informes/index.php?claveal=<? echo $claveal;?>&todos=1" target="_blank" class="btn btn-primary">
        Ver Informe del Alumno
        </a> 
        <a href="../jefatura/tutor.php?alumno=<? echo $apellidos.", ".$nombre;?>&unidad=<? echo $unidad;?>&grupo=<? echo $grupo;?>" target="_blank" class="btn btn-primary">Registrar intervención de Jefatura</a></div>
    </div>
    <hr>
    <br />
    <h4>Problemas de Convivencia en el Curso</h4>
    <?
    echo "<br /><table class='table table-striped' style='width:auto;'>";
	echo "<tr>
		<th>Fecha</th>
		<th>Tipo</th>
		<th>Gravedad</th>
		<th></th>
		</tr>";
	// Consulta de datos del alumno.
	$result = mysql_query ( "select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.grave, Fechoria.id from Fechoria where claveal = '$claveal' and fecha >= '$inicio_curso' order by fecha DESC" );
	
	while ( $row = mysql_fetch_array ( $result ) ) {
		echo "<tr>
	<td nowrap>$row[0]</td>
	<td>$row[1]</td>
	<td>$row[2]</td>
	<td nowrap><a href='detfechorias.php?id= $row[3]&claveal=$claveal' data-bs='tooltip' title='Detalles'><i class='fa fa-search fa-fw fa-lg'></i></a><a href='delfechorias.php?id= $row[3]' data-bs='tooltip' title='Eliminar'><i class='fa fa-trash-o fa-fw fa-lg'></i></a></td>
	</tr>";
	}
	echo "</table>\n";
    ?>
    
  </div>
  
  <div class="col-sm-5">
    <?
   $pr = $_SESSION ['profi'];
   $conv = mysql_query("SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr'");
   if (mysql_num_rows($conv) > '0') {$gucon = '1';}
	if(stristr($_SESSION['cargo'],'1') == TRUE or $gucon == '1' or stristr($_SESSION['cargo'],'8') == TRUE)
		{
	if (stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE) {
	?>
    
    <div class="well"><h4>Expulsión del alumno</h4><br>
    <form id="form1" name="form1" method="post" action="detfechorias.php" class="">
      <div class="form-group">
	<label> N&ordm; de D&iacute;as:</label>
        <input name="expulsion" type="text" id="textfield" <? if($expulsion > 0){echo "value=$expulsion";}?> maxlength="2" class="form-control" />
        
      </div>
       
      <input name="id" type="hidden" value="<? echo $id; ?>"/>
      <input name="claveal" type="hidden" value="<? echo $claveal; ?>"/>
 

<div class="form-group " id="datetimepicker1">
<label>Inicio:</label>
<div class="input-group">
  <input name="inicio" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="inicio" <? if(strlen($inicio) > '0' and !($inicio == '00-00-0000')){echo "value='$inicio'";}?>  >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>

<div class="form-group " id="datetimepicker2">
<label>Fin:</label>
<div class="input-group">
  <input name="fin" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fin" <? if(strlen($fin) > '0' and !($fin == '00-00-0000')){echo "value='$fin'";}?>  >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>

  <div class="form-group ">
      <div class="checkbox">    
         <label>
         <input name="mens_movil" type="checkbox" id="sms" value="envia_sms" checked="checked" />
        Enviar SMS </label>
      </div>
      </div>
      
        <input name="submit" type="submit" value="Enviar datos" class="btn btn-primary" />
      
    </form>
    </div>
    <?
		}
    ?>
    <?php 
 $hora = date ( "G" ); // hora
	$ndia = date ( "w" );
	if (($hora == '8' and $minutos > 15) or ($hora == '9' and $minutos < 15)) {
		$hora_dia = '1';
	} elseif (($hora == '9' and $minutos > 15) or ($hora == '10' and $minutos < 15)) {
		$hora_dia = '2';
	} elseif (($hora == '10' and $minutos > 15) or ($hora == '11' and $minutos < 15)) {
		$hora_dia = '3';
	} elseif (($hora == '11' and $minutos > 15) or ($hora == '11' and $minutos < 45)) {
		$hora_dia = '9';
	} elseif (($hora == '11' and $minutos > 45) or ($hora == '12' and $minutos < 45)) {
		$hora_dia = '4';
	} elseif (($hora == '12' and $minutos > 45) or ($hora == '13' and $minutos < 45)) {
		$hora_dia = '5';
	} elseif (($hora == '13' and $minutos > 45) or ($hora == '14' and $minutos < 45)) {
		$hora_dia = '6';
	} else {
		$hora_dia = "0";
	}	
 ?>
 <div class="well">
    <h4>Expulsión al Aula de convivencia </h4><br>
    <form id="form2" name="form2" method="post" action="detfechorias.php" >
      
      <div class="form-group">
      <label >N&uacute;mero de D&iacute;as</label>
        <input name="convivencia" type="text" id="expulsion" <? if($convivencia > 0){echo "value=$convivencia";}else{ if ($gucon == '1') {
          	echo "value=";}}?> size="2" maxlength="2" class="form-control" />
      </div>
      
      <div class="form-group">
      <label >Horas sueltas</label>
        <input name="horas" type="text" <? if($horas > 0){echo "value=$horas";}else{ 
          	if (stristr($_SESSION['cargo'],'1') == TRUE) {
          		echo "value=123456";
          	}else{
          		echo "value=$hora_dia";
          	}
          	}
          	?> size="6" maxlength="6" class="form-control" />
            </div>
        <input name="id" type="hidden" value="<? echo $id;?>" />
        <input name="claveal" type="hidden" value="<? echo $claveal;?>" />
     <hr>
     
     <div class="form-group"  id="datetimepicker3">
<label>Inicio:</label>
<div class="input-group">
  <input name="fechainicio" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fechainicio" <?if($inicio_aula){echo "value=$inicio_aula";}else{if ($gucon == '1'){	$def_inicio = date ( 'd' ) . "-" . date ( 'm' ) . "-" . date ( 'Y' ); 	echo "value='$def_inicio'";}} ?> >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>

    <div class="form-group" id="datetimepicker4">
<label>Fin:</label>
<div class="input-group">
  <input name="fechafin" type="text" class="form-control" data-date-format="DD-MM-YYYY" id="fechafin" <?if($fin_aula){echo "value=$fin_aula";}else{ if ($gucon == '1'){$def_fin = date ( 'd' ) . "-" . date ( 'm' ) . "-" . date ( 'Y' );  echo "value='$def_fin'";}} ?>  >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> 
</div>

          <div class="form-group">
          <div class="checkbox">
         <label for='tareas'>
          <input name="tareas" type="checkbox" id="tareas" value="insertareas" <?php if ($gucon == '1') {}else{          	echo 'checked="checked"';
          }?> />
          Activar Tareas
          </label>
          </div>
          
          
           <div class="checkbox">
          <label for='sms'>
          <input name="mens_movil" type="checkbox" id="sms" value="envia_sms" checked="checked"  />
          Enviar SMS
          </label>
          </div>
          </div>
<hr>          <input type="submit" name="imprimir4" value="Enviar datos" class="btn btn-primary"/>
        
    </form>
    </div>
    <?
}
   ?>
   <div>
   <div class="well">
    <h4>Impresión de partes</h4><br>
    <?
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
	?>
    <h6>EXPULSI&Oacute;N DEL CENTRO</h6>
    <form id="form2" name="form2" method="post" action="imprimir/expulsioncentro.php">
      <input name="id" type="hidden" value="<? echo $id;?>" />
      <input name="claveal" type="hidden" value="<? echo $claveal;?>" />
      <input name="fechainicio" type="hidden" id="textfield2" size="10" maxlength="10" <? if($inicio){echo "value=$inicio";}?> />
      <input name="fechafin" type="hidden" id="textfield3" size="10" maxlength="10" <? if($fin){echo "value=$fin";}?> />
      
        <input type="submit" name="imprimir" value="Expulsi&oacute;n del Centro" class="btn btn-danger"/>
      
    </form>
    <h6>EXPULSI&Oacute;N AL AULA DE CONVIVENCIA</h6>
    
      <form id="form3" name="form3" method="post" action="imprimir/convivencia.php">
        <input name="id" type="hidden" value="<? echo $id;?>" />
        <input name="claveal" type="hidden" value="<? echo $claveal;?>" />
        <input name="fechainicio" type="hidden" id="textfield2" size="10" maxlength="10" <? if($inicio_aula){echo "value=$inicio_aula";}?> />
        <input name="fechafin" type="hidden" id="textfield3" size="10" maxlength="10" <? if($fin_aula){echo "value=$fin_aula";}?> />
        <input name="horas" type="hidden" value="<? echo $horas;?>" />
        <input type="submit" name="imprimir5" value="Aula de Convivencia"  class="btn btn-danger" />
      </form>
        <?
}
   ?>
    <h6>EXPULSI&Oacute;N
      DEL AULA </h6>
    <form id="form3" name="form3" method="post" action="imprimir/expulsionaula.php">
      
        <input name="id" type="hidden" value="<? echo $id;?>" />
        <input name="claveal" type="hidden" value="<? echo $claveal;?>" />
        <input type="submit" name="imprimir2" value="Parte de Expulsi&oacute;n del Aula" class="btn btn-danger" />
      
    </form>
    <h6>AMONESTACI&Oacute;N ESCRITA </h6>
    <form id="form3" name="form3" method="post" action="imprimir/amonestescrita.php">
      
        <input name="id" type="hidden" value="<? echo $id;?>" />
        <input name="claveal" type="hidden" value="<? echo $claveal;?>" />
        <input type="submit" name="imprimir3" value="Amonestaci&oacute;n escrita " class="btn btn-danger" />
      
    </form>
    </div>
  </div>
</div>
</div>
</div>
<? include("../../pie.php");?>
	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker2').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker3').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datetimepicker4').datetimepicker({
			language: 'es',
			pickTime: false
		});
	});  
	</script>
</body>
</html>
