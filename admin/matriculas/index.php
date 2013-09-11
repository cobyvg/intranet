<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
if(!(stristr($_SESSION['cargo'],'1') == TRUE) and !(stristr($_SESSION['cargo'],'7') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

?>
<? include("../../menu.php");?>
<? include("./menu.php");?>
<div align="center">
<div class="page-header" align="center">
  <h2>Matriculación de Alumnos <small> Matricular Alumnos de ESO</small></h2>
</div>
<br />
  <div class="well well-large" style="width:400px;" align="left">
    <form action="matriculas.php" method="post">
      <label><p class="lead">Selecciona el Nivel</p>
        <span class="help-block">(No es obligatorio si el alumno pertenece a nuestro Centro o los Colegios adscritos que han entregado el archivo de Séneca de sus alumnos)</span>
        <select maxlength="12" name="curso" id="curso" style="margin-bottom:18px;" class="formselect" onChange="desactivaOpcion()">
          <option><? echo $curso;?></option>
          <option>1ESO</option>
          <option>2ESO</option>
          <option>3ESO</option>
          <option>4ESO</option>
        </select>
      </label>
      <hr>
      <label><p class="lead">D.N.I. del Alumno o del Tutor legal</p>
        <input type="input" maxlength="13" name="dni" id="dni"   >
      </label>
      <hr>
      <input type="submit" name="matricular" value="Proceder a la Matrículación" maxlength="25" alt="Introducir" class="btn btn-primary"/>
    </form>
  </div>
</div>
<? include("../../pie.php");
