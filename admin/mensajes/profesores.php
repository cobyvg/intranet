<?
 if(isset($_POST['submit1']))
{	
  if(!$asunto or !$texto or empty($profesor)) { 
  	echo '<div class="alert alert-info alert-block">';
    echo '  Es necesario que rellenes todos los campos del formulario: Destinatario, asunto y texto del mensaje.';
    echo '</div>';
  }
elseif(!$profeso and !$tutor and !$departamento and !$equipo and !$etcp and !$ca and !$claustro and !$direccion and !$orientacion and !$bilingue and !$biblio and !($padres))
{
	echo '<div class="alert alert-info alert-block">';
    echo '  No has elegido el destinatario del mensaje.';
    echo '</div>';
}
else
{

$msg_success = '<div class="alert alert-success alert-block">El mensaje se ha enviado correctamente.</div></div><br />';
      
$query0="insert into mens_texto (asunto,texto, origen) values ('".$asunto."','".$texto."','".$profesor."')";
mysql_query($query0);
$id0 = mysql_query("select id from mens_texto where asunto = '$asunto' and texto = '$texto' and origen = '$profesor'");
$id1 = mysql_fetch_array($id0);
$id = $id1[0];

$ok=0;

if($profeso)
	{
$profiso = $_POST["profeso"];
	foreach($profiso as $nombre)
	{
	$query1="insert into mens_profes (id_texto, profesor) values ('".$id."','".$nombre."')";
	mysql_query($query1);
	$t_nombres.=$nombre."; ";
	}
	$ok=1;
	mysql_query("update mens_texto set destino = '$t_nombres' where id = '$id'");	
	}
	
if($tutor)
	{
$tu = $_POST["tutor"];
	foreach($tu as $nombre_tutor)
	{
	$nombre_tut = explode("-->",$nombre_tutor);
	$nombre_tuto = trim($nombre_tut[0]);
	$rep0 = mysql_query("select * from mens_profes where id_texto = '$id' and profesor = '$nombre_tuto'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$nombre_tuto."')");
	$t_nombres.=$nombre_tuto."; ";
	}
	mysql_query("update mens_texto set destino = '$t_nombres' where id = '$id'");
	$ok=1;
	}

if($departamento)
	{
$dep = $_POST["departamento"];
	foreach($dep as $nombre_dep)
	{
	$dep0 = mysql_query("select distinct nombre from departamentos where departamento = '$nombre_dep'");
	while($dep1 = mysql_fetch_array($dep0)){
	$rep0 = mysql_query("select * from mens_profes where id_texto = '$id' and profesor = '$dep1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$dep1[0]."')");
	}
	$t_nombres.="Departamento de ".$nombre_dep."; ";
	}
	mysql_query("update mens_texto set destino = '$t_nombres' where id = '$id'");
	$ok=1;
	}	
	
if($equipo)
	{
$eq = $_POST["equipo"];
foreach($eq as $nombre_eq)
	{
	$eq0 = mysql_query("select distinct nombre from profesores, departamentos where nombre = profesor and grupo = '$nombre_eq' or cargo like '%8%'");
	while($eq1 = mysql_fetch_array($eq0))
	{
	$rep0 = mysql_query("select * from mens_profes where id_texto = '$id' and profesor = '$eq1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)	
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$eq1[0]."')");
	}
	$t_nombres.="Equipo Educativo de ".$nombre_eq."; ";
	}
	mysql_query("update mens_texto set destino = '$t_nombres' where id = '$id'");
	$ok=1;
	}

if($ca == '1')
	{
	$ca0 = mysql_query("select distinct nombre from departamentos where cargo like '%9%'");
	while($ca1 = mysql_fetch_array($ca0)){
	$rep0 = mysql_query("select * from mens_profes where id_texto = '$id' and profesor = '$ca1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)
	 mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$ca1[0]."')");
	//echo "insert into mens_profes (id_texto, profesor) values ('".$id."','".$ca1[0]."')";
	}
	 mysql_query("update mens_texto set destino = 'CA' where id = '$id'");
	//echo "update mens_texto set destino = 'CA' where id = '$id'";
	echo $msg_success;
	}

if($etcp == '1')
	{
	$etcp0 = mysql_query("select distinct nombre from departamentos where cargo like '%4%'");
	while($etcp1 = mysql_fetch_array($etcp0)){
	$rep0 = mysql_query("select * from mens_profes where id_texto = '$id' and profesor = '$etcp1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)
	 mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$etcp1[0]."')");
	//echo "insert into mens_profes (id_texto, profesor) values ('".$id."','".$etcp1[0]."')";
	}
	 mysql_query("update mens_texto set destino = 'ETCP' where id = '$id'");
	//echo "update mens_texto set destino = 'ETCP' where id = '$id'";
	$ok=1;
	}	

	
if($claustro == '1')
	{
	$cl0 = mysql_query("select distinct nombre from departamentos");
	while($cl1 = mysql_fetch_array($cl0)){
	$rep0 = mysql_query("select * from mens_profes where id_texto = '$id' and profesor = '$cl1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)	
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$cl1[0]."')");
	}
	mysql_query("update mens_texto set destino = 'Claustro del Centro' where id = '$id'");
	$ok=1;
	}

if($direccion == '1')
	{
	$dir0 = mysql_query("select distinct nombre from departamentos where cargo like '%1%'");
	while($dir1 = mysql_fetch_array($dir0)){
	$rep0 = mysql_query("select * from mens_profes where id = '$id' and profesor = '$dir1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)	
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$dir1[0]."')");
	}
	mysql_query("update mens_texto set destino = 'Equipo Directivo' where id = '$id'");
	echo $msg_success;
	}

if($orientacion == '1')
	{
	$orienta0 = mysql_query("select distinct nombre from departamentos where cargo like '%8%'");
	while($orienta1 = mysql_fetch_array($orienta0)){
	$rep0 = mysql_query("select * from mens_profes where id = '$id' and profesor = '$orienta1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)	
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$orienta1[0]."')");
	}
	mysql_query("update mens_texto set destino = 'Departamento de Orientaci&oacute;n' where id = '$id'");
	$ok=1;
	}
	
if($bilingue == '1')
	{
	$bilingue0 = mysql_query("select distinct nombre from departamentos where cargo like '%a%'");
	while($bilingue1 = mysql_fetch_array($bilingue0)){
	$rep0 = mysql_query("select * from mens_profes where id = '$id' and profesor = '$bilingue1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)	
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$bilingue1[0]."')");
	}
	mysql_query("update mens_texto set destino = 'Bilinguismo' where id = '$id'");
	$ok=1;
	}
	
if($biblio == '1')
	{
	$biblio0 = mysql_query("select distinct nombre from departamentos where cargo like '%c%'");
	while($biblio1 = mysql_fetch_array($biblio0)){
	$rep0 = mysql_query("select * from mens_profes where id = '$id' and profesor = '$biblio1[0]'");
	$num0 = mysql_fetch_row($rep0);
	if(strlen($num0[0]) < 1)	
	mysql_query("insert into mens_profes (id_texto, profesor) values ('".$id."','".$biblio1[0]."')");
	}
	mysql_query("update mens_texto set destino = 'Biblioteca' where id = '$id'");
	$ok=1;
	}	
	
if($padres)
	{
$pa = $_POST["padres"];
	foreach($pa as $nombre)
	{
	$query1="insert into mens_profes (id_texto, profesor) values ('".$id."','".$nombre."')";
	mysql_query($query1);
	$t_nombres.=$nombre."; ";
	}
	mysql_query("update mens_texto set destino = '$t_nombres' where id = '$id'");	
	$ok=1;
	}
}
}

if($ok) echo $msg_success;
?>