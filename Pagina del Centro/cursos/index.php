<? include("../conf_principal.php");?>
<? include "../cabecera.php"; ?>
<? include('../menu.php'); ?>
<? 
if (isset($_GET['tab'])) {
	$tab=$_GET['tab'];
}
for($i=1;$i<6;$i++){
if ($tab==$i) { ${activo1.$i} = 'class=" active"'; ${activo2.$i}=" active";}
}
if($tab==""){
	 $activo11 = 'class=" active"'; $activo21=" active";
}
?>
<div class="span9">	
<br>
<h3 align='center'><i class='icon icon-pencil'> </i> Estudios en este Centro<br /></h3>
<hr />
<div class="tabbable" style="margin-bottom: 18px;">
<ul class="nav nav-tabs">
<li <? echo $activo11;?>><a href="#tab1" data-toggle="tab">Ed. Secundaria</a></li>
<li <? echo $activo12;?>><a href="#tab2" data-toggle="tab">Bachillerato</a></li>
<li <? echo $activo13;?>><a href="#tab3" data-toggle="tab">Guía, Información y Asistencia Turísticas</a></li>
<li <? echo $activo14;?>><a href="#tab4" data-toggle="tab">Atención a Personas en Situación de Dependencia</a></li>
<li <? echo $activo15;?>><a href="#tab5" data-toggle="tab">PCPI</a></li>
</ul>

<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
<div class="tab-pane fade in <? echo $activo21;?>" id="tab1">
<?
echo "<br /><p class='lead muted' align='center'><i class='icon icon-book'></i>&nbsp; Educación Secundaria Obligatoria</p><hr />";
include("eso.php");
?>
</div>
<div class="tab-pane fade in <? echo $activo22;?>" id="tab2">
<?
echo "<br /><p class='lead muted' align='center'><i class='icon icon-book'> </i> Bachillerato</p><hr />";
include("bachillerato.php");
?>
</div>
<div class="tab-pane fade in <? echo $activo23;?>" id="tab3">
<?
echo "<br /><p class='lead muted' align='center'><i class='icon icon-book'> </i> Guía, Información y Asistencia Turísticas</p><hr />";
include("frmod.php");
?>
</div>
<div class="tab-pane fade in <? echo $activo24;?>" id="tab4">
<?
echo "<br /><p class='lead muted' align='center'><i class='icon icon-book'> </i> Atención a Personas en Situación de Dependencia</p><hr />";
include("sociosanitario.php");
?>
</div>
<div class="tab-pane fade in <? echo $activo25;?>" id="tab5">
<?
echo "<br /><p class='lead muted' align='center'><i class='icon icon-book'> </i> Programas de Cualificación Profesional: Auxiliar Informático</p><hr />";
include("pcpi.php");
?>
</div>
</div>
</div>
</div>

<? include("../pie.php");?>

