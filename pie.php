    
    <footer class="hidden-print">
    	<div class="container-fluid" role="footer">
    		<hr>
    		
    		<p class="text-center">
    			<small class="text-muted">Copyright &copy; <?php echo date('Y'); ?> IESMonterroso</small><br>
    			<small class="text-muted">Este programa es software libre, liberado bajo la GNU General Public License.</small>
    		</p>
    		<p class="text-center">
    			<small>
    				<a href="http://<?php echo $dominio; ?>/intranet/LICENSE.md" target="_blank">Licencia de uso</a>
    				&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;
    				<a href="https://github.com/IESMonterroso/intranet" target="_blank">Github</a>
    			</small>
    		</p>
    	</div>
    </footer>
    
    <!-- BOOTSTRAP JS CORE -->
    <script src="http://<? echo $dominio;?>/intranet/js/jquery-1.11.1.min.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap.min.js"></script>
    
    <!-- PLUGINS JS -->
    <script src="http://<? echo $dominio;?>/intranet/js/bootbox.min.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/summernote/summernote.min.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/summernote/summernote-es-ES.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/datetimepicker/moment.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/datetimepicker/moment-es.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/datetimepicker/bootstrap-datetimepicker.js"></script>
    <?php if(isset($PLUGIN_DATATABLES) && $PLUGIN_DATATABLES): ?>
    <script src="http://<? echo $dominio;?>/intranet/js/datatables/jquery.dataTables.min.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/datatables/dataTables.bootstrap.js"></script>
    <?php endif; ?>
    <?php if(isset($_GET['tour']) && $_GET['tour']): ?>
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-tour/bootstrap-tour.min.js"></script>
    <?php endif; ?>
    <script src="http://<? echo $dominio;?>/intranet/js/ajax_alumnos.js"></script>
    
		
		<script>
		$(function () {
		  var nua = navigator.userAgent
		  var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
		  if (isAndroid) {
		    $('select.form-control').removeClass('form-control').css('width', '100%')
		  }
		  
		  $("#toggleMenu").click(function() {
		    $('#accordion').toggleClass("hidden-xs");
		  });
		  
		})
		</script>
	
		<script type="text/javascript">
			$("[data-bs=tooltip]").tooltip({
				container: 'body'
			});
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
		