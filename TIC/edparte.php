<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../menu.php");
include("menu.php");
?>

<div align=center>
 <div class="page-header" align="center">
  <h2>Centro TIC <small> Editar incidencia</small></h2>
</div>
<br />
<?
if(isset($_POST['ed_enviar']))
{
$query = "UPDATE partestic SET nivel = '$nivel', grupo = '$grupo', carro = '$carrito', nserie = '$numero', fecha = '$fecha', hora = '$hora', alumno = '$alumno', profesor = '$profesor', descripcion = '$descripcion'";
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
$query.=", estado = '$estado', nincidencia = '$nincidencia'";
}
$query.=" WHERE parte = '$parte'";
$result = mysql_query($query) or die ("Error en la actualización: $query. " . mysql_error());
if($result == "1")
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la incidencia han sido actualizados correctamente.
</div></div>';
?>
<script language="javascript">
<? 
// Redireccionamos al Cuaderno    
$mens = "clista.php";
?>
setTimeout("window.location='<? echo $mens; ?>'", 1500) 
</script>
<?
exit;
}

else{
$query = "SELECT parte, nivel, grupo, carro, nserie, fecha, hora, alumno, profesor, descripcion, estado, nincidencia FROM  partestic where parte = '$parte'";
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) > 0)
	{
	$row = mysql_fetch_array($result);
	$nivel = $row[1];
	$grupo = $row[2];
	$carrito = $row[3];
	$numero = $row[4];
	$fecha = $row[5];
	$hora = $row[6];
	$alumno = $row[7];
	$profesor = $row[8];
	$descripcion = $row[9];
	$estado = $row[10];
	$nincidencia = $row[11];
	?>
<div align="center">
  <div class="well well-large" style="width:400px;" align="left">
  <form action='edparte.php' method='post'>
    <?
if(stristr($_SESSION['cargo'],'1') == TRUE)
{

?>
    <label style="display:inline">Estado&nbsp;&nbsp;
      <select name="estado" id="estado" class="input-small">
        <option><? echo $estado;?></option>
        <option>Activo</option>
        <option>Solucionado</option>
      </select>
    </label>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label style="display:inline">Nº de incidencia&nbsp;&nbsp;
      <input name="nincidencia" type="text" class="input-mini" maxlength="8" value="<? echo $nincidencia;?>" />
    </label>
<hr>
<?
}
?>
    <label style="display:inline">Nivel
      <select name="nivel" onChange="submit()" class="input-mini">
        <option><? echo $nivel;?></option>
        <? nivel();?>
      </select>
    </label>
    <label style="display:inline">&nbsp;&nbsp;&nbsp;Grupo
      <select name="grupo" onChange="submit()" class="input-mini">
        <option><? echo $grupo;?></option>
        <? grupo($nivel);?>
      </select>
    </label>
    <hr>
    <label>Alumno<br />
      <select name="alumno"  class="span4">
        <option><? echo $alumno;?></option>
        <?
  $alumnosql = mysql_query("SELECT distinct APELLIDOS, NOMBRE FROM FALUMNOS where nivel='$nivel' and grupo='$grupo'  order by APELLIDOS asc");

  if ($falumno = mysql_fetch_array($alumnosql))
        {
        do {
	printf ("<OPTION>$falumno[0], $falumno[1]</OPTION>");

	} while($falumno = mysql_fetch_array($alumnosql));
        }
	?>
      </select>
    </label>
    <label>Profesor<br />
      <select name="profesor" class="span4">
        <OPTION><? echo $profesor;?></OPTION>
        <?
  // Datos del Profesor que hace la consulta. No aparece el nombre del a&ntilde;o de la nota. Se podr&iacute;a incluir.
  $profe = mysql_query(" SELECT NOMBRE FROM departamentos order by NOMBRE asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      printf ("
		  <OPTION>$filaprofe[0]</OPTION>");

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
      </select>
    </label>
    <hr>
    <label style="display:inline">
    N&ordm; Carro&nbsp;&nbsp;
    <input name="carrito" type="text" id="carrito" size="2" maxlength="2" value="<? echo $carrito;?>" class="input-mini"/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </label>
    <label style="display:inline">N&ordm; del ordenador&nbsp;&nbsp;
      <input name="numeroserie" type="text" id="numeroserie"  maxlength="2" value="<? echo $numero;?>" class="input-small" />
    </label>
    <?
                if(!(empty($numero)) and !(empty($carrito)))
{
$n_serie0=mysql_query("select serie from ordenadores_tic where carrito='$carrito' and numero='$numero'");
$n_serie=mysql_fetch_array($n_serie0);
// echo "select serie from ordenadores_tic where carrito='$carrito' and numero='$numero'";
if(mysql_num_rows($n_serie0) == "1")
{
?>
    <label>Nº de serie<br />
      <?  echo $n_serie[0];?>
    </label>
    <?
}
}
?>
<hr>
    <label style="display:inline">Fecha&nbsp;&nbsp;
      <input name="fecha" id="fecha" size="10" maxlength="10" value="<? echo $fecha;?>"  class="input-small"/>
    </label>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label style="display:inline">Hora (1, 2, etc.)&nbsp;&nbsp;
      <input name="hora" type="text" id="hora" maxlength="1" size="1" value="<? echo $hora;?>" class="input-mini"/>
    </label>
    <hr>
    <label>Descripción del problema <br />
      <textarea name="descripcion" rows="5"  class="span4" id="descripcion"><? echo $descripcion;?></textarea>
    </label>
    <br />
    <input name="parte" type="hidden" id="parte" value="<? echo $parte;?>"/>
    <input name="ed_enviar" type="submit" id="enviar" value="Actualizar datos de la Incidencia" class="btn btn-primary" />
    </div>
  </form>
</div>
</div>
<? }?>
</body></html><?
}
?>