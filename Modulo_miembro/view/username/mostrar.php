<?php
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/view/head/head.php");
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/controller/usernameControler.php");
$obj = new usernameController();
$date = $obj->mostrar($_GET['id']);
?>
<!--En este apartado se muestra toda la informacion general del deportista-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del registro</title>
    <!-- Enlace a tu hoja de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="../css/mostrar.css">
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body> 
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 mb-3 text-center"> <!-- Centrar el título -->
        <h2 class="mb-4" style="background-color: black; color: white; text-shadow: 2px 2px 6px red;">DETALLES DE REGISTRO</h2>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-striped table-bordered text-center">
        <!-- Contenido de la tabla -->
        <thead class="thead-dark">
            <tr>
                <th scope="col">Doc ID</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Nacimiento</th>
                <th scope="col">Edad</th>
                <th scope="col">Altura</th>
                <th scope="col">Peso</th>
                <th scope="col">Pie Dominante</th>
                <th scope="col">Posición</th>
                <th scope="col">Dirección</th>
                <th scope="col">EPS</th>
                <th scope="col">Estado EPS</th>
                <th scope="col">Contacto Acudiente</th>
                <th scope="col">Categoría</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
            <tbody>
                <tr>
                    <td><?= $date['doc_identidad'] ?></td>
                    <td><?= $date['nombre'] ?></td>
                    <td><?= $date['apellido'] ?></td>
                    <td><?= $date['fecha_nacimiento'] ?></td>
                    <td>
                        <?php
                        // Calcular la edad a partir de la fecha de nacimiento
                        $fecha_nacimiento = new DateTime($date['fecha_nacimiento']);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($fecha_nacimiento)->y;
                        echo $edad;
                        ?>
                    </td>
                    <td><?= $date['altura'] ?></td>
                    <td><?= $date['peso'] ?></td>
                    <td><?= $date['pie_dominante'] ?></td>
                    <td><?= $date['posicion'] ?></td>
                    <td><?= $date['direccion'] ?></td>
                    <td><?= $date['eps'] ?></td>
                    <td><?= $date['estado_eps'] ?></td>
                    <td><?= $date['contacto_acudiente'] ?></td>
                    <td><?= $date['categoria'] ?></td>
                    <td>
                        <a class="btn btn-warning mb-2" href="editar.php?id=<?= $date['doc_identidad'] ?>">Editar</a>
                        <!-- Botón para abrir el modal -->
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <form action="index.php">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z"/>
                    <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 1.707V10.5a.5.5 0 0 1-1 0V1.707L5.354 3.854a.5.5 0 1 1-.708-.708z"/>
                </svg>
                Volver A Miebros
            </button>
        </form>
    </div>
</div>

<!-- Modal para confirmar la eliminación del registro -->

<!-- Enlace a Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
