<? include("../conf_principal.php");?>
<!DOCTYPE html>
<html>
  <head>
    <title><? echo $nombre_del_centro;?>
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META name="Author" content="Miguel A. García">
    <META name="keywords" content="insituto,<? echo $nombre_del_centro;?>,andalucia,linux,smeserver,tic">
<title>Páginas del I.E.S. Monterroso</title>
<link rel="stylesheet" href="http://<? echo $dominio;?>css/<? echo $css_estilo; ?>">
<link rel="stylesheet" href="http://<? echo $dominio;?>css/bootstrap_personal.css">
<link href="http://<? echo $dominio;?>css/bootstrap-responsive.min.css" rel="stylesheet"> 
<link rel="stylesheet" href="http://<? echo $dominio;?>font-awesome/css/font-awesome.min.css">
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAGhS4NMgZnzVqQBhZMrJY0hSH3rr1H8yk0AE_hM_iK-sIudzcBBSXK0kjCeNN0-XvvFvtqDfoyqYSAw" type="text/javascript"></script>
  <script type="text/javascript">

    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(36.427964,-5.153403), 15);
		map.setMapType(G_NORMAL_MAP);
		map.addControl(new GMapTypeControl()); 
      map.addControl(new GSmallZoomControl());
      map.addControl(new GScaleControl());
	  
	   var point = new GPoint (-5.154600, 36.429800);
      var marker = new GMarker(point);
      map.addOverlay(marker); 

		}
		}
    //]]>
    </script>
</head>
<body onLoad="load()">
<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
elseif (strstr($_SERVER['REQUEST_URI'],'notas')==TRUE){ $activo2 = ' class="active" ';}
elseif (strstr($_SERVER['REQUEST_URI'],'doc')==TRUE){ $activo3 = ' class="active" ';}
include("conf_principal.php");
?>
<div class="navbar">
  <div class="navbar-inner" style="padding-left:0px">
      <img src="http://<? echo $dominio;?>logo.gif" class="img-polaroid img-rounded pull-left"  width="60" style="margin-right:30px;margin-left:0px;padding:3px;background-color:#fafafa"/>
		    <div class="container-fluid">
		      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </a>
		      <a class="brand" href="http://<? echo $dominio;?>"><? echo $nombre_del_centro;?></a>
		      <div class="nav-collapse collapse">
		        <ul class="nav">
  		  <li <? echo $activo1;?>> <a href="http://<? echo $dominio;?>index.php">Inicio</a></li>
          <li <? echo $activo2;?>><a href="http://<? echo $dominio;?>notas/">Acceso para Alumnos</a></li>
          <li <? echo $activo3;?>><a href="http://<? echo $dominio;?>doc">Documentos</a></li>
 		  <? if ($moodle==1) { ?>
 		  <li><a href="<? echo $enlace_moodle; ?>">Moodle</a></li>
 		  <? } ?>
		        </ul>
                      <form class="form-search navbar-search pull-right"  action="http://www.google.com/custom" method="get">
    <input type="hidden" name="sitesearch" value="<? echo $dominio;?>" checked="checked" />                 
    <input type="hidden" name="cof" value="S:http://<? echo $dominio;?>;AH:center;L:ies.gif;AWFID:12e022daa787c23d;" />
    <input type="hidden" name="domains" value="<? echo $dominio;?>" />
      	<div class="input-append">
    <input type="text" class="search-query span2" placeholder="Buscar en <? echo $nombre_del_centro;?>" name="q" onClick="this.value=''">
    <button type="submit" class="btn btn-success"><i class="icon icon-search"></i></button>
  		</div>    
</form>
		      </div>
		      </div>
		    </div>
		  </div>
		</div>
    </div>
  </div>
</div>


<div class="container-fluid">
<div class="row-fluid">

		      <br><h3 align="center"><i class='icon icon-map-marker'> </i> Localización del Centro en Estepona </h3><hr />

<div class="span6 offset1">		           
	
	      <div id="map" style="width: 650px; height: 500px; border:1px solid #ccc"></div>
	      
	      
	      
</div>
<div class="span4">		           
<div class="well well-large">
<p class="lead muted">Cómo llegar...</p>
	        <p class="text-info">
	            Hay tres Institutos en Estepona: <strong>IES Albor&aacute;n</strong>, <strong>IES Mediterr&aacute;neo</strong> e <strong>IES Monterroso</strong>. Dependiendo del lugar desde el que llegas, tienes varias posibilidades.            </p>
	        <p class="text-info"> Si
		          te encuentras <strong>dentro de Estepona</strong>, en el Centro o en el
		          Paseo Mar&iacute;timo, el Instituto se halla junto al Campo de Futbol,
		          al final y a la derecha de la <strong>Avda. Juan Carlos</strong> (la calle
		          donde est&aacute;n los juzgados, el Centro de Salud, el Colegio P&uacute;blico
            Ram&oacute;n Garc&iacute;a, etc.) </p> 
	        <p class="text-info">Si llegas desde <strong>fuera
		          de la localidad</strong>, hay que dejar la autov&iacute;a o autopista por
		          la <strong>salida 155</strong>, que desemboca en una gran
            rotonda en la <strong>Avda. Juan Carlos</strong>. El
		          Instituto es un edificio blanco que, por ahora, se ve desde la rotonda
		          mirando hacia el Este.<br />
            </p> 
</div>
</div>
</div>

