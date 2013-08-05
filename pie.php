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