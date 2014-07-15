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

<div class="modal hide fade" id="mensaje<? echo $n_mensajes;?>">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h4>Mensaje de <? echo $alumno;?> </h4><br /><small>Enviado <? echo $fechaenv;?></small>
  </div>
  <div class="modal-body">
<p><? echo $row->asunto;?></p>
<p><? echo $row->texto;?></p>  </div>
  <div class="modal-footer">
  <form name="mensaje_enviado" action="index.php" method="post" enctype="multipart/form-data" class="form-inline">
  <a href="#" class="btn btn-warning" data-dismiss="modal">Cerrar</a>
    <?

echo '<a href="../mensajes/index.php?padres=1&asunto='.$row->asunto.'&origen='.$alumno.'" target="_top" class="btn btn-primary">Responder</a>';
?>
<input type='hidden' name = 'id_ver' value = '$id' />
</form>
</div>
</div>
<?
	}
echo " </table>";
}
?>  


