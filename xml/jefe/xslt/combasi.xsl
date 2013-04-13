<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE xsl:stylesheet  [
	<!ENTITY copy   "&#169;">
	<!ENTITY reg    "&#174;">
	<!ENTITY trade  "&#8482;">
	<!ENTITY mdash  "&#8212;">
	<!ENTITY ldquo  "&#8220;">
	<!ENTITY rdquo  "&#8221;"> 
	<!ENTITY pound  "&#163;">
	<!ENTITY yen    "&#165;">
	<!ENTITY euro   "&#8364;">]>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="ISO-8859-1" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Combinacion de asignaturas en Alma</title>
</head>

<body>
<xsl:for-each select="SERVICIO/CURSOS/CURSO/UNIDADES/UNIDAD/ALUMNOS/ALUMNO">
 UPDATE;<xsl:value-of select="X_MATRICULA"/>;<xsl:for-each select="MATERIAS_ALUMNO/MATERIA_ALUMNO"><xsl:value-of select="X_MATERIAOMG"/>:</xsl:for-each>;<xsl:value-of select="T_APELLIDO1"/>;<xsl:value-of select="T_APELLIDO2"/>;<xsl:value-of select="T_NOMBRE_ALU"/>;<xsl:value-of select="../../T_NOMBRE"/>;
 <br />
</xsl:for-each>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
