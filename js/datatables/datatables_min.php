<script src="http://<? echo $dominio;?>/intranet/js/datatables/jquery.dataTables.js"></script>
<script src="http://<? echo $dominio;?>/intranet/js/datatables/dataTables.bootstrap.js"></script>
<script src="http://<? echo $dominio;?>/intranet/js/datatables/TableTools.min.js"></script>
<script type="text/javascript">
$(function() {			
	$('.tabladatos').dataTable( {
		"oLanguage": {
			"sProcessing":     "Procesando...",
		    "sLengthMenu":     "Mostrar _MENU_ registros",
		    "sZeroRecords":    "No se encontraron resultados",
		    "sEmptyTable":     "Ningún dato disponible en esta tabla",
		    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		    "sInfoPostFix":    "",
		    "sSearch":         "Buscar:",
		    "sUrl":            "",
		    "sInfoThousands":  ",",
		    "sLoadingRecords": "Cargando...",
		    "oPaginate": {
		        "sFirst":    "Primero",
		        "sLast":     "Ãšltimo",
		        "sNext":     "",
		        "sPrevious": ""
		    },
		    "oAria": {
		        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		    }
				
		},
		"bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
		"sDom": "<'row-fluid'<'span12'f>>t<'row-fluid'<'span12'p>>",
			});
 });
</script>
