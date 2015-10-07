<?php
require('../../bootstrap.php');


include("../../menu.php");
?>

<div class="container">

	<div class="page-header">
	  <h2>Jefatura de Estudios <small> Informe de Problemas de Convivencia</small></h2>
	</div>
	
<div class="text-center" id="t_larga_barra">
	<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
</div>
 <div id='t_larga' style='display:none' >
<div>
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Resumen general</a></li>
<li><a href="#tab2" data-toggle="tab">Resumen por Nivel</a></li>
<li><a href="#tab3" data-toggle="tab">Resumen por Grupo</a></li>
<?php
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE)
{
echo '<li><a href="#tab4" data-toggle="tab">Informe por Profesor</a></li>';	
}
?>
<li><a href="#tab5" data-toggle="tab">Informe por Tipo</a></li>
</ul>
<div class="tab-content" style="padding-bottom: 9px;">
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
<?php 
 
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12'  order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03'  order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06'  order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados1 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados2 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados1 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados2 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados3 = mysqli_num_rows($result);
 ?>
 
    <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula1 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula2 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct id from infotut_alumno where month(F_ENTREV) >='09' and month(F_ENTREV) <= '12' order by claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes1 = mysqli_num_rows($result);
 $SQL = "select distinct id from infotut_alumno where month(F_ENTREV) >='01' and month(F_ENTREV) <= '03' order by claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes2 = mysqli_num_rows($result);
 $SQL = "select distinct id from infotut_alumno where month(F_ENTREV) >='04' and month(F_ENTREV) <= '06' order by claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct id from tutoria where month(fecha) >='09' and month(fecha) <= '12' and date(fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones1 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria where month(fecha) >='01' and month(fecha) <= '03' and date(fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones2 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria where month(fecha) >='04' and month(fecha) <= '06' and date(fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct id from tutoria where causa = 'Faltas de Asistencia' and month(fecha) >='09' and month(fecha) <= '12' and date(fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica1 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria where causa = 'Faltas de Asistencia' and month(fecha) >='01' and month(fecha) <= '03' and date(fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica2 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria where causa = 'Faltas de Asistencia' and month(fecha) >='04' and month(fecha) <= '06' and date(fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica3 = mysqli_num_rows($result);
 ?>
 
 <?php  
 //mysqli_query($db_con, "truncate table absentismo");
 for($i=1;$i<13;$i++)
 {
// Creaci�n de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;  
 $SQLTEMP = "create table absentismo$i SELECT claveal, falta, (count(*)) AS numero, unidad FROM FALTAS where falta = 'F' and MONTH(fecha) = '$i' group by claveal";
 $resultTEMP= mysqli_query($db_con, $SQLTEMP);
 mysqli_query($db_con, "insert into absentismo select * from absentismo$i where numero > '25'");
 
 $SQLDEL = "DROP table if exists absentismo$i";
 mysqli_query($db_con, $SQLDEL);
 }
 $faltas = "select distinct claveal from absentismo";
 $faltas0 = mysqli_query($db_con, $faltas);
 $num_faltas = mysqli_num_rows($faltas0);
 ?>
<?php
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
    <td><?php echo $num_faltas; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_conv1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_conv2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_conv3; ?><hr><strong><?php echo $num_conv; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_leves1; ?><br /><span style="color:#abc">2T.</span>  <?php echo $num_leves2; ?><br /><span style="color:#abc">3T.</span>  <?php echo $num_leves3; ?><hr><strong><?php echo $num_leves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_graves1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_graves2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_graves3; ?><hr><strong><?php echo $num_graves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_muygraves1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_muygraves2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_muygraves3; ?><hr><strong><?php echo $num_muygraves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsion1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsion2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsion3; ?><hr><strong><?php echo $num_expulsion; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsados1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsados2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsados3; ?><hr><strong><?php echo $num_expulsados; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsadosaula1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsadosaula2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsadosaula3; ?><hr><strong><?php echo $num_expulsadosaula; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_acciones1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_acciones2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_acciones3; ?><hr><strong><?php echo $num_acciones; ?></td> 
    <td><span style="color:#abc">1T.</span>  <?php echo $num_informes1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_informes2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_informes3; ?><hr><strong><?php echo $num_informes; ?></td>
	<td><span style="color:#abc">1T.</span>  <?php echo $num_comunica1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_comunica2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_comunica3; ?><hr><strong><?php echo $num_comunica; ?></td>
</tr>
 </table>
<hr style="width:950px">


</div>
<div class="tab-pane fade in" id="tab2">


<h3>Informaci�n por Nivel</h3>
<br />
<?php 
 $nivel0 = "select distinct nomcurso from cursos";
 $nivel1 = mysqli_query($db_con, $nivel0);
 while($nivel = mysqli_fetch_array($nivel1))
 {
 $nivel = $nivel[0];
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12'  order by Fechoria.claveal";
 //echo $SQL."<br>";
 $result = mysqli_query($db_con, $SQL);
 $num_conv1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03'  order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06'  order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and nivel = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'leve' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and grave = 'muy grave' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion3 = mysqli_num_rows($result);
 ?>
 
  <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados1 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados2 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados1 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados2 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsion > '0' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados3 = mysqli_num_rows($result);
 ?>
 
    <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula1 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='01' and month(Fechoria.fecha) <= '03' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula2 = mysqli_num_rows($result);
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.curso = '$nivel' and alma.claveal = Fechoria.claveal  and expulsionaula = '1' and month(Fechoria.fecha) >='04' and month(Fechoria.fecha) <= '06' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and month(F_ENTREV) >='09' and month(F_ENTREV) <= '12' order by infotut_alumno.claveal";
 //echo $SQL."<br>";
 $result = mysqli_query($db_con, $SQL);
 $num_informes1 = mysqli_num_rows($result);
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and month(F_ENTREV) >='01' and month(F_ENTREV) <= '03' order by infotut_alumno.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes2 = mysqli_num_rows($result);
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and month(F_ENTREV) >='04' and month(F_ENTREV) <= '06' order by infotut_alumno.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones1 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and month(tutoria.fecha) >='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones2 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and month(tutoria.fecha) >='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones3 = mysqli_num_rows($result);
 ?>
 
   <?php    
 $SQL = "select distinct id from tutoria , alma where alma.claveal=tutoria.claveal and curso = '$nivel' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica1 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica2 = mysqli_num_rows($result);
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica3 = mysqli_num_rows($result);
 ?>
 
 <?php  
 
 $faltas = "select distinct absentismo.claveal from absentismo, alma where alma.claveal=absentismo.claveal and  curso = '$nivel'";
 $faltas0 = mysqli_query($db_con, $faltas);
 $num_faltas = mysqli_num_rows($faltas0);
 ?>

<?php
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
    <td><span class="badge badge-success"><?php echo $nivel; ?></span></td>
    <td><?php echo $num_faltas; ?></td>	
	<td><span style="color:#abc"><span style="color:#abc">1T.</span> </span> <?php echo $num_conv1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_conv2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_conv3; ?><hr><strong><?php echo $num_conv; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_leves1; ?><br /><span style="color:#abc">2T.</span>  <?php echo $num_leves2; ?><br /><span style="color:#abc">3T.</span>  <?php echo $num_leves3; ?><hr><strong><?php echo $num_leves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_graves1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_graves2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_graves3; ?><hr><strong><?php echo $num_graves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_muygraves1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_muygraves2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_muygraves3; ?><hr><strong><?php echo $num_muygraves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsion1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsion2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsion3; ?><hr><strong><?php echo $num_expulsion; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsados1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsados2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsados3; ?><hr><strong><?php echo $num_expulsados; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsadosaula1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsadosaula2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsadosaula3; ?><hr><strong><?php echo $num_expulsadosaula; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_acciones1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_acciones2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_acciones3; ?><hr><strong><?php echo $num_acciones; ?></td> 
    <td><span style="color:#abc">1T.</span>  <?php echo $num_informes1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_informes2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_informes3; ?><hr><strong><?php echo $num_informes; ?></td>
	<td><span style="color:#abc">1T.</span>  <?php echo $num_comunica1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_comunica2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_comunica3; ?><hr><strong><?php echo $num_comunica; ?></td>

</tr>
</table>
<hr>
<br />
<?php } ?>

<hr style="width:950px">


</div>
<div class="tab-pane fade in" id="tab3">


<h3>
 Informaci&oacute;n de los Grupos </h3>
 
<?php
 $cursos0 = "select distinct curso, unidad from alma order by curso";
 $cursos1 = mysqli_query($db_con, $cursos0);
 while($cursos = mysqli_fetch_array($cursos1))
 {
 $nivel = $cursos[0];
 $grupo = $cursos[1];
 $unidad = $cursos[0]."-".$cursos[1];
?> 
 
 <?php 
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_conv3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'leve' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves1 = mysqli_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'leve' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves2 = mysqli_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'leve' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_leves3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves1 = mysqli_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'grave' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves2 = mysqli_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'grave' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_graves3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'muy grave' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves1 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'muy grave' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves2 = mysqli_num_rows($result);
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and grave = 'muy grave' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_muygraves3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion1 = mysqli_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion2 = mysqli_num_rows($result);
$SQL = "select distinct id from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsion3 = mysqli_num_rows($result);
 ?>
  <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados1 = mysqli_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados2 = mysqli_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados3 = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados1 = mysqli_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados2 = mysqli_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsion > '0' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsados3 = mysqli_num_rows($result);
 ?>
    <?php    
 $SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsionaula = '1' and month(Fechoria.fecha) >='09' and month(Fechoria.fecha) <= '12' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula1 = mysqli_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsionaula = '1' and month(Fechoria.fecha)>='01' and month(Fechoria.fecha) <= '03' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula2 = mysqli_num_rows($result);
$SQL = "select distinct Fechoria.claveal from Fechoria, alma where alma.claveal = Fechoria.claveal and curso = '$nivel' and unidad = '$grupo' and expulsionaula = '1' and month(Fechoria.fecha)>='04' and month(Fechoria.fecha) <= '06' and date(Fechoria.fecha) > '".$config['curso_inicio']."' order by Fechoria.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_expulsadosaula3 = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and infotut_alumno.unidad = '$grupo' and month(F_ENTREV) >='09' and month(F_ENTREV) <= '12' and date(F_ENTREV) > '".$config['curso_inicio']."' order by infotut_alumno.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes1 = mysqli_num_rows($result);
$SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and infotut_alumno.unidad = '$grupo' and month(F_ENTREV)>='01' and month(F_ENTREV) <= '03' and date(F_ENTREV) > '".$config['curso_inicio']."' order by infotut_alumno.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes2 = mysqli_num_rows($result);
$SQL = "select distinct id from infotut_alumno, alma where alma.claveal=infotut_alumno.claveal and curso = '$nivel' and infotut_alumno.unidad = '$grupo' and month(F_ENTREV)>='04' and month(F_ENTREV) <= '06' and date(F_ENTREV) > '".$config['curso_inicio']."' order by infotut_alumno.claveal";
 $result = mysqli_query($db_con, $SQL);
 $num_informes3 = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones1 = mysqli_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and month(tutoria.fecha)>='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones2 = mysqli_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and month(tutoria.fecha)>='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_acciones3 = mysqli_num_rows($result);
 ?>
   <?php    
 $SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and causa = 'Faltas de Asistencia' and month(tutoria.fecha) >='09' and month(tutoria.fecha) <= '12' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica1 = mysqli_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and causa = 'Faltas de Asistencia' and month(tutoria.fecha)>='01' and month(tutoria.fecha) <= '03' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica2 = mysqli_num_rows($result);
$SQL = "select distinct id from tutoria, alma where alma.claveal=tutoria.claveal and curso = '$nivel' and tutoria.unidad = '$grupo' and causa = 'Faltas de Asistencia' and month(tutoria.fecha)>='04' and month(tutoria.fecha) <= '06' and date(tutoria.fecha) > '".$config['curso_inicio']."' order by id";
 $result = mysqli_query($db_con, $SQL);
 $num_comunica3 = mysqli_num_rows($result);
 ?>

 <?php  
 $faltas = "select distinct absentismo.claveal from absentismo, alma where alma.claveal=absentismo.claveal and curso = '$nivel' and absentismo.unidad = '$grupo' order by absentismo.claveal";
 $faltas0 = mysqli_query($db_con, $faltas);
 $num_faltas = mysqli_num_rows($faltas0);
 ?>
 <?php
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
<h3 align="center"><span  class="badge badge-info"><?php echo $unidad;?></span></h3><br />
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
    <td><?php echo $num_faltas; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_conv1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_conv2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_conv3; ?><hr><strong><?php echo $num_conv; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_leves1; ?><br /><span style="color:#abc">2T.</span>  <?php echo $num_leves2; ?><br /><span style="color:#abc">3T.</span>  <?php echo $num_leves3; ?><hr><strong><?php echo $num_leves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_graves1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_graves2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_graves3; ?><hr><strong><?php echo $num_graves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_muygraves1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_muygraves2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_muygraves3; ?><hr><strong><?php echo $num_muygraves; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsion1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsion2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsion3; ?><hr><strong><?php echo $num_expulsion; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsados1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsados2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsados3; ?><hr><strong><?php echo $num_expulsados; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_expulsadosaula1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_expulsadosaula2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_expulsadosaula3; ?><hr><strong><?php echo $num_expulsadosaula; ?></td>
    <td><span style="color:#abc">1T.</span>  <?php echo $num_acciones1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_acciones2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_acciones3; ?><hr><strong><?php echo $num_acciones; ?></td> 
    <td><span style="color:#abc">1T.</span>  <?php echo $num_informes1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_informes2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_informes3; ?><hr><strong><?php echo $num_informes; ?></td>
	<td><span style="color:#abc">1T.</span>  <?php echo $num_comunica1; ?><br /><span style="color:#abc">2T.</span> <?php echo $num_comunica2; ?><br /><span style="color:#abc">3T.</span> <?php echo $num_comunica3; ?><hr><strong><?php echo $num_comunica; ?></td>
</tr>
</table>
<hr>

<br /><table class="table table-striped" align="center" style="width:800px">
<tr>
  <th>Tipo de Problema</th>
  <th>N�mero</th>
</tr>
<?php
$tabla = str_replace("-","",$grupo);
$temp = mysqli_query($db_con, "create table $tabla select Fechoria.asunto from Fechoria, alma where Fechoria.claveal = alma.claveal and alma.unidad = '$grupo'"); 
$ini0 = mysqli_query($db_con, "SELECT distinct asunto, COUNT( * ) FROM  `$tabla` group by asunto");
	while ($ini = mysqli_fetch_array($ini0)){
?>
<tr>
  <td><?php  echo $ini[0];?></td>
  <td><?php  echo $ini[1];?></td>
</tr>
<?php
 }
 $borra_temp = mysqli_query($db_con, "drop table $tabla");
 echo "</tbody>
</table>";
 echo '<hr style="width:800px">
<br />';
  }
  ?>
 </div>
<?php
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE)
{
?>
<div class="tab-pane fade in" id="tab4">
<h3>Informe por Profesor</h3><br />
<div class="row">
<?php 

if (file_exists(INTRANET_DIRECTORY . '/config_datos.php')) {
	if (!empty($c_escolar) && ($c_escolar != $config['curso_actual'])) {
		$exp_c_escolar = explode("/", $c_escolar);
		$anio_escolar = $exp_c_escolar[0];
		
		$db_con = mysqli_connect($config['db_host_c'.$anio_escolar], $config['db_user_c'.$anio_escolar], $config['db_pass_c'.$anio_escolar], $config['db_name_c'.$anio_escolar]);
	}
	if (empty($c_escolar)){
		$c_escolar = $config['curso_actual'];
	}
}
else {
	$c_escolar = $config['curso_actual'];
}

$cur = substr($config['curso_inicio'],0,4);
for ($i = 3; $i >= 0; $i--)
{
	$anio_escolar = $cur-$i;
	$haydatos = 0;
	
	if($i > 0 && ! empty($config['db_host_c'.$anio_escolar])) {
		$db_con = mysqli_connect($config['db_host_c'.$anio_escolar], $config['db_user_c'.$anio_escolar], $config['db_pass_c'.$anio_escolar], $config['db_name_c'.$anio_escolar]);
		$haydatos = 1;
	}
	
	if ($i == 0) {
		$db_con = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']) or die('error');
		$haydatos = 1;
	}
	
	
	if($haydatos && stristr($_SESSION['cargo'],'1') == TRUE)
{
?>
<div class="col-sm-4">
<h4 class="text-info">Curso <?php echo $anio_escolar; echo "-".($anio_escolar+1);?></h4>
<br />
<table class="table table-bordered table-striped table-hover">
<thead>
<tr>
<th>Profesor</th><th width="62">N�mero</th>
</tr>
</thead>
<tbody>

  <?php 
$tot0 = '';
$tot1 = mysqli_query($db_con, "create table fech_temp select informa, count(*) as numeros from Fechoria group by informa");
$tot0 = mysqli_query($db_con, "select informa, numeros from fech_temp order by numeros desc");
while ($total0 = mysqli_fetch_array($tot0)){
?>
  <tr>
    <td><?php  echo nomprofesor($total0[0]);?></td>
      <td>
    <?php  echo $total0[1];?>
      </td>
  </tr>
  <?php
}
?>
</tbody>
</table>
</div>
<?php
mysqli_query($db_con, "drop table fech_temp");
}
}
?>
</div>
</div>
<?php
}
?>
<div class="tab-pane fade in" id="tab5">
<h3>Informe por Tipo de problema</h3><br />
<?php
if (file_exists(INTRANET_DIRECTORY . '/config_datos.php')) {
	if (!empty($c_escolar) && ($c_escolar != $config['curso_actual'])) {
		$exp_c_escolar = explode("/", $c_escolar);
		$anio_escolar = $exp_c_escolar[0];
		
		$db_con = mysqli_connect($config['db_host_c'.$anio_escolar], $config['db_user_c'.$anio_escolar], $config['db_pass_c'.$anio_escolar], $config['db_name_c'.$anio_escolar]);
	}
	if (empty($c_escolar)){
		$c_escolar = $config['curso_actual'];
	}
}
else {
	$c_escolar = $config['curso_actual'];
}

$cur = substr($config['curso_inicio'],0,4);
for ($i = 0; $i <= 3; $i++)
{
	$anio_escolar = $cur-$i;
	$haydatos = 0;
	
	if($i > 0 && ! empty($config['db_host_c'.$anio_escolar])) {
		$db_con = mysqli_connect($config['db_host_c'.$anio_escolar], $config['db_user_c'.$anio_escolar], $config['db_pass_c'.$anio_escolar], $config['db_name_c'.$anio_escolar]);
		$haydatos = 1;
	}
	
	if ($i == 0) {
		$db_con = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']) or die('error');
		$haydatos = 1;
	}
	
	if($haydatos) {
?>

<h4 class="text-info">Problemas de Convivencia en el Curso <?php echo $anio_escolar; echo "-".($anio_escolar+1);?></h4>
<br />

<table class="table table-bordered table-striped table-hover">
  <thead>
  <tr>
    <th>Tipo de Problema</th>
    <th width="62">N�mero</th>
    <th width="72">Gravedad</th>
  </tr>
  </thead>
  <tbody>
  <?php 
$tot = '';
$tot = mysqli_query($db_con, "select asunto, count(*), grave from Fechoria group by grave, asunto");
while ($total = mysqli_fetch_array($tot)){
?>
  <tr>
    <td><?php  echo $total[0];?></td>
    <td ><?php  echo $total[1];?></td>
    <td><?php  echo $total[2];?></td>
  </tr>
  <?php
}
?>
</table>
<br />
<?php
}
}
?>
</div>
</div>

</div>
</div>

</div>
</div>
<?php include("../../pie.php");?>
 <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>  
</body>
</html>