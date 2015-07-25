    
    <footer class="hidden-print">
    	<div class="container-fluid" role="footer">
    		<hr>
    		
    		<p class="text-center">
    			<small class="text-muted">Versión <?php echo INTRANET_VERSION; ?> - Copyright &copy; <?php echo date('Y'); ?> IESMonterroso</small><br>
    			<small class="text-muted">Este programa es software libre, liberado bajo la GNU General Public License.</small>
    		</p>
    		<p class="text-center">
    			<small>
    				<a href="//<?php echo $dominio; ?>/intranet/LICENSE.md" target="_blank">Licencia de uso</a>
    				&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;
    				<a href="https://github.com/IESMonterroso/intranet" target="_blank">Github</a>
    			</small>
    		</p>
    	</div>
    </footer>

    <!-- MODAL SESIÓN-->
	<div class="modal fade" id="session_expired" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title">Inactividad de la cuenta</h4>
			  </div>
			  <div class="modal-body">
			    <p>Hemos detectado inactividad en su cuenta. Por seguridad, la sesión se cerrará automáticamente dentro de 
			    	<strong>3 minutos</strong>. Realice alguna actividad en la aplicación para cancelar esta acción.</p>
			  </div>
			  <div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Entendido</button>
			  </div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- FIN MODAL SESIÓN -->
    
    <!-- BOOTSTRAP JS CORE -->
    <script src="//<?php echo $dominio;?>/intranet/js/jquery-1.11.3.min.js"></script>  
    <script src="//<?php echo $dominio;?>/intranet/js/bootstrap.min.js"></script>
    
    <!-- PLUGINS JS -->
    <script src="//<?php echo $dominio;?>/intranet/js/bootbox.min.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/validator/validator.min.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/summernote/summernote.min.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/summernote/summernote-es-ES.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/datetimepicker/moment.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/datetimepicker/moment-es.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/datetimepicker/bootstrap-datetimepicker.js"></script>
    <?php if(isset($PLUGIN_DATATABLES) && $PLUGIN_DATATABLES): ?>
    <script src="//<?php echo $dominio;?>/intranet/js/datatables/jquery.dataTables.min.js"></script>
    <script src="//<?php echo $dominio;?>/intranet/js/datatables/dataTables.bootstrap.js"></script>
    <?php endif; ?>
    <?php if(isset($PLUGIN_COLORPICKER) && $PLUGIN_COLORPICKER): ?>
    <script src="//<?php echo $dominio;?>/intranet/js/colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <?php endif; ?>
    <?php if(isset($_GET['tour']) && $_GET['tour']): ?>
    <script src="//<?php echo $dominio;?>/intranet/js/bootstrap-tour/bootstrap-tour.min.js"></script>
    <?php endif; ?>
    <script src="//<?php echo $dominio;?>/intranet/js/ajax_alumnos.js"></script>
    
		
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

	<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function() {
			$("#session_expired").modal('show');
		},(<?php echo ini_get("session.gc_maxlifetime"); ?>*60000)-180000);
	});
	</script>
		