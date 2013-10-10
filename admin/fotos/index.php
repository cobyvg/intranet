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
  <?
  	include("../../menu.php");
  ?>
<br />
   <div align=center>
  <div class="page-header" align="center">
  <h2>Fotos de los Alumnos <small></small></h2>
</div>

<div class="well well-small" style="width:33%;margin:auto;">
<FORM action="fotos_alumnos.php" method="POST" name="fotos" target="_blank">
  <legend> Selecciona el Grupo de alumnos</legend><br />
  <label> Grupo: 
    <select  name="curso" style="width:80px" onChange="submit()">
      <option></option>
                    <?
  $tipo = "select distinct unidad from alma order by unidad";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }				
					?>
    </select>
  </label>
  <br /><INPUT type="submit" name="submit1" value="Enviar datos" class="btn btn-primary">          
          </FORM>  
  
  </div>
  <?php
  	include("../../pie.php");
  ?>