<?
require('../../bootstrap.php');


$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$config['dominio'].'/intranet/salir.php');
exit;	
}


include("../../menu.php");
?>
<br />
<div class="container">
<div class="page-header">
  <h2>Administración <small> Actualización de Días Festivos en la localidad</small></h2>
</div>
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<FORM ENCTYPE="multipart/form-data" ACTION="festivos.php" METHOD="post">
<div class="form-group">
 <p class="help-block"><span style="color:#9d261d">(*) </span>Si has descargado el archivo <strong>200CalEscCent</strong> de Séneca (desde Séneca --> Centro --> Días festivos), puedes continuar con el segundo paso.</p>
  <br />
  <div class="well well-large" style="width:600px; margin:auto;" align="left">
  <div class="controls">
  <label class="control-label" for="file">Selecciona el archivo con los datos de las Fiestas y Vacaciones
  </label>
  <input type="file" name="archivo" class="input input-file id="file">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary">
  </div>
  </div>
  </div>
  </div>
</FORM>
<br />
</div>
</div>
</div>
    <?php 
include("../../pie.php");
?>
</body>
</html>
