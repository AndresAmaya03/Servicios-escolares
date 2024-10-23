<div class="container is-fluid mb-6">
	<h1 class="title">Actualizar expediente</h1>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['exp_id_up'])) ? $_GET['exp_id_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando categoria ==*/
    	$check_exp=conexion();
    	$check_exp=$check_exp->query("SELECT * FROM expediente WHERE expediente_id='$id'");

        if($check_exp->rowCount()>0){
        	$datos=$check_exp->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/exp_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="expediente_id" value="<?php echo $datos['expediente_id']; ?>" required >
		<input type="hidden" name="sesion" required value="<?php echo $_SESSION['id']?>">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Numero*</label>
				  	<input class="input has-background-grey has-text-white p-4" type="text" name="expediente_numero" required value="<?php echo $datos['expediente_numero']; ?>" readonly>
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Descripción (Nombre del estudiante)</label>
				  	<input class="input" type="text" name="expediente_descripcion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" value="<?php echo $datos['expediente_descripcion']; ?>" >
				</div>
		  	</div>
		</div>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label
						title="Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental">Clasificación
						LFTAIPG</label>
					<div class="select is-rounded">
						<select name="expediente_clasificacion_LFTAIPG" required>
							<option value="" selected="">Seleccione una opción</option>
							<option value="publica">Pública</option>
							<option value="reservada">Reservada</option>
							<option value="confidencial">Confidencial</option>
						</select>
					</div>
				</div>

			</div>

			<div class="column">
				<div class="control">
					<label>Año de apertura:</label>
					<input type="date" name="expediente_fecha_apertura" value="<?php echo $datos['expediente_fecha_apertura']; ?>" required>
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Estado de expediente:</label>
					<div class="select is-rounded">
						<select name="expediente_estado" required>
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
					<input type="date" name="expediente_fecha_cierre" value="<?php echo $datos['expediente_fecha_cierre']; ?>">
				</div>
			</div>
		</div><br>

		<label>Vigencia documental:</label><br>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Años de tramite</label>
					<div>
						<input type="number" name="expediente_tiempo_tramite" value="<?php echo $datos['expediente_tiempo_tramite']; ?>" required>
					</div>
				</div>

			</div>

			<div class="column">
				<div class="control">
					<label>Años en concentración</label>
					<div>
						<input type="number" name="expediente_tiempo_concentracion" value="<?php echo $datos['expediente_tiempo_concentracion']; ?>" required>
					</div>
				</div>

			</div>
			<div class="column">
				<div class="control">
					<label>Suma de años</label>
					<div>
						<input type="number" name="expediente_tiempo_total" value="<?php echo $datos['expediente_tiempo_total']; ?>" required>
					</div>
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Valor documental</label>
					<div class="select is-rounded">
						<select name="expediente_valor_documental" required>
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
						<select name="expediente_tradicion_documental" required>
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
					<input type="number" name="expediente_hojas" value="<?php echo $datos['expediente_hojas']; ?>" required>
				</div>
			</div>
		</div><br>

		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Legajos</label>
					<input type="number" name="expediente_legajos" value="<?php echo $datos['expediente_legajos']; ?>" required>
				</div>
			</div>

			<div class="column">
				<div class="control">
					<label>Observaciones</label>
					<input class="input" type="text" name="expediente_observaciones" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,100}"
						maxlength="100" value="<?php echo $datos['expediente_observaciones']; ?>" required>
				</div>
			</div>
		</div>

		<p class="has-background-grey has-text-white p-4">
			No es posible editar el número de expediente en esta edición. Se recomienda hacer lo siguiente:<br>
			1.- Descargar documentos relacionados a este expediente para hacer un respaldo<br>
			2.- Guardar información sobre el expediente<br>
			3.- Eliminar el expediente<br>
			4.- Crear un nuevo expediente con el numero correcto
		</p>
			<br>
			<br>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>

	</form>
	
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_exp=null;
	?>
</div>