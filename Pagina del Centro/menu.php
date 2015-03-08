<div class="span3">    
<div class="well well-large">
<li class="nav-header">Páginas del Centro<i class="icon icon-list icon-large pull-right"> </i></li>
<hr />
<ul class="nav nav-list"> 
<li><a href="http://<? echo $dominio;?>index.php"><i class="icon icon-home icon-large"> </i> Inicio</a></li>
<li><a data-toggle="collapse" data-target="#instituto" style="cursor:pointer"> <i class="icon icon-sitemap icon-large"> </i>Instituto <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="instituto" class="collapse">
  <ul class="nav nav-list">				
    <li><a  href="http://<? echo $dominio;?>direccion/">Direcci&oacute;n</a></li>
    <li><a  href="http://<? echo $dominio;?>departamentos/" target="_self">Departamentos</a></li>
    <li><a  href="http://<? echo $dominio;?>calendario/calendario_escolar.php" target="_blank">Calendario Escolar</a></li>
	<li><a  href="http://<? echo $dominio;?>actividades">Actividades</a></li>
    <?
if ($monterroso=="1") {
?>
    <li><a  href="http://<? echo $dominio;?>ampa">A.M.P.A.</a></li>
<?
}
?>    
</ul>
</div>
<li><a data-toggle="collapse" data-target="#estudios" style="cursor:pointer"><i class="icon icon-book icon-large"> </i> Estudios <i class="icon-chevron-down pull-right"> </i> </a></li>

<div id="estudios" class="collapse">
  <ul class="nav nav-list">
	<li> <a  href="http://<? echo $dominio;?>cursos/index.php?tab=1">Educación Secundaria</a></li>
    <li><a  href="http://<? echo $dominio;?>cursos/index.php?tab=2">Bachillerato</a></li>
    <li><a  href="http://<? echo $dominio;?>cursos/index.php?tab=3">Ciclo de Turismo</a></li>
    <li><a  href="http://<? echo $dominio;?>cursos/index.php?tab=4">Ciclo Sociosanitario</a></li>
    <li><a  href="http://<? echo $dominio;?>cursos/index.php?tab=5">PCPI</a></li>
    <li><a  href="http://<? echo $dominio;?>textos/index.php">Libros de Texto</a></li>
</ul>
</div>

<li><a data-toggle="collapse" data-target="#documentos" style="cursor:pointer"><i class="icon icon-edit icon-large"> </i> Documentos <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="documentos" class="collapse">
  <ul class="nav nav-list">	
    <li <? echo $activo3;?>><a href="http://<? echo $dominio;?>doc">Directorio de Documentos</a></li>
    <?
if ($monterroso=="1") {
?>
	<li><a href="http://<? echo $dominio;?>PC/index.htm">Plan de Centro</a></li> 

<?
}
?>    			
 </ul>
</div>

<li><a data-toggle="collapse" data-target="#otrascosas" style="cursor:pointer"><i class="icon icon-plus-sign icon-large"> </i> Otras cosas... <i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="otrascosas" class="collapse">
  <ul class="nav nav-list">
  <?
if ($monterroso=="1") {
?>
   <li><a  href="http://<? echo $dominio;?>reportajes/">Reportajes</a></li>
<?
}
?> 
<?
if ($mod_fotos=="1") {
?>
   <li><a  href="http://<? echo $dominio;?>reportajes/fotosies/index.php">Fotos del Centro</a></li>
<?
}
?> 
<?
if ($mod_biblio=="1") {
?>
   <li><a href="http://<? echo $dominio;?>biblioteca/">Fondos de la Biblioteca</a></li>				
<?
}
?>  
  <?
if ($monterroso=="1") {
?>
    <li><a  href="http://<? echo $dominio;?>situa/index.php">Situaci&oacute;n del IES</a></li>
<?
}
?>  
    <li><a href="http://iesmonterroso.org/intranet_ies/">Intranet del Centro</a></li>	
   
</ul>
</div>

<li><a data-toggle="collapse" data-target="#enlaces" style="cursor:pointer"><i class="icon icon-bookmark icon-large"> </i> Enlaces<i class="icon-chevron-down pull-right"> </i> </a></li>
<div id="enlaces" class="collapse">
  <ul class="nav nav-list">				
	<li><a  href="http://www.juntadeandalucia.es/educacion">Consejería</a></li>
	<li><a  href="http://www.juntadeandalucia.es/averroes/">Averroes</a></li>
    <li><a  href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio">S&eacute;neca</a></li>
    <li><a  href="http://www.mec.es/">M.E.C.</a></li>
    <li><a  href="http://wwwn.mec.es/mecd/becas/index.html">Becas M.E.C.</a></li>
    <li><a  href="http://www.cep-marbellacoin.org/">C.E.P. Marbella</a></li>
    <li><a  href="http://www.seg-social.es/inicio/?MIval=cw_usr_view_Folder&amp;LANG=1&amp;ID=28622">Seguro
        Escolar</a></li>
    <li><a  href="http://www.ujaen.es/serv/vicest/acceso2/">Selectividad</a></li>
</ul>
</div>
 </ul>
</div>
<?
include('calendario/index.php');
?>
</div>