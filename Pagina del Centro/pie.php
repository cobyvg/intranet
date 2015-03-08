</div>
</div>
<footer class="footer well" style="text-align:center">
      <div class="container-fluid">
      <p class="muted"><a href="http://iesmonterroso.org"><? echo $nombre_del_centro;?></a></p>
        <p class="muted"><? echo $dirección_del_centro;?> <? echo $codigo_postal_del_centro;?> <? echo $localidad_del_centro;?> Málaga</p>
        <p class="muted">Contacto: <a href="mailto:<? echo $email_del_centro;?>"> Correo</a> Tfno: <? echo $telefono_del_centro;?></p>
        <? if($monterroso==1){ ?>
	    <p><a href="<? echo $dominio;?>situa/index.php">Cómo llegar...</a></p>
		<? } ?>        
      </div>
    </footer>
    <script src="http://<? echo $dominio;?>js/jquery.js"></script>
    <script src="http://<? echo $dominio;?>js/bootstrap.min.js"></script>
</body>
</html>
