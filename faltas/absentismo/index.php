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
  <h1>Faltas de Asistencia <small> Alumnos Absentistas</small></h1>
</div>
<br />
<div class="well-2 well-large" style="width:350px; text-align:left;">
<?
	  if(stristr($_SESSION['cargo'],'1') == TRUE)
	  {
?>
<form enctype='multipart/form-data' action='lista.php' method='post'>
<h6 align="center"> Selección de Mes y Número de Faltas.</h6>
<hr>
		
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
<br />
<form enctype='multipart/form-data' action='index2.php' method='post'>
<br />
<h6 align="center"> Consulta de Absentismo por mes.</h6>
<hr>
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
</body>
</html>
