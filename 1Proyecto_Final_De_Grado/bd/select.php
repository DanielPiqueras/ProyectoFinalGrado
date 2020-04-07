<?php

function autoincrementarId() {
    //COGEMOS LA ID QUE VAMOS A INTRODUCIR DE FORMA OCULTA AL CLIENTE
    $sql = "SELECT MAX(ID) AS ID FROM usuarios";
    $dwes = abrir_conexion();
    $resultado = $dwes->query($sql);
    $stock = $resultado->fetch_array();
    $idactual = $stock[0];
    $id = $idactual + 1;
    //MOSTRAR EL VALOR DE LA ID
    //echo "<br>$id";
    cerrar_conexion($dwes);
    return $id;
}

function mostrarDatos($usuario, $contrasenia) {
    //MOSTRAMOS LOS CLIENTES POR PANTALLA
    $dwes = abrir_conexion();
    $sql = "SELECT nombre, contrasenia, edad, altura, peso, genero FROM usuarios WHERE nombre='$usuario' AND contrasenia='$contrasenia'";
    $resultado = $dwes->query($sql);
    $stock = $resultado->fetch_array();
    ?>
    <div class="table-responsive">
        <table class="table table-sm table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Altura</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Género</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    while ($stock != null) {

                        echo "<td>" . $stock['nombre'] . "</td>";
                        echo "<td>" . $stock['edad'] . " años</td>";
                        echo "<td>" . $stock['altura'] . " metros</td>";
                        echo "<td>" . $stock['peso'] . " kg</td>";
                        echo "<td>" . $stock['genero'] . "</td>";

                        $stock = $resultado->fetch_array();
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
   <?php
}

function mostrarActividades($id_usuarios) {
    //CREAMOS UN ARRAY PARA IR ALMACENANDO LAS ID DE LAS ACTIVIDADES
    $id_actividades = array();
    $total = 0;

    $dwes = abrir_conexion();
    $sql = "SELECT ID_ACTIVIDADES FROM usuarios_actividades WHERE id_usuarios=$id_usuarios";
    $resultado = $dwes->query($sql);
    $stock = $resultado->fetch_array();
    ?>
    <table class="table table-sm table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">Nombre_Actividad</th>
                <th scope="col">Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($stock != null) {

                $id_actividades[] = $stock['ID_ACTIVIDADES'];
                $stock = $resultado->fetch_array();
            }

            foreach ($id_actividades as $value) {
                $sql_actividades = "SELECT ID, NOMBRE, PRECIO FROM actividades WHERE ID=$value";
                $resultado_actividades = $dwes->query($sql_actividades);
                $stock_actividades = $resultado_actividades->fetch_array();

                if ($stock_actividades) {
                    ?>

                    <?php
                    while ($stock_actividades != null) {
                        //CALCULAMOS EL PRECIO TOTAL DE LAS ACTIVIDADES

                        $precio = $stock_actividades['PRECIO'];
                        $total = $total + $precio;

                        echo "<tr>";
                        echo "<td>" . $stock_actividades['NOMBRE'] . "</td>";
                        echo "<td>" . $stock_actividades['PRECIO'] . "€</td>";
                        echo '<td><a href="../bd/delete.php?id=' . $stock_actividades['ID'] . '">Eliminar</a></td>';
                        $stock_actividades = $resultado_actividades->fetch_array();
                        echo "</tr>";
                    }
                }
            }

            echo "<tr>";
            echo "<th>Total</th>";
            echo "<th>" . $total . "€</th>";
            echo "</tr>";
            ?>
        </tbody>
    </table>
    <?php
}

function idUsuarioActual($usuario, $contrasenia) {
    //DEVOLVEMOS LA ID DEL USUARIO QUE HA INICIADO SESIÓN
    $dwes = abrir_conexion();
    $sql = "SELECT id FROM usuarios WHERE nombre='$usuario' AND contrasenia='$contrasenia'";
    $resultado = $dwes->query($sql);
    $stock = $resultado->fetch_array();

    return $stock['id'];
}

function formularioActividades($id_usuario) {

    $were = "WHERE 1";

    $actividadesYaContratadas = actividadesContratadas($id_usuario);

    foreach ($actividadesYaContratadas as $key => $value) {
        $were = "$were AND ID != $value";
    }

    $dwes = abrir_conexion();
    $sql = "SELECT ID, NOMBRE, INFORMACION, PRECIO FROM ACTIVIDADES $were";
    $resultado = $dwes->query($sql);
    $stock = $resultado->fetch_array();
    ?>
    <form action="" method="POST">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Seleccionar</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        while ($stock != null) {
                          
                        //Todos este html está escrito en PHP debido al error de OUTPUT que suelen dar los headers.
                        //En este caso, el header del INSERT, función 'insertActividades()'.
                        echo"<tr>";
                            echo"<td>";
                                echo'<div class="form-group">';
                                    echo"<input class='form-control' type='checkbox' name='actividad[]' value=".$stock['ID'].">";
                                echo"</div>";

                            echo"</td>";

                            echo "<td>" . $stock['NOMBRE'] . "</td>";
                            echo "<td>" . $stock['INFORMACION'] . "</td>";
                            echo "<td>" . $stock['PRECIO'] . "</td>";
                          
                        echo"</tr>";


                        $stock = $resultado->fetch_array();
                    }
                    
                    echo"</tr>";
                echo"</tbody>";
            echo"</table>";
        echo"</div>";
        echo'<input class="btn btn-secondary" type="submit" name="enviar" value="Enviar">';
    echo"</form>";

}

function actividadesContratadas($id_usuario) {
    $array = array();
    $dwes = abrir_conexion();
    $sql = "SELECT ID_ACTIVIDADES FROM USUARIOS_ACTIVIDADES WHERE ID_USUARIOS = $id_usuario";
    $resultado = $dwes->query($sql);
    $stock = $resultado->fetch_array();

    while ($stock != null) {
        $array[] = $stock['ID_ACTIVIDADES'];
        $stock = $resultado->fetch_array();
    }

    return $array;
}
