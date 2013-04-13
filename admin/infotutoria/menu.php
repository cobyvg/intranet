   
    <div class="container">  
    
    <div class="navbar navbar-fixed-top no_imprimir visible-phone visible-tablet">
  <div class="navbar-inner2">
    <div class="container-fluid">
    <div class="convive">
      <a class="btn btn-default" data-toggle="collapse" data-target=".convive .nav-collapse" style="float:right">
        <span class="icon-list"></span>
      </a>
      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php" style="color:#2c2c2c">Informes de Tutoría</a>
      <div id="convive" class="nav-collapse collapse">
        <ul class="nav nav-pills">
 <li> <a href="index.php">Página de Informes de Tutoría</a></li>
<?
if(stristr($_SESSION ['cargo'],'2') == TRUE or stristr($_SESSION ['cargo'],'1') == TRUE)
{
	if(stristr($_SESSION ['cargo'],'2') == TRUE){
	$tutor = $_SESSION ['tut'];
}
?>
<li><a href="infotut.php?nivel=<? echo  $_SESSION ['s_nivel'];?>&grupo=<? echo $_SESSION ['s_grupo'];?>&tutor=<? echo $tutor;?>">Activar Nuevo Informe</a></li>
     <? }?>
     <li> <a href="buscar.php?todos=1">Ver Todos los Informes</a></li>
     <li> <a href="index_buscar.php">Buscar Informes</a></li>
     <?
     if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
     <li> <a href="control.php">Control de Informes</a></li>
     <? }?>
    </ul>
      </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
</div>

        <div class="subnav subnav-fixed hidden-phone hidden-tablet">
          <ul class="nav nav-pills">
 <li> <a href="index.php">Página de Informes de Tutoría</a></li>
<?
if(stristr($_SESSION ['cargo'],'2') == TRUE or stristr($_SESSION ['cargo'],'1') == TRUE)
{
	if(stristr($_SESSION ['cargo'],'2') == TRUE){
	$tutor = $_SESSION ['tut'];
}
?>
     <li><a href="infotut.php?nivel=<? echo  $_SESSION ['s_nivel'];?>&grupo=<? echo $_SESSION ['s_grupo'];?>&tutor=<? echo $tutor;?>">Activar Nuevo Informe</a></li>
     <? }?>
     <li> <a href="buscar.php?todos=1">Ver Todos los Informes</a></li>
     <li> <a href="index_buscar.php">Buscar Informes</a></li>
     <?
     if(stristr($_SESSION ['cargo'],'1') == TRUE){?>
     <li> <a href="control.php">Control de Informes</a></li>
     <? }?>
    </ul>
        </div>
        </div>
