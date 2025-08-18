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

# LIMPIAR CADENAS DE TEXTO #
function limpiar_cadena($cadena) {
    $cadena = trim($cadena); # ELIMINA ESPACIOS AL PRINCIPIO Y AL FINAL #
    $cadena = stripslashes($cadena); # ELIMINA LAS BARRAS INVERTIDAS #
    $cadena = str_ireplace("<script>","",$cadena); # ELIMINA ETIQUETAS DE SCRIPT #
    $cadena = str_ireplace("</script>","",$cadena); # ELIMINA ETIQUETAS DE SCRIPT #
    $cadena = str_ireplace("<script src","",$cadena);
    $cadena = str_ireplace("<script type","",$cadena);
    $cadena = str_ireplace("SELECT * FROM","",$cadena);
    $cadena = str_ireplace("DELETE FROM","",$cadena);
    $cadena = str_ireplace("INSERT INTO","",$cadena);
    $cadena = str_ireplace("DROP TABLE","",$cadena);
    $cadena = str_ireplace("DROP DATABASE","",$cadena);
    $cadena = str_ireplace("TRUNCATE TABLE","",$cadena);
    $cadena = str_ireplace("SHOW TABLE","",$cadena);
    $cadena = str_ireplace("SHOW DATABASES","",$cadena);
    $cadena = str_ireplace("<?php","",$cadena);
    $cadena = str_ireplace("?>","",$cadena);
    $cadena = str_ireplace("--","",$cadena);
    $cadena = str_ireplace("^","",$cadena);
    $cadena = str_ireplace("<","",$cadena);
    $cadena = str_ireplace("[","",$cadena);
    $cadena = str_ireplace("]","",$cadena);
    $cadena = str_ireplace("==","",$cadena);
    $cadena = str_ireplace(";","",$cadena);
    $cadena = str_ireplace("::","",$cadena);
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    return $cadena;
}

# FUNCION RENOMBRAR FOTOS #
function renombrar_fotos($nombre) {
    $nombre = str_ireplace(" ","_",$nombre);
    $nombre = str_ireplace("/","_",$nombre);
    $nombre = str_ireplace("#","_",$nombre);
    $nombre = str_ireplace("-","_",$nombre);
    $nombre = str_ireplace("$","_",$nombre);
    $nombre = str_ireplace(".","_",$nombre);
    $nombre = str_ireplace(",","_",$nombre);
    $nombre = $nombre."_".rand(0,100);
    return $nombre;
}
