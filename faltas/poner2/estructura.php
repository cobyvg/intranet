<div class="page-header" align="center">
  <h1>Faltas de Asistencia <small> Poner faltas</small></h1>
</div>
<div class="row-fluid">
<div class="span5">
<?
if(is_numeric($profesor))
{
	$nombre_p=mysql_query("select distinct prof from horw where no_prof = '$profesor'");
	echo "select distinct prof from horw where no_prof = '$profesor'";
	$nombre_pr = mysql_fetch_array($nombre_p);
	$n_profe=$profesor."_ ".$nombre_pr[0];
}
else{$n_profe = $profesor;}
?>
<h3><span style='font-size:0.9em; color:#08c'>&nbsp;&nbsp; <? echo $n_profe;?> &nbsp;&nbsp;</span></h3><br />
<div class="well-2 well-large" style="margin-left:15px;">
 <?
 if ($profesor) {
		  $trozos = explode("_ ",$profesor) ;
		  $id = $trozos[0];
		  $profesores = $trozos[1];     	
		  echo "<a href=index.php?year=$year&today=$today&month=$month&id=$id class='btn btn-success'>Elegir otro Profesor</a>";
          	echo "";

          	echo "<input type=hidden name=profesor value= \"$profesor\"><hr>";
          }
?>            
<?
		 if(!($profesor)){
		echo '<h6 align="center">Selecciona un profesor</h6><br />';
profesor();
echo "<hr>";
		 }
		 ?>

           <? 
		if ($registro) {
			echo '<div align="left""><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Las Faltas de Asistencia han sido registradas.
          </div></div>';
		}
		if ($mens1) {
			echo '<div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens1.'</div></div>';
		}
		if ($mens2) {
			echo '<div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens2.'</div></div>';
		}
		if ($mens3) {
			echo '<div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens3.'</div></div>';
		}
		if ($mens4) {
			echo '<div align="left"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_4.'</div></div>';
		}
		if ($fiesta) {
			echo '<div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$fiesta.'</div></div>';
		}
		if ($mens_fecha) {
			echo '<div align="left"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_fecha.'</div></div>';
		}			
		?>
                 <? include("cal.php"); ?>  
                              
</div>
</div>
<div class="span7">
<?
echo "<h3 align='center'><span  style='font-size:0.9em; color:#08c'>Semana:&nbsp;&nbsp;$lunes1 &nbsp;&nbsp;-->&nbsp;&nbsp; $viernes&nbsp;&nbsp;</span></h3><br />";
            echo "<input type=hidden name=today value= \"$today\">";
			echo "<input type=hidden name=year value= \"$year\">";
			echo "<input type=hidden name=month value= \"$month\">";
                 include("profes.php"); ?>                   
              <div align="center"> 
    <input type="submit" name="enviar" class="btn btn-primary" value="Registrar las faltas de asistencia">
  </div>                   
  </div>
  </div>              

			      <script>
<!--
document.form1.profesor.focus()
document.form1.profesor.options[<?php $id = $id; echo $id-1;?>].selected = true

    </script>
