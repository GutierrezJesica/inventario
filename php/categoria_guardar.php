<?php

require_once "main.php";

# Almacenamiento de los input en variables #

$nombre=limpiar_cadena($_POST['categoria_nombre']);
$ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);

# VERIFICANDO CAMPOS OBLIGATORIOS #

if($nombre=="") {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado el campo nombre, que son obligatorios
    </div>
    ';
    exit();
}

# VERIFICANDO INTEGRIDAD DE LOS DATOS #

if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $nombre)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El nombre no coincide con el formato solicitado
    </div>
    ';
    exit();
}

if($ubicacion!="") {
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $ubicacion)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    La ubicación no coincide con el formato solicitado
    </div>
    ';
    exit();
    }
}

# VERIFICANDO LA EXISTENCIA DEL NOMBRE DE CATEGORIA #

    $check_nombre=conexion(); # cerrar esta conexion más abajo #
    $check_nombre=$check_nombre->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre='$nombre'");
        if($check_nombre->rowCount()>0) {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre ingresado ya se encuentra registrado, por favor elija otro
            </div>
            ';
            exit();
        }
        $check_nombre=null; # conexion cerrada #

# GUARDANDO DATOS EN LA TABLA CATEGORIA DE LA BD #

$guardar_categoria=conexion(); # cerrar esta conexion más abajo #
$guardar_categoria=$guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre, categoria_ubicacion) VALUES (:nombre, :ubicacion)");

$marcadores=[
    ":nombre"=>$nombre,
    ":ubicacion"=>$ubicacion
];

$guardar_categoria->execute($marcadores);

if($guardar_categoria->rowCount()==1) {
    echo '
            <div class="notification is-info is-light">
            <strong>¡CATEGORÍA REGISTRADA!</strong><br>
            La categoría se registro con exito
            </div>
            ';
}else{
    echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar la categoría, por favor intente nuevamente
            </div>
            ';
}

$guardar_categoria=null; # conexion cerrada #