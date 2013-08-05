<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet &middot; <? echo $nombre_del_centro; ?></title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del <? echo $nombre_del_centro; ?>">  
    <meta name="author" content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">
      
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">
    
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <!--[if IE 7]>
      <link href="http://<? echo $dominio;?>/intranet/css/font-awesome-ie7.min.css" rel="stylesheet">
    <![endif]-->
    
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <script type="text/javascript" src="http://<? echo $dominio;?>/intranet/js/buscarAlumnos.js"></script>                 
</head>

<body>
  
<?
include ("funciones.php");
$idea = $_SESSION ['ide'];
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index0.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activo3 = ' class="active" ';}
?>
		  <!-- Navbar
		    ================================================== -->
		<div class="navbar navbar-fixed-top navbar-inverse no_imprimir">
		  <div class="navbar-inner">
		    <div class="container-fluid">
		      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </a>
		      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php">Intranet del <?php echo $nombre_del_centro; ?></a>
		      <div class="nav-collapse collapse">
		        <ul class="nav">
		          <li <? echo $activo1;?>><a href="http://<? echo $dominio;?>/intranet/index0.php">Inicio</a></li>
		          <li><a href="http://<? echo $dominio;	?>">Página del centro</a></li>
		          <li<? echo $activo2;?>><a href="http://<? echo $dominio;	?>/intranet/admin/mensajes/">Mensajes</a></li>
		          <li<? echo $activo3;?>><a href="http://<? echo $dominio;	?>/intranet/upload/">Documentos</a></li>
		          <li><a href="https://www.juntadeandalucia.es/educacion/seneca/" target="_blank">Séneca</a></li>
		        </ul>
		        
		        <ul class="nav pull-right">
		        	<li class="dropdown">
		        		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		        			<i class="icon-user icon-white"></i> <? echo $idea; ?> <b class="caret"></b>
		        		</a>
		        		<ul class="dropdown-menu">
		        			<li><a href="http://<? echo $dominio; ?>/intranet/clave.php"><i class="icon-edit"></i> Cambiar contraseña</a></li>
		        			<li class="divider"></li>
		        			<li><a href="http://<? echo $dominio;?>/intranet/salir.php"><i class="icon-off"></i> Cerrar sesión</a></li>
		        		</ul>
		        	</li>
		        </ul>
		      </div>
		      </div>
		    </div>
		  </div>
		</div>
    </div>
  </div>
</div>
