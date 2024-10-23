	<?php

	require_once "./php/main.php";

	include "./inc/btn_back.php";
	?>

	<body>
	<?php	
	/*== Verificando expediente ==*/
	$expediente_id = $_GET['expediente_id'];
	$check_expediente = conexion();
	
	$check_expediente = $check_expediente->query("SELECT * FROM expediente WHERE expediente_id='$expediente_id'");
	$check_expediente = $check_expediente->fetch();
	$expediente = $check_expediente['expediente_numero'];
	$check_expediente = null;
	
	/*== Almacenando datos ==*/
	$documento_nombre = $_GET['documento_nombre'];
	$documento_nombre_completo = $expediente . '_' . $documento_nombre;
	$documento_dir = './expedientes/' . $expediente . '/' . $documento_nombre_completo . '.pdf';

	$check_documento = conexion();
	$check_documento = $check_documento->query("SELECT * FROM documento WHERE documento_nombre='$documento_nombre_completo'");

	if ($check_documento->rowCount() == 1) {
		
		?>		 
		<embed src=<?php echo $documento_dir; ?> height="100%" width="100%"> <?php

	} else {
		echo '
				<div class="notification is-danger is-light">
					<strong>¡Ocurrio un error inesperado!</strong><br>
					El DOCUMENTO que intenta ver no existe
				</div>
			';
	}
	$check_documento = null;
	?>
	</body>
	