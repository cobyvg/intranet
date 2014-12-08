<div class="bs-module hidden-xs">
<h4><span class="fa fa-pie-chart fa-fw"></span> Estadísticas del día</h4>

<div class="row">
<div class="col-sm-3">
<?php $result = mysqli_query($db_con, "SELECT nombre, apellidos, asunto, informa, id, fechoria.claveal FROM Fechoria, alma WHERE alma.claveal=fechoria.claveal and fechoria.fecha = CURDATE()"); ?>
<?php $n_fechorias = mysqli_num_rows($result); ?> 
<?php 
while($row = mysqli_fetch_array($result)){	
$dat.="<p><a href='admin/fechorias/detfechorias.php?id=$row[4]&claveal=$row[5]'> <i class='fa fa-user'> </i> $row[0] $row[1]</a> <span class='text-info'>(".strtoupper($row[3]).")</span><span class='text-muted'> $row[2]</span></p>";	
} 
?> 
<?php mysqli_free_result($result); ?>
<h4 class="text-center">

<? echo "<a class='alert-link' data-toggle='modal' href='#fechoria' >";?>
<span class="lead"> <?php echo $n_fechorias; ?> </span><br>
<small>Problemas Convivencia</small>
</a>
</h4>
<div class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true"
	id="fechoria">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">Problemas de Convivencia</h4>
</div>
<div class="modal-body">
<? echo substr($dat,0,-4);?>
</div>
<div class="modal-footer"><a href="#" class="btn btn-primary"
	data-dismiss="modal">Cerrar</a></div>
</div>
</div>
</div>
</div>


<div class="col-sm-3">
<?php $result = mysqli_query($db_con, "SELECT COUNT(*) AS total FROM Fechoria WHERE expulsion > 0 AND inicio < CURDATE() AND fin >= CURDATE()"); ?>
<?php $row = mysqli_fetch_array($result); ?> 
<?php mysqli_free_result($result); ?>

<?php $result1 = mysqli_query($db_con, "SELECT COUNT(*) AS total FROM Fechoria WHERE expulsion > 0 AND fin = CURDATE()"); ?>
<?php $row1 = mysqli_fetch_array($result1); ?> <?php mysqli_free_result($result1); ?>

<h4 class="text-center"><a href="admin/fechorias/expulsados.php"> <span
	class="lead"> <?php echo $row['total']; ?> / <?php echo $row1['total']; ?>
</span><br>
<small>Expulsiones Reingresos</small> </a></h4>
</div>


<div class="col-sm-3">
<?php $result = mysqli_query($db_con, "SELECT id, apellidos, nombre, unidad, tutor FROM infotut_alumno WHERE F_ENTREV = CURDATE()"); ?>
<?php $n_visitas = mysqli_num_rows($result); ?> 
<?php 
while($row = mysqli_fetch_array($result)){	
$dat1.="<p><a href='./admin/infotutoria/infocompleto.php?id=$row[0]'> <i class='fa fa-user'> </i> $row[2] $row[1]</a> <span class='text-muted'>( <span class='text-info'>$row[3]: </span>".mb_strtoupper($row[4])." )</span></p>";	
} 
?> 
<?php mysqli_free_result($result); ?>
<? echo "<a class='alert-link' data-toggle='modal' href='#visitas' >";?>
<h4 class="text-center">
<span class="lead"> <?php echo $n_visitas; ?> </span><br>
<small>Visitas de Padres</small>
</h4>
</a>
<div class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel1" aria-hidden="true"
	id="visitas">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel1">Visitas de Padres</h4>
</div>
<div class="modal-body">
<? echo $dat1;?>
</div>
<div class="modal-footer"><a href="#" class="btn btn-primary"
	data-dismiss="modal">Cerrar</a></div>
</div>
</div>
</div>
</div>


<div class="col-sm-3">
<?php $result0 = mysqli_query($db_con, "create table tmp SELECT DISTINCT profesor FROM reg_intranet WHERE fecha LIKE CONCAT(CURDATE(),'%') and profesor in (select nombre from departamentos where departamento not like 'Administracion' and departamento not like 'Admin' and departamento not like 'Conserjeria')"); 
$result = mysqli_query($db_con, "select nombre from departamentos where departamento not like 'Administracion' and departamento not like 'Admin' and departamento not like 'Conserjeria' and nombre not in (select profesor from tmp)");
?>
<?php $result1 = mysqli_query($db_con, "SELECT * FROM departamentos where departamento not like 'Administracion' and departamento not like 'Admin' and departamento not like 'Conserjeria'"); ?>
<?php $n_ausentes = mysqli_num_rows($result); ?> 
<?php $n_profes = mysqli_num_rows($result1); ?> 
<?php 
while($row = mysqli_fetch_array($result)){	
$dat2.="<p> <i class='fa fa-user'> </i> $row[0]</p>";	
} 
?> 
<?php mysqli_query($db_con, "drop table tmp"); ?>
<?php mysqli_free_result($result); ?>
<? echo "<a class='alert-link' data-toggle='modal' href='#accesos' >";?>
<h4 class="text-center">
<span class="lead"> <?php echo $n_ausentes; ?> / <?php echo $n_profes; ?> </span><br>
<small>Profesores sin entrar</small>
</h4>
</a>
<div class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel2" aria-hidden="true"
	id="accesos">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">Profesores sin entrar</h4>
</div>
<div class="modal-body">
<? echo $dat2;?>
</div>
<div class="modal-footer">
<a href="./xml/jefe/informes/accesos.php" class="btn btn-info">Ver Accesos</a>
<a href="#" class="btn btn-primary"	data-dismiss="modal">Cerrar</a></div>
</div>
</div>
</div>
</div>

</div>
</div>
<br>
