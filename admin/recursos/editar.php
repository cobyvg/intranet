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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editar Recursos</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
  <?php
include("../../menu.php");
include("mrecursos.php");
?>

<?	
$fecha1 = (date("Y").-date("m").-date("d"));						

if($actualizar == "Actualizar Datos")
{
$query="update recursos SET id = '$id', titulo = '$titulo', descripcion = '$descripcion', categoria = '$categoria', departamento = '$departamento', profesor = '$profesor', nivel = '$nivel', asignatura = '$asignatura', direccion = '$direccion', fecha ='$fecha', subclase ='$dhistoria' where id = '$id'";
mysql_query($query);
echo "<div align='center'><table width=50% class='tabla'>
   <tr>
     <td bgcolor=#FFFFFF><div align=center><strong>RECURSO MODIFICADO (Nuevos Datos).</strong></DIV></td>
   </tr>
 </table></div>";
$informe = "select id, titulo, descripcion, categoria, departamento, profesor, nivel, asignatura, direccion, subclase from recursos where id = $id";
// echo $informe;
$sqlinforme = mysql_query($informe);
	while($rowinforme = mysql_fetch_array($sqlinforme))
	{
	$id = $rowinforme[0];
	$titulo = $rowinforme[1];
	$descripcion = $rowinforme[2];
	$categoria = $rowinforme[3];
	$departamento = $rowinforme[4];
	$profesor = $rowinforme[5];
	$nivel = $rowinforme[6];
	$asignatura = $rowinforme[7];
	$direccion = $rowinforme[8];
	$dhistoria = $rowinforme[9];
echo "<div align='center'><span class=titulin>$rowinforme[1]</span>
<table width='75%' class='tabla'>
  <tr>
    <td id='filasecundaria' width=65%><strong>T&Iacute;TULO</strong>: $rowinforme[1]</td>
      <td id='filasecundaria' width=35%><strong>DEPARTAMENTO</strong>: $rowinforme[4]</td>
    </tr>
  <tr>
    <td id='filaprincipal'><strong>DESCRIPCI&Oacute;N</strong>: $rowinforme[2]</td>
      <td id='filaprincipal'><strong>PROFESOR</strong>: $rowinforme[5]</td>
    </tr>
  <tr>
    <td id='filasecundaria'><strong>CATEGOR&Iacute;A</strong>: $rowinforme[3]</td>
      <td id='filasecundaria'><strong>NIVEL</strong>: $rowinforme[6] <strong>ASIGNATURA</strong>: $rowinforme[7]</td>
    </tr>
  </table><div>";
}
}

else
{
$SQL0 = "select id, titulo, descripcion, categoria, departamento, profesor, nivel, asignatura, direccion, subclase from recursos where id = '$id'";
// echo $SQL0;
$result0 = mysql_query($SQL0);
 if(mysql_num_rows($result0) == 1)
	{
	$rowinforme = mysql_fetch_row($result0);
 	$id = $rowinforme[0];
	$titulo = $rowinforme[1];
	$descripcion = $rowinforme[2];
	$categoria = $rowinforme[3];
	$departamento = $rowinforme[4];
	$profesor = $rowinforme[5];
	$nivel = $rowinforme[6];
	$asignatura = $rowinforme[7];
	$direccion = $rowinforme[8];
	$dhistoria = $rowinforme[9];
	?>
	<span class=titulin style="margin-left:150px;margin-top:0px; color:#281;">Edición de Recursos Educativos</span>
<form action="editar.php" method="post">
      <div align="center"><table width="70%" class="tabla">
        <tr>
          <td id='filaprincipal'>Profesor</td>
          <td><select  style="font-size:95%;" name="profesor">
            <?
			
 echo "<option>$profesor</option>";
 echo "<option></option>";
// Seleccion de Profesor en profes.
$SQL = "select distinct PROFESOR from profesores order by PROFESOR asc";
//echo $SQL;
$result = mysql_query($SQL);

	while($row = mysql_fetch_array($result))
	{
	$profe = $row[0];
	echo "<option  class=content>" . $profe . "</option>";
}
	// Selecci&oacute;n de las asignaturas del profesor
?>
          </select></td>
        </tr>
        <tr>
          <td id='filaprincipal'>Departamento</td>
          <td><select id="departamento"  name = "departamento">
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
            <option>Ingl&eacute;s</option>
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
          <td id='filaprincipal'>Tipo de Recurso</td>
          <td><select id="categoria" name = "categoria">
            <option><? echo $categoria; ?></option>
            <option></option>
            <option>P&aacute;gina Web</option>
            <option>WEBQUESTS</option>
            <option>CAZA DE TESOROS</option>
            <option>EJERCICIOS INTERACTIVOS</option>
            <option>Otros..</option>
          </select></td>
        </tr>
        <tr>
          <td id='filaprincipal'>T&iacute;tulo para el Recurso </td>
          <td><input name="titulo" value = '<? echo $titulo; ?>' type="text" size="60" /></td>
        </tr>
        <tr>
          <td id='filaprincipal'>Descripci&oacute;n, Comentario, Observaciones, Palabras Clave. </td>
          <td><textarea name="descripcion" cols="56" rows="5" id="descripcion"><? echo $descripcion; ?></textarea></td>
        </tr>
        <tr>
          <td id='filaprincipal'>Direcci&oacute;n de la P&aacute;gina </td>
          <td><input type="text" id="direccion" size="60" name = "direccion" value = "<? 
	if($direccion)	
	{echo $direccion;}
	else {echo "http://";} ?>" /></td>
        </tr>
        <tr>
          <td id='filaprincipal'>Nivel </span>(Optativo) </td>
          <td><select name="nivel" style="">
            <option><? echo $nivel; ?></option>
            <?
 $SQLcurso = "select distinct NIVEL from profesores";
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
          <td id='filaprincipal'>Asignatura </span>(Optativo)</td>
          <td><?
	 $asignatura0 = "select distinct MATERIA from profesores order by MATERIA asc";
//echo $asignatura0;
	?>
                <select name="asignatura" style="">
                  <option> <? echo $asignatura; ?></option>
  
                  <?
$resultasignatura = mysql_query($asignatura0);
	while($rowasignatura = mysql_fetch_array($resultasignatura))
	{
	$asignaturas = $rowasignatura[0];

	echo "<option>" . $asignaturas . "</option>";
}
}

?>
              </select></td>
        </tr>
        <tr>
          <td width="35%" colspan="2"><center>
	<input type="hidden" name='id' <? echo "value='" . $id . "'" ?> />
    <input type="hidden" name='fecha' <? echo "value='" . $fecha1 . "'" ?> />
	<div align="center"><input name="actualizar" type="submit" id="formsubmit" value="Actualizar Datos"></div>
          </td>
        </tr>
      </table>
    </form></div>
<?
}
?>
</body>
</html>
