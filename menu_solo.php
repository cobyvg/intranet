<?
include ("funciones.php");
$idea = $_SESSION ['ide'];
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activo3 = ' class="active" ';}
?>
  <!-- Navbar
		    ================================================== -->
		<div class="navbar navbar-fixed-top navbar-inverse no_imprimir">
		  <div class="navbar-inner">
		    <div class="container-fluid">
		      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		        <span class="fa fa-bars"></span>
		      </a>
		      <a class="brand" href="http://<? echo $dominio;?>/intranet/index.php">Intranet del <?php echo $nombre_del_centro; ?></a>
		      <div class="nav-collapse collapse">
		        <ul class="nav">
		          <li <? echo $activo1;?>><a href="http://<? echo $dominio;?>/intranet/index.php">Inicio</a></li>
		          <li<? echo $activo2;?>><a href="http://<? echo $dominio;	?>/intranet/admin/mensajes/">Mensajes</a></li>
		          <li<? echo $activo3;?>><a href="http://<? echo $dominio;	?>/intranet/upload/">Documentos</a></li>
		          <li><a href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio" target="_blank">S&eacute;neca</a></li>
		        </ul>
		        
		        <ul class="nav pull-right">
		       
		        	<li class="dropdown">
		        		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		        			<i class="fa fa-user "></i> <? echo $idea; ?> <b class="caret"></b>
		        		</a>
		        		<ul class="dropdown-menu">
		        			<li><a href="http://<? echo $dominio; ?>/intranet/clave.php"><i class="fa fa-pencil-square-o"></i> Cambiar contrase&ntilde;a</a></li>
		        			<li class="divider"></li>
		        			<li><a href="http://<? echo $dominio;?>/intranet/salir.php"><i class="fa fa-sign-out"></i> Cerrar sesi&oacute;n</a></li>
		        		</ul>
		        	</li>
					<li style="margin-top:4px;margin-left:15px;"><small style='color:#d9d9d9;'><i class="fa fa-clock-o fa-lg"></i>&Uacute;ltima conexi&oacute;n: <br />
            <?
$time = mysql_query("select fecha from reg_intranet where profesor = '".$_SESSION['profi']."' order by fecha desc limit 2");
while($last = mysql_fetch_array($time)){
	$num+=1;
if ($num==2) {
	$t_r0 = explode(" ",$last[0]) ;
	$dia_hora = cambia_fecha($t_r0[0]);
	echo "$dia_hora &nbsp; $t_r0[1]";
}
}
            ?>
            </small></li>
		        </ul>
		        
		      </div>
		      </div>
		    </div>
		  </div>
