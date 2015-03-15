<? include_once("../conf_principal.php");?>
<?  include("../cabecera.php"); ?>
<?  include("../menu.php"); ?>
<? include("../funciones.php"); ?>
<div class="span9">
<div class="span10 offset1">
            <div align="center">
           <br>
           <h3><i class='icon icon-lock'> </i> Acceso privado para los Alumnos del Centro.</h3>
            <br />
<div class="well well-large" style="width:450px; margin:auto; text-align:center">
<form action="control.php" method="post" align="center" class="form-signin" name="form1">
<label for="user"><h2 align="left"><small>Clave del Centro </small><input type="text" name="user" class="input-block-level input-large" required /></h2></label>
<label for="clave"><h2 align="left"><small>Clave del Alumno </small><input type="password" name="clave" class="input-block-level input-large" required /></h2></label>
<br />
<button type="submit" name="submit" value="Entrar" class="btn btn-large btn-primary btn-block"><i class="icon icon-signin icon-white icon-large"></i> &nbsp;Entrar</button>
</form>
</div>
<br />
<div class="row-fluid">
<div class="well well-large well-transparent span5" style="text-align:left;">
        <legend class="text-success">Páginas de los Alumnos</legend><p style="text-align:justify"> A través de estas páginas puedes ver la informaci&oacute;n académica m&aacute;s  importante sobre un Alumno.
                                  El Instituto  te ofrece datos sobre las <em>Asignaturas</em>
                                  y <em>Profesores</em>, las
                                  calificaciones de las distintas <em>Evaluaciones</em>,
                                  las faltas de <em>Asistencia</em>,
          problemas relacionados con la <em>Convivencia</em>          en
          el Centro, <em>Libros</em>          de Texto, <em>Horario</em>          del
          año, etc. También puedes utilizar el sistema de mensajes para ponerte en contacto con el Tutor del Grupo, y recibir la respuesta del mismo.</p>
</div>
<div class="well well-large well-transparent span6 offset1" style="text-align:left;">
        <legend class="text-success">Nuevo Sistema de Acceso</legend><p style="text-align:justify">Para entrar en estas páginas es necesario conseguir una clave de acceso que proporciona el Centro (<em><b>Clave del Centro</b></em> a través del Tutor del alumno, Jefatura de Estudios o la Administracción del Instituto). La Clave del VCentro es la misma que ya se venía utilizando para poder ver las Faltas de asistencia y los Problemas de Convivencia del , por lo que puedes usarla para entrar normalmente si ya la tenías. También debes registrar una clave personal privada (<em><b>Clave del Alumno</b></em>). Para registrar tu clave personal, la primera vez que entres repite la <em>Clave del Centro</em> en ambos campos del formulario. Pasarás a otra página en la que deberás escribir tu clave privada y correo electrónico. </p>
</div>
</div>
</div>
</div>                                                 
</div>
 <? include("../pie.php"); ?>

