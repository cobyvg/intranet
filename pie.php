    
    <footer class="hidden-print">
    	<div class="container-fluid" role="footer">
    		<hr>
    		
    		<p class="text-center">
    			<small class="text-muted"><?php echo date('Y'); ?> &copy; IESMonterroso</small>
    		</p>
    		<p class="text-center">
    			<small>
    				<a href="http://<?php echo $dominio; ?>/intranet/GPL.html">Licencia de uso</a>
    				&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;
    				<a href="https://github.com/IESMonterroso/intranet">Github</a>
    			</small>
    		</p>
    	</div>
    </footer>
    
    <!-- BOOTSTRAP JS CORE -->
    <script src="http://<? echo $dominio;?>/intranet/js/jquery.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap.min.js"></script>
    
    <!-- PLUGINS JS -->
    <script src="http://<? echo $dominio;?>/intranet/js/summernote.min.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/summernote-es-ES.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/bootbox.min.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-datepicker.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/ajax_alumnos.js"></script>
    
    <!--  Tablas de Bootstrap DataTables.  -->   

 <?
if (isset($datatables_activado)){
if ($datatables_activado){
	include("js/datatables/carga_datatables.php");
}        
}
?>
 <?
if (isset($imprimir_activado)){
if ($imprimir_activado){
	include("js/datatables/imprimir_datatables.php");
}        
}
?>
 <?
if (isset($datatables_min)){
if ($datatables_min){
	include("js/datatables/datatables_min.php");
}        
}
?>

	<script type="text/javascript">
		$("[rel=tooltip]").tooltip();
	</script>

	<script>
	$(document).on("click", "a[data-bb]", function(e) {
	    e.preventDefault();
	    var type = $(this).data("bb");
			var link = $(this).attr("href");
			
			if (type == 'confirm-delete') {
				bootbox.setDefaults({
				  locale: "es",
				  show: true,
				  backdrop: true,
				  closeButton: true,
				  animate: true,
				  title: "Confirmación para eliminar",
				});
				
				bootbox.confirm("Esta acción eliminará permanentemente el elemento seleccionado ¿Seguro que desea continuar?", function(result) {
				    if (result) {
				    	document.location.href = link;
				    }
				});
			}
	});
	</script>