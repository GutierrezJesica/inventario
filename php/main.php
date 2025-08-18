<?php
# ACA ESTAN TODAS LAS FUNCIONES QUE HACEN ANDAR EL SISTEMA #

# CONEXION A LA BASE DE DATOS #
function conexion() {
$pdo = new PDO('mysql:host=localhost;dbname=inventario','root',''); # NO DEJAR ESPACIOS ENTRE HOST, = Y EL LOCALHOST #
return $pdo;
}

# VALIDACIÓN DE FORMULARIOS #
function verificar_datos($filtro, $cadena) {
    if(preg_match("/^".$filtro."$/",$cadena)) {
        return false;
    }else {
        return true;
    }
}