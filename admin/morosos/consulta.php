<?php

if ($submit2)
{
	include("lpdf.php");
	//echo $fecha;
}
else
{
	?>
	<?
	session_start();
	include("../../config.php");
	registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
	if((!(stristr($_SESSION['cargo'],'1') == TRUE)) and (!(stristr($_SESSION['cargo'],'c') == TRUE)) )
	{
		header("location:http://$dominio/intranet/salir.php");
		exit;
	}
	?>
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.css" rel="stylesheet"> 
    <?php
    	if($_SERVER ['REQUEST_URI'] == "/intranet/index0.php"){
    ?>
    	<link href="http://<? echo $dominio;?>/intranet/css/otros_index.css" rel="stylesheet">
    <?php 
    	} else {
	?>
    	<link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <?php
    }
    ?>
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <link href="http://<? echo $dominio;?>/intranet/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css">          
   
    
    <!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->  
    <script>
    function selectall(form)  
    {  
     var formulario = eval(form)  
     for (var i=0, len=formulario.elements.length; i<len ; i++)  
      {  
        if ( formulario.elements[i].type == "checkbox" )  
          formulario.elements[i].checked = formulario.elements[0].checked  
      }  
    }  
    </script>  
</head>

<body>
  
<?
//include ("funciones.php");
$idea = $_SESSION ['ide'];
if (strstr($_SERVER['REQUEST_URI'],'index0.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activo2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activo3 = ' class="active" ';}
?>
  <!-- Navbar
    ================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top no_imprimir">
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
          <li><a href="https://www.juntadeandalucia.es/educacion/seneca/" style="color:#51a351" target="_blank">Séneca</a></li>
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
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

	<?
	
$datatables_activado = true;
	if($submit1){
		?>
<div align="center">
<div class="page-header" style="margin-top:-15px;" align="center">
  <h1>Biblioteca <small> Consulta</small></h1>
<p class="lead muted">Fecha elegida: <? echo $fecha;?></small></p>
</div>
<div class='container-fluid'>
  <div class="row-fluid">
  <div class="span8 offset2">
<form name="form" action="edicion.php" method="post">
<table class='table table-striped tabladatos' style='width: 100%;'>
<thead>
	<tr>
		<th><input type="checkbox" onClick="selectall(form)" /></th>
		<th>Grupo </th>
		<th>Alumno </th>
		<th>Título </th>
		<th width="90">Fecha dev. </th>
		<th> </th>
	</tr>
	</thead><tbody>
	<?
	$fecha_act = date('Y-m-d');
	$lista=mysql_query("select curso, apellidos, nombre, ejemplar, devolucion, amonestacion, id, sms from morosos where hoy='$fecha' and devolucion<'$fecha_act'  order by curso, apellidos asc");

	$n=0;
	while ($list=mysql_fetch_array($lista)){
	?>
	<tr>
	<? 
	if ($list[5]=='NO') { 
		$n+=1   
	?>
		<td style="text-align: center"><input type="checkbox" name="id[]"
			value="<? echo $list[6] ;?>" /></td>
		<td style="text-align: center"><? echo $list[0];   ?></td>
		<td><? echo $list[1].', '.$list[2];   ?></td>
		<td><? echo $list[3];   ?></td>
		<td style="text-align: center"><? echo $list[4];   ?></td>
		<td style="text-align: left" nowrap><i class="icon-remove-sign" style="margin-left:15px;"></i>
		<?
		if ($list[7] == "SI") {
			echo '<i class="icon-comment" style="margin-left:6px;" rel="tooltip" title="Se ha enviado SMS de advertencia"></i>';
		}
		?>
		</td>
			<? }
			else {?>
		<td style="text-align: center"></td>
		<td style="text-align: center"><? echo $list[0];   ?></td>
		<td><? echo $list[1].', '.$list[2];   ?></td>
		<td><? echo $list[3];   ?></td>
		<td style="text-align: center"><? echo $list[4];   ?></td>
		<td style="text-align: center"><i class="icon-ok"></i></td>

		<? } ?>
	</tr>
	<?	}

	?>
</tbody></table>

	<? if($n==0){?>
	<br /><br />
<div align="center">
<div class="alert alert-info alert-block fade in"
	style="max-width: 500px;">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<h5>ATENCIÓN:</h5>
Todos los alumnos de esta lista han sido registrados. Ahora sólo podrás
consultarla.</div>
</div>
	<? }
	else {?>
<hr>
<button class="btn btn-danger" type="submit" name="borrar" value="Borrar"><i class="icon-trash icon-white"></i> Borrar</button>
&nbsp;&nbsp; &nbsp;&nbsp;
<button class="btn btn-info" type="submit" name="sms" value="sms"><i class="icon-play-circle icon-white"></i> Enviar SMS</button>
&nbsp;&nbsp; &nbsp;&nbsp;
<button class="btn btn-warning" type="submit" name="registro" value="registro"><i class="icon-play-circle icon-white"></i> Registrar Amonestaciones</button>

	<? } ?></form>

<form action="consulta.php"
	method="POST" name="listas" class="form-inline">
<input type="hidden" name="fecha" value="<? echo $fecha; ?>" />
<input type="hidden" name="fecha_act" value="<? echo $fecha_act; ?>" />
<button class="btn btn-success" type="submit" name="submit2"
	value="Lista del Curso"><i class="icon-file  icon-white"></i> Listado
en pdf</button>
</form>
	<? }  ?> 
	<? }  ?> 
	<? include("../../pie.php");?>
</body>

</html>
