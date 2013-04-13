<script src="http://<? echo $dominio;?>/intranet/js/datatables/jquery.dataTables.js"></script>
<script src="http://<? echo $dominio;?>/intranet/js/datatables/dataTables.bootstrap.js"></script>
<script src="http://<? echo $dominio;?>/intranet/js/datatables/TableTools.min.js"></script>
<script type="text/javascript">
 $(function() {	
	 $.extend( true, $.fn.DataTable.TableTools.classes, {
			"container": "btn-group",
			"buttons": {
				"normal": "btn btn-primary",
				"disabled": "btn disabled"
			},
			"collection": {
				"container": "DTTT_dropdown dropdown-menu",
				"buttons": {
					"normal": "",
					"disabled": "disabled"
				}
			}
		} );

		// Have the collection use a bootstrap compatible dropdown
		$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
			"collection": {
				"container": "ul",
				"button": "li",
				"liner": "a"
			}
		} );		
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
		        "sLast":     "Último",
		        "sNext":     "",
		        "sPrevious": ""
		    },
		    "oAria": {
		        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		    }
					
		},
		"aaSorting": [],
		"bProcessing": true,
		"sDom": "<'row-fluid'<'span3'l><'span8'f><'span1'T>r>t<'row-fluid'<'span4'i><'span8'p>>",
		"oTableTools": {
			"aButtons": [ 
		                    { 
		                    "sExtends": "print", 
		                    "sButtonText": "<i class='icon icon-print icon-white icon-large'></i> Imprimir"		                    } 
		                    ]
		}
	});
 });
</script>
