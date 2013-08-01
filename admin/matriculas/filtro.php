<br />
<div class="well well-small" style="width:980px;">
<form action="consultas.php" method="post" name="form2" id="form2">
<h4>Selecciona Nivel&nbsp;
<select maxlength="12" name="curso" id="curso" onChange="desactivaOpcion();">
	<option><? echo $curso;?></option>
	<option>1ESO</option>
	<option>2ESO</option>
	<option>3ESO</option>
	<option>4ESO</option>
</select>
<!-- </h4> -->
<label>Grupos:
<?					
$tipo0 = "select distinct grupo_actual from matriculas where curso = '$curso' order by grupo_actual";
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
		<td><label>Bilinguismo <select name="bilinguism">
		<? if ($bilinguism) {
			echo "<option>$bilinguism</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
		</select></label>
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
			<option>Promociona</option>
			<option>PIL</option>
			<option>Repite</option>
		</select>
		</td>
		<td><label>Exención <select name="exencio" style="width:50px;">
		<?php
		if ($exencio) {
			echo "<option>$exencio</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
		</select></td>
		
		<td><label>Itinerario <select name="itinerari" style="width:50px;">
		<?php
		if ($itinerari) {
			echo "<option>$itinerari</option>";
		}
		?>
			<option></option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
		</select></td>
		<td><label>Matematicas 4º <select name="matematica4" style="width:50px;">
		<?php
		if ($matematica4) {
			echo "<option>$matematica4</option>";
		}
		?>
			<option></option>
			<option>A</option>
			<option>B</option>
		</select></td>
	</tr>
	<tr>
		<td><label>Diversificación <select name="diversificacio" style="width:50px;">
		<?php
		if ($diversificacio) {
			echo "<option>$diversificacio</option>";
		}
		?>
			<option></option>
			<option>Si</option>
			<option>No</option>
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
			<option>H</option>
			<option>I</option>
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
			<option>H</option>
			<option>I</option>
		</select></td>
		
		<td><label>Optativa <select name="optativ" style="width:150px;">
		<?php
		if ($optativ) {
			echo "<option>$optativ</option>";
		}
		?>
			<option></option>
			<option>optativa1</option>
			<option>optativa2</option>
			<option>optativa3</option>
			<option>optativa4</option>
			<option>optativa5</option>
			<option>optativa6</option>
			<option>optativa7</option>
		</select></td>
		
	</tr>
	<tr>
	<td><label>Transporte escolar<br /> <select name="transport" style="width:100px;">
		<?php
		if ($transport) {
			echo "<option>$transport</option>";
		}
		?>
			<option></option>
			<option>ruta_este</option>
			<option>ruta_oeste</option>
		</select></td>
		<td><label>Religión<br /></span> <select name="religio" id="religion" style="width:150px;">
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
		<td><label>Centro Origen <br /><select name="colegi" style="width:160px;">
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
		<td><label>Actividades <br /><select name="actividade" style="width:150px;">
		<?php
		if ($actividade) {
			echo "<option>$actividade</option>";
		}
		?>
			<option></option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
		</select></td>
		
	</tr>
	<tr>
	<td colspan=4><label align=center>Problemas de Convivencia <select name="fechori">
		<? if ($fechori) {
			echo "<option>$fechori</option>";
		}
		?>
			<option></option>
			<option>Sin problemas</option>
			<option>1 --> 5</option>
			<option>5 --> 15</option>
			<option>15 --> 1000</option>
		</select></label>
		</td>
	</tr>
</table>
<input type="submit" name="consulta" value="Ver matrículas" alt="Introducir" class="btn btn-primary" />
</form>
</div>
<br />
