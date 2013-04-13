<?
if ($submit1)
{
include("fechorias.php");
}
else
{
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
<?php
include("../../menu.php");
include("menu.php");
?>

<div aligna="center">
<div class="page-header" align="center">
  <h1>Problemas de Convivencia <small> Consultas</small></h1>
</div>
</div>
<br />

<div align="center" style="width:600px; margin:auto;" class="well-2">
<div align="left">
<div class="row-fluid">
<div class="span6">
  <FORM action="cfechorias.php" method="POST" name="Fechorias" class="">
   <div class="row-fluid">
    <div class="span6">
    <label>Nivel:      
    <SELECT name="nivel" id="NIVEL"  onChange="submit()" class="span6" style="display:inline">
        <OPTION><? echo $nivel;?></OPTION>
        <? nivel();?>
      </SELECT>
    </label>
    </div>
    <div class="span6">
    <label style="display:inline">Grupo:     
    <SELECT name="grupo" id="GRUPO" class="span6" style="display:inline">
        <OPTION><? echo $grupo;?></OPTION>
        <? grupo($nivel);?>
      </SELECT>
    </label>
    </div>
    </div>
    <label>Apellidos:<br />      
    <INPUT type="text" name="APELLIDOS" size="40" maxlength="32" alt="Apellidos">
    </label>
    <label>Nombre:<br />      
    <INPUT type="text" name="NOMBRE" size="40" maxlength="25">
    </label>
   
    </div>
    <div class="span6">
    
    
    <div class="row-fluid">
    <div class="span6">
    <label>Mes:     
    <INPUT type="text" name="MES" class="span4" alt="Mes" style="display:inline">
    </label>
    </div>
    <div class="span6">
    <label>D&iacute;a:      
    <INPUT type="text" name="DIA" alt="Dia" class="span4" style="display:inline">
    </label>
    </div>
    </div>
    
    
    
    
    
    
    <label>Otros criterios:<br />      
    <select size="5" style="width:220px; padding:2px;" name = "clase[]" >
        <option>Expulsion del Centro</option>
        <option>Expulsion del Aula</option>
        <option>Aula de Convivencia</option>
        <option>Falta Grave</option>
        <option>Falta Muy Grave</option>
      </select>
    </label>
    
  <? }?>
  </div>
  </div>
  </div>
  <div align="center">
  <input name="submit1" type='submit' value='Enviar Datos' class="btn btn-primary">
  </FORM>
  </div>
</div>
<?php
	include("../../pie.php");
?>
</BODY></HTML>