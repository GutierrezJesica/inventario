<?php

$category_id_del = limpiar_cadena($_GET['category_id_del']);

# VERIFICANDO CATEGORIA #
$check_categoria = conexion();
$check_categoria = $check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$category_id_del'");

if($check_categoria->rowCount()==1) {
    # VERIFICANDO CATEGORIA EN RELACIÓN A SI TIENE PRODUCTO ASOCIADO #
    $check_productos = conexion();
    $check_productos = $check_productos->query("SELECT categoria_id FROM productos WHERE categoria_id='$category_id_del' LIMIT 1");

    if($check_productos->rowCount()<=0) {
        # ELIMINANDO CATEGORIA #
        $eliminar_categoria = conexion();
        $eliminar_categoria = $eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id=:id");

        $eliminar_categoria->execute([":id"=>$category_id_del]);

        if($eliminar_categoria->rowCount()==1) {
            echo '
            <div class="notification is-info is-light">
            <strong>¡CATEGORÍA ELIMINADA!</strong><br>
            La categoría se elimino con éxito
            </div>
            ';
        }else {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo eliminar la categoría, por favor intente nuevamente
            </div>
            ';
        }
        $eliminar_categoria = null;
    }else {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se puede eliminar la categoría, ya que tiene productos asociados
        </div>
        ';
    }
    $check_productos = null;

}else{
    echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La categoría que intenta eliminar no existe
        </div>
        ';
}
$check_categoria = null;