<?
include ("../encabezado.inc.php");
include_once ("../funciones.inc.php"); 
include("../conexion.inc.php"); #La conexion es $c

$profe = $profe_sesion;
#$unidad=$_SESSION['unidad_s'];

if(!tiene_el_perfil($permiso,'148'))
{
echo "<br><br><div class='menu' align='center'>La página a la que estás accediendo esta restringida.<br><br>";
echo 'Si piensas que es un error consulta con el administrador.<br><br>';
echo "<a href='../index.php'>Volver a la Intranet</a></div><br><br>";
include('../pie.inc');
mysql_close();
exit;	
}
if (!isset($_SESSION['temp_depto'])){$_SESSION['temp_depto']='';}
if (isset($_GET['zdepto'])){$cond_depto=$_GET['zdepto'];}else{$cond_depto=$_SESSION['temp_depto'];}
$_SESSION['temp_depto']=$cond_depto;
echo "<br><div align='center' class='titulo'><b>Gestión del Departamento</b></div><br>";
echo "<form name='formndeptos' method='GET' action='?'>";
echo '<table  width=50% align=center border=0 class="opciones">';
echo "<tr><td colspan='3' align='center'>";
#bgcolor="#aad0df"

#echo "</td></tr>";
#echo "<tr><td>";			


$deptos_array=array('Ciencias Naturales', 'Ciencias Sociales', 'Educacón Física','Educación Plástica','Francés','Inglés', 'Lengua Castellana y Literatura','Matemáticas','Música','Tecnología');


echo "<div class='menu'>Elige el Departamento: <select name='zdepto' onchange='submit()'>";
echo "<Option></option>";
foreach($deptos_array as $deptos){
if($deptos==$cond_depto){echo "<Option selected value='$deptos'>$deptos</option>";}else{echo "<Option value='$deptos'>$deptos</option>";}
}
echo "</select></div>";
echo "</td>";
echo "";											
echo "</tr>";
echo "<tr><td>";											
echo "</form>";

if ($cond_depto!='' or $cond_depto!=Null )
{
?>	 <center><br><table width="400px"  border="0">
	    <tr bordercolor="#000099" bgcolor="#acbcda" class="cabecera_menu">
	      <td width="32%" scope="col"><span><center>Mantenimiento del Departamento.</center></span></th>
	    </tr>

<?	/*    <tr bordercolor="#000099" bgcolor="#acdaca">
	      <td><div align="center" class="opciones"><a href="diario.php?grupo=<?echo $cond_depto;?>">Acción tutorial. Diario.</a></div></td>
	    </tr>
	<tr bordercolor="#000099" bgcolor="#acdaca">
	    <td><div align="center" class="opciones"><a href="puestos.php?grupo=<?echo $cond_depto;?>">Asignación de puestos</a></div></td></tr>
	    <tr bordercolor="#000099" bgcolor="#acdaca">
	      <td><div align="center" class="opciones"><a href="recuentos.php?grupo=<?echo $cond_depto;?>">Estadísticas y recuentos</a></div></td>
	    </tr>
					 <tr bordercolor="#000099" bgcolor="#acdaca">
					      <td><div align="center" class="opciones"><a href="horario_tutoria.php?grupo=<?echo $cond_depto;?>">Horario de tutoría</a></div></td>
					    </tr>
				 <tr bordercolor="#000099" bgcolor="#acdaca">
				      <td><div align="center" class="opciones"><a href="tarjeta_tutor.php?select=<?echo $cond_depto;?>&profe=<?echo $profe_sesion;?>">Tarjeta tutor/a</a></div></td>
				    </tr> 


*/ ?>
	 <tr bordercolor="#000099" bgcolor="#acdaca">
	      <td><div align="center" class="opciones"><a href="memoria.php?depto=<?echo $cond_depto;?>">Memoria final del departamento</a></div></td>
	    </tr>
	
	  </table><center>
	<?
} # de si el grupo no está vacio											

##############################
echo "</td></tr>";
?>
</table>
<br>
<?
mysql_close();
##############################
include('../pie.inc');?>
