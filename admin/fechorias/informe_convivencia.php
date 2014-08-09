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
?>
<br />
<div align="center" style="max-width:1250px;margin:auto;">
<div class="page-header">
  <h2>Jefatura de Estudios <small> Informe de Problemas de Convivencia</small></h2>
</div>
<div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="fa fa-spin fa fa-spin fa-2x pull-left"></i> Cargando los datos...
 </div>
 <div id='t_larga' style='display:none' >
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Resumen general</a></li>
<li><a href="#tab2" data-toggle="tab">Resumen por Nivel</a></li>
<li><a href="#tab3" data-toggle="tab">Resumen por Grupo</a></li>
<?
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE)
{
echo '<li><a href="#tab4" data-toggle="tab">Informe por Profesor</a></li>';	
}
?>
<li><a href="#tab5" data-toggle="tab">Informe por Tipo</a></li>
</ul>
<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<div class="tab-pane fade in active" id="tab1">
<h3>Resumen General</h3><br />
 <table class="table table-striped" style="width:auto">
<tr>
    <th>Absentismo</th>
    <th>Convivencia</th>
    <th>Leves</th>
    <th>Graves</th>
	<th>Muy Graves</th>
    <th>Expulsiones</th>
    <th>Alumnos Expulsados</th>
	<th>Expulsi&oacute;n del Aula</th>
    <th>Acciones</th>
    <th>Informes</th>
        <th>Comunicaciones</th>
</tr>
<? 
 
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12'  order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03'  order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06'  order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados1 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados2 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados1 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados2 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados3 = mysql_num_rows($result);
 ?>
 
    <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula1 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula2 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct id from infotut_alumno where month(F_ENTREV) >='09' and month(F_ENTREV) <= '12' order by claveal";
 $result = mysql_query($SQL);
 $num_informes1 = mysql_num_rows($result);
 $SQL = "select distinct id from infotut_alumno where month(F_ENTREV) >='01' and month(F_ENTREV) <= '03' order by claveal";
 $result = mysql_query($SQL);
 $num_informes2 = mysql_num_rows($result);
 $SQL = "select distinct id from infotut_alumno where month(F_ENTREV) >='04' and month(F_ENTREV) <= '06' order by claveal";
 $result = mysql_query($SQL);
 $num_informes3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct id from tutoria where month(fecha) >='09' and month(fecha) <= '12' and date(fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones1 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria where month(fecha) >='01' and month(fecha) <= '03' and date(fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones2 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria where month(fecha) >='04' and month(fecha) <= '06' and date(fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct id from tutoria where causa = 'Faltas de Asistencia' and month(fecha) >='09' and month(fecha) <= '12' and date(fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica1 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria where causa = 'Faltas de Asistencia' and month(fecha) >='01' and month(fecha) <= '03' and date(fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica2 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria where causa = 'Faltas de Asistencia' and month(fecha) >='04' and month(fecha) <= '06' and date(fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica3 = mysql_num_rows($result);
 ?>
 
 <?  
 //mysql_query("truncate table absentismo");
 for($i=1;$i<13;$i++)
 {
// Creación de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;  
 $SQLTEMP = "create table absentismo$i SELECT claveal, falta, (count(*)) AS numero, unidad FROM FALTAS where falta = 'F' and MONTH(fecha) = '$i' group by claveal";
 $resultTEMP= mysql_query($SQLTEMP);
 mysql_query("insert into absentismo select * from absentismo$i where numero > '25'");
 
 $SQLDEL = "DROP table if exists absentismo$i";
 mysql_query($SQLDEL);
 }
 $faltas = "select distinct claveal from absentismo";
 $faltas0 = mysql_query($faltas);
 $num_faltas = mysql_num_rows($faltas0);
 ?>
<?
$num_conv = $num_conv1 + $num_conv2 + $num_conv3;
$num_leves = $num_leves1 + $num_leves2 + $num_leves3;
$num_graves = $num_graves1 + $num_graves2 + $num_graves3;
$num_muygraves = $num_muygraves1 + $num_muygraves2 + $num_muygraves3;
$num_expulsion = $num_expulsion1 + $num_expulsion2 + $num_expulsion3;
$num_expulsados = $num_expulsados1 + $num_expulsados2 + $num_expulsados3;
$num_expulsadosaula = $num_expulsadosaula1 + $num_expulsadosaula2 + $num_expulsadosaula3;
$num_acciones = $num_acciones1 + $num_acciones2 + $num_acciones3;
$num_informes = $num_informes1 + $num_informes2 + $num_informes3;
$num_comunica = $num_comunica1 + $num_comunica2 + $num_comunica3;
?>
<tr>
    <td><? echo $num_faltas; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_conv1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_conv2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_conv3; ?><hr><strong><? echo $num_conv; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_leves1; ?><br /><span style="color:#abc">2T.</span>  <? echo $num_leves2; ?><br /><span style="color:#abc">3T.</span>  <? echo $num_leves3; ?><hr><strong><? echo $num_leves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_graves1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_graves2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_graves3; ?><hr><strong><? echo $num_graves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_muygraves1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_muygraves2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_muygraves3; ?><hr><strong><? echo $num_muygraves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsion1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsion2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsion3; ?><hr><strong><? echo $num_expulsion; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsados1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsados2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsados3; ?><hr><strong><? echo $num_expulsados; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsadosaula1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsadosaula2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsadosaula3; ?><hr><strong><? echo $num_expulsadosaula; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_acciones1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_acciones2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_acciones3; ?><hr><strong><? echo $num_acciones; ?></td> 
    <td><span style="color:#abc">1T.</span>  <? echo $num_informes1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_informes2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_informes3; ?><hr><strong><? echo $num_informes; ?></td>
	<td><span style="color:#abc">1T.</span>  <? echo $num_comunica1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_comunica2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_comunica3; ?><hr><strong><? echo $num_comunica; ?></td>
</tr>
 </table>
<hr style="width:950px">


</div>
<div class="tab-pane fade in" id="tab2">


<h3>Información por Nivel</h3>
<br />
<? 
 $nivel0 = "select distinct nomcurso from cursos";
 $nivel1 = mysql_query($nivel0);
 while($nivel = mysql_fetch_array($nivel1))
 {
 $nivel = $nivel[0];
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal and month(fecha) >='09' and month(Fechoria.fecha) <= '12'  order by Fechoria.claveal";
 //echo $SQL."<br>";
 $result = mysql_query($SQL);
 $num_conv1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03'  order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06'  order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and nivel = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion3 = mysql_num_rows($result);
 ?>
 
  <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados1 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados2 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados1 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados2 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados3 = mysql_num_rows($result);
 ?>
 
    <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula1 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula2 = mysql_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and month(F_ENTREV) >='09' and month(F_ENTREV) <= '12' order by infotut_alumno.claveal";
 //echo $SQL."<br>";
 $result = mysql_query($SQL);
 $num_informes1 = mysql_num_rows($result);
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and month(F_ENTREV) >='01' and month(F_ENTREV) <= '03' order by infotut_alumno.claveal";
 $result = mysql_query($SQL);
 $num_informes2 = mysql_num_rows($result);
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and month(F_ENTREV) >='04' and month(F_ENTREV) <= '06' order by infotut_alumno.claveal";
 $result = mysql_query($SQL);
 $num_informes3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones1 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and month(tutoria.fecha) >='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones2 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and month(tutoria.fecha) >='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones3 = mysql_num_rows($result);
 ?>
 
   <?    
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica1 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica2 = mysql_num_rows($result);
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica3 = mysql_num_rows($result);
 ?>
 
 <?  
 
 $faltas = "select distinct absentismo.claveal from absentismo, alma where alma.claveal=absentismo.claveal and  curso = '$nivel'";
 $faltas0 = mysql_query($faltas);
 $num_faltas = mysql_num_rows($faltas0);
 ?>

<?
$num_conv = $num_conv1 + $num_conv2 + $num_conv3;
$num_leves = $num_leves1 + $num_leves2 + $num_leves3;
$num_graves = $num_graves1 + $num_graves2 + $num_graves3;
$num_muygraves = $num_muygraves1 + $num_muygraves2 + $num_muygraves3;
$num_expulsion = $num_expulsion1 + $num_expulsion2 + $num_expulsion3;
$num_expulsados = $num_expulsados1 + $num_expulsados2 + $num_expulsados3;
$num_expulsadosaula = $num_expulsadosaula1 + $num_expulsadosaula2 + $num_expulsadosaula3;
$num_acciones = $num_acciones1 + $num_acciones2 + $num_acciones3;
$num_informes = $num_informes1 + $num_informes2 + $num_informes3;
$num_comunica = $num_comunica1 + $num_comunica2 + $num_comunica3;
?>

 <table class="table table-striped" style="width:auto">
<tr>
    <th>Nivel</th>
    <th>Absentismo</th>
    <th>Convivencia</th>
    <th>Leves</th>
    <th>Graves</th>
	<th>Muy Graves</th>
    <th>Expulsiones</th>
    <th>Alumnos Expulsados</th>
	<th>Expulsi&oacute;n del Aula</th>
    <th>Acciones</th>
    <th>Informes</th>
        <th>Comunicaciones</th>
</tr>
<tr>
    <td><span class="badge badge-success"><? echo $nivel; ?></span></td>
    <td><? echo $num_faltas; ?></td>	
	<td><span style="color:#abc"><span style="color:#abc">1T.</span> </span> <? echo $num_conv1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_conv2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_conv3; ?><hr><strong><? echo $num_conv; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_leves1; ?><br /><span style="color:#abc">2T.</span>  <? echo $num_leves2; ?><br /><span style="color:#abc">3T.</span>  <? echo $num_leves3; ?><hr><strong><? echo $num_leves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_graves1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_graves2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_graves3; ?><hr><strong><? echo $num_graves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_muygraves1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_muygraves2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_muygraves3; ?><hr><strong><? echo $num_muygraves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsion1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsion2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsion3; ?><hr><strong><? echo $num_expulsion; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsados1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsados2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsados3; ?><hr><strong><? echo $num_expulsados; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsadosaula1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsadosaula2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsadosaula3; ?><hr><strong><? echo $num_expulsadosaula; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_acciones1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_acciones2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_acciones3; ?><hr><strong><? echo $num_acciones; ?></td> 
    <td><span style="color:#abc">1T.</span>  <? echo $num_informes1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_informes2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_informes3; ?><hr><strong><? echo $num_informes; ?></td>
	<td><span style="color:#abc">1T.</span>  <? echo $num_comunica1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_comunica2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_comunica3; ?><hr><strong><? echo $num_comunica; ?></td>

</tr>
</table>
<hr>
<br />
<? } ?>

<hr style="width:950px">


</div>
<div class="tab-pane fade in" id="tab3">


<h3>
 Informaci&oacute;n de los Grupos </h3>
 
<?
 $cursos0 = "select distinct curso, unidad from alma order by curso";
 $cursos1 = mysql_query($cursos0);
 while($cursos = mysql_fetch_array($cursos1))
 {
 $nivel = $cursos[0];
 $grupo = $cursos[1];
 $unidad = $cursos[0]."-".$cursos[1];
?> 
 
 <? 
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_conv3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'leve' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves1 = mysql_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'leve' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves2 = mysql_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'leve' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_leves3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves1 = mysql_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'grave' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves2 = mysql_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'grave' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_graves3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'muy grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves1 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'muy grave' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves2 = mysql_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'muy grave' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_muygraves3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion1 = mysql_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion2 = mysql_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsion3 = mysql_num_rows($result);
 ?>
  <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados1 = mysql_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados2 = mysql_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados3 = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados1 = mysql_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados2 = mysql_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsados3 = mysql_num_rows($result);
 ?>
    <?    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsionaula = '1' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula1 = mysql_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsionaula = '1' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula2 = mysql_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsionaula = '1' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '$inicio_curso' order by Fechoria.claveal";
 $result = mysql_query($SQL);
 $num_expulsadosaula3 = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and infotut_alumno.unidad = '$grupo' and month(F_ENTREV) >='09' and month(F_ENTREV) <= '12' and date(F_ENTREV) > '$inicio_curso' order by infotut_alumno.claveal";
 $result = mysql_query($SQL);
 $num_informes1 = mysql_num_rows($result);
$SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and infotut_alumno.unidad = '$grupo' and month(F_ENTREV)>='01' and month(F_ENTREV) <= '03' and date(F_ENTREV) > '$inicio_curso' order by infotut_alumno.claveal";
 $result = mysql_query($SQL);
 $num_informes2 = mysql_num_rows($result);
$SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and infotut_alumno.unidad = '$grupo' and month(F_ENTREV)>='04' and month(F_ENTREV) <= '06' and date(F_ENTREV) > '$inicio_curso' order by infotut_alumno.claveal";
 $result = mysql_query($SQL);
 $num_informes3 = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones1 = mysql_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and month(tutoria.fecha)>='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones2 = mysql_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and month(tutoria.fecha)>='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_acciones3 = mysql_num_rows($result);
 ?>
   <?    
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica1 = mysql_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and causa = 'Faltas de Asistencia' and month(tutoria.fecha)>='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica2 = mysql_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and causa = 'Faltas de Asistencia' and month(tutoria.fecha)>='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '$inicio_curso' order by id";
 $result = mysql_query($SQL);
 $num_comunica3 = mysql_num_rows($result);
 ?>

 <?  
 $faltas = "select distinct absentismo.claveal from absentismo, alma where alma.claveal=absentismo.claveal and curso = '$nivel' and absentismo.unidad = '$grupo' order by absentismo.claveal";
 $faltas0 = mysql_query($faltas);
 $num_faltas = mysql_num_rows($faltas0);
 ?>
 <?
$num_conv = $num_conv1 + $num_conv2 + $num_conv3;
$num_leves = $num_leves1 + $num_leves2 + $num_leves3;
$num_graves = $num_graves1 + $num_graves2 + $num_graves3;
$num_muygraves = $num_muygraves1 + $num_muygraves2 + $num_muygraves3;
$num_expulsion = $num_expulsion1 + $num_expulsion2 + $num_expulsion3;
$num_expulsados = $num_expulsados1 + $num_expulsados2 + $num_expulsados3;
$num_expulsadosaula = $num_expulsadosaula1 + $num_expulsadosaula2 + $num_expulsadosaula3;
$num_acciones = $num_acciones1 + $num_acciones2 + $num_acciones3;
$num_informes = $num_informes1 + $num_informes2 + $num_informes3;
$num_comunica = $num_comunica1 + $num_comunica2 + $num_comunica3;
?>
<h3 align="center"><span  class="badge badge-info"><? echo $unidad;?></span></h3><br />
<table class="table table-striped" style="width:auto">
<tr>
         <th>Absentismo</th>
    <th>Convivencia</th>
    <th>Leves</th>
    <th>Graves</th>
	<th>Muy Graves</th>
    <th>Expulsiones</th>
    <th>Alumnos Expulsados</th>
	<th>Expulsi&oacute;n del Aula</th>
    <th>Acciones</th>
    <th>Informes</th>
        <th>Comunicaciones</th>
</tr>
<tr>
    <td><? echo $num_faltas; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_conv1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_conv2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_conv3; ?><hr><strong><? echo $num_conv; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_leves1; ?><br /><span style="color:#abc">2T.</span>  <? echo $num_leves2; ?><br /><span style="color:#abc">3T.</span>  <? echo $num_leves3; ?><hr><strong><? echo $num_leves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_graves1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_graves2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_graves3; ?><hr><strong><? echo $num_graves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_muygraves1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_muygraves2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_muygraves3; ?><hr><strong><? echo $num_muygraves; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsion1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsion2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsion3; ?><hr><strong><? echo $num_expulsion; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsados1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsados2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsados3; ?><hr><strong><? echo $num_expulsados; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_expulsadosaula1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_expulsadosaula2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_expulsadosaula3; ?><hr><strong><? echo $num_expulsadosaula; ?></td>
    <td><span style="color:#abc">1T.</span>  <? echo $num_acciones1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_acciones2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_acciones3; ?><hr><strong><? echo $num_acciones; ?></td> 
    <td><span style="color:#abc">1T.</span>  <? echo $num_informes1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_informes2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_informes3; ?><hr><strong><? echo $num_informes; ?></td>
	<td><span style="color:#abc">1T.</span>  <? echo $num_comunica1; ?><br /><span style="color:#abc">2T.</span> <? echo $num_comunica2; ?><br /><span style="color:#abc">3T.</span> <? echo $num_comunica3; ?><hr><strong><? echo $num_comunica; ?></td>
</tr>
</table>
<hr>

<br /><table class="table table-striped" align="center" style="width:800px">
<tr>
  <th>Tipo de Problema</th>
  <th>Número</th>
</tr>
<?
$tabla = str_replace("-","",$grupo);
$temp = mysql_query("create table $tabla select Fechoria.asunto from Fechoria, alma where Fechoria.claveal = alma.claveal and alma.unidad = '$grupo'"); 
$ini0 = mysql_query("SELECT distinct asunto, COUNT( * ) FROM  `$tabla` group by asunto");
	while ($ini = mysql_fetch_array($ini0)){
?>
<tr>
  <td><?php  echo $ini[0];?></td>
  <td><?php  echo $ini[1];?></td>
</tr>
<?
 }
 $borra_temp = mysql_query("drop table $tabla");
 echo "</tbody>
</table>";
 echo '<hr style="width:800px">
<br />';
  }
  ?>
 </div>
<?
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE)
{
?>
<div class="tab-pane fade in" id="tab4">
<h3>Informe por Profesor</h3><br />
<div class="container-fluid">
<?php 
$cur = substr($inicio_curso,0,4)+1;
for ($i=$cur;$i>$cur-3;$i--)
{
	//$b_d = "";
	if ($i == $cur){
		$b_d = "faltas";
	}
	else{
		$b_d = "faltas".$i;
	}
	mysql_select_db($b_d);
?>


<?
	if(stristr($_SESSION['cargo'],'1') == TRUE)
{
?>
<div class="col-sm-4">
<h4 align="center">Curso <?php echo $i-1; echo "-".$i;?></h4>
<br />
<table class="table table-striped" align="center" style="width:auto">
<thead>
<tr>
<th>Profesor</th><th width="62">Número</th>
</tr>
</thead>
<tbody>

  <?php 
$tot0 = '';
$tot1 = mysql_query("create table fech_temp select informa, count(*) as numeros from $b_d.Fechoria group by informa");
$tot0 = mysql_query("select informa, numeros from $b_d.fech_temp order by numeros desc");
while ($total0 = mysql_fetch_array($tot0)){
?>
  <tr>
    <td style="font-size:10px"><?php  echo $total0[0];?></td>
      <td>
    <?php  echo $total0[1];?>
      </td>
  </tr>
  <?
}
?>
</tbody>
</table>
</div>
<?
mysql_query("drop table fech_temp");
}
}
?>
</div>
</div>
<?
}
?>
<div class="tab-pane fade in" id="tab5">
<div class="col-sm-8 col-sm-offset-2">
<h3>Informe por Tipo de problema</h3><br />
<?
$cur = substr($inicio_curso,0,4)+1;
for ($i=$cur;$i>$cur-3;$i--)
{
	//$b_d = "";
	if ($i == $cur){
		$b_d = "faltas";
	}
	else{
		$b_d = "faltas".$i;
	}
	mysql_select_db($b_d);
?>

<h4 align="center">Problemas de Convivencia en el Curso <?php echo $i-1; echo "-".$i;?></h4>
<br />

<table class="table table-striped tabladatos" align="center" style="width:100%">
  <thead>
  <tr>
    <th>Tipo de Problema</th>
    <th width="62">Número</th>
    <th width="72">Gravedad</th>
  </tr>
  </thead>
  <tbody>
  <?php 
$tot = '';
$tot = mysql_query("select asunto, count(*), grave from $b_d.Fechoria group by grave, asunto");
while ($total = mysql_fetch_array($tot)){
?>
  <tr>
    <td><?php  echo $total[0];?></td>
    <td ><?php  echo $total[1];?></td>
    <td><?php  echo $total[2];?></td>
  </tr>
  <?
}
?>
</table>
<hr>
<br />
<?
}
echo "</div></div>";
?>

</div>

</div>
</div>

</div>
</div>
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