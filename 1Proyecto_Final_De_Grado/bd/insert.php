<?php

function insertUsuarios($id, $nombre, $contrasenia, $edad, $altura, $peso, $genero) {
    $sql = "INSERT INTO usuarios VALUES ($id, '$nombre', '$contrasenia', $edad, $altura, $peso, '$genero')";
    $dwes = abrir_conexion();
    $resultado = $dwes->query($sql);
    if ($resultado) {
        echo "Se han insertado los valores correctamente en la tabla<br>";
    } else {
        echo "Lo sentimos, no se han podido insertar los valores.";
    }
    cerrar_conexion($dwes);
}

function insertActividades($id_Usuarios, $id_Actividades) {
    $sql = "INSERT INTO usuarios_actividades VALUES ($id_Usuarios, $id_Actividades)";
    $dwes = abrir_conexion();
    $resultado = $dwes->query($sql);
    if ($resultado) {
        header("Location: ../php/actividades.php");
    }
    cerrar_conexion($dwes);
}

?>