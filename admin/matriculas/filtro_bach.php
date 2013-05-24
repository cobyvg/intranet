<br />
<div class="well-2 well-small" style="width:980px;">

<form action="consultas_bach.php" method="post" name="form2">
<h4>Selecciona Nivel&nbsp;
<select maxlength="12" name="curso" id="curso" onChange="desactivaOpcion();submit()">
	<option><? echo $curso;?></option>
	<option>1BACH</option>
	<option>2BACH</option>
</select>
</h4>
<label>Grupos:
<?					
$tipo0 = "select distinct grupo_actual from matriculas_bach where curso = '$curso' order by grupo_actual";
$tipo10 = mysql_query($tipo0);
  while($tipo20 = mysql_fetch_array($tipo10))
        {	
        	if ($tipo20[0]=="") {
        		$tipo20[0]="Ninguno";
        	}
echo "<span class='badge badge-info'>".$tipo20[0]."</span>&nbsp;";
echo "<input name='grupo_actua[]' type='checkbox' value='$tipo20[0]' ";
if ($_POST['grupo_actua']) {			
		foreach ($_POST['grupo_actua'] as $grup_actua){
			  if ($grup_actua==$tipo20[0]) {
			  	echo " checked ";
			  }
		}	
	}
echo ">&nbsp;&nbsp;";
        }
						
	?>
    </label>
<br />
<table class="table table-striped table-condensed table-bordered" >
	<tr>
		<td><label>
		DNI <input type="text" name="dn" size="10"  
		<?php
		if ($dn) {
			echo "value='$dn'";
		}
		?>
		 />
         </label>
		</td>
		<td><label>
		Apellidos <input type="text" name="apellid" size="10"
		<?php
		if ($apellid) {
			echo "value='$apellid'";
		}
		?>
		 />
         </label>
		</td>
		<td><label>
		Nombre <input type="text" name="nombr" size="10"
		<?php
		if ($nombr) {
			echo "value='$nombr'";
		}
		?>
		 />
         </label>
		</td>
		</tr>
		<tr>	
		<td><label>Promoción <select name="promocion" style="width:120px;">
		<?php
		if ($promocion) {
			echo "<option>$promocion</option>";
		}
		?>
			<option></option>
			<option>SI</option>
			<option>NO</option>
			<option>3/4</option>
		</select></td>
		<td></td>
		
		<td><label>Modalidad <select name="itinerari" style="width:50px;">
		<?php
		if ($itinerari) {
			echo "<option>$itinerari</option>";
		}
		?>
			<option></option>
			<option>1</option>
			<option>2</option>
		</select></td>
	</tr>
	<tr>
		<td><label>Optativas Modal. <select name="optativ" style="width:150px;">
		<?php
		if ($optativ) {
			echo "<option>$optativ</option>";
		}
		?>
			<option></option>
		<?
		for ($i = 1; $i < 3; $i++) {
			foreach(${opt.$n_curso.$i} as $key=>$val){
			echo '<option value="'.$key.'">'.$val.'</option>';
		}			
		}

			
		?>	
		</select></td>		
		<td><label>Grupo de Origen <select name="letra_grup" style="width:50px;">
		<?php
		if ($letra_grup) {
			echo "<option>$letra_grup</option>";
		}
		?>
			<option></option>
			<option>A</option>
			<option>B</option>
			<option>C</option>
			<option>D</option>
			<option>E</option>
			<option>F</option>
			<option>G</option>
		</select></td>
		
		<td><label>Grupo Actual <select name="grupo_actua_seg" style="width:50px;">
		<?php
		if ($grupo_actua_seg) {
			echo "<option>$grupo_actua_seg</option>";
		}
		?>
			<option></option>
			<option>Ninguno</option>
			<option>A</option>
			<option>B</option>
			<option>C</option>
			<option>D</option>
			<option>E</option>
			<option>F</option>
			<option>G</option>
		</select></td>
		

		
	</tr>
	<tr>
	<td><label>Transporte escolar <select name="transport" style="width:100px;">
		<?php
		if ($transport) {
			echo "<option>$transport</option>";
		}
		?>
			<option></option>
			<option>ruta_este</option>
			<option>ruta_oeste</option>
		</select></td>
		<td><label>Religión</span> <select name="religio" id="religion" style="width:150px;">
		<?php
		if ($religio) {
			echo "<option>$religio</option>";
		}
		?>
			<option></option>
			<option>Religi&oacute;n Cat&oacute;lica</option>
			<option>Religión Islámica</option>
			<option>Religión Judía</option>
			<option>Religión Evangélica</option>
			<option>Historia de las Religiones</option>
			<option>Atención Educativa</option>
		</select></td>
		<td><label>Centro Origen <select name="colegi" style="width:160px;">
		<?php
		if ($colegi) {
			echo "<option>$colegi</option>";
		}
		?>
		<option></option>
		<?php 
		$coleg=mysql_query("select distinct colegio from matriculas order by colegio");
		while ($cole=mysql_fetch_array($coleg)) {
			echo "<option>$cole[0]</option>";
		}
		?>
		</select></td>
		
	</tr>
</table>
<input type="submit" name="consulta" value="Ver matrículas" alt="Introducir" class="btn btn-primary" />
</form>
</div>
<br />
