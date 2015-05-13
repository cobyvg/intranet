<?
// Copia de la Base de datos principal para mantener registro de cursos académicos
$curso_pasado=date('Y');
$nombre_copia=$db.$curso_pasado;
echo '<div align="center">
<div class="alert alert-info alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            A principio de cada Curso escolar se crea una copia de la base de datos principal, <strong><em>'.$db.'</em></strong>, con el año del curso escolar añadido al final del nombre (en este caso <strong><em>'.$nombre_copia.'</em></strong>). A continuación se vacían las tablas adecuadas, aunque se mantienen las que contienen datos persistentes. Una vez completadas estas tareas, comienza la importación de datos de alumnos.</div></div><br />';

mysqli_query($db_con, "CREATE DATABASE if not exists ".$nombre_copia."") or die('
<div align="center">
<div class="alert alert-danger alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>ATENCIÓN:</strong>
Ha surgido un error al crear la copia de seguridad de la Base de datos de forma automática. Debes crear una base de datos manualmente para recibir la copia de seguridad de los datos actuales. El nombre de la base de datos sigue el patrón que se describe más arriba (<strong><em>'.$nombre_copia.'</em></strong>, en tu caso). Una vez creada la base de datos, asegúrate que el usuario de MySQL que has registrado en la página de configuración tiene permiso para escribir en la nueva base de datos, y vuelve a recargar esta página para completar el proceso.
</div></div><br />');

// Vaciado de tablas para comenzar cada curso
$tablas = mysqli_query($db_con, "show tables");
while ($tabla = mysqli_fetch_array($tablas)) {
mysqli_query($db_con, "create table ".$nombre_copia.".".$tabla[0]." SELECT * FROM ".$db.".".$tabla[0]);
	$protegida = "";
	$intocables = array("absentismo","biblioteca","actualizacion","calendario","calendario_categorias", "c_profes", "control", "departamentos","fotos", "inventario_clases", "inventario", "inventario_lugares", "listafechorias", "mensajes", "mens_profes", "mens_texto", "noticias", "partestic", "recursos", "r_departamento", "Textos", "textos_gratis", "alma_primaria", "alma_secundaria", "matriculas", "matriculas_bach", "matriculas_backup", "matriculas_bach_backup", "mem_dep");
	foreach ($intocables as $notocar){
		if ($tabla[0]==$notocar) {
			$protegida = "1";
		}
	}
	if (!($protegida == "1")) {
		mysqli_query($db_con, "truncate table $tabla[0]");
	}
}

?>