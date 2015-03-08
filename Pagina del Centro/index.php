<? include_once("conf_principal.php");?>
<? include "cabecera.php"; ?>
<? include('menu.php'); ?>
<div class="span6">	
<div class="row-fluid">
<div class="span10 offset1">	           
 <?
include('noticias.php');
?>
</div>
</div>       
</div><!-- span5 -->
<div class="span3">
<?
include('fijos.php');
?>
</div><!-- span3 -->
<?
include('pie.php');
?>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
</script> 