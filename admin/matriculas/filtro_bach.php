<div class="well hidden-print">
	<form method="post" id="form2" name="form2" action="consultas_bach.php">
		
		<fieldset>
			<legend>Criterios de búsqueda</legend>
			
			
			<!-- FILA 1 -->
			<div class="row">
				<!-- FILA 1, COLUMNA 1 -->
				<div class="col-sm-6">
					
					<div class="form-group">
						<label for="curso">Curso</label>
						<select class="form-control" id="curso" name="curso" onchange="submit();">
							<option value=""></option>
							<option value="1BACH" <?php echo (isset($curso) && $curso == "1BACH") ? 'selected' : ''; ?>>1º de Bachillerato</option>
							<option value="2BACH" <?php echo (isset($curso) && $curso == "2BACH") ? 'selected' : ''; ?>>2º de Bachillerato</option>
						</select>
					</div>
					
				</div><!-- /.col-sm-6 -->
				
				
				<!-- FILA 1, COLUMNA 2 -->
				<div class="col-sm-6">
					<div class="form-group">
						<label>Grupos</label>
						
						<div class="form-inline">
						<div class="checkbox" style="margin-right: 10px;">
							<label>
								<input type="checkbox" name="grupo_actua[]" value="Ninguno" <?php echo (in_array('Ninguno',$grupo_actua)) ? 'checked' : ''; ?>> <span class="badge badge-default">Ninguno</span>
							</label>
						</div>
						<?php $result = mysql_query("SELECT DISTINCT grupo_actual FROM matriculas_bach WHERE curso='$curso' ORDER BY grupo_actual ASC"); ?>
						<?php if(mysql_num_rows($result)): ?>
							<?php while($row = mysql_fetch_array($result)): ?>
							<?php if($row['grupo_actual'] != ""): ?>
							<div class="checkbox" style="margin-right: 10px;">
								<label>
									<input type="checkbox" name="grupo_actua[]" value="<?php echo $row['grupo_actual']; ?>" <?php echo (in_array($row['grupo_actual'], $grupo_actua)) ? 'checked' : ''; ?>> <span class="badge badge-default"><?php echo $row['grupo_actual']; ?></span>
								</label>
							</div>
							<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; ?>
						</div>
						
					</div>
				</div>
				
			</div><!-- /.row -->
			
			
			<div class="panel-group" id="filter">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#filter" href="#avanzado">
			          <span class="fa fa-filter"></span> Búsqueda avanzada
			        </a>
			      </h4>
			    </div>
			    <div id="avanzado" class="panel-collapse collapse">
			      <div class="panel-body">
			        
			        <!-- FILA 2 -->
			        <div class="row">
			        	<!-- FILA 2, COLUMNA 1 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="dn">DNI/Pasaporte</label>
			        			<input type="text" class="form-control" id="dn" name="dn" placeholder="DNI/Pasaporte" value="<?php echo (isset($dn) && $dn != "") ? $dn : ''; ?>" maxlength="12">
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 2, COLUMNA 2 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="apellid">Apellidos</label>
			        			<input type="text" class="form-control" id="apellid" name="apellid" placeholder="Apellidos" value="<?php echo (isset($apellid) && $apellid != "") ? $apellid : ''; ?>" maxlength="30">
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 2, COLUMNA 3 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="nombr">Nombre</label>
			        			<input type="text" class="form-control" id="nombr" name="nombr" placeholder="Nombre" value="<?php echo (isset($nombr) && $nombr != "") ? $nombr : ''; ?>" maxlength="30">
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 2, COLUMNA 4 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="itinerari">Modalidad</label>
			        			<select class="form-control" id="itinerari" name="itinerari">
			        				<option value=""></option>
			        				<?php for($i=1; $i<3; $i++): ?>
			        				<option value="<?php echo $i; ?>" <?php echo (isset($itinerari) && $itinerari == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
			        				<?php endfor; ?>
			        			</select>
			        		</div>
			        	</div>
			        </div><!-- /.row -->
			        
			        
			        <!-- FILA 3 -->
			        <div class="row">
			        	<!-- FILA 3, COLUMNA 1 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="optativ">Optativas modalidad</label>
			        			<select class="form-control" id="optativ" name="optativ">
			        				<option value=""></option>
			        				<?php for ($i = 1; $i < 3; $i++): ?>
			        				<?php foreach (${opt.$n_curso.$i} as $key => $value): ?>
			        				<option value="<?php echo $key; ?>" <?php echo (isset($optativ) && $optativ == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
			        				<?php endforeach; ?>
			        				<?php endfor; ?>
			        			</select>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 3, COLUMNA 2 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="idiom1">Primer Idioma</label>
			        			<select class="form-control" id="idiom1" name="idiom1">
			        				<option value=""></option>
			        				<option value="Inglés" <?php echo (isset($idiom1) && $idiom1 == "Inglés") ? 'selected' : ''; ?>>Inglés</option>
			        				<option value="Francés" <?php echo (isset($idiom1) && $idiom1 == "Francés") ? 'selected' : ''; ?>>Francés</option>
			        			</select>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 3, COLUMNA 3 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<?php if($curso == "1BACH"): ?>
			        			<label for="idiom2">Segundo Idioma</label>
			        			<select class="form-control" id="idiom2" name="idiom2">
			        				<option value=""></option>
			        				<option value="Alemán" <?php echo (isset($idiom2) && $idiom2 == "Alemán") ? 'selected' : ''; ?>>Alemán</option>
			        				<option value="Francés" <?php echo (isset($idiom2) && $idiom2 == "Francés") ? 'selected' : ''; ?>>Francés</option>
			        			</select>
			        			<?php elseif ($curso == "2BACH"): ?>
			        			<label for="optativ2">Otras optativas</label>
			        			<select class="form-control" id="optativ2" name="optativ2">
			        				<option value=""></option>
			        				<?php $n_opt2 = 1; ?>
			        				<?php foreach (${opt23} as $key => $value): ?>
			        				<option value="<?php echo $n_opt2; ?>" <?php echo (isset($optativ2) && $optativ2 == $n_opt2) ? 'selected' : ''; ?>><?php echo $value; ?></option>
			        				<?php $n_opt2++; ?>
			        				<?php endforeach; ?>
			        			</select>
			        			<?php endif; ?>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 3, COLUMNA 4 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="promocion">Promoción</label>
			        			<select class="form-control" id="promocion" name="promocion">
			        				<option value=""></option>
			        				<option value="SI" <?php echo (isset($promocion) && $promocion == "SI") ? 'selected' : ''; ?>>Sí</option>
			        				<option value="NO" <?php echo (isset($promocion) && $promocion == "NO") ? 'selected' : ''; ?>>No</option>
			        				<?php if($n_curso == "1"): ?>
			        				<option value="3/4" <?php echo (isset($promocion) && $promocion == "3/4") ? 'selected' : ''; ?>>3/4</option>
			        				<?php endif; ?>
			        			</select>
			        		</div>
			        	</div>
			        </div><!-- /.row -->
			        
			        
			        
			        <!-- FILA 4 -->
			        <div class="row">
			        	<!-- FILA 4, COLUMNA 1 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="letra_grup">Grupo de origen</label>
			        			<select class="form-control" id="letra_grup" name="letra_grup">
			        				<option value=""></option>
			        				<?php for ($i=65; $i<75; $i++): ?>
			        				  <option value="<?php echo chr($i); ?>" <?php echo (isset($letra_grup) && $letra_grup == chr($i)) ? 'selected' : ''; ?>><?php echo chr($i); ?></option>               
			        				<?php endfor; ?>
			        			</select>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 4, COLUMNA 2 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="grupo_actua_seg">Grupo actual</label>
			        			<select class="form-control" id="grupo_actua_seg" name="grupo_actua_seg">
			        				<option value=""></option>
			        				<option value="Ninguno" <?php echo (isset($grupo_actua_seg) && $grupo_actua_seg == "Ninguno") ? 'selected' : ''; ?>>Ninguno</option>
			        				<?php for ($i=65; $i<75; $i++): ?>
			        				  <option value="<?php echo chr($i); ?>" <?php echo (isset($grupo_actua_seg) && $grupo_actua_seg == chr($i)) ? 'selected' : ''; ?>><?php echo chr($i); ?></option>               
			        				<?php endfor; ?>
			        			</select>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 4, COLUMNA 3 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="transport">Transporte escolar</label>
			        			<select class="form-control" id="transport" name="transport">
			        				<option value=""></option>
			        				<option value="ruta_este" <?php echo (isset($transport) && $transport == "ruta_este") ? 'selected' : ''; ?>>Ruta este</option>
			        				<option value="ruta_oeste" <?php echo (isset($transport) && $transport == "ruta_oeste") ? 'selected' : ''; ?>>Ruta oeste</option>
			        			</select>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 4, COLUMNA 4 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="religio">Religión</label>
			        			<select class="form-control" id="religio" name="religio">
			        				<option value=""></option>
			        				<option value="Religión Católica" <?php echo (isset($religio) && $religio == "Religión Católica") ? 'selected' : ''; ?>>Religión Católica</option>
			        				<option value="Religión Islámica" <?php echo (isset($religio) && $religio == "Religión Islámica") ? 'selected' : ''; ?>>Religión Islámica</option>
			        				<option value="Religión Judía" <?php echo (isset($religio) && $religio == "Religión Judía") ? 'selected' : ''; ?>>Religión Judía</option>
			        				<option value="Religión Evangélica" <?php echo (isset($religio) && $religio == "Religión Evangélica") ? 'selected' : ''; ?>>Religión Evangélica</option>
			        				<option value="Historia de las Religiones" <?php echo (isset($religio) && $religio == "Historia de las Religiones") ? 'selected' : ''; ?>>Historia de las Religiones</option>
			        				<option value="Atención Educativa" <?php echo (isset($religio) && $religio == "Atención Educativa") ? 'selected' : ''; ?>>Atención Educativa</option>
			        			</select>
			        		</div>
			        	</div>
			        </div><!-- /.row -->
			        
			        
			        <!-- FILA 5 -->
			        <div class="row">
			        	<!-- FILA 5, COLUMNA 1 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="colegi">Centro de origen</label>
			        			<?php $result = mysql_query("SELECT DISTINCT colegio FROM matriculas ORDER BY colegio ASC"); ?>
			        			<?php if(mysql_num_rows($result)): ?>
			        			<select class="form-control" id="colegi" name="colegi">
			        				<?php while($row = mysql_fetch_array($result)): ?>
			        				<option value="<?php echo $row['colegio']; ?>" <?php echo (isset($colegi) && $colegi == $row['colegio']) ? 'selected' : ''; ?>><?php echo $row['colegio']; ?></option>
			        				<?php endwhile; ?>
			        			</select>
			        			<?php else: ?>
			        			<select class="form-control" id="colegi" name="colegi" disabled>
			        				<option></option>
			        			</select>
			        			<?php endif; ?>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 5, COLUMNA 2 -->
			        	<div class="col-sm-3">
			        		<div class="form-group">
			        			<label for="fechori">Problemas de convivencia</label>
			        			<select class="form-control" id="fechori" name="fechori">
			        				<option value=""></option>
			        				<option value="Sin problemas" <?php echo (isset($fechori) && $fechori == "Sin problemas") ? 'selected' : ''; ?>>Sin problemas</option>
			        				<option value="1 --> 5" <?php echo (isset($fechori) && $fechori == "1 --> 5") ? 'selected' : ''; ?>>De 1 a 5 problemas</option>
			        				<option value="5 --> 15" <?php echo (isset($fechori) && $fechori == "5 --> 15") ? 'selected' : ''; ?>>De 5 a 15 problemas</option>
			        				<option value="15 --> 1000" <?php echo (isset($fechori) && $fechori == "15 --> 1000") ? 'selected' : ''; ?>>De 15 a 1000 problemas</option>
			        			</select>
			        		</div>
			        	</div>
			        	
			        	
			        	<!-- FILA 5, COLUMNA 3 -->
			        	<div class="col-sm-3"></div>
			        	
			        	
			        	<!-- FILA 5, COLUMNA 4 -->
			        	<div class="col-sm-3"></div>
			        </div><!-- /.row -->
			        
			        
			      </div>
			    </div>
			  </div>
	
			</div>

			
			<button type="submit" class="btn btn-primary" name="consulta">Consultar</button>
			<?php if(isset($curso) && $curso != ""): ?>
			<a class="btn btn-default" href="consultas_bach.php">Cancelar</a>
			<?php endif; ?>
			
		</fieldset>
		
	</form>
</div>