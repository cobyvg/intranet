<?xml version="1.0" encoding="ISO-8859-1"?><!-- DWXMLSource="../../exporta/1EA.xml" -->
<!DOCTYPE xsl:stylesheet  [
	<!ENTITY nbsp   "&#160;">
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
<title>Documento sin ttulo</title>
</head>

<body>
<xsl:for-each select="SERVICIO/SISTEMAS_CALIFICACION/SISTEMA_CALIFICACION/CALIFICACIONES/CALIFICACION">
 INSERT INTO calificaciones VALUES ('<xsl:value-of select="X_CALIFICA"/>', '<xsl:value-of select="D_CALIFICA"/>', '<xsl:value-of select="T_ABREV"/>', '<xsl:value-of select="N_ORDEN"/>');
 <br />
</xsl:for-each>
</body>
</html>
</xsl:template>
</xsl:stylesheet>