<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
  <?
include("../menu.php");
?>
<?
include("menu.php");
?>
<div align=center>
<div class="page-header" align="center">
  <h2>Centro TIC <small> Documentos</small></h2>
</div>
<br />
<table class="table" style="width:920px">
      <tr>
        <th  colspan="2" style="background-color:#dff0d8" style="background-color:#dff0d8"><h6>Punto de partida sobre las TIC. </h6></th>
        </tr>
      <tr>
        <td style="width:25%"><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/TIC_como_agentes_innovacion.pdf" target="_blank">Las TIC como Agentes de innovacion</a> </td>
        <td>Documento esencial para entender lo que la Consejeria de Educacion pretende con la idea de los Centros TIC, y como afecta el asunto a Padres, Alumnos y Profesores. </td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/guia_centros_tic.pdf" target="_blank">Guia de los Centros TIC</a> </td>
        <td>El CGA (Centro de Gestion Avanzado, creo) ha elaborado una Guia muy completa sobre todos los aspectos tecnicos que rodean a un Centro TIC: ordenadores y perifericos, Sistema Operativo (Guadalinex), Plataforma Educativa, etc. Incluye una seccion estupenda sobre el uso de un escaner, impresoras, camaras de fotos. Hay otra seccion sobre el Ca&ntilde;on Virtual, Jclic, y otras aplicaciones. </td>
      </tr>
      <tr>
        <th  colspan="2" style="background-color:#dff0d8"><h6>HARDWARE</h6></th>
        </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/MAN-toshiba-es.pdf">Manual del Portatil TOSHIBA </a></td>
        <td>Para los que quieran conocer en detalle las caracteristicas y uso del portatil que utilizamos en el Centro, aqui van el PDF que contiene el Manual de Uso. </td>
      </tr>
      <tr>
        <th  colspan="2" style="background-color:#dff0d8"><h6>GUADALINEX</h6></th>
        </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/Guia_Guadalinex_V3.pdf" target="_top">Guia de Guadalinex V.3.1</a> </td>
        <td>Guia completita del Sistema Operativo que utilizamos. Hay una version en formato libro por si alguien queire echarle un vistazo. Imprescindible tanto para los recien llegados como para usuarios mas avanzados. Ademas del Sistema Operativo, trata aplicaciones de uso corriente. </td>
      </tr>
      <tr>
        <th  colspan="2" style="background-color:#dff0d8"><h6>APLICACIONES IMPORTANTES EN GUADALINEX </h6></th>
        </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/openoffice_writer.pdf">Procesador de textos de OpenOffice </a></td>
        <td>Introducion a la aplicacion de textos de OpenOffice.</td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/gimp.pdf">Gimp (Graficos)</a> </td>
        <td>Gimp es una aplicacion para el tratamiento de graficos y fotografias. Algo asi como el PhotoShop de Linux. La introduccion es basica pero util para empezar. </td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/paginas_web_con_composer.pdf">Composer (Creacion de Paginas Web)</a> </td>
        <td>Introducion rapida al uso de esta aplicacion para crear paginas web sencillas en modo grafico. Hay otra utilidad mas potente con la misma funcion en Guadalinex, NVU, en caso de pedir mas potencia. </td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/xsane_manual_escanear.pdf">XSane (Escaner)</a> </td>
        <td>Introduccion a la aplicacion que utiliza Guadalinex para el uso de un Escaner. Imprescindible para los que quieran utilizar regularmente la maquina. </td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/CanonVirtual.pdf">Ca&ntilde;on Virtual </a></td>
        <td>Instrucciones para el uso de la aplicacion Ca&ntilde;on Virtual que esta disponible en Guadalinex. La aplicacion permite al profesor que el alumno vea en su ordenador lo que el profesor tiene en la suya, por ejemplo peliculas o el propio escritorio. Muy util para el uso en las aulas. </td>
      </tr>
      <tr>
        <th  colspan="2" style="background-color:#dff0d8"><h6>PLATAFORMA EDUCATIVA </h6>          
          <div align="center"></div></td>
        </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/Manual_Plataforma_Educativa.pdf">Manual de la Plataforma Educativa </a></td>
        <td>La Plataforma Educativa es la otra cosa que viene con los Centros TIC: una aplicacion que permite trabajar con los alumnos en el aula (colocar documentos, poner controles, crear foros de discusion, etc). El uso necesita de cierto aprendizaje, asi que aqui van un par de manuales de uso para quien quiera entrar en ese mundo. Aunque su uso no es obligatorio, algunos profesores pueden encontrar muchas posibilidades para utilizar regularmente el ordenador en el aula con los alumnos. </td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/plataforma_e-ducativa.pdf">Plataforma E-Ducativa </a></td>
        <td>Otro manual de uso de la Plataforma. </td>
      </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="ftp://iesmonterroso.org/departamentos/TIC/plataformaIVcontenidos.doc">Contenidos en la Plataforma </a></td>
        <td>Instrucciones para crear contenidos para los alumnos, quizas la parte fundamental de la Plataforma. </td>
      </tr>
      <tr>
        <th  colspan="2" style="background-color:#dff0d8"><h6>ENLACES INTERESANTES </h6></th>
        </tr>
      <tr>
        <td><i class="icon icon-tags"> </i> <a href="http://www.juntadeandalucia.es/averroes/cga">Centro de Gesti&oacute;n Avanzado de centros TIC </a></td>
        <td>Pagina principal del Organismo que lleva el peso de los Centros TIC. Hay documentacion importante.</td>
      </tr>
    </table>
</div></body>
</html>
