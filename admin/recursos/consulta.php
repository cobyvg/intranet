
<?php
  
if (empty($consultar)) {
	?>
	
<? }
?>


<div class='titulin'  style='width:400px;margin:auto; color:#281;margin-top:0px;margin-bottom26px; text-align:center'>Consulta de Recusos Educativos</div>
<div align="center">
<form action="index.php" method="post">
  <table class="tabla" style="">
    <tr style="text-align:center">
      <td id="filaprincipal">Departamento</td>
      <td id="filaprincipal">Tipo de Recurso</td>
      <td id="filaprincipal">Nivel</td>
      <td id="filaprincipal">Asignatura</span><br />
          <?

	?>
	</td>
    </tr>
    <tr  style="text-align:center">
      <td><select id="departamento" name = "departamento">
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
      </select></td>
      <td><select id="categoria" name = "categoria">
        <option><? echo $categoria; ?></option>
        <option></option>
        <option>P&Aacute;GINA WEB</option>
        <option>WEBQUESTS</option>
        <option>CAZA DE TESOROS</option>
        <option>EJERCICIOS INTERACTIVOS</option>
        <option>Otros..</option>
      </select></td>
      <td><select name="curso" style="font-size:90%;" onChange="submit()">
	          <option> <? echo $curso; ?></option>
        <option></option>
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
      <td><select name="asignatura" style="font-size:90%;">
 
        <option><? echo $asignatura;?></option>
        <?
			if($nivel)
	{
	echo "<option></option>";
$asignatura0 = "select distinct MATERIA from profesores where NIVEL = '$curso'";
$resultasignatura = mysql_query($asignatura0);
	while($rowasignatura = mysql_fetch_array($resultasignatura))
	{
	$asignatura1 = $rowasignatura[0];
	echo "<option>" . $asignatura1 . "</option>";
	}
}
?>
      </select></td>
    </tr>

	<tr  style="text-align:center">
      <td colspan="4" style="color:#369;">Texto que buscamos&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="titulo" value = "<? echo $titulo; ?>" type="text" size="45" />
        <input type="hidden" name='fecha' <? echo "value='" . $fecha1 . "'" ?> />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="consultar" type="submit" id="consultar" value="Consultar los recursos" /></td>
    </tr>
  </table>
</form>
</div>

<? if($consultar == "")
{
?>
<div align="center">
  <table width="75%" class="tabla">
    <tr>
      <td style="padding:10px;">
        <div align="left" class="text">          En esta Consulta, ning&uacute;n campo es obligatorio, as&iacute; que si no introducimos datos veremos la totalidad de los Recursos Educativos registrados. La Consulta se volver&aacute; m&aacute;s selectiva si seleccionamos Departamento, Tipo de Recurso, Nivel o Asignatura. El campo Nivel es necesario seleccionarlo si queremos ver las Asignaturas que le corresponden.<br />
          El campo quiz&aacute;s m&aacute;s importante es el &uacute;ltimo, &quot;Texto que buscamos&quot;. Escribiendo una palabra, la Consulta buscar&aacute; recursos que contengan esa palabra en el T&iacute;tulo o en la Descripci&oacute;n del mismo.<br />
        Una vez tengamos en pantalla la lista de los recursos que responden a nuestra consulta, podemos editarlos o eliminarlos. </div>      </td>
    </tr>
  </table>
  </div>
<? }
else
{
 #Comprobamos si se ha metido Apellidos o no.
    if  (TRIM("$departamento")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and departamento like '$departamento%'";
    }
  if  (TRIM("$categoria")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and categoria like '$categoria%'";
    }
		  if  (TRIM("$curso")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and curso like '$curso%'";
    }
	  if  (TRIM("$asignatura")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and asignatura like '$asignatura%'";
    }
		  if  (TRIM("$titulo")=="")
    {
    $AUXSQL .= " AND 1=1 ";
    }
    ELSE
    {
    $AUXSQL .= " and titulo like '%$titulo%' or descripcion like '%$titulo%' or subclase like '%$titulo%'";
    }

echo "<div align='center'><div class='titulin' style='font-size:12px;width:400px;margin:auto; color:#369;margin-bottom:20px;margin-top:35px;text-align:center'>Recursos disponibles en la Base de Datos.</div>";
$informe = "select id, titulo, descripcion, categoria, departamento, profesor, nivel, asignatura, direccion, subclase from recursos where 1=1 " . $AUXSQL . " order by id";
// echo $informe;
$sqlinforme = mysql_query($informe);
if(mysql_num_rows($sqlinforme) == 0)
{
echo " <table width=50% class='tabla'>
   <tr>
     <td><div align=center class=clasenoticia>No hay Recursos Educativos registrados con esos datos.</DIV></td>
   </tr>
 </table></div>";
}
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
	$subclase = $rowinforme[9];
	
echo "<div align='left'><a href='$rowinforme[8]'><span class='titulin' style='margin-left:150px;color:#281; font-size:12px;'>$rowinforme[1]</span></a></div>
<div align='center'><table width='940' class='tabla' style=';'>
  <tr>
    <td width=65% ID='filaprincipal'>T&Iacute;TULO: $rowinforme[1]</td>
      <td width=35% ID='filaprincipal'>DEPARTAMENTO: $rowinforme[4]</td>
    </tr>
  <tr>
    <td ID='filasecundaria'>DESCRIPCI&Oacute;N: $rowinforme[2]</td>
      <td ID='filasecundaria'>PROFESOR: $rowinforme[5]</td>
    </tr>
    
  <tr>
    <td ID='filaprincipal'>CATEGOR&Iacute;A: $rowinforme[3]</td>
      <td ID='filaprincipal'>NIVEL: $rowinforme[6]</td>
    </tr>
    
      <tr>
    <td ID='filasecundaria'>ASIGNATURA: $rowinforme[7]</td>
      <td ID='filasecundaria'>ÁREA: $rowinforme[9] </td>
    </tr>
    
  </table>
<table  class='tabla'  style='margin-left:150px; margin-top:0px; margin-bottom:15px; width:150px;text-align:center; '>  <tr>
    <td style='background-color:#efe'><a href=editar.php?id=$id>Editar</a></td>
    <td style='background-color:#efe'><a href=eliminar.php?id=$id>Eliminar</a></td>
  </tr>
</table>  
</div>";
}
}
?>

