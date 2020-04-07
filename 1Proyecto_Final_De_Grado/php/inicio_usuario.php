<?php
session_start();
//session_destroy();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../estilos/bootstrap/estilos.css">

    </head>
    <body>
        <div class="container-fluid">

            <header class="fixed-top border-bottom border-secondary py-2 bg-dark text-white">
                <div class="row">
                    <div class="col-lg-6 col-sm text-center">
                        <h3 class="font-weight-bold">GIMNASIO ELMEJOR</h3>
                    </div>

                    <?php
                    if (isset($_SESSION['usuario']) && isset($_SESSION['contrasenia'])) {
                        ?>

                        <div class="col-lg-6 col-sm text-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Información
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="inicio_usuario.php">Datos Usuario</a>
                                    <a class="dropdown-item" href="actividades.php">Actividades</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Generar PDF</a>
                                </div>
                                 <a class="btn btn-secondary" href="index.php">Cerrar Sesión</a>
                            </div>
                           
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="col-lg-6 col-sm text-center">
                            <a class="btn btn-secondary" href="index.php">Atrás</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </header>
            <main class="jumbotron my-5">
                <?php
                if (isset($_SESSION['usuario']) && isset($_SESSION['contrasenia'])) {
                    include '../bd/conexion.php';
                    include '../bd/select.php';
                    //MOSTRAMOS LOS DATOS DEL USUARIO
                    mostrarDatos($_SESSION['usuario'], $_SESSION['contrasenia']);
                    
                    $id = idUsuarioActual($_SESSION['usuario'], $_SESSION['contrasenia']);
                    
                    //LE ASIGNAMOS A UNA SESIÓN EL VALOR DEVUELTO POR LA FUNCIÓN QUE HAYA EL VALOR DE LA ID DEL USUARIO ACTUAL
                    $_SESSION['id'] = $id;
                    
                    //MOSTRAMOS LA INFORAMCIÓN DE LAS ACTIVIDADES ADQUIRIDAS POR EL USUARIO ACTUAL
                    //EN CASO DE NO HABER ACTIVIDADES ADQUIRIDAS, NO MOSTRARÍAMOS NADA
                    mostrarActividades($_SESSION['id']);
                    
                    //MOSTRAMOS LA INFORMACIÓN DEL GIMNASIO DE FORMA CONSTANTE
                    include '../maquetacion/informacion.php';
                } else {
                    include '../maquetacion/formularios/inicio_sesion.php';
                    if (isset($_POST['nombreInicio']) && isset($_POST['contraseniaInicio'])) {
                        $nombre = $_POST['nombreInicio'];
                        $contrasenia = $_POST['contraseniaInicio'];
                        
                        $_SESSION['usuario'] = $nombre;
                        $_SESSION['contrasenia'] = $contrasenia;

                        header("location:inicio_usuario.php");
                    }
                }
                ?>
            </main>

        </div>
    </body>
</html>