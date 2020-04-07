<?php

//funcion para conectar a la BD
function abrir_conexion(){
    $conexion = mysqli_connect("localhost", "root", "", "gimnasio");
    //verificamos que la conexión se ha establecido correctamente
    //funcion conect_errno: devuelve el número de error o null si no se produce ningún error
    $error = $conexion->connect_errno;
    if ($error != null) {
        echo "<p>Error $error conectando a la base de datos: $conexion->connect_error</p>";
        exit();
    }
    else{
        mysqli_set_charset($conexion, "utf8");
        return $conexion;
    }    
}

//funcion para cerrar la conexion a la BD
function cerrar_conexion($conexion){
    mysqli_close($conexion);
}