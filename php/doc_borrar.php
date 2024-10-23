<?php
require_once "main.php";

/*== Verificando expediente ==*/
$expediente_id = $_POST['expediente_id'];
$check_expediente = conexion();
$check_expediente = $check_expediente->query("SELECT * FROM expediente WHERE expediente_id='$expediente_id'");
$check_expediente = $check_expediente->fetch();
$expediente = $check_expediente['expediente_numero'];
$check_expediente = null;

/*== Almacenando datos ==*/
$documento_nombre = $_POST['documento_nombre'];
$documento_nombre_completo = $expediente . '_' . $documento_nombre;
$documento_dir = '../expedientes/' . $expediente . '/' . $documento_nombre_completo . '.pdf';

$check_documento = conexion();
$check_documento = $check_documento->query("SELECT * FROM documento WHERE documento_nombre='$documento_nombre_completo'");

if ($check_documento->rowCount() == 1) {

	$datos = $check_documento->fetch();
	$documento_id = $datos['documento_id'];
	$eliminar_documento = conexion();
	$eliminar_documento = $eliminar_documento->prepare("DELETE FROM documento WHERE documento_id=:id");

	//Datos a agregar a la bitacora
	$sesionid = $_POST['sesion'];
	$documentoConexion = null;
	$movimiento = "D";

	$bitacora_documento = conexion();
	$bitacora_documento = $bitacora_documento->prepare("INSERT INTO bitacoradocumentos(bitacoraD_expedienteid,bitacoraD_documentoid,bitacoraD_usuarioid,bitacoraD_movimiento) VALUES(:expedienteid,:documentoid,:sesionid,:movimiento)");
	$marcadores_bitacora = [
		":expedienteid" => $expediente_id,
		":documentoid" => $documento_id,
		":sesionid" => $sesionid,
		":movimiento" => $movimiento
	];

	$bitacora_documento->execute($marcadores_bitacora);
	$bitacora_documento = null;
	//



	$eliminar_documento->execute([":id" => $documento_id]);

	if ($eliminar_documento->rowCount() == 1) {

		if (is_file($documento_dir)) {
			chmod($documento_dir, 0777);
			unlink($documento_dir);
		}

		echo '
	            <div class="notification is-info is-light">
	                <strong>DOCUMENTO ELIMINADO!</strong><br>
	                El documento se elimino con exito
	            </div>
	        ';
	} else {
		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No se pudo eliminar el producto, por favor intente nuevamente
	            </div>
	        ';
	}
	$eliminar_documento = null;
} else {
	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El DOCUMENTO que intenta eliminar no existe
            </div>
        ';
}
$check_documento = null;