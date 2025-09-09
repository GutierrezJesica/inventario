<?php

$user_id_del = limpiar_cadena($_GET['user_id_del']);

# VERIFICANDO USUARIO #
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'");

if($check_usuario->rowCount()==1) {
    # VERIFICANDO USUARIO EN RELACIÓN A SI TIENE PRODUCTO ASOCIADO #
    $check_productos = conexion();
    $check_productos = $check_productos->query("SELECT usuario_id FROM productos WHERE usuario_id='$user_id_del' LIMIT 1");

    if($check_productos->rowCount()<=0) {
        # ELIMINANDO USUARIO #
        $eliminar_usuario = conexion();
        $eliminar_usuario = $eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id");

        $eliminar_usuario->execute([":id"=>$user_id_del]);

        if($eliminar_usuario->rowCount()==1) {
            echo '
            <div class="notification is-info is-light">
            <strong>¡USUARIO ELIMINADO!</strong><br>
            El usuario se elimino con éxito
            </div>
            ';
        }else {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo eliminar el usuario, por favor intente nuevamente
            </div>
            ';
        }
        $eliminar_usuario = null;
    }else {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se puede eliminar el usuario, ya que tiene productos asociados
        </div>
        ';
    }
    $check_productos = null;
}else {
    echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El usuario que intenta eliminar no existe
        </div>
        ';
}
$check_usuario = null;