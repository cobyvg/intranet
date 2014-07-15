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
if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE))
{
header("location:http://$dominio/intranet/index.php");
exit;	
}
?>
<? 
include("../../menu.php");
// Actualizamos el campo nivel
mysql_query("ALTER TABLE  `textos_gratis` CHANGE  `nivel`  `nivel` VARCHAR( 48 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT  '' ");

mysql_query("update `textos_gratis` set nivel = '1º de E.S.O.' WHERE nivel = '1E'");
mysql_query("update `textos_gratis` set nivel = '2º de E.S.O.' WHERE nivel = '2E'");
mysql_query("update `textos_gratis` set nivel = '3º de E.S.O.' WHERE nivel = '3E'");
mysql_query("update `textos_gratis` set nivel = '4º de E.S.O.' WHERE nivel = '4E'");

?>
<div align="center">
        <div class="page-header" align="center">
  <h2>Programa de Ayudas al Estudio <small> Libros gratuitos de la ESO</small></h2>
</div>
<br />
  <div class="row-fluid">
    <div class="span1"></div>
    <div class="span3">
      <form enctype="multipart/form-data" action="reposicion.php" method="post" class="form-inline">
        <h3>Imprimir Certificados de Reposici&oacute;n</h3><br />
        <div class="well well-large">
        
        <label>Nivel: 
        <select name="niv" id="nivel">
        <?
        $niv_sen = mysql_query("select nomcurso from cursos where nomcurso like '%E.S.O.'");
        while ($nivel_seneca = mysql_fetch_array($niv_sen)) {
        	echo '<option value="'.$nivel_seneca[0].'">'.$nivel_seneca[0].'</option>';
        }
        ?>
        </select>
        </label>
        <br />
        <br />
        <input type="submit" name="enviar3" value="Consultar" class="btn btn-primary" />
        </div>
      </form>
    </div>
    <div class="span3">
      <form enctype="multipart/form-data" action="libros.php" method="post" class="form-inline">
        <h3>Consultar el Estado de los Libros.</h3><br />
        <div class="well well-large">
        <label>Nivel: 
        <select name="nivel" id="select">
       <?
        $niv_sen = mysql_query("select nomcurso from cursos where nomcurso like '%E.S.O.'");
        while ($nivel_seneca = mysql_fetch_array($niv_sen)) {
        	echo '<option value="'.$nivel_seneca[0].'">'.$nivel_seneca[0].'</option>';
        }
        ?>
        </select>
        </label>
        <br />
        <br />
        <input type="hidden" name="jefe" value="1" />
        <input type="submit" name="enviar2" value="Consultar"  class="btn btn-primary" />
        </div>
      </form>
    </div>
    <div class="span4">
      <form enctype="multipart/form-data" action="in_textos.php" method="post" class="form-inline">
        <h3>Importación de Libros desde Séneca</h3><br />
        <div class="well well-large" align="left">
        <p class="text-info">Si has descargado los archivos
          de texto que contienen los Libros de este Curso escolar (desde
          Alumnado --&gt; Ayudas al Estudio --&gt; Asignación de Libros a
          Materias --> Exportar (PDF, XLS)) con el formato de exportacion seleccionado como "Texto Plano", y los
          has renombrado correctamente (1ESO.txt, 2ESO.txt, etc.),
          puedes continuar con el segundo paso.</p>
          <hr>
        <input type="file" name="archivo" />
        <br /><br />
        <div align="center"><input type="submit" name="enviar" value="Aceptar"  class="btn btn-primary btn-block" /></div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>