<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


$idea = $_SESSION ['ide'];
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activ1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'mensajes')==TRUE){ $activ2 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'upload')==TRUE){ $activ3 = ' class="active" ';}

$PLUGIN_DATATABLES = 1;

include("../../menu.php");
include("menu.php");

if(isset($_GET['id'])){$id = $_GET['id'];}
?>
<style>
.table th{
	font-size:0.8em;
	vertical-align:top !important;
}
</style>
  <?php

  echo "<div class='container'>";
  echo '<div class="page-header">
    <h2>Problemas de convivencia <small>Últimos problemas</small></h2>
  </div>';
  echo '<div class="row">';
  echo '<div class="col-sm-12">';
      
    echo '<div class="text-center" id="t_larga_barra">
    	<span class="lead"><span class="fa fa-circle-o-notch fa-spin"></span> Cargando...</span>
    </div>';
     		 
    echo "<div id='t_larga' style='display:none' >";
  if (isset($_POST['confirma'])) {
  	foreach ($_POST as $clave => $valor){
  		if (strlen($valor) > '0' and $clave !== 'confirma') {
  		$actualiza = "update Fechoria set confirmado = '1' where id = '$clave'";
  		$act = mysqli_query($db_con, $actualiza);		
  		} 
  	}
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El registro ha sido confirmado.
          </div></div>';
  }
   if(isset($_GET['borrar']) and $_GET['borrar']=="1"){
$query = "DELETE FROM Fechoria WHERE id = '$id'";
$result = mysqli_query($db_con, $query) or die ("Error en la Consulta: $query. " . mysqli_error($db_con));
echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El registro ha sido eliminado de la base de datos.
          </div></div>';	
}
  
  mysqli_query($db_con, "drop table Fechcaduca");
  mysqli_query($db_con, "create table Fechcaduca select id, fecha, TO_DAYS(now()) - TO_DAYS(fecha) as dias from Fechoria order by fecha desc limit 500");
  mysqli_query($db_con, "ALTER TABLE  `Fechcaduca` ADD INDEX (  `id` )");
  mysqli_query($db_con, "ALTER TABLE  `Fechcaduca` ADD INDEX (  `fecha` )");
  $query0 = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, FALUMNOS.nc, Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.claveal, Fechoria.id, Fechoria.expulsion, Fechoria.expulsionaula, Fechoria.medida, Fechoria.tutoria, recibido, dias, aula_conv, inicio_aula, fin_aula, confirmado, horas from Fechoria, FALUMNOS, Fechcaduca where Fechcaduca.id = Fechoria.id and FALUMNOS.claveal = Fechoria.claveal  order by Fechoria.fecha desc limit 500";
  // echo $query0;
  $result = mysqli_query($db_con, $query0);
 echo "<form action='lfechorias.php' method='post' name='cnf'>
 <table class='table table-bordered' style='width:auto' align='center'><tr><td class='expulsion-centro'>Expulsión del Centro</td><td class='amonestacion-escrita'>Amonestación escrita</td><td class='expulsion-aula'>Expulsión del aula</td><td class='aula-convivencia-jefatura'>Aula de convivencia (Jefatura)</td><td class='aula-convivencia-profesor'>Aula de convivencia (Profesor)</td></tr></table><br />";
		echo '<div class="table-responsive"><table class="table table-striped table-bordered table-vcentered datatable">';
		$fecha1 = (date("d").-date("m").-date("Y"));
        echo "<thead><tr>
		<th></th>
        <th>ALUMNO</th>
		<th nowrap>UNIDAD</th>
		<th>FECHA</th>
		<th>TIPO</th>
		<th>INFORMA</th>
		<th>GRAV.</th>
		<th>NUM.</th>
		<th>CAD.</th>		
		<th></th>
		<th></th>
		<th></th>
		</tr></thead><tbody>";	
   while($row = mysqli_fetch_array($result))
        {
        $marca = '';
		$apellidos = $row[0];
		$nombre = $row[1];
		$unidad = $row[2];
		$fecha = $row[4];
		$asunto = $row[5];
		$informa = $row[6];
		$grave = $row[7];
		$claveal = $row[8];
		$id = $row[9];
		$expulsion=$row[10];
		$expulsionaula=$row[11];
		$medida=$row[12];
		$tutoria=$row[13];
		$recibido=$row[14];
		$dias=$row[15];
		$aula_conv=$row[16];
		$inicio_aula=$row[17];
		$fin_aula=$row[18];
		$confirmado=$row[19];
		$horas=$row[20];
		if ($confirmado == '1') {
			$marca = " checked = 'checked'";
		}
		if(($dias > 30 and ($grave == 'leve' or $grave == 'grave')) or ($dias > 60 and $grave == 'muy grave'))
		{$caducada="Sí";} else {$caducada="No";}
		$numero = mysqli_query($db_con, "select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' and Fechoria.fecha >= '$inicio_curso' order by Fechoria.fecha"); 
		$rownumero= mysqli_num_rows($numero);
		$rowcurso = $unidad;
        $rowalumno = $nombre."&nbsp;".$apellidos;
				$bgcolor="class=''";
				if($medida == "Amonestación escrita" and $expulsionaula !== "1" and $expulsion == 0){$bgcolor="class='amonestacion-escrita'";}
				if($expulsionaula == "1"){$bgcolor="class='expulsion-aula'";}
				
				if($aula_conv > 0){
					if ($horas == "123456") {
						$bgcolor="class='aula-convivencia-jefatura'";
					}
					else{
						$bgcolor="class='aula-convivencia-profesor'";
					}
				}	
				
				if($expulsion > 0){$bgcolor="class='expulsion-centro'";}		
				if($recibido == '1'){$comentarios1="<i class='fa fa-check' data-bs='tooltip'  title='El Tutor ha recibido la notificación.'> </i>";}elseif($recibido == '0'  and ($grave == 'grave' or $grave == 'muy grave' or $expulsionaula == '1' or $expulsion > '0' or $aula_conv > '0')){$comentarios1="<i class='fa fa-exclamation-triangle'  data-bs='tooltip' title='El Tutor NO ha recibido la notificación.'> </i>";}else{$comentarios1="";}
		echo "<tr>
		<td>";
		$foto="<span class='fa fa-user fa-fw fa-3x'></span>";
		if(file_exists('../../xml/fotos/'.$claveal.'.jpg')) $foto = "<img src='../../xml/fotos/$claveal.jpg' width='50'>";
		echo $foto."</td>";
		echo "<td>$rowalumno</td>
		<td>$rowcurso</td>
		<td nowrap>$fecha</td>
		<td>$asunto</td>
		<td><span  style='font-size:0.9em'>$informa</span></td>
		<td $bgcolor>$grave</td>
		<td><center>$rownumero</center></td>
		<td>$caducada</td>
		<td nowrap>$comentarios1 $comentarios</td><td nowrap>"; 	

		echo " <a href='detfechorias.php?id=$id&claveal=$claveal'><span class='fa fa-search fa-fw fa-lg' data-bs='tooltip' title='Detalles'></span></a>
		<a href='lfechorias2.php?clave=$claveal'><span class='fa fa-history fa-fw fa-lg' data-bs='tooltip' title='Historial'></span></a>
		";
        if($_SESSION['profi']==$row[6] or stristr($_SESSION['cargo'],'1') == TRUE){echo "<a href='infechoria.php?id=$id&claveal=$claveal'><span class='fa fa-edit fa-fw fa-lg' data-bs='tooltip' title='Editar'></span></a><a href='lfechorias.php?id= $row[9]&borrar=1' data-bb='confirm-delete'><span class='fa fa-trash-o fa-fw fa-lg' data-bs='tooltip' title='Eliminar'></span></a>";}
		echo "</td>
		<td>";
		//echo "$expulsion >  $expulsionaula";
		if (stristr($_SESSION['cargo'],'1')) {
			echo "<input type='checkbox' name='$id' value='1' $marca onChange='submit()' />";			
		}		
		echo "</td></tr>";
        }
        echo "</tbody></table></div>";
        echo "<input type='hidden' name='confirma' value='si' />";
        echo "</form>";
		echo "</div></div></div></div>";
  ?>
  <? include("../../pie.php");?>
  
  <script>
  $(document).ready(function() {
    var table = $('.datatable').DataTable({
    		"paging":   true,
        "ordering": true,
        "info":     false,
        
    		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
    		
    		"order": [[ 2, "desc" ]],
    		
    		"language": {
    		            "lengthMenu": "_MENU_",
    		            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
    		            "info": "Página _PAGE_ de _PAGES_",
    		            "infoEmpty": "No hay resultados disponibles.",
    		            "infoFiltered": "(filtrado de _MAX_ resultados)",
    		            "search": "Buscar: ",
    		            "paginate": {
    		                  "first": "Primera",
    		                  "next": "Última",
    		                  "next": "",
    		                  "previous": ""
    		                }
    		        }
    	});
  });
  </script>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>     
  </body>
  </html>
