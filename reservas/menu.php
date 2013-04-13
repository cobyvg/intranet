
    <div class="container">  
    
    <div class="navbar navbar-fixed-top no_imprimir visible-phone visible-tablet">
  <div class="navbar-inner2">
    <div class="container-fluid">
    <div class="convive">
      <a class="btn btn-default" data-toggle="collapse" data-target=".convive .nav-collapse" style="float:right">
        <span class="icon-list"></span>
      </a>
      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php" style="color:#2c2c2c">Reservas de Aulas y Medios Audiovisuales</a>
      <div id="convive" class="nav-collapse collapse">
        <ul class="nav nav-pills">
<li><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=aula">Aulas Compartidas</a></li>
<?
if ($mod_horario=="1") {
?>
    <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index_aula_grupo.php?recurso=aula_grupo">Aulas de Grupo</a></li>
<?
}
?>
       <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=carrito">Carritos de
      Port&aacute;tiles</a></li>
    <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=medio">Videoproyectores,
            Port&aacute;tiles</a></li>
    </ul>
      </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
</div>

        <div class="subnav subnav-fixed hidden-phone hidden-tablet">
          <ul class="nav nav-pills">
<li><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=aula">Aulas compartidas</a></li>
    <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index_aula_grupo.php?recurso=aula_grupo">Aulas de Grupo</a></li>
    <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=carrito">Carritos de
      Port&aacute;tiles</a></li>
    <li><a href="http://<? echo $dominio; ?>/intranet/reservas/index.php?recurso=medio">Videoproyectores,
            Port&aacute;tiles</a></li>
    </ul>
        </div>
        </div>