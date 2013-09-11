<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Poner faltas</small></h2>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class="span4">
<?
if(is_numeric($profesor))
{
	$nombre_p=mysql_query("select distinct prof from horw where no_prof = '$profesor'");
	echo "select distinct prof from horw where no_prof = '$profesor'";
	$nombre_pr = mysql_fetch_array($nombre_p);
	$n_profe=$profesor."_ ".$nombre_pr[0];
}
else{$n_profe = $profesor;}
if(strlen($n_profe)>0){
?>
<div align="center">
<h3> <? echo $n_profe;?> &nbsp;&nbsp;</h3>
<?
}
?>

 <?
 if ($profesor) {
		  $trozos = explode("_ ",$profesor) ;
		  $id = $trozos[0];
		  $profesores = $trozos[1];     	
		  echo "<a href=index.php?year=$year&today=$today&month=$month&id=$id class='btn btn-success'>Elegir otro Profesor</a>";
          	echo "</div>";

          	echo "<input type=hidden name=profesor value= \"$profesor\"><hr>";
          }
?>            
<?
		 if(empty($profesor)){
		echo '<div align="center">';
		echo '<legend>Selecciona un profesor</legend>';
profesor();
echo "</div>";
		 }
		 ?>
<div class="well-trasnparent well-large">
           <? 
		if (isset($registro)) {
			echo '<div align="left""><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Las Faltas de Asistencia han sido registradas.
          </div></div>';
		}
		if (isset($mens1)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>1'.$mens1.'</div></div>';
		}
		if (isset($mens2)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>2'.$mens2.'</div></div>';
		}
		if (isset($mens3)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>3'.$mens3.'</div></div>';
		}
		if (isset($mens4)) {
			echo '<div align="left""><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>4'.$mens_4.'</div></div>';
		}
		if (isset($fiesta)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>5'.$fiesta.'</div></div>';
		}
		if (isset($mens_fecha)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>6'.$mens_fecha.'</div></div>';
		}			
		?>
                 <? include("cal.php"); ?>  
                              
</div>
</div>
<div class="span8">
<?
echo "<h3 align='center'>Semana:&nbsp;&nbsp;$lunes1 &nbsp;&nbsp;-->&nbsp;&nbsp; $viernes&nbsp;&nbsp;</h3><br />";
            echo "<input type=hidden name=today value= \"$today\">";
			echo "<input type=hidden name=year value= \"$year\">";
			echo "<input type=hidden name=month value= \"$month\">";
                 include("profes.php"); ?>                   
              <div align="center"> 
    <br /><input type="submit" name="enviar" class="btn btn-primary" value="Registrar las faltas de asistencia">
  </div>                   
  </div>
  </div>              

			      <script>
<!--
document.form1.profesor.focus()
document.form1.profesor.options[<?php $id = $id; echo $id-1;?>].selected = true

    </script>
