<?xml version="1.0" encoding="ISO-8859-1"?><!-- DWXMLSource="../../exporta/1BACHD.xml" -->
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

<xsl:for-each select="SERVICIO/CURSOS/CURSO/UNIDADES/UNIDAD/MATERIAS/MATERIA">
 
  INSERT INTO asignaturtmp VALUES ('<xsl:value-of select="X_MATERIAOMG"/>','<xsl:value-of select="D_MATERIAC"/>','<xsl:value-of select="T_ABREV"/>','<xsl:value-of select="../../../../D_OFERTAMATRIG"/>');
 <br />
</xsl:for-each>
</xsl:template>
</xsl:stylesheet>
