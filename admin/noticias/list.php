<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_GET['timestamp'])) $timestamp = $_GET['timestamp'];
if (isset($_GET['pag'])) $pag = $_GET['pag'];

if(isset($_GET['borrar']) && $borrar) {
	$result = mysql_query("DELETE FROM noticias WHERE id='$id' LIMIT 1");
	
	if(!$result) $msg_error = "No se ha podido eliminar la noticia. Error: ".mysql_error();
	else $msg_success = "La noticia ha sido eliminada.";
}


include("../../menu.php");
include("menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Noticias <small>Noticias y novedades del centro</small></h2>
		</div>
		
		<!-- MENSAJES -->
		<?php if(isset($msg_error)): ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $msg_error; ?>
		</div>
		<?php endif; ?>
		
		<?php if(isset($msg_success)): ?>
		<div class="alert alert-success" role="alert">
			<?php echo $msg_success; ?>
		</div>
		<?php endif; ?>
		
		
		<div class="row">
			
			<div class="col-sm-12">
				
				<?php $result = mysql_query("SELECT id, slug, timestamp, contact FROM noticias ORDER BY timestamp DESC LIMIT 0, 20"); ?>
				
				<?php if (mysql_num_rows($result)): ?>
					
					<?php $row = mysql_fetch_array($result); ?>
					<?php $exp_profesor = explode(',', $row['contact']); ?>
					<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
					
					<style class="text/css">
						a.link-msg, a.link-msg:hover { color: #444; display: block; text-decoration:none; }
					</style>
					
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Título</th>
									<th nowrap>Fecha publicación</th>
									<th>Autor</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($row = mysql_fetch_array($result)): ?>
									<tr>
										<td><a class="link-msg" href="story.php?id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
										<td><a class="link-msg" href="story.php?id=<?php echo $row['id']; ?>"><?php echo (strlen($row['slug']) > 60) ? substr($row['slug'],0,60).'...' : $row['slug']; ?></a></td>
										<td><a class="link-msg" href="story.php?id=<?php echo $row['id']; ?>"><?php echo strftime('%d-%m-%G',strtotime($row['timestamp'])); ?></a></td>
										<td><a class="link-msg" href="story.php?id=<?php echo $row['id']; ?>"><?php echo $row['contact']; ?></a></td>
										<td nowrap>
											<?php if(stristr($_SESSION['cargo'],'1') == TRUE || $_SESSION['profi'] == $row['contact']): ?>
											<a href="add.php?id=<?php echo $row['id']; ?>"><span class="fa fa-edit fa-fw fa-lg"></span></a>
											<a href="list.php?id=<?php echo $row['id']; ?>&timestamp=<?php echo $row['timestamp']; ?>&borrar=1"><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
					
					<ul class="pager">
					  <li class="previous"><a href="#">&larr; Antiguas</a></li>
					  <li class="next disabled"><a href="#">Recientes &rarr;</a></li>
					</ul>
					
					<?php mysql_free_result($result); ?>
					
				<?php else: ?>
					
					<h3>No se ha redactado ninguna noticia.</h3>
					
					
				<?php endif; ?>
				
			</div><!-- /.col-sm-12 -->
					
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
