<div class="container hidden-print" style="margin-top:-15px">
<div class="tabbable">
<ul class="nav nav-tabs">
	<li><a href='<? echo "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso_sin&nom_asig=$nom_asig";?>'><i class="fa fa-plus-circle fa-fw"></i> Nueva columna de datos</a></li>

	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"
		href="#"><i class="fa fa-gears fa-fw"></i> Funciones <span class="caret"></span> </a>
	<ul class="dropdown-menu" role="menu">
	<?
	$mens1 = "cuaderno.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso_sin&seleccionar=1&nom_asig=$nom_asig";
	$mens2 = "cuaderno/c_nota.php?profesor=$pr&asignatura=$asignatura&dia=$dia&hora=$hora&curso=$curso_sin&nom_asig=$nom_asig";
	$mens3 = "cuaderno/orden.php?menu_cuaderno=1&profesor=".$_SESSION['profi']."&dia=$dia&hora=$hora&asignatura=$asignatura&curso=$curs0&nom_asig=$nom_asig";

	echo '<li><a href="'.$mens1.'"><i class="fa fa-user fa-fw"></i>&nbsp;Seleccionar alumnos</a></li>';
	echo '<li><a href="'.$mens3.'"><i class="fa fa-reorder fa-fw"></i>&nbsp;Ordenar Columnas</a></li>';
	echo '<li><a onclick="print()"><i class="fa fa-print fa-fw"></i>&nbsp;Imprimir tabla</a></li>';
	?>
	</ul>
	</li>

	<li><!-- Button trigger modal --> <a href="#" class="pull-right" data-toggle="modal" data-target="#myModal1"><i class="fa fa-columns fa-fw"></i>  Operaciones con las Columnas </a> <!-- Modal -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
		aria-labelledby="myModal1Label" aria-hidden="true">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span
		aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" id="myModal1Label">Operaciones con las Columnas	de datos.</h4>
	</div>
	<div class="modal-body">
	<div class="row">
	<div class="col-sm-7">
	<?
	$colum= "select distinct id, nombre, orden, oculto from notas_cuaderno where profesor = '$pr' and curso = '$curs' and asignatura='$asignatura' order by orden asc";
	$colum0 = mysqli_query($db_con, $colum);
	echo '<form action="cuaderno/editar.php" method="POST" id="editar">';
	if (mysqli_num_rows($colum0) > 0) {
		$h=0;
		while($colum00=mysqli_fetch_array($colum0)){

			$otra=mysqli_query($db_con, "select distinct ponderacion from datos where id='$colum00[0]' and ponderacion<>'1' ");
			if ($otra){$h+=1;}											}
			echo "<table class='table table-striped table-condensed table-hover' style='width:100%;'>";

			$otra3=mysqli_query($db_con, "select * from notas_cuaderno where profesor = '$pr' and curso = '$curs' and asignatura='$asignatura' order by orden asc");
			while($columna1 = mysqli_fetch_array($otra3)){
				$total=$total+1;
			}
			$col_total=$total+1;
			if($_GET['seleccionar'] == "1"){
				$col_total=$col_total+1;
			}

			$otra2=mysqli_query($db_con, "select distinct id, nombre, orden, oculto, visible_nota from notas_cuaderno where profesor = '$pr' and curso = '$curs' and asignatura='$asignatura' order by orden asc");
			while ($colum1 = mysqli_fetch_array($otra2)) {
				$n_col = $colum1[2];
				$id = $colum1[0];
				$nombre = $colum1[1];
				$oculto = $colum1[3];
				$visible_not= $colum1[4];
				$pon=mysqli_query($db_con, "select distinct ponderacion from datos where id='$id'");
				$pon0=mysqli_fetch_array($pon);
				$pond= $pon0[0];
				$mens0 = "cuaderno/c_nota.php?profesor=$pr&curso=$curso&dia=$dia&hora=$hora&id=$id&orden=$n_col&nom_asig=$nom_asig&asignatura=$asignatura";
				$colum1[4] ? $icon_eye = '<i class="fa fa-eye" data-bs="tooltip" title="Columna visible en la página pública del Centro"></i>' : $icon_eye  = '<i class="fa fa-eye-slash" data-bs="tooltip" title="Columna oculta en la página pública del Centro"></i>';
				$colum1[3] ? $icon_lock = '<i class="fa fa-lock" data-bs="tooltip" title="Columna oculta en el Cuaderno"></i>' : $icon_lock  = '';
				echo "<tr><td nowrap style='vertical-align:middle;'>";
				?> 
				<input type="checkbox" name="<? echo $id;?>"	value="<? if(mysqli_num_rows($pon)==0){echo 1;} else{ echo $pond;}?>">
				<?
				echo "&nbsp;$n_col &nbsp;$icon_eye &nbsp;$icon_lock";
				
		echo "</td><td style='vertical-align:middle;'><a href='$mens0'>$nombre</a>";

		if ($pon0[0] > "1" ) {echo "<span align='center' class='text-muted' data-bs='tooltip' title='Ponderación de la columna'> ($pond)</span>"; }
		echo "</td></tr>";
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


	?> 
	
	</div>
	<div class="col-sm-5">

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
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	</div>
	</div>
	</div>
	</div>

	</li>
</ul>
</div>
</div>
<br>
