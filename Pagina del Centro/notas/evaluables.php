<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$claveal = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];
	$curso = $unidad;
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	
<?
 $rown1[]="";
 $rown2[]="";
 $rown3[]="";
 $rown4[]="";
   	echo "<h3 align='center'>$todosdatos<br /></h3>";   	
   	echo "<p class='lead muted' align='center'><i class='icon icon-th-list'> 
</i> Actividades evaluables</p><hr />";
?>	

	<?php
	$query_evaluables = mysql_query("SELECT notas_cuaderno.profesor AS 
nomprofesor, asignaturas.NOMBRE AS nomasignatura, notas_cuaderno.id AS 
idactividad, notas_cuaderno.nombre AS nomactividad, notas_cuaderno.fecha AS 
fecactividad FROM notas_cuaderno JOIN asignaturas ON notas_cuaderno.asignatura = 
asignaturas.CODIGO WHERE notas_cuaderno.curso like '%$unidad%' AND 
notas_cuaderno.visible_nota=1") or die (mysql_error());
	?>
	
	<?php if(!mysql_num_rows($query_evaluables)): ?>
	
	<div class="alert alert-info">
		<strong>Información:</strong> No hay actividades evaluables.
	</div>
	
	<?php else: ?>
	<br><table class="table table-bordered table-striped" style="width:auto;margin:auto"">
	    <tr class='text-info'>
	      <th>Asignatura</th>
	      <th>Actividad</th>
	      <th>Fecha</th>
	      <th>Calificación</th>
	    </tr>
	  <tbody>
	    <?php while ($actividad = mysql_fetch_object($query_evaluables)): ?>
	    <tr>
	      <td><?php echo $actividad->nomasignatura; ?></td>
	      <td><?php echo $actividad->nomactividad; ?></td>
	      <td><?php echo $actividad->fecactividad; ?></td>
	      <?php
	      $query_calificacion = mysql_query("SELECT nota FROM datos WHERE 
claveal='$claveal' AND id='$actividad->idactividad'");
	      $actividad_nota = mysql_fetch_object($query_calificacion);
	      ?>
	      <td><?php echo $actividad_nota->nota; ?></td>
	    </tr>
	    <?php endwhile; ?>
	  </tbody>
	</table>
	<?php endif; ?>

</div>
</div>
 <? include "../pie.php"; ?>
