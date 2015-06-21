<?
require('../../bootstrap.php');


include("../../menu.php");
include("menu.php");
 ?>
<div align=center>
<div class="page-header">
  <h2>Problemas de convivencia <small> Borrar problema</small></h2>
</div>
<br />
<?
if(isset($_GET['id'])){$id = $_GET['id'];}else{$id="";}

$db_con = mysqli_connect($db_host, $db_user, $db_pass) or die ("No es posible conectar con la base de datos!");
mysqli_select_db($db_con, $db) or die ("No es posible conectar con la base de datos!");
$query = "DELETE FROM Fechoria WHERE id = '$id'";
$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));
mysqli_close($db_con);
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Atención:</strong>
			El problema de convivencia ha sido borrado de la base de datos.
          </div></div>';
?>

</div>  
</body>
</html>
