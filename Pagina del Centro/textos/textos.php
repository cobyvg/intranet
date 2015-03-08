<?
	$titulo = "$nivel";
	if($grupo and $grupo!=="Selecciona GRUPO"){$titulo.=" - $grupo";}
	echo "<p class='lead muted' align='center'>$titulo";
	echo "<br />Curso Escolar $curso_textos</p>";

// Datos del pROFESOR que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
	$textos0 = "SELECT distinct Departamento, Asignatura, Autor, Titulo, Editorial, 
	Obligatorio FROM Textos where Nivel = '$nivel'";
	if(strlen($grupo)==1)
	{
	$textos0.= " and GRUPO like '%$grupo%'";
	}
	$textos0.= " order by Asignatura";
	$textos = mysql_query($textos0);
	
   if ($row = mysql_fetch_array($textos))
   {
	echo "<table class='table table-striped table-bordered'>
	<tr class='text-info'>
	 <th>ASIGNATURA</th>
	 <th>AUTOR</th>
	 <th>TITULO</th>
	 <th>EDITORIAL</th>
	 <th>TIPO</th></tr></tbody>";
do
{
          printf ("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",
		  $row[1], $row[2], $row[3], $row[4], $row[5]);
        } while($row = mysql_fetch_array($textos));	
		echo "</tbody></table>";
		}	
?>

