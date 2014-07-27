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
include("../menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Alumnos Absentistas</small></h2>
</div>
<br />
<div class="container">
<div class="row">
<div class="col-sm-5 col-sm-offset-1">
<div class="well well-large" style="text-align:left;">
<?
	  if(stristr($_SESSION['cargo'],'1') == TRUE)
	  {
?>
<form enctype='multipart/form-data' action='lista.php' method='post'>
<legend> Consulta por Mes y Número de Faltas.</legend>
		
                    <label>Mes: <br />
                    <select name='mes' type='text' class="input-large">
                    <option></option>
                    <option>Septiembre</option>
                    <option>Octubre</option>
                    <option>Noviembre</option>
                    <option>Diciembre</option>
                    <option>Enero</option>
                    <option>Febrero</option>
                    <option>Marzo</option>
                    <option>Abril</option>
                    <option>Mayo</option>
                    <option>Junio</option>
                    </select>
                    </label>
 
                    <label >Número mínimo de Faltas<br />
                    <INPUT name="numero" type="text" id="numero" size="3" maxlength="3" class="input-small">
                    </label>
                    <br /> 
			              <INPUT name="submit4" type="submit" value="Enviar Datos" id="submit4" class="btn btn-primary"> 
</form>
<?
	  }
?>
</div>
</div>
<div class="col-sm-5">
<div class="well well-large" style="text-align:left;">
<form enctype='multipart/form-data' action='index2.php' method='post'>
<legend> Consulta de Absentismo por mes.</legend>
                    <label>Mes<br />
                    <select name='mes' type='text' class="input-large">
                    <option>Septiembre</option>
                    <option>Octubre</option>
                    <option>Noviembre</option>
                    <option>Diciembre</option>
                    <option>Enero</option>
                    <option>Febrero</option>
                    <option>Marzo</option>
                    <option>Abril</option>
                    <option>Mayo</option>
                    <option>Junio</option>
                    </select>
</label>
<br />
                    <INPUT name="submit5" type="submit" value="Ir a la Página de Informes" class="btn btn-primary"> 
</form>
</div>
</div>
</div>
</div>
    <? 
include("../../../pie.php");
?>
</body>
</html>
