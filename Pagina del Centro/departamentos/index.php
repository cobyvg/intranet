<?
include("../conf_principal.php");
include "../cabecera.php";
?>
<div class="span3">
<div class="well well-large">
<li class="nav-header" style="margin-bottom: 5px;">Departamentos</li>
<ul class="nav nav-list">
<?
mysql_connect ($host, $user, $pass);
mysql_select_db ($db);
$dep0 = "SELECT distinct departamento from departamentos where departamento not like 'Conserjeria' and departamento not like 'Administracion' and departamento not like 'admin' order by departamento";
$dep1 = mysql_query($dep0);
while($dep = mysql_fetch_row($dep1))
{
	$departamento = $dep[0];
	?>
	<li><a href="<? echo "#$departamento";?>"><? echo "$departamento";?></a></li>
	<?
}
echo "</ul></DIV>";
?>

</div>

<div class="span9"><br>
<h3 align='center'><i class='icon icon-user'> </i> Departamentos del Centro<hr />
</h3>
<br>
<div class="span8 offset2 well well-large"><?
// DNI del Padre/Madr
$dep0 = "SELECT distinct departamento from departamentos  where departamento not like 'Conserjeria' and departamento not like 'Administracion' and departamento not like 'admin' order by departamento";
$dep1 = mysql_query($dep0);
while($dep = mysql_fetch_row($dep1))
{
	$departamento0 = trim($dep[0]);
	$pes = " P.E.S.";
	$departamento = str_replace($pes,"",$departamento0);
	$departamento1 = str_replace("á","a",$departamento);
	$departamento1 = str_replace("é","e",$departamento1);
	$departamento1 = str_replace("í","i",$departamento1);
	$departamento1 = str_replace("ó","o",$departamento1);
	$departamento1 = str_replace("ú","u",$departamento1);
	echo  '
      <a name="'.$departamento0.'" id="'.$departamento0.'"></a>                
        <p class="lead muted">Departamento de ' . $departamento . '</p> 
		<p class="text-info"><i class="icon icon-user"> </i>&nbsp;Miembros del Departamento</p><ul>';  
	$profe0 = "SELECT nombre from departamentos where departamento = '$departamento0' order by nombre";
	$profe1 = mysql_query($profe0);
	while($profe = mysql_fetch_row($profe1))
	{
		$nombre = $profe[0];
		?>

<li><? echo $nombre;?></li>

		<?
	}
	echo "</ul>";
	if ($mod_departamentos==1) {
	echo '<a href="http://'.$dominio.'doc/index.php?&direction=0&order=&directory=departamentos/';
	if($departamento == 'Matemáticas') $departamento = "Matemáticas";
	if($departamento == 'Lengua Castellana') $departamento = "Lengua Castellana y Literatura";
	if($departamento == 'Lengua Extranjera-Inglés') $departamento = "Inglés";
	echo $departamento1;
	echo '"><i class="icon icon-file-text"> </i>&nbsp;Archivos
 de ' . $departamento . '</a>';
	}
	echo "<hr />";
}
?></div>
</div>
<? include("../pie.php");?>