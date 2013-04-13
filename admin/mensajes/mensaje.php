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
<? 
?>
<?
include("../../menu.php");
include("menu.php");

?>
</div>
<?
 
mysql_connect($db_host, $db_user, $db_pass) or die ("Imposible conectar!");
mysql_select_db($db) or die ("Imposible seleccionar base de datos!");
$query = "SELECT asunto, ahora, texto, origen FROM mens_texto where id = '$id'";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$row = mysql_fetch_array($result);

if ($row)
{?>
<?
echo "<br /><br /><div align='CENTER'> <table class='table table-striped' style='width:800px;'>
            <tr valign=Top> 
            <th>$row[0]
				</th>
			<th><h6><small>";
			fecha_actual($row[1]);
			echo "
             	</small></h6></th>
              </tr>
           <tr> 
            <td colspan=2><blockquote>$row[2]</blockquote>
            <form action='index.php'>
            <input type='hidden' name='profes' value='1' />
            <input type='hidden' name='origen' value='$row[3]' />
            <input type='hidden' name='asunto' value='$row[0]' />
            <INPUT  type='submit' name='responder' value='Responder al Mensaje' class='btn btn-success'>
            </form>
              </td>
             </tr>
       	";?>
  		<?
echo "<tr> <th colspan='2'>Destinatarios del Mensaje
				</th></tr><tr><td colspan='2'>";
$query0 = "SELECT recibidoprofe, profesor from mens_profes where id_texto = '$id'";
$result0 = mysql_query($query0);
while($row0 = mysql_fetch_array($result0))
{
$n_profesor = $row0[1];
if($row0[0] == '1')
{
echo "<span style='color:#46a546;'>$n_profesor; </span>";
}
else
{
echo "<span style='color:#9d261d;'>$n_profesor; </span>";
}
}
	echo "</td></tr>";	
		?> 
         <tr>
            <td style='padding:10px;' colspan=2><h6><small>Enviada: <? echo fecha_actual($row->timestamp); ?><br> Autor: <? echo $row[3]; ?>
              </small></h6></td></tr>
              
              </table>
              <a href="../../index0.php" class="btn btn-primary">Volver a la página principal</a></div>
							 
  <?
}
else
{
?>
<p>El Mensaje no se encuentra en la base de datos.</p>
<?
}

// close database connection

?>
</body>
</html>
