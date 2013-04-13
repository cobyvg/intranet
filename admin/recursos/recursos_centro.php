<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title>Recursos Educativos</title>

<link href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
  <?php
include("../../menu.php");
include("mrecursos.php");

?>
<div align="center">
<div class='titulin'  style='color:#281;margin-top:0px;margin-bottom:15px; width:550px;'>Recursos Educativos elaborados por Profesores de este Centro</div>
<table class="tablaespaciada" width="480">
        <tr> 
          <td id="filaprincipal">
              PROFESOR/A </td>
          <td id="filaprincipal">
          TRABAJO</td>
        </tr>
        <tr>
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/ntic/index.htm" target="_blank">Nuevas 
              tecnolog&iacute;as de comunicaci&oacute;n</a></td>
        </tr>
        <tr> 
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/sist-aut/index.htm" target="_blank">Sistemas 
              autom&aacute;ticos de control</a></td>
        </tr>
        <tr> 
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/act-ini/index.htm" target="_blank">Actividad 
              inicial de inform&aacute;tica</a></td>
        </tr>
        <tr> 
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/anofis/index.htm" target="_blank">A&ntilde;o 
              Mundial de la F&iacute;sica</a></td>
        </tr>
        <tr> 
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/hd/index.htm" target="_blank">Discos 
              Duros</a></td>
        </tr>
        <tr> 
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/domotica/index.htm" target="_blank">Dom&oacute;tica</a></td>
        </tr>
        <tr> 
          <td>Jos&eacute; Manuel 
              Moya</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/digestivo/index.htm" target="_blank">Aparato 
              digestivo</a></td>
        </tr>
        <tr> 
          <td>Jos&eacute; Manuel 
              Moya</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/tectonica" target="_blank">T&eacute;ctonica 
              de placas</a></td>
        </tr>
        <tr> 
          <td>Francisco Jos&eacute; 
              Ruiz Rey</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/fractales/fractales.htm" target="_blank">Fractales</a></td>
        </tr>
        <tr> 
          <td>Francisco P&eacute;rez 
              Gomar</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/ciclos" target="_blank">Contratos 
              de trabajo</a></td>
        </tr>
        <tr> 
          <td>Javier Cabello 
              Garc&iacute;a</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/atomo/atomo.htm" target="_blank">El 
              &aacute;tomo</a></td>
        </tr>
        <tr> 
          <td>Esther Cabezas 
              y Eva Ruiz</td>
          <td><a href="http://esthercabezas.blogia.com" target="_blank">Blog 
              del Departamento de Dibujo</a></td>
        </tr>
        <tr> 
          <td>Emilio Fuentes</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/webquestue/index.htm" target="_blank">Uni&oacute;n 
              Europea</a></td>
        </tr>
        <tr> 
          <td>Eva Ruiz </td>
          <td><a href="http://<? echo $dominio; ?>/recursos/picasso" target="_blank">Picasso 
              y las t&eacute;cnicas art&iacute;sticas</a></td>
        </tr>
        <tr> 
          <td>Santiago Ortega 
              Garabito</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/santiagortega/funciones.htm" target="_blank">Funciones</a></td>
        </tr>
        <tr> 
          <td>Francisco Javier 
              M&aacute;rquez</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/locomotor.htm" target="_blank">Aparato 
              locomotor</a> </td>
        </tr>
        <tr> 
          <td>Francisco Medina 
              Infantes</td>
          <td><a href="http://www.juntadeandalucia.es/averroes/~29002885/test/" target="_blank">Test 
              de conocimientos b&aacute;sicos - Matem&aacute;ticas</a></td>
        </tr>
        <tr> 
          <td>Carmen Aguilar</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/murcia/MURCIA.htm" target="_blank">Murcia</a></td>
        </tr>
        <tr> 
          <td>Julio P&eacute;rez</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/Ayala" target="_blank">Ayala</a></td>
        </tr>
        <tr> 
          <td>M&ordf; Carmen 
              Ortega</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/enjoy/Enjoy Estepona.htm" target="_blank">Enjoy 
              Estepona</a></td>
        </tr>
        <tr> 
          <td>Manuel Rinc&oacute;n</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/enrenova" target="_blank">Energ&iacute;as 
              renovables</a></td>
        </tr>
        <tr> 
          <td>Isabel Rojas</td>
          <td><a href= "http://<? echo $dominio; ?>/recursos/marchena/Visita Marchena.htm" target="_blank">Visita 
              a Marchena</a></td>
        </tr>
        <tr> 
          <td>Francisco Jos&eacute; 
              Ruiz Rey</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/fractales.exe" target="_blank">Fractales 
              con Neobook</a></td>
        </tr>
        <tr> 
          <td>Manuel Barrio</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/laenergia" target="_blank">La 
              Energ&iacute;a</a></td>
        </tr>
        <tr> 
          <td>Lourdes Barrutia</td>
          <td><a href="http://<? echo $dominio; ?>/recursos/paz" target="_blank">D&iacute;a 
              internacional de la paz</a></td>
        </tr>
        <tr>
          <td>Francisco Jos&eacute; 
              Ruiz Rey</td>
          <td><a href="http://www.internetrecursoeducativo.blogia.com" target="_blank">Internet 
              como recurso educativo</a></td>
        </tr>
        <tr> 
          <td>Francisco Jos&eacute; 
              Ruiz Rey</td>
          <td><a href="http://www.innova.uned.es/webpages/fruiz/home.htm" target="_blank">Astrobiolog&iacute;a 
              y Marte</a></td>
        </tr>
</table>
		</div>

</body>
</html>
