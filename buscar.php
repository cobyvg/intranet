<p class="lead">Buscar...</p>
<form method="post" action="admin/noticias/buscar.php" class="form-search">
<input
	type="text" name="expresion" id="exp"
	class="search-query"
	value="...en las Noticias y Mensajes" onclick="this.value=''" style="width:90%" />
    </form>
<form action="http://www.google.com/custom" method="get"
	style="margin-top: 0px;" class="form-search">
    <input type="text" id="exp" name="q"
	maxlength="255" onMouseOver="select()"
	class="search-query"
	value="...en iesmonterroso.org" onclick="this.value=''" style="width:90%" /> 
    <input
	type="hidden" name="sitesearch" value="<?
	echo $dominio;
	?>"
	checked="checked" /> <input type="hidden" name="cof"
	value="S:http://<?
	echo $dominio;
	?>;AH:center;L:ies.gif;AWFID:12e022daa787c23d;" /> <input type="hidden"
	name="domains" value="<?
	echo $dominio;
	?>" />
</form>
