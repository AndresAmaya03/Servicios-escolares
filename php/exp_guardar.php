<?php
require_once "main.php";

/*== Almacenando datos ==*/
//No se verifican
$fondo = $_POST['expediente_fondo'];
$subfondo = $_POST['expediente_subfondo'];
$seccion = $_POST['expediente_seccion'];
$serie = $_POST['expediente_serie'];
$cierre = $_POST['expediente_fecha_cierre'];
$legajos = $_POST['expediente_legajos'];

//Se verifican
$numero = limpiar_cadena($_POST['expediente_numero']);
$descripcion = limpiar_cadena($_POST['expediente_descripcion']);
$clasificacion = $_POST['expediente_clasificacion_LFTAIPG'];
$apertura = $_POST['expediente_fecha_apertura'];
$estado = $_POST['expediente_estado'];
$tramite = $_POST['expediente_tiempo_tramite'];
$concentracion = $_POST['expediente_tiempo_concentracion'];
$tiempoTotal = $tramite + $concentracion;
$valor = $_POST['expediente_valor_documental'];
$tradicion = $_POST['expediente_tradicion_documental'];
$hojas = $_POST['expediente_hojas'];
$observaciones = limpiar_cadena($_POST['expediente_observaciones']);


/*== Verificando campos obligatorios ==*/
if ($numero != "") {

    if (verificar_datos("[a-zA-Z0-9]{8,9}", $numero)) {
        echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El EXPEDIENTE no coincide con el formato solicitado
                </div>
            ';
        exit();
    }

} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios (Expediente)
            </div>
        ';
    exit();
}

if ($descripcion != "") {
    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $descripcion)) {
        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La DESCRIPCION no coincide con el formato solicitado
	            </div>
	        ';
        exit();
    }
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios (Descripcion)
            </div>
        ';
    exit();
}

if ($observaciones != "") {
    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $observaciones)) {
        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La OBSERVACIONES no coincide con el formato solicitado
	            </div>
	        ';
        exit();
    }
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios (OBSERVACIONES)
            </div>
        ';
    exit();
}

camposObligatoriosNuevoExpediente('Clasificacion', $clasificacion);
camposObligatoriosNuevoExpediente('Año de Apertura', $apertura);
camposObligatoriosNuevoExpediente('Estado de expediente', $estado);
camposObligatoriosNuevoExpediente('Años de tramite', $tramite);
camposObligatoriosNuevoExpediente('Años en concentracion', $concentracion);
camposObligatoriosNuevoExpediente('Valor documental', $valor);
camposObligatoriosNuevoExpediente('Tradicion documental', $tradicion);
camposObligatoriosNuevoExpediente('Numero de hojas', $hojas);

$clasificacion_archivistica = 'TECNM/SE/04S.07/' . $numero . '';

/*== Verificando expediente ==*/
$check_numero = conexion();
$check_numero = $check_numero->query("SELECT expediente_numero FROM expediente WHERE expediente_numero='$numero'");
if ($check_numero->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El EXPEDIENTE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
    exit();
}
$check_numero = null;


/*== Guardando datos ==*/
$guardar_expediente = conexion();
$guardar_expediente = $guardar_expediente->prepare("INSERT INTO expediente(
    expediente_numero,
    expediente_descripcion,
    expediente_clasificacion_archivistica,
    expediente_clasificacion_LFTAIPG,
    expediente_estado,
    expediente_fecha_apertura,
    expediente_fecha_cierre,
    expediente_tiempo_tramite,
    expediente_tiempo_concentracion,
    expediente_tiempo_total,
    expediente_valor_documental,
    expediente_tradicion_documental,
    expediente_legajos,
    expediente_observaciones,
    expediente_hojas) VALUES(:numero,
    :descripcion,
    :clasificacionArchivistica,
    :clasificacion,
    :estado,
    :apertura,
    :cierre,
    :tramite,
    :concentracion,
    :tiempoTotal,
    :valor,
    :tradicion,
    :legajos,
    :observaciones,
    :hojas)");

$marcadores = [
    ":numero" => $numero,
    ":descripcion" => $descripcion,
    ":clasificacionArchivistica" => $clasificacion_archivistica,
    ":clasificacion" => $clasificacion,
    ":estado" => $estado,
    ":apertura" => $apertura,
    ":cierre" => $cierre,
    ":tramite" => $tramite,
    ":concentracion" => $concentracion,
    ":tiempoTotal" => $tiempoTotal,
    ":valor" => $valor,
    ":tradicion" => $tradicion,
    ":legajos" => $legajos,
    ":observaciones" => $observaciones,
    ":hojas" => $hojas
];

$guardar_expediente->execute($marcadores);
$exp_dir = '../expedientes/' . $numero;

if ($guardar_expediente->rowCount() == 1) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡EXPEDIENTE REGISTRADO!</strong><br>
                El expediente se registro con exito
            </div>
        ';
    mkdir($exp_dir, 0777);
    //Datos a agregar a la bitacora
    $sesionid = $_POST['sesion'];
    $expedienteConexion = conexion();
    $expedienteConexion = $expedienteConexion->query("SELECT expediente_id FROM expediente WHERE expediente_numero='$numero'");
    $expedienteConexion = $expedienteConexion->fetch();
    $expedienteid = $expedienteConexion['expediente_id'];
    $expedienteConexion = null;
    $movimiento = "C";

    $bitacora_expedientes = conexion();
    $bitacora_expedientes = $bitacora_expedientes->prepare("INSERT INTO bitacoraexpedientes(bitacoraE_expedienteId,bitacoraE_usuarioId,bitacoraE_movimiento) VALUES(:expedienteid,:sesionid,:movimiento)");
    $marcadores_bitacora = [
        ":expedienteid" => $expedienteid,
        ":sesionid" => $sesionid,
        ":movimiento" => $movimiento
    ];

    $bitacora_expedientes->execute($marcadores_bitacora);
    $bitacora_expedientes = null;
} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el expediente, por favor intente nuevamente
            </div>
        ';
}
$guardar_expediente = null;
