
<div aligna="center">
<div class="page-header">
  <h2>Faltas de Asistencia <small> Poner faltas</small></h2>
</div>
<div class="container-fluid">
<div class="row">
<div class="col-sm-4">
<h2 align="center"><small class="text-success"> <? echo $profesor;?> &nbsp;&nbsp;</small></h2><hr />
<div class="well-transparent well-large">
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
		if (isset($registro)) {
			echo '<div align="left""><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			Las Faltas de Asistencia han sido registradas.
          </div></div>';
		}
		if (isset($mens1)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens1.'</div></div>';
		}
		if (isset($mens2)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens2.'</div></div>';
		}
		if (isset($mens3)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens3.'</div></div>';
		}
		if (isset($mens4)) {
			echo '<div align="left""><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_4.'</div></div>';
		}
		if (isset($fiesta)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$fiesta.'</div></div>';
		}
		if (isset($mens_fecha)) {
			echo '<div align="left""><div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>'.$mens_fecha.'</div></div>';
		}				
		?>
                 
                 <?
				  
                  include("cal.php"); 
                  ?>                   
</div>
</div>
<div class="col-sm-8">
<?          
            echo "<input type=hidden name=today value= \"$today\">";
			echo "<input type=hidden name=year value= \"$year\">";
			echo "<input type=hidden name=month value= \"$month\">";
			echo "<h2 align='center'><small class='text-success'>Semana:&nbsp;&nbsp;$lunes1 &nbsp;&nbsp;-->&nbsp;&nbsp; $viernes&nbsp;&nbsp;</small></h2><hr />";
            include("profes.php"); 
            ?>
             <div align="center"> 
    <br /><input type="submit" name="enviar" class="btn btn-primary" value="Registrar las faltas de asistencia">
  </div>                   
  </div>
  </div>      

			      <script>
document.form1.profesor.focus()
document.form1.profesor.options[<?php $id = $id; echo $id;?>].selected = true
    </script>
