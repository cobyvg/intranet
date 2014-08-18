<?
ini_set("session.cookie_lifetime","2800");
ini_set("session.gc_maxlifetime","3600");
session_start();
include("config.php");
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


$pr = $_SESSION['profi'];

include("menu.php");

// Variables
if (isset($_GET['profesor'])) {
	$profesor = $_GET['profesor'];
}
elseif (isset($_POST['profesor'])) {
	$profesor = $_POST['profesor'];
}

if (isset($_GET['dia'])) {
	$dia = $_GET['dia'];
}
elseif (isset($_POST['dia'])) {
	$dia = $_POST['dia'];
}

if (isset($_GET['hora'])) {
	$hora = $_GET['hora'];
}
elseif (isset($_POST['hora'])) {
	$hora = $_POST['hora'];
}

if (isset($_GET['curso'])) {
	$curso = $_GET['curso'];
}
elseif (isset($_POST['curso'])) {
	$curso = $_POST['curso'];
}

if (isset($_GET['asignatura'])) {
	$asignatura = $_GET['asignatura'];
}
elseif (isset($_POST['asignatura'])) {
	$asignatura = $_POST['asignatura'];
}

if (isset($_GET['nom_asig'])) {
	$nom_asig = $_GET['nom_asig'];
}
elseif (isset($_POST['nom_asig'])) {
	$nom_asig = $_POST['nom_asig'];
}

if (isset($_GET['clave'])) {
	$clave = $_GET['clave'];
}
elseif (isset($_POST['clave'])) {
	$clave = $_POST['clave'];
}
if (isset($_GET['seleccionar'])) {
	$seleccionar = $_GET['seleccionar'];
}
elseif (isset($_POST['seleccionar'])) {
	$seleccionar = $_POST['seleccionar'];
}

$pr = $_SESSION['profi'];
// Elegir Curso y Asignatura.
if(empty($curso))
{
	include("index.php");
	exit;
}
mysql_query("ALTER TABLE  datos CHANGE  nota VARCHAR( 48 ) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT  '' ");

// Titulo
echo "<div class='container'><div class='row'>";
echo "<br /><div class='page-header hidden-print'>";
$n_profe = explode(", ",$pr);
$nombre_profe = "$n_profe[1] $n_profe[0]";
echo "<h2 class='no_imprimir'>Cuaderno de Notas&nbsp;&nbsp;<small>Registro de datos</small></h2>";
echo "</div>";
echo "</div></div>";
echo '<div class="container-fluid"><div class="row-fluid"><div align="center">';

// Enviar datos y procesarlos
if(isset($_POST['enviar']))
{
	include("cuaderno/poner_notas.php");
	//include("horario.php");
	//exit;
}

// echo "$pr --> $dia --> $hora<br />";
if($pr and $dia and $hora)
{
	?>
	<?php
	// Distintos códigos de la asignatura cuando hay varios grupos en una hora.
	$n_c = mysql_query("SELECT distinct  a_grupo, profesores.nivel FROM  horw, profesores where prof = profesor and a_grupo = profesores.grupo and prof = '$pr' and dia = '$dia' and hora = '$hora'");
	while($varias = mysql_fetch_array($n_c))
	{
		if (substr($varias[0],3,2) == "Dd" ) {
			$varias[0] = substr($varias[0],0,4);
		}
		$nombre_asig = $varias[1];
		$nombre_materia = strtolower($nombre_asig);
	}
	$num_cursos0 = mysql_query("SELECT distinct  a_grupo, c_asig, asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'");
	// Todos los Grupos juntos
	$curs = "";
	$codigos = "";
	$nom_asig="";
	while($n_cur = mysql_fetch_array($num_cursos0))
	{
		$curs .= $n_cur[0].", ";
		$codigos.= $n_cur[1]." ";
		$nom_asig = $n_cur[2];
	}
	$codigos = substr($codigos,0,-1);
	// Eliminamos el espacio
	$curs0 = substr($curs,0,(strlen($curs)-1));
	// Eliminamos la última coma para el título.
	$curso_sin = substr($curs0,0,(strlen($curs0)-1));
	//Número de columnas
	$col = "select distinct id, nombre, orden, visible_nota from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura'  and oculto = '0' order by orden asc";
	$col0 = mysql_query($col);
	$cols = mysql_num_rows($col0);
	$sin_coma=$curso;
	
	echo "<p class='lead bg-primary' style='width:50%'>$curso_sin <span class='muted'>( $nom_asig )</span></p><br>";
	
	echo '<form action="cuaderno.php" method="post" name="imprime" class="form-inline">';
	
	if(isset($_GET['seleccionar'])){
		$seleccionar=$_GET['seleccionar'];
	}
	else{
		$seleccionar = "";
	}
	if($seleccionar == "1"){
		?>
<div class="well hidden-print" align="center" style="width: 500px;"><legend>Selecciona
tus Alumnos...</legend> <a href="javascript:seleccionar_tod()"
	class="btn btn-success">Marcarlos todos</a>&nbsp;&nbsp;&nbsp;&nbsp;<a
	href="javascript:deseleccionar_tod()" class="btn btn-danger">Desmarcarlos
todos</a></div>
<br />
		<?
	}
	?>
<div class="col-md-9">	

	<?
		echo "<table class='table table-striped table-condensed' style='width:auto'>";
		echo "<thead><th colspan=2 style='vertical-align:bottom;background-color:#fff'></th>";
		// Número de las columnas de la tabla
		$cols2=0;
		while($col20 = mysql_fetch_array($col0)){
			$icon_eye="";
			$nombre_col="";
			$col2=mysql_query("select distinct id from datos where id = '$col20[0]' ");
			$cols2 += mysql_num_rows($col2); //echo $cols2;
			$ident= $col20[2];
			$id = $col20[0];
			$nombre_col = $col20[1];
			$mens0 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&curso=$curs0&dia=$dia&hora=$hora&id=$id&orden=$ident&nom_asig=$nom_asig";
			if (strlen($nombre_col)>26) {
				$col_vert = substr($nombre_col,0,24)."...";
			}
			else {
				$col_vert = $nombre_col;
			}

			echo "<th nowrap style='background-color:#fff'>
<div style='width:40px;height:130px;'>
<div class='Rotate-90'><span class='text-info text-lowercase' style='font-weight:normal'>$col_vert</span> </div>
</div> </th>";
		}
		if($seleccionar == 1){
			echo "<th nowrap style='background-color:#999; color:#fff'>
<div style='width:40px;height:130px;'>
<div class='Rotate-90'><span class='text-lowercase' style='font-weight:normal'> Selección de alumnos </span></div>
</div> </th>";
		}
		echo "</thead>";
		// Tabla para cada Grupo
		$curso0 = "SELECT distinct  a_grupo, c_asig, asig FROM  horw where prof = '$pr' and dia = '$dia' and hora = '$hora'";
		//echo $curso0."<br />";
		$curso20 = mysql_query($curso0);
		while ($curso11 = mysql_fetch_array($curso20))
		{
			$curso = $curso11[0];
			$nivel_curso = substr($curso,0,1);
			$nombre = $curso11[2];

			// Número de Columnas para crear la tabla
			$num_col = 2 + $cols + $cols2;

			//	Problemas con Diversificación (4E-Dd)
			$profe_div = mysql_query("select * from profesores where grupo = '$curso'");
			if (mysql_num_rows($profe_div)<1) {

				$div = $curso;
				$grupo_div = mysql_query("select distinct unidad from alma where unidad like '$nivel_curso%' and (combasi like '%25204%' or combasi LIKE '%25226%')");
				$grupo_diver = mysql_fetch_row($grupo_div);
				$curso = $grupo_diver[0];
			}
			else{
				if($seleccionar=="1"){	$num_col += 1;	}

			}

			// Seleccionar alumnos
			if($seleccionar=="1"){
				// Si seleccionamos alumnos, se lo indicamos a poner_notas.php
				echo '<input name=seleccionar type=hidden value="1" />';
			}
			// Codigo Curso
			echo '<input name=curso type=hidden value="';
			echo $curs0;
			echo '" />';
			// Profesor
			echo '<input name=profesor type=hidden value="';
			echo $pr;
			echo '" />';
			// Asignatura.
			echo '<input name=asignatura type=hidden value="';
			echo $asignatura;
			echo '" />';
			if (empty($seleccionar)) {
				if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $curso;}
				mysql_select_db($db);
				$hay0 = "select alumnos from grupos where profesor='$pr' and asignatura = '$asignatura' and curso = '$curso_orig'";
				//echo $hay0."<br>";
				$hay1 = mysql_query($hay0);
				$hay = mysql_fetch_row($hay1);
				$todos = "";
				if(mysql_num_rows($hay1) == "1"){
					$seleccionados = substr($hay[0],0,strlen($hay[0])-1);
					$t_al = explode(",",$seleccionados);
					$todos = " and (nc = '300'";
					foreach($t_al as $cadauno){
						$todos .=" or nc = '$cadauno'";
					}
					$todos .= ")";
					// echo "$todos<br>";
				}
			}

			// Alumnos para presentar que tengan esa asignatura en combasi
			$resul = "select distinctrow FALUMNOS.CLAVEAL, FALUMNOS.NC, FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, alma.MATRICULAS, alma.combasi, alma.unidad, alma.curso from FALUMNOS, alma WHERE FALUMNOS.CLAVEAL = alma.CLAVEAL and alma.unidad = '$curso' and (";
			//Alumnos de 2º de Bachillerato
			if (stristr($curso,"1B")==TRUE or stristr($curso,"2B")==TRUE) {
				if (strlen($codigos)>'6') {
					$cod_var='';
					$d_cod = explode(" ",$codigos);
					foreach ($d_cod as $cod_var){
						$resul.=" combasi like '%$cod_var:%' or";
					}
					$resul = substr($resul,0,-3);
					//echo $varias."<br>";
				}
				else{
					$resul.=" combasi like '%$asignatura:%' ";
				}
			}
			else{
				$resul.=" combasi like '%$asignatura:%' ";
			}
			$resul.=") ". $todos ." order by NC";

			//echo $resul;
			$result = mysql_query ($resul);
			while($row = mysql_fetch_array($result))
			{
				$claveal = $row[0];
				$nombre_al =   $row[3];
				$apellidos =   $row[2];
				$nc =   $row[1];
				$grupo_simple =  $row[6];
				if ($row[5] == "") {}
				else
				{
					$inf = 'cuaderno/informe.php?profesor='.$pr.'&curso='.$curso.'&asignatura='.$asignatura.'&nc='.$nc.'&claveal='.$claveal.'&nombre='.$nombre_al.'&apellidos='.$apellidos.'&nom_asig='.$nom_asig.'';
					echo "<tr>";
					?>
		
		
		<td nowrap style='vertical-align: middle'><?
		$foto="";
		$foto = "<img src='xml/fotos/$claveal.jpg' width='50' height='60' class=''  />";
		?> <a href="" onclick="window.open('<? echo $inf;?>')"> <?
		echo $foto;
		?> </a><? echo $row[1];?>&nbsp;</td>
		<td nowrap style='vertical-align: middle' class='text-info'
			style='width:auto;'><a href=""
			onclick="window.open('<? echo $inf;?>')"> <?
			?> &nbsp; <? echo $row[2].', '.$row[3];?></a></td>
			<?
			// Si hay datos escritos rellenamos la casilla correspondiente
			$colu10 = "select distinct id, Tipo from notas_cuaderno where profesor = '$pr' and curso like '%$curso%' and asignatura = '$asignatura' and oculto = '0' order by id";
			$colu20 = mysql_query($colu10);
			while($colus10 = mysql_fetch_array($colu20)){
				$id = $colus10[0];
				$t_dato = $colus10[1];
				$dato0 = mysql_query("select nota, ponderacion from datos where claveal = '$claveal' and id = '$id'");
				$dato1 = mysql_fetch_array($dato0);
				if($dato1[0] < 5){$color="#9d261d";}else{$color="navy";}

				if (stristr($t_dato,"Casilla")==TRUE) {
					$tipo_dato = "<div class='checkbox'><input type='checkbox' name='$id-$claveal' value='1' ";
					if ($dato1[0]==1) {
						$tipo_dato.=" checked ";
					}
					$tipo_dato.=" /></div>";
				}
				elseif (stristr($t_dato,"Número")==TRUE) {
					?>
		<style>
input[type=number]::-webkit-inner-spin-button {
	-webkit-appearance: none;
}
</style>
<?
$tipo_dato = "<input type='number' step='any'  name='$id-$claveal' value='$dato1[0]' rel='Tooltip' title='$dato1[0]' style='max-width:40px;color:$color;height:30px;background-color:#de9'>";
				}
				elseif (stristr($t_dato,"Texto corto")==TRUE) {
					$tipo_dato = "<input type='text' name='$id-$claveal' value='$dato1[0]' rel='Tooltip' title='$dato1[0]' style='width:100%;margin:0px;height:30px;maxlength:3;max-width:40px;background-color:#adc'>";
				}
				else{
					$tipo_dato = "<input type='text' name='$id-$claveal' value='$dato1[0]' rel='Tooltip' title='$dato1[0]' style='height:30px;maxlength:35;background-color:#dbf;max-width:90px;'>";
				}

				echo "<td style='vertical-align:middle; text-align:center;margin:0px;padding:0px;width:auto;'>$tipo_dato</td>";


			}
				}
				// Casilla para seleccionar alumnos
				if($seleccionar == "1")
				{
					if(!(empty($div))){$curso_orig = $div;}else{$curso_orig = $grupo_simple;}
					$grupos2 = "select alumnos from grupos where profesor = '$pr' and curso = '$curso_orig' and asignatura = '$asignatura'";
					$marcado = "";
					$grupos0 = mysql_query($grupos2);
					$grupos1 = mysql_fetch_array($grupos0);
					$sel = explode(",",$grupos1[0]);
					foreach($sel as $nc_sel){if($nc_sel == $nc)
					{
						$marcado = "1";
					}
					}
					if(!(empty($div))){$curso = $div;}
					?>
		<td
			style="vertical-align: middle; text-align: center;; background-color: #999">
		<div class="checkbox"><input
			name="select_<? echo $row[1]."_".$curso;?>" type="checkbox"
			id="selal" <? if ($marcado == "1") {echo "checked ";}?> value="1" /></div>
		</td>
		<?
				}
				echo "</tr>";
			}
		}
		$num_col+=1;
		// Datos ocultos

		// Asignatura.
		echo '<input name=asignatura type=hidden value="';
		echo $asignatura;
		echo '" />';
		// Nombre Asignatura.
		echo '<input name=nom_asig type=hidden value="';
		echo $nom_asig;
		echo '" />';
		// Día.
		echo '<input name=dia type=hidden value="';
		echo $dia;
		echo '" />';
		// Hora.
		echo '<input name=hora type=hidden value="';
		echo $hora;
		echo '" />';



		echo '</table>
<div align="center" class="hidden-print"><br /><input name="enviar" type="submit" value="Enviar datos" class="btn btn-primary" /></div></FORM>'; 
		?>
		<?

		$colum24= "select distinct id, nombre, orden from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura' order by orden asc";
		$colu = mysql_query($colum24);
		?>

		</div>

		<div class=" col-md-3 hidden-print">
		<div class="well" align="left">
		
			<!-- Button trigger modal --> 
		<a href="#"
			class="pull-right" data-toggle="modal" data-target="#myModal"> <span
			class="fa fa-border fa-question-circle fa-lg"></span> </a> <!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span
			aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Instrucciones de uso.</h4>
		</div>
		<div class="modal-body">
		<p class="help-block">El cuaderno clasifica los datos en columnas, por
		lo que la primera operación consiste en crear una columna para
		introducir datos sobre los alumnos de un grupo. Las columnas pueden
		ser de varios tipos: las numéricas tienen una caja de datos pequeña y
		sólo admiten números con decimales; las columnas de texto largo son
		más grandes y pueden contener caracteres alfanuméricos; etc. <br />
		La siguiente función permite seleccionar Alumnos de la materia. Los
		alumnos no seleccionados ya no volverán a aparecer en el Cuaderno. Por
		último, puedes imprimir la tabla con los datos de los alumnos. La
		impresión sólo contiene la tabla y sus datos.</p>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
		</div>
		</div>
		</div>
		
		<legend><small>Operaciones básicas</small></legend> 
		
	




		<?
		// Enlace para crear nuevos Alumnos y para crear nuevas columnasx
		$mens1 = "cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0&seleccionar=1'";
		$mens2 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0&nom_asig=$nom_asig&nom_asig=$nom_asig";

		echo '<ul class="no_imprimir list-unstyled" style="line-height:32px">';
		$mens1 = "cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curs0&seleccionar=1&nom_asig=$nom_asig";
		echo '<li><i class="fa fa-user fa-lg no_imprimir" title="Seleccionar Alumnos de la materia. Los alumnos no seleccionados ya no volverán a aparecer en el Cuaderno." rel="Tooltip"></i> &nbsp;<a href="'.$mens1.'">Seleccionar alumnos</a></li>';
		echo '<li><i class="fa fa-print fa-lg no_imprimir"  rel="Tooltip" title="Imprimir la tabla de alumnos con los datos registrados" onclick="print()"';
		echo '\'" style="cursor: pointer;"> </i> <a onclick="print()" style="cursor: pointer;">Imprimir tabla</a></li>';
		echo '<li><i class="fa fa-plus-circle fa-lg no_imprimir" rel="Tooltip" title="Añadir un columna de datos al Cuaderno" onclick="window.location=\'';
		echo $mens2;
		echo '\'" style="cursor: pointer;"> </i> <a href="'.$mens2.'">Nueva columna de datos</a></li>';
		echo '';
		echo "</ul>";
		?></div>
		<div class="well" align="left"
			style="min-width: 250px;">
			<!-- Button trigger modal --> <a href="#" class="pull-right"
			data-toggle="modal" data-target="#myModal1"> <span
			class="fa fa-border fa-question-circle fa-lg"></span> </a> <!-- Modal -->
		<div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span
			aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel1">Operaciones y Funciones.</h4>
		</div>
		<div class="modal-body">
		<p class="help-block">Hay varias funciones que puedes realizar sobre
		las columnas que contienen los datos (ocultar, eliminar, calcular
		medias, etc). Marca las columnas sobre las que quieres trabajar, y
		luego presiona el botón que realiza una determinada operación sobre
		esas columnas. No te olvides de seleccionar las columnas
		correspondientes.</p>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
		</div>
		</div>
		</div>
			<legend><small>Cosas que puedes hacer...</small></legend>
		


		<?
		$colum= "select distinct id, nombre, orden, oculto from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura' order by orden asc";
		$colum0 = mysql_query($colum);
		echo '<form action="cuaderno/editar.php" method="POST" id="editar">';
		if (mysql_num_rows($colum0) > 0) {
			$h=0;
			while($colum00=mysql_fetch_array($colum0)){

				$otra=mysql_query("select distinct ponderacion from datos where id='$colum00[0]' and ponderacion<>'1' ");
				if ($otra){$h+=1;}											}
				echo "<table class='table table-striped' style='width:100%;'>";
				$otra2=mysql_query("select distinct id, nombre, orden, oculto, visible_nota from notas_cuaderno where profesor = '$pr' and curso = '$curs0' and asignatura='$asignatura' order by orden asc");
				while ($colum1 = mysql_fetch_array($otra2)) {
					$n_col = $colum1[2];
					$id = $colum1[0];
					$nombre = $colum1[1];
					$oculto = $colum1[3];
					$visible_not= $colum1[4];
					$pon=mysql_query("select distinct ponderacion from datos where id='$id'");
					$pon0=mysql_fetch_array($pon);
					$pond= $pon0[0];
					$mens0 = "cuaderno/c_nota.php?profesor=$pr&curso=$curso&dia=$dia&hora=$hora&id=$id&orden=$ident&nom_asig=$nom_asig";
					$colum1[4] ? $icon_eye = '<i class="fa fa-eye" rel="Tooltip" title="Columna visible en la página pública del Centro"></i>' : $icon_eye  = '<i class="fa fa-eye-slash" rel="Tooltip" title="Columna oculta en la página pública del Centro"></i>';
					echo "<tr><td nowrap style='vertical-align:middle;'>$n_col &nbsp;&nbsp;$icon_eye </td><td style='vertical-align:middle;'><a href='$mens0'>$nombre</a></td>";
					echo "<td>";
					?> 
					<div class="checkbox">
					<input type="checkbox"
			name="<? echo $id;?>"
			value="<? if(mysql_num_rows($pon)==0){echo 1;} else{ echo $pond;}?>">
			<?
	  if ($pon0[0] > "1" ) {echo "<span align='center' class='text-muted' Rel='Tooltip' title='Ponderación de la columna'> ($pond)</span>"; }
	  echo "</div></td></tr>";
				}
				echo "</table>";

		}
		// Codigo Curso
		echo '<input name=curso type=hidden value="';
		echo $curso;
		echo '" />';
		// Profesor
		echo '<input name=profesor type=hidden value="';
		echo $pr;
		echo '" />';
		// Asignatura.
		echo '<input name=asignatura type=hidden value="';
		echo $asignatura;
		echo '" />';
		// Nombre Asignatura.
		echo '<input name=nom_asig type=hidden value="';
		echo $nom_asig;
		echo '" />';
		// Día.
		echo '<input name=dia type=hidden value="';
		echo $dia;
		echo '" />';
		// Hora.
		echo '<input name=hora type=hidden value="';
		echo $hora;
		echo '" />';


		?> <br>
		<p><input name="media" type="submit" value="Media Aritmética"
			class="btn btn-primary btn-block" /></p>
		<p><input name="media_pond2" type="submit" value="Media Ponderada"
			class="btn btn-primary btn-block" /></p>
		<p><input name="estadistica" type="submit" value="Estadística"
			class="btn btn-primary btn-block" /></p>
		<p><input name="ocultar" type="submit" value="Ocultar"
			class="btn btn-primary btn-block" /></p>
		<p><input name="mostrar" type="submit" value="Mostrar"
			class="btn btn-primary btn-block" /></p>
		<p><input name="eliminar" type="submit" value="Eliminar"
			class="btn btn-primary btn-block" /></p>

		</form>
		</div>
		</div>
		<?
}
?>
</div>
</div>
</div>
<?php include("pie.php"); ?>

<script>
	function seleccionar_tod(){
		for (i=0;i<document.imprime.elements.length;i++)
			if(document.imprime.elements[i].id == 'selal')	
				document.imprime.elements[i].checked=1
	}
	function deseleccionar_tod(){
		for (i=0;i<document.imprime.elements.length;i++)
			if(document.imprime.elements[i].id == 'selal')	
				document.imprime.elements[i].checked=0
	}
	</script>

</body>
</html>
