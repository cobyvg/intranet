
<div aligna="center">
<div class="page-header" align="center">
  <h1>Faltas de Asistencia <small> Poner faltas</small></h1>
</div>
<br />

<div class="row-fluid">
<div class="span5">
<h3><span style='font-size:0.9em; color:#08c'>&nbsp;&nbsp; <? echo $profesor;?> &nbsp;&nbsp;</span></h3><br />
<div class="well-2 well-large" style="margin-left:15px;">
<?
  if (isset($_SESSION['todo_profe'])) {
		  $trozos = explode("_ ",$_SESSION['todo_profe']) ;
		  $id = $trozos[0];
		  $profesor = $trozos[1];     	
		  echo "";
          	if (!(isset($_SESSION['todo_profe']))) 
			{
			echo "<a href=index.php?year=$year&today=$today&month=$month&id=$id class='btn btn-primary'>Elegir otro Profesor</a>";
          	echo "<br /><br />";
			}
          	echo "<input type=hidden name=profesor value= \"$profesor\">";
          }
          else {              
profesor();
          }
		if ($registro) {
			echo '<div align="left""><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Las Faltas de Asistencia han sido registradas.
          </div></div>';
		}
		if ($mens1) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens1.'</div></div>';
		}
		if ($mens2) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens2.'</div></div>';
		}
		if ($mens3) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens3.'</div></div>';
		}
		if ($mens4) {
			echo '<div align="left""><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_4.'</div></div>';
		}
		if ($fiesta) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$fiesta.'</div></div>';
		}
		if ($mens_fecha) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_fecha.'</div></div>';
		}				
		?>
                 
                 <?
				  
                  include("cal.php"); 
                  ?>                   
</div>
</div>
<div class="span7">
<?          
            echo "<input type=hidden name=today value= \"$today\">";
			echo "<input type=hidden name=year value= \"$year\">";
			echo "<input type=hidden name=month value= \"$month\">";
			echo "<h3 align='center'><span  style='font-size:0.9em; color:#08c'>Semana:&nbsp;&nbsp;$lunes1 &nbsp;&nbsp;-->&nbsp;&nbsp; $viernes&nbsp;&nbsp;</span></h3><br />";
            include("profes.php"); 
            ?>
             <div align="center"> 
    <input type="submit" name="enviar" class="btn btn-primary" value="Registrar las faltas de asistencia">
  </div>                   
  </div>
  </div>      

			      <script>
document.form1.profesor.focus()
document.form1.profesor.options[<?php $id = $id; echo $id;?>].selected = true
    </script>
