<?
$activo1="";
$activo2="";
$activo3="";
$activo4="";
$activo5="";
$activo6="";
$activo7="";
if (strstr($_SERVER['REQUEST_URI'],'cfechorias.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'infechoria.php')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'lfechorias.php')==TRUE){ $activo3 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'expulsados.php')==TRUE){ $activo4 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'convivencia.php')==TRUE){ $activo5 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'lfechorias3.php')==TRUE){ $activo6 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'convivencia_jefes.php')==TRUE){ $activo7 = ' class="active" ';}
?>
        <div class="container">
        <div class="tabbable">
          <ul class="nav nav-tabs">

     <li <? echo $activo1;?>> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/cfechorias.php">
      Consultar Problemas</a></li>
     <li <? echo $activo2;?>> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/infechoria.php">
      Registrar Problema</a></li>
     <li <? echo $activo3;?>> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/lfechorias.php">
      Últimos Problemas</a></li>
     <li <? echo $activo4;?>> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/expulsados.php">
      Alumnos expulsados</a></li>
      <?
      $pr_conv = $_SESSION['profi'];
	$conv = mysqli_query($db_con, "SELECT DISTINCT nombre FROM departamentos WHERE cargo like '%b%' AND nombre = '$pr_conv'");
// echo "select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr'";
if (mysqli_num_rows($conv) > '0') {
?>
      <li <? echo $activo5;?>><a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/convivencia.php">Aula de Convivencia</a></li>  
<?
}
      ?>
     <li <? echo $activo6;?>> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/lfechorias3.php">
      Ranking</a></li>
      
<?   
if(stristr($_SESSION['cargo'],'1') == TRUE){
?>
      <li <? echo $activo7;?>><a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/convivencia_jefes.php">Aula de Convivencia</a></li>
<?
}
?>           
  
    </ul>
        </div>
        </div>

