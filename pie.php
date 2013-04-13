<!-- Le javascript  
    ================================================== -->  
    <!-- Placed at the end of the document so the pages load faster -->     
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-transition.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-alert.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-modal.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-dropdown.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-scrollspy.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-tab.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-tooltip.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-popover.js"></script> 
    
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-button.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-collapse.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-carousel.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-typeahead.js"></script>     
    
    <!--  Calendario de Bootstrap.  -->   
    <script src="http://<? echo $dominio;?>/intranet/js/jquery.js"></script>  
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap.min.js"></script>
    <script src="http://<? echo $dominio;?>/intranet/js/bootstrap-datepicker.js"></script>  
    
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

 <script type="text/javascript">
    $("[rel=tooltip]").tooltip();
</script> 