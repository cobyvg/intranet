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
      <a class="brand" href="http://<? echo $dominio;?>/intranet/index0.php" style="color:#2c2c2c">Faltas de asistencia</a>
      <div id="convive" class="nav-collapse collapse">
        <ul class="nav nav-pills">
          
         <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
// Comprobamos si existe la tabla de festivos
$registrada='0';
$fest0 = mysql_query("show tables from $db");
while ($fest = mysql_fetch_array($fest0)) {
	if ($fest[0]=='festivos') {
		$registrada='1';
	}
}
if ($registrada=='1') {} else{
	mysql_query("CREATE TABLE `festivos` (
  `fecha` date NOT NULL default '0000-00-00',
  `nombre` varchar(64) NOT NULL default '',
  `docentes` char(2) NOT NULL default '',
  `ambito` varchar(10) NOT NULL default '',
  KEY `fecha` (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1");
} 
	  }
	  ?>  
         <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
$repe0=mysql_query("select fecha from festivos");		
if (mysql_num_rows($repe0)<'1') {
  	$festivos='actualizar';
	  ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/index_festivos.php">
     Importar Días festivos</a></li>  
	  <? 
  }  
$repe=mysql_query("select fecha from festivos where date(fecha) < date('$inicio_curso')");
if (mysql_num_rows($repe) > '0') {	
$festivos='actualizar';
	  ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/index_festivos.php">
     Importar Días festivos</a></li>  
	  <? 
		}
	  }
	  ?>  
    
                <?
	  if(stristr($_SESSION['cargo'],'3') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE)
	  {
	  ?>
      <li><a href="http://<? echo $dominio; ?>/intranet/faltas/poner2/index.php">
      Poner</a></li>
	  <? 
	  } else {
	  ?> 
      <li><a href="http://<? echo $dominio; ?>/intranet/faltas/poner/index.php">
      Poner</a></li>
      <?
	  }
	  ?>      
            
      <?
	  if(stristr($_SESSION['cargo'],'2') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
	  ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/justificar/index.php">
      Justificar</a></li>  
	  <? 
	  }
	  ?>      
      <li><a href="http://<? echo $dominio; ?>/intranet/admin/faltas/index.php">
      Consultar</a></li>
         <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
 ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/absentismo/index.php">
     Alumnos Absentistas</a></li>  
	  <? 
	  }
	  ?> 
            <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE)
	  {
	  ?>
	   <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Séneca
        <b class="caret"></b>
        </a>
	  <ul class="dropdown-menu">
	  <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/">
      Subir Faltas a S&eacute;neca</a></li> 
      <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/subir.php">
      Actualizar archivos de faltas desde S&eacute;neca</a></li>
      </ul>
      </li>
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

              
         <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
// Comprobamos si existe la tabla de festivos
$registrada='0';
$fest0 = mysql_query("show tables from $db");
while ($fest = mysql_fetch_array($fest0)) {
	if ($fest[0]=='festivos') {
		$registrada='1';
	}
}
if ($registrada=='1') {} else{
	mysql_query("CREATE TABLE `festivos` (
  `fecha` date NOT NULL default '0000-00-00',
  `nombre` varchar(64) NOT NULL default '',
  `docentes` char(2) NOT NULL default '',
  `ambito` varchar(10) NOT NULL default '',
  KEY `fecha` (`fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1");
} 
	  }
	  ?>  
         <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
$repe0=mysql_query("select fecha from festivos");		
if (mysql_num_rows($repe0)<'1') {
  	$festivos='actualizar';
	  ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/index_festivos.php">
     Importar festivos</a></li>  
	  <? 
  }  
  		  
$repe=mysql_query("select fecha from festivos where date(fecha) < date('$inicio_curso')");
if (mysql_num_rows($repe) > '0') {	
$festivos='actualizar';
	  ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/index_festivos.php">
     Importar festivos</a></li>  
	  <? 
		}
	  }
	  ?>  
    
                <?
	  if(stristr($_SESSION['cargo'],'3') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE)
	  {
	  ?>
      <li><a href="http://<? echo $dominio; ?>/intranet/faltas/poner2/index.php">
      Poner</a></li>
	  <? 
	  } else {
	  ?> 
      <li><a href="http://<? echo $dominio; ?>/intranet/faltas/poner/index.php">
      Poner</a></li>
      <?
	  }
	  ?>      
            
      <?
	  if(stristr($_SESSION['cargo'],'2') == TRUE or stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
	  ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/justificar/index.php">
      Justificar</a></li>  
	  <? 
	  }
	  ?>      
      <li><a href="http://<? echo $dominio; ?>/intranet/admin/faltas/index.php">
      Consultar</a></li>
         <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'3') == TRUE)
	  {
 ?>
        <li><a href="http://<? echo $dominio; ?>/intranet/faltas/absentismo/index.php">
     Alumnos Absentistas</a></li>  
	  <? 
	  }
	  ?> 
            <?
	  if(stristr($_SESSION['cargo'],'1') == TRUE)
	  {
	  ?>
	   <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Séneca
        <b class="caret"></b>
        </a>
	  <ul class="dropdown-menu">
	  <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/">
      Subir Faltas a S&eacute;neca</a></li> 
      <li><a href="http://<? echo $dominio; ?>/intranet/faltas/seneca/subir.php">
      Actualizar archivos de faltas desde S&eacute;neca</a></li>
      </ul>
      </li>
	  <? 
	  }
	  ?> 
     
    </ul>
        </div>
        </div>

<?
if($festivos == 'actualizar'){
echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No se han importado los <strong>Días festivos </strong>de este Curso Escolar en la Base de datos.</span> Hazlo antes de comenzar a utilizar la aplicación de Faltas de asistencia, o tendrás problemas para exportar posteriormente los datos a Séneca. Sigue el enlace del menú ( <strong><em>Importar Días festivos</em></strong> ) para proceder a la importación de las fechas.
		</div></div><br />';	
}
?>