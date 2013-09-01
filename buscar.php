<legend> <i class="icon icon-search"></i> Buscar...</legend>
<form action="admin/noticias/buscar.php" method="POST" class="form-search">
  <input type="text" name="expresion" id="exp" class="search-query" placeholder="...en las Noticias y Mensajes" style="width:90%">
</form>

<form action="http://www.google.com/cse" method="GET" target="_blank" class="form-search" style="margin-top: 0px;">
    <input type="text" id="exp" name="q" maxlength="255" class="search-query" placeholder="...en <?php echo $dominio; ?>" style="width:90%">
    <input type="hidden" name="cof" value="FORID:9">
    <input type="hidden" name="sitesearch" value="<?php echo $dominio; ?>">
    <input type="hidden" name="hl" value="es">
</form>