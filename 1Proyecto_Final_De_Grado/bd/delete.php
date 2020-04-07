<?php

session_start();
include 'conexion.php';


if (isset($_GET['id'])) {
    $id_actividades = $_GET['id'];
    borrarActividades($id_actividades);
}

function borrarActividades($id_actividades) {
    $id_usuario = $_SESSION['id'];
    //COGEMOS LA ID QUE VAMOS A INTRODUCIR DE FORMA OCULTA AL CLIENTE
    $sql = "DELETE FROM USUARIOS_ACTIVIDADES WHERE ID_USUARIOS=$id_usuario AND ID_ACTIVIDADES=$id_actividades";
    $dwes = abrir_conexion();
    if (mysqli_query($dwes, $sql)) {
        header("Location: ../php/inicio_usuario.php");
    } 
    cerrar_conexion($dwes);
}
