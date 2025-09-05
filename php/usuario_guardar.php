<?php
    require_once "main.php";

# Almacenamiento de los input en variables #

$nombre=limpiar_cadena($_POST['usuario_nombre']);
$apellido=limpiar_cadena($_POST['usuario_apellido']);

$usuario=limpiar_cadena($_POST['usuario_usuario']);
$email=limpiar_cadena($_POST['usuario_email']);

$clave_1=limpiar_cadena($_POST['usuario_clave_1']);
$clave_2=limpiar_cadena($_POST['usuario_clave_2']);

# VERIFICANDO CAMPOS OBLIGATORIOS # Esto es un segundo aviso en caso de que la verificación del HTML este desactivada

if($nombre=="" || $apellido=="" || $usuario=="" || $clave_1=="" || $clave_2=="") {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}

# VERIFICANDO INTEGRIDAD DE LOS DATOS # Esto es un segundo aviso en caso de que la verificación del HTML este desactivada

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El nombre no coincide con el formato solicitado
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El apellido no coincide con el formato solicitado
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El usuario no coincide con el formato solicitado
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Las claves no coinciden con el formato solicitado
    </div>
    ';
    exit();
}

# VERIFICANDO EL EMAIL #

if($email!="") {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email=conexion(); # cerrar esta conexion más abajo #
        $check_email=$check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
        if($check_email->rowCount()>0) {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El email ingresado ya se encuentra registrado, por favor elija otro
            </div>
            ';
            exit();
        }
        $check_email=null; # conexion cerrada #
    }else {
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El email ingresado no es valido
            </div>
            ';
    exit();
    }

}

# VERIFICANDO LA EXISTENCIA DEL USUARIO #

    $check_usuario=conexion(); # cerrar esta conexion más abajo #
    $check_usuario=$check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
        if($check_usuario->rowCount()>0) {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario ingresado ya se encuentra registrado, por favor elija otro
            </div>
            ';
            exit();
        }
        $check_usuario=null; # conexion cerrada #

# VERIFICANDO COINCIDENCIA DE CLAVES #

if($clave_1!=$clave_2) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Las claves que ha ingresado no coinciden
    </div>
    ';
    exit();
}else {
    $clave=password_hash($clave_1, PASSWORD_BCRYPT, ["cost"=>10]); # Encriptando la clave #
}

# GUARDANDO DATOS EN LA TABLA USUARIO DE LA BD#

$guardar_usuario=conexion(); # cerrar esta conexion más abajo #
$guardar_usuario=$guardar_usuario->query("INSERT INTO usuario(usuario_nombre, usuario_apellido,
usuario_usuario, usuario_clave, usuario_email) VALUES ('$nombre', '$apellido', '$usuario', '$clave', '$email')");

if($guardar_usuario->rowCount()==1) {
    echo '
    <div class="notification is-info is-light">
    <strong>¡USUARIO REGISTRADO!</strong><br>
    El usuario se registro con exito.
    </div>
    ';
}else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡USUARIO NO REGISTRADO!</strong><br>
    No se pudo registrar el usuario, por favor intente nuevamente.
    </div>
    ';
}

$guardar_usuario=null; # conexion cerrada #