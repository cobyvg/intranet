         <!-- Navbar
    ================================================== -->

    <div class="container">  
    
    <div class="navbar navbar-fixed-top no_imprimir visible-phone visible-tablet">
  <div class="navbar-inner2">
    <div class="container-fluid">
    <div class="convive">
      <a class="btn btn-default" data-toggle="collapse" data-target=".convive .nav-collapse" style="float:right">
        <span class="icon-list"></span>
      </a>
      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php" style="color:#2c2c2c">Act. Complementarias y Extraescolares</a>
      <div id="convive" class="nav-collapse collapse">
        <ul class="nav nav-pills">
<?

if (stristr ( $_SESSION ['cargo'], '5' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
	?>
    
       <li><a href="indexextra.php">Administrar Actividades</a></li>
 <?
}
?>
       <li><a href="index.php">Introducir Nueva Actividad</a></li>
      <li><a href="consulta.php">Lista de Actividades</a></li>
          
          <form method="post" action="consulta.php" class="form-search" style="margin-top:5px;">
<input type="text" name="expresion" id="exp" class="search-query" />
<button type="submit" class="btn btn-primary"> <i class="icon icon-white icon-search"> </i> Buscar actividades</button>
    </form>
    </ul>
      </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
</div>

        <div class="subnav subnav-fixed hidden-phone hidden-tablet">
          <ul class="nav nav-pills">
<?

if (stristr ( $_SESSION ['cargo'], '5' ) == TRUE or stristr ( $_SESSION ['cargo'], '1' ) == TRUE) {
	?>
    
       <li><a href="indexextra.php">Administrar Actividades</a></li>
 <?
}
?>
       <li><a href="index.php">Introducir Nueva Actividad</a></li>
      <li><a href="consulta.php">Lista de Actividades</a></li>
          
          <form method="post" action="consulta.php" class="form-search" style="margin-top:5px;">
<input type="text" name="expresion" id="exp" class="search-query" />
<button type="submit" class="btn btn-primary"> <i class="icon icon-white icon-search"> </i> Buscar actividades</button>
    </form>
    </ul>
        </div>
        </div>
            <h2 align="center" class="hidden-phone hidden-tablet">Actividades Complementarias y Extraescolares</h2>
<br />