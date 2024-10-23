<?php
require_once "../inc/session_start.php";
require_once "main.php";


/*== Verificando expediente ==*/

$expediente_id = $_POST['expediente_id'];
$check_expediente = conexion();
$check_expediente = $check_expediente->query("SELECT * FROM expediente WHERE expediente_id='$expediente_id'");
$check_expediente = $check_expediente->fetch();
$expediente = $check_expediente['expediente_numero'];
$check_expediente = null;

/*== Almacenando datos ==*/

$documento_nombre = $expediente . '_' . $_POST['documento_nombre'];
$documento_dir = '../expedientes/' . $expediente . '/';


/*== Verificando documento ==*/
$check_documento = conexion();
$check_documento = $check_documento->query("SELECT documento_nombre FROM documento WHERE documento_nombre='$documento_nombre'");
if ($check_documento->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El documento ingresado ya se encuentra registrado
            </div>
        ';
    exit();
}
$check_documento = null;


/*== Verificando expediente ==*/
$check_numero = conexion();
$check_numero = $check_numero->query("SELECT expediente_numero FROM expediente WHERE expediente_numero='$expediente'");
if ($check_numero->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El EXPEDIENTE no existe
            </div>
        ';
    exit();
}
$check_numero = null;

/*== Comprobando si se ha seleccionado un documento ==*/
if ($_FILES['documento']['name'] != "" && $_FILES['documento']['size'] > 0) {

    /* Comprobando formato de las imagenes */
    if (mime_content_type($_FILES['documento']['tmp_name']) != "application/pdf"){
        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El documento no esta en el formato solicitado
	            </div>
	        ';
        exit();
    }


    /* Comprobando que la imagen no supere el peso permitido */
    if (($_FILES['documento']['size'] / 1024) > 3072) {
        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El documento que ha seleccionado supera el límite de peso permitido
	            </div>
	        ';
        exit();
    }


    /* extencion del documento */

    $documento_ext = ".pdf";

    /* Cambiando permisos al directorio */
    chmod($documento_dir, 0777);

    /* Nombre final del documento */
    $documento_archivo = $documento_nombre . $documento_ext;

    /* Moviendo documento al directorio */
    if (!move_uploaded_file($_FILES['documento']['tmp_name'], $documento_dir . $documento_archivo)) {
        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos subir el documento al sistema en este momento, por favor intente nuevamente
	            </div>
	        ';
        exit();
    }

} else {

    echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No se ha seleccionado ningun documento para subir
	            </div>
	        ';
    exit();
}


/*== Guardando datos ==*/
$guardar_documento = conexion();
$guardar_documento = $guardar_documento->prepare("INSERT INTO documento(documento_expediente_id,documento_nombre,documento_archivo) VALUES(:expediente_id,:documento_nombre,:documento_archivo)");

$marcadores = [
    ":expediente_id" => $expediente_id,
    ":documento_nombre" => $documento_nombre,
    ":documento_archivo" => $documento_archivo,
];

$guardar_documento->execute($marcadores);

if ($guardar_documento->rowCount() == 1) {
    echo '
            <div class="notification is-info is-light">
                <strong>DOCUMENTO REGISTRADO!</strong><br>
                El documento se registro con exito
            </div>
        ';
        //Datos a agregar a la bitacora
    $sesionid = $_POST['sesion'];
    $documentoConexion = conexion();
    $documentoConexion = $documentoConexion->query("SELECT documento_id FROM documento WHERE documento_nombre='$documento_nombre'");
    $documentoConexion = $documentoConexion->fetch();
    $documentoid = $documentoConexion['documento_id'];
    $documentoConexion = null;
    $movimiento = "C";

    $bitacora_documento = conexion();
    $bitacora_documento = $bitacora_documento->prepare("INSERT INTO bitacoradocumentos(bitacoraD_expedienteid,bitacoraD_documentoid,bitacoraD_usuarioid,bitacoraD_movimiento) VALUES(:expedienteid,:documentoid,:sesionid,:movimiento)");
    $marcadores_bitacora = [
        ":expedienteid" => $expediente_id,
        ":documentoid" => $documentoid,
        ":sesionid" => $sesionid,
        ":movimiento" => $movimiento
    ];

    $bitacora_documento->execute($marcadores_bitacora);
    $bitacora_documento = null;


} else {

    if (is_file($documento_dir . $documento_archivo)) {
        chmod($documento_dir . $documento_archivo, 0777);
        unlink($documento_dir . $documento_archivo);
    }

    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el documento, por favor intente nuevamente
            </div>
        ';
}
$guardar_documento = null;
