<?php

/*== Almacenando datos ==*/
$user_id_del = limpiar_cadena($_GET['user_id_del']);

/*== Verificando usuario ==*/
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'");

if ($check_usuario->rowCount() == 1) {

    //Datos a agregar a la bitacora
    $sesionid = $_SESSION['id'];
    $usuarioid = $user_id_del;
    $movimiento = "D";

    $bitacora_usuarios = conexion();
    $bitacora_usuarios = $bitacora_usuarios->prepare("INSERT INTO bitacorausuarios(bitacoraU_sesionid,bitacoraU_usuarioid,bitacoraU_movimiento) VALUES(:sesionid,:usuarioid,:movimiento)");
    $marcadores_bitacora = [
        ":sesionid" => $sesionid,
        ":usuarioid" => $usuarioid,
        ":movimiento" => $movimiento
    ];

    $bitacora_usuarios->execute($marcadores_bitacora);
    $bitacora_usuarios = null;

    $eliminar_usuario = conexion();
    $eliminar_usuario = $eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id");

    $eliminar_usuario->execute([":id" => $user_id_del]);

    if ($eliminar_usuario->rowCount() == 1) {
        echo '
		            <div class="notification is-info is-light">
		                <strong>¡USUARIO ELIMINADO!</strong><br>
		                Los datos del usuario se eliminaron con exito
		            </div>
		        ';
    } else {
        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar el usuario, por favor intente nuevamente
		            </div>
		        ';
    }
    $eliminar_usuario = null;

} else {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El USUARIO que intenta eliminar no existe
            </div>
        ';
}
$check_usuario = null;
