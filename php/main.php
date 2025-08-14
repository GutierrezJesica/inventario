<?php
# ACA ESTAN TODAS LAS FUNCIONES QUE HACEN ANDAR EL SISTEMA #

# CONEXION A LA BASE DE DATOS #
function conexion() {
$pdo = new PDO('mysql:host=localhost;dbname=inventario','root',''); # NO DEJAR ESPACIOS ENTRE HOST, = Y EL LOCALHOST #
return $pdo;
}
