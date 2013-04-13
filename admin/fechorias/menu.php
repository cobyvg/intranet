         <!-- Navbar
    ================================================== -->
    
    <div class="navbar navbar-fixed-top no_imprimir visible-phone visible-tablet">
  <div class="navbar-inner2">
    <div class="container-fluid">
    <div class="convive">
      <a class="btn btn-default" data-toggle="collapse" data-target=".convive .nav-collapse" style="float:right">
        <span class="icon-list"></span>
      </a>
      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php" style="color:#2c2c2c">Problemas de Convivencia</a>
      <div id="convive" class="nav-collapse collapse">
        <ul class="nav nav-pills">

     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/cfechorias.php">
      Consultar Problemas</a></li>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/infechoria.php">
      Registrar Problema</a></li>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/lfechorias.php">
      Últimos Problemas</a></li>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/expulsados.php">
      Alumnos expulsados</a></li>
      <?
      $pr_conv = $_SESSION['profi'];
$conv = mysql_query("select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr_conv'");
// echo "select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr'";
if (mysql_num_rows($conv) > '0') {
?>
      <li><a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/convivencia.php">Aula de Convivencia</a></li>  
<?
}
      ?>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/lfechorias3.php">
      Ranking</a></li>
      
<?   
if(stristr($_SESSION['cargo'],'1') == TRUE){
?>
      <li><a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/convivencia_jefes.php">Aula de Convivencia</a></li>
<?
}
?>           
  
    </ul>
      </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
</div>

        <div class="subnav subnav-fixed hidden-phone hidden-tablet">
          <ul class="nav nav-pills">

     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/cfechorias.php">
      Consultar Problemas</a></li>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/infechoria.php">
      Registrar Problema</a></li>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/lfechorias.php">
      Últimos Problemas</a></li>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/expulsados.php">
      Alumnos expulsados</a></li>
      <?
      $pr_conv = $_SESSION['profi'];
$conv = mysql_query("select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr_conv'");
// echo "select distinct prof from horw where a_asig = 'GUCON' and prof = '$pr'";
if (mysql_num_rows($conv) > '0') {
?>
      <li><a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/convivencia.php">Aula de Convivencia</a></li>  
<?
}
      ?>
     <li> <a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/lfechorias3.php">
      Ranking</a></li>
      
<?   
if(stristr($_SESSION['cargo'],'1') == TRUE){
?>
      <li><a href="http://<? echo $dominio; ?>/intranet/admin/fechorias/convivencia_jefes.php">Aula de Convivencia</a></li>
<?
}
?>           
  
    </ul>
        </div>
        </div>

