<?php
require_once "main.php";

/*== Almacenando id ==*/
$id = limpiar_cadena($_POST['expediente_id']);


/*== Verificando categoria ==*/
$check_exp = conexion();
$check_exp = $check_exp->query("SELECT * FROM expediente WHERE expediente_id='$id'");

if ($check_exp->rowCount() <= 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El expediente no existe en el sistema
            </div>
        ';
    exit();
} else {
    $datos = $check_exp->fetch();
}
$check_exp = null;

/*== Almacenando datos ==*/
$numero = limpiar_cadena($_POST['expediente_numero']);
$descripcion = limpiar_cadena($_POST['expediente_descripcion']);
$clasificacion = $_POST['expediente_clasificacion_LFTAIPG'];
$apertura = $_POST['expediente_fecha_apertura'];
$cierre = $_POST['expediente_fecha_cierre'];
$legajos = $_POST['expediente_legajos'];
$estado = $_POST['expediente_estado'];
$tramite = $_POST['expediente_tiempo_tramite'];
$concentracion = $_POST['expediente_tiempo_concentracion'];
$tiempoTotal = $_POST['expediente_tiempo_total'];
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
camposObligatoriosNuevoExpediente('Suma de años', $tiempoTotal);
camposObligatoriosNuevoExpediente('Valor documental', $valor);
camposObligatoriosNuevoExpediente('Tradicion documental', $tradicion);
camposObligatoriosNuevoExpediente('Numero de hojas', $hojas);

$clasificacion_archivistica = 'TECNM/SE/04S.07/' . $numero . '';

/*== Actualizar datos ==*/
$actualizar_exp = conexion();
$actualizar_exp = $actualizar_exp->prepare("UPDATE expediente SET 
    expediente_numero=:numero,
    expediente_descripcion=:descripcion,
    expediente_clasificacion_LFTAIPG=:clasificacion,    
    expediente_fecha_apertura=:apertura,
    expediente_fecha_cierre=:cierre,
    expediente_legajos=:legajos,
    expediente_estado=:estado,
    expediente_tiempo_tramite=:tramite,
    expediente_tiempo_concentracion=:concentracion,
    expediente_tiempo_total=:tiempoTotal,
    expediente_valor_documental=:valor,
    expediente_tradicion_documental=:tradicion,
    expediente_hojas=:hojas,
    expediente_observaciones=:observaciones,
    expediente_clasificacion_archivistica=:clasificacion_archivistica
    WHERE expediente_id=:id");

$marcadores = [
    ":numero" => $numero,
    ":descripcion" => $descripcion,
    ":clasificacion" => $clasificacion,
    ":apertura" => $apertura,
    ":cierre" => $cierre,
    ":legajos" => $legajos,
    ":estado" => $estado,
    ":tramite" => $tramite,
    ":concentracion" => $concentracion,
    ":tiempoTotal" => $tiempoTotal,
    ":valor" => $valor,
    ":tradicion" => $tradicion,
    ":hojas" => $hojas,
    ":observaciones" => $observaciones,
    ":clasificacion_archivistica" => $clasificacion_archivistica,
    ":id" => $id
];

if ($actualizar_exp->execute($marcadores)) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡EXPEDIENTE ACTUALIZADO!</strong><br>
                El expediente se actualizo con exito
            </div>
        ';
    //Datos a agregar a la bitacora
    $sesionid = $_POST['sesion'];
    $expedienteid = $id;
    $movimiento = "U";

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
                No se pudo actualizar el expediente, por favor intente nuevamente
            </div>
        ';
}
$actualizar_exp = null;