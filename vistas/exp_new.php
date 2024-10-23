<div class="container is-fluid mb-6">
	<h1 class="title">Expediente</h1>
	<h2 class="subtitle">Nuevo expediente</h2>
</div>

<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/exp_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
		<input type="hidden" name="sesion" required value="<?php echo $_SESSION['id']?>">
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Fondo</label>
					<div class="select is-rounded">
						<select name="expediente_fondo">
							<option value="" selected="">Seleccione una opción</option>
							<option value="ITH">TECNM</option>
						</select>
					</div>
				</div>
			</div>

			<div class="column">
				<div class="control">
					<label>Subfondo</label>
					<div class="select is-rounded">
						<select name="expediente_subfondo">
							<option value="" selected="">Seleccione una opción</option>
							<option value="servicios_escolares">Servicios escolares</option>
						</select>
					</div>
				</div>
			</div>

			<div class="column">
				<div class="control">
					<label>Seccion</label>
					<div class="select is-rounded">
						<select name="expediente_seccion">
							<option value="" selected="">Seleccione una opción</option>
							<option value="4S">4S</option>
						</select>
					</div>
				</div>
			</div>

			<div class="column">
				<div class="control">
					<label>Serie</label>
					<div class="select is-rounded">
						<select name="expediente_serie">
							<option value="" selected="">Seleccione una opción</option>
							<option value=".07">.07</option>
						</select>
					</div>
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Expediente</label>
					<input class="input" type="text" name="expediente_numero" pattern="[a-zA-Z0-9]{8,9}"
						maxlength="50" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Descripción (Nombre del estudiante)</label>
					<input class="input" type="text" name="expediente_descripcion"
						pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150">
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label
						title="Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental">Clasificación
						LFTAIPG</label>
					<div class="select is-rounded">
						<select name="expediente_clasificacion_LFTAIPG">
							<option value="" selected="">Seleccione una opción</option>
							<option value="publica">Pública</option>
							<option value="reservada" >Reservada</option>
							<option value="confidencial" >Confidencial</option>

						</select>
					</div>
				</div>

			</div>

			<div class="column">
				<div class="control">
					<label>Año de apertura:</label>
					<input type="date" name="expediente_fecha_apertura">
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Estado de expediente:</label>
					<div class="select is-rounded">
						<select name="expediente_estado">
							<option value="" selected="">Seleccione una opción</option>
							<option value="proceso">Proceso</option>
							<option value="concluido">Concluido</option>
						</select>
					</div>
				</div>
			</div>

			<div class="column">
				<div class="control">
					<label>Año de cierre:</label>
					<input type="date" name="expediente_fecha_cierre">
				</div>
			</div>
		</div><br>

		<label>Vigencia documental:</label><br>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Años de tramite</label>
					<div>
						<input type="number" min = "0" name="expediente_tiempo_tramite">
					</div>
				</div>

			</div>

			<div class="column">
				<div class="control">
					<label>Años en concentración</label>
					<div>
						<input type="number" min = "0" name="expediente_tiempo_concentracion">
					</div>
				</div>

			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Valor documental</label>
					<div class="select is-rounded">
						<select name="expediente_valor_documental">
							<option value="" selected="">Seleccione una opción</option>
							<option value="administrativo">Administrativo</option>
							<option value="legal">Legal</option>
							<option value="fiscal">Fiscal o contable</option>
							<option value="evidencial">Evidencial</option>
							<option value="testimonial">Testimonial</option>
							<option value="informativo">Informativo</option>

						</select>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<Label>Tradicion documental</Label>
					<div class="select is-rounded">
						<select name="expediente_tradicion_documental">
							<option value="" selected="">Seleccione una opción</option>
							<option value="original">Original</option>
							<option value="copia">Copia</option>
						</select>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Numero de hojas</label>
					<input type="number" min = "0" name="expediente_hojas">
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Legajos</label>
					<input type="number" min = "0" name="expediente_legajos">
				</div>
			</div>

			<div class="column">
				<div class="control">
					<label>Observaciones</label>
					<input class="input" type="text" name="expediente_observaciones" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,100}"
						maxlength="100" required>
				</div>
			</div>
		</div>

		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>