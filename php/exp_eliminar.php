<?php
/*== Almacenando datos ==*/
$exp_id_del = limpiar_cadena($_GET['exp_id_del']);

/*== Verificando usuario ==*/
$check_exp = conexion();
$check_exp = $check_exp->query("SELECT expediente_id FROM expediente WHERE expediente_id='$exp_id_del'");

if ($check_exp->rowCount() == 1) {

	$check_docs = conexion();
	$check_docs = $check_docs->query("SELECT documento_expediente_id FROM documento WHERE documento_expediente_id='$exp_id_del' LIMIT 1");

	if ($check_docs->rowCount() <= 0) {

		//Datos a agregar a la bitacora
		$sesionid = $_SESSION['id'];
		$expedienteid = $exp_id_del;
		$movimiento = "D";
	
		$bitacora_expedientes = conexion();
		$bitacora_expedientes = $bitacora_expedientes->prepare("INSERT INTO bitacoraexpedientes(bitacoraE_expedienteId,bitacoraE_usuarioId,bitacoraE_movimiento) VALUES(:expedienteid,:sesionid,:movimiento)");
		$marcadores_bitacora = [
			":expedienteid" => $expedienteid,
			":sesionid" => $sesionid,
			":movimiento" => $movimiento
		];
	
		$bitacora_expedientes->execute($marcadores_bitacora);
		$bitacora_expedientes = null;
		//

		$eliminar_exp = conexion();
		$eliminar_exp = $eliminar_exp->prepare("DELETE FROM expediente WHERE expediente_id=:id");

		$check_expediente = conexion();
		$check_expediente = $check_expediente->query("SELECT * FROM expediente WHERE expediente_id='$exp_id_del'");
		$check_expediente = $check_expediente->fetch();
		$expediente = $check_expediente['expediente_numero'];
		$check_expediente = null;
		$documento_dir = './expedientes/'.$expediente;
		chmod($documento_dir, 0777);
		rmdir($documento_dir);

		$eliminar_exp->execute([":id" => $exp_id_del]);

		if ($eliminar_exp->rowCount() == 1) {
			echo '
		            <div class="notification is-info is-light">
		                <strong>¡EXPEDIENTE ELIMINADO!</strong><br>
		                Los datos del expediente se eliminaron con exito
		            </div>
		        ';
		} else {
			echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar el expediente, por favor intente nuevamente
		            </div>
		        ';
		}
		$eliminar_exp = null;
	} else {
		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar expediente que tiene documentos asociados
	            </div>
	        ';
	}
	$check_exp = null;
} else {
	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El expediente que intenta eliminar no existe
            </div>
        ';
}
$check_exp = null;