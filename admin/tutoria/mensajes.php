<p class='lead'>Mensajes de Tutoría</p>
            <?php
// Conexión al Servidor
 
  $c=mysql_connect ($db_host, $db_user, $db_pass);
  

// Consulta
$query = "SELECT id, ahora, apellidos, nombre, asunto, texto from alma, mensajes where alma.claveal = mensajes.claveal and mensajes.unidad = '$unidad' and date(ahora) > '$inicio_curso' ORDER BY id desc";
// echo $query;
$result = mysql_query($query,$c) or die ("Error in query: $query. " . mysql_error());

if (mysql_num_rows($result) > 0)
{
// Si hay datos
  echo "<table class='table table-striped table-condensed' style='width:100%'>";
		?>
<?
echo "<tr>
		<th>Alumno</th>
		<th>Fecha</th>
</TR>";
	while($row = mysql_fetch_object($result))
	{
$n_mensajes=$n_mensajes+1;
$tr = explode(" ",$row->ahora);
$fecha_mens = $tr[0];
$fech = explode("-",$fecha_mens);
$fechaenv = "el $fech[2] del $fech[1] de $fech[0]";
$alumno = "$row->apellidos, $row->nombre";
  echo "<tr height='25'>
   <TD><A data-toggle='modal' href='#mensaje$n_mensajes' >$alumno</a></TD>
   <TD nowrap>$fecha_mens</TD></tr>";
?>

<div id="mensaje<?php echo $n_mensajes; ?>" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title"><?php echo $row->asunto;?><br /><small>Enviado por <?php echo $alumno; ?> <?php echo $fechaenv; ?></small></h4>
      </div>
      <div class="modal-body">
        <p><?php echo $row->texto;?></p>
      </div>
      <div class="modal-footer">
        <form method="post" name="mensaje_enviado" action="index.php" class="form-inline">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        <a class="btn btn-primary" href="../mensajes/redactar.php?padres=1&asunto=<?php echo $row->asunto; ?>&origen=<?php echo $alumno; ?>">Responder</a>
	        <input type="hidden" name="id_ver" value="<?php echo $id; ?>">
	      </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?
	}
echo " </table>";
}
?>  


