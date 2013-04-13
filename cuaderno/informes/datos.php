<div align="center"><br /><h4>
 Datos del Alumno</h4><br /></div>
  <?php
   
  
  $SQL = "select distinct alma.claveal, alma.apellidos, alma.nombre, alma.nivel, alma.grupo,\n
  alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.PADRE from alma
  where claveal = '$claveal' order BY alma.apellidos";
  // echo $SQL;
  $result = mysql_query($SQL);
echo "<table  class='table table-striped' style='width:auto'>";
                while($row = mysql_fetch_array($result)){
		$claveal = $row[0];
		$PADRE =  $row[9];
		echo "
<tr><th>Clave</th><td>$claveal</td></tr>
<tr><th>Nombre</th><td>$row[2] $row[1]</td></tr>
<tr><th>Grupo</th><td>$row[3]-$row[4]</td></tr>
<tr><th>DNI</th><td>$row[5]</td></tr>
<tr><th>FECHA</th><td>$row[6]</td></tr>
<tr><th>DOMICILIO</th><td>$row[7]</td></tr>
<tr><th>TELÉFONO</th><td>$row[8]</td></tr>
<tr><th>PADRE</th><td>$PADRE</td></tr>";
        } 
        echo "</table>";        
  ?>

