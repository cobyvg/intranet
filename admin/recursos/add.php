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
$pr = $_SESSION['profi'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Introducir recursos en la Base de Datos</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {color: #281}
-->
</style>
</head>
<body>
<?php
include("../../menu.php");
include("mrecursos.php");
	$fecha1 = (date("Y").-date("m").-date("d"));
  	if ($enviar) 
	{ 
//Conecxion con la base de datos.

//Errores posibles
	$errorList = array();
	$count = 0;

	if (!$titulo or !$departamento or !$profesor or !$descripcion or !$direccion) 
	{ 
	$errorList[$count] = "<script type='text/javascript' language>
alert(\"No has introducido datos en alguno de los campos obligatorios. Vuelve atrás e inténtalo de nuevo.\")
</script>"; $count++; 
}
	if (sizeof($errorList) == 0)
	{
// Base de datos
  

//Introduccion de datos si todo va bien
		$query="insert into recursos (departamento,profesor,titulo,direccion,descripcion,nivel,asignatura,fecha,categoria,subclase) values ('".$departamento."','".$profesor."','".$titulo."','".$direccion."','".$descripcion."','".$curso."','".$asignatura."','".$fecha."','".$categoria."','".$dhistoria."')";

		mysql_query($query) or die("No se ha podido insertar el registro en la Base de datos");
echo "<div align='center'><table width=50% class='tabla'>
   <tr>
     <td><div align=center>RECURSO MODIFICADO (Nuevos Datos).</DIV></td>
   </tr>
 </table></div>";
	}
		else
	{
	for ($x=0; $x<sizeof($errorList); $x++)
	{
	echo "$errorList[$x]";
	}
//	echo "<h6>Hay un error en los datos que estás intentando registrar.<br> No has introducido datos en alguno de los campos obligatorios. Vuelve atrás e íntentalo de nuevo.</h6>";
	// Final del formulario de errores
	?>
	  <br>
	  <p id="texto">ERROR EN EL FORMULARIO: FALTAN DATOS.</p>
	  <INPUT class ='content' TYPE='button' VALUE='Volver atrás'
   onClick='history.back()'>
   <?
	}

}

else
{

?>
<span class=titulin style="margin-top:0px; margin-left:150px; color:#281">Añadir Recurso Educativo</span>
<div align="center">
<form action="add.php" method="post">
        <table width="70%"  class="tabla">
          <tr>
            <td id="filaprincipal">Profesor</td>
            <td>
            <input name="profesor"  style="font-size:95%;" value="<? echo $pr; ?>" size="60" >
			</td>
          </tr>
          <tr>
            <td id="filaprincipal">Departamento</td>
            <td><select id="departamento"  name = "departamento" onChange="submit()">
                <option><? echo $departamento; ?></option>
                <option></option>
                <option>Filosof&iacute;a</option>
                <option>Lengua y Literatura</option>
                <option>Matem&aacute;ticas</option>
                <option>F&iacute;sica y Qu&iacute;mica</option>
                <option>Lat&iacute;n y Griego</option>
                <option>M&uacute;sica</option>
                <option>Biolog&iacute;a</option>
                <option>Educaci&oacute;n F&iacute;sica</option>
                <option>Religi&oacute;n</option>
                <option>Inglés</option>
                <option>Franc&eacute;s</option>
                <option>Geograf&iacute;a e Historia</option>
                <option>Ciclos Formativos</option>
                <option>Dibujo</option>
                <option>Orientaci&oacute;n</option>
                <option>Tecnolog&iacute;a</option>
                <option>Econom&iacute;a</option>
                <option>Inform&aacute;tica</option>
                <option>F.O.L.</option>
                <option>Otros..</option>
            </select>
                        <?
            if ($departamento == "Geografía e Historia") {
            	echo '<select id="dhistoria"  name = "dhistoria">
                <option></option>
                <option>CLIMATOLOG&Iacute;A</option>
                <option>GEOMORFOLOG&Iacute;A</option>
                <option>BIOGEOFRAF&Iacute;A</option>
                <option>GEOGRAF&Iacute;A URBANA</option>
                <option>GEOGRAF&Iacute;A DE LA POBLACI&Oacute;N</option>
                <option>GEOGRAF&Iacute;A ECON&Oacute;MICA</option>
                <option>GEOGRAF&Iacute;A DESCRIPTIVA</option>
                <option>CARTOGRAF&Iacute;A</option>
                <option>GEOGRAF&Iacute;A DE ESPA&Ntilde;A Y ANDALUC&Iacute;A</option>
                <option>GEOGRAF&Iacute;A DE EUROPA</option>
                <option>SUBDESARROLLO</option>
                <option>H&ordf; Y TEOR&Iacute;A DEL ARTE</option>
                <option>ARTE PREHIST&Oacute;RICO Y ANTIGUO</option>
                <option value="Q">ARTE MEDIEVAL</option>
                <option>ARTE MODERNO</option>
                <option>ARTE CONTEMPOR&Aacute;NEO</option>
                <option>H&ordf; DE ESPA&Ntilde;A</option>
                <option>PREHISTORIA</option>
                <option>H&ordf; ANTIGUA</option>
                <option>H&ordf; MEDIEVAL</option>
                <option>H&ordf; MODERNA</option>
                <option>H&ordf; CONTEMPOR&Aacute;NEA</option>
                <option>H&ordf; DEL PENSAMIENTO POL&Iacute;TICO</option>
                <option>BIOGRAF&Iacute;AS</option>
                                          </select>';
            }
            ?>
           </td>
          </tr>
          <tr>
            <td id="filaprincipal">Tipo de Recurso</td>
            <td><select id="categoria"  name = "categoria">
                <option><? echo $categoria; ?></option>
                <option></option>
                <option>Página Web</option>
                <option>WEBQUESTS</option>
                <option>CAZA DE TESOROS</option>
                <option>EJERCICIOS INTERACTIVOS</option>
                <option>Otros..</option>
            </select></td>
          </tr>
          <tr>
            <td id="filaprincipal">T&iacute;tulo para el Recurso </td>
            <td><input name="titulo" value = "<? echo $titulo; ?>" type="text" size="60"></td>
          </tr>
          <tr>
            <td id="filaprincipal">Descripci&oacute;n, Comentario, Observaciones, Palabras Clave. </td>
            <td><textarea name="descripcion" cols="56" rows="5" id="descripcion"><? echo $descripcion; ?></textarea></td>
          </tr>
          <tr>
            <td id="filaprincipal">Direcci&oacute;n de la P&aacute;gina </td>
            <td><input type="text" id="direccion" size="60" name = "direccion" value = "<? 
	if($direccion)	
	{echo $direccion;}
	else {echo "http://";} ?>"></td>
          </tr>
          <tr>
            <td id="filaprincipal">Nivel (Optativo) </td>
            <td><select name="curso">
                <option></option>
                <?
   if(stristr($_SESSION['cargo'],'1') == TRUE)
{
$prof = "";
}
else {
$prof = " where PROFESOR = '$pr'";
}             
 $SQLcurso = "select distinct NIVEL from profesores, departamentos $prof";
//echo $SQLcurso;
$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$nivel = $rowcurso[0];

	echo "<option>" . $nivel . "</option>";
}
?>
            </select></td>
          </tr>
          <tr>
            <td id="filaprincipal">Asignatura (Optativo)</td>
            <td><?
    if(stristr($_SESSION['cargo'],'1') == TRUE)
{
$profa = "";
}
else {
$profa = "where departamentos.nombre = profesores.profesor and PROFESOR = '$pr'";
} 
	 $asignatura0 = "select distinct MATERIA from departamentos, profesores $profa";

	?>
                <select name="asignatura">
                  <option> <? echo $asignatura; ?></option>
                  <option></option>
                  <?
$resultasignatura = mysql_query($asignatura0);
	while($rowasignatura = mysql_fetch_array($resultasignatura))
	{
	$asignaturas = $rowasignatura[0];

	echo "<option>" . $asignaturas . "</option>";
}
?>
              </select></td>
          </tr>
          <tr>
            <td width="35%" colspan="2">
                <input type=hidden name='fecha' <? echo "value='" . $fecha1 . "'" ?>>
                <div align="center"><input name="enviar" type="submit" id="formsubmit" value="Enviar Datos"></div>
            </td>
          </tr>
        </table>
      </form>
    <table class="tabla" width="70%">
    <tr>
      <td valign="top" style="padding:10px;"><p align="justify" id="texto">Este es el Formulario para introducir datos. Los dos primeros Campos, <span class="Estilo1">Profesor</span> y <span class="Estilo1">Departamento</span>, son obligatorios. El <span class="Estilo1">Tipo</span> o <span class="Estilo1">Categor&iacute;a</span> del Recurso no es obligatorio, aunque es recomendable proporcionar este dato para futuras consultas. El <span class="Estilo1">T&iacute;tulo</span> es necesario, y ha de ser lo m&aacute;s indicativo posible, a modo de titular de una noticia. La <span class="Estilo1">Descripci&oacute;n</span> es quiz&aacute;s la parte fundamental.  Presenta el Recurso en su relacion con el resto de los datos: contenidos de la pagina, utilidad didactica, nivel educativo al que esta dirigida , etc. Las b&uacute;squedas y consultas de datos descansan ante todo en este campo. El <span class="Estilo1">Nivel</span> y la <span class="Estilo1">Asignatura</span> son opcionales, pero ser&iacute;a buena idea marcarlos si la pagina lo permite. No olvid&eacute;is que el Formulario de Busqueda de los Recursos permitir&aacute; seleccionar entre todos los apartados, por lo que, cuanto m&aacute;s abundantes sean los datos, 
        mas precisa ser&aacute; la consulta.
      </p></td>
    </tr>
  </table>
</div>
<? } ?>

</body>
</html>
