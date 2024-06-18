<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 

<?php
include "conexion.php"; 

// Obtener el ID del usuario de la URL
if(isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} else {
    // Si no se proporciona el ID del usuario, redirigir o manejar el error según sea necesario
    // Por ejemplo:
    header("Location: error.php");
    exit();
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Variables para almacenar los datos del formulario
    $doc_identidad = $_POST['doc_identidad'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $pie_dominante = $_POST['pie_dominante'];
    $posicion = $_POST['posicion'];
    $eps = $_POST['eps'];
    $estado_eps = $_POST['estado_eps'];
    $contacto_acudiente = $_POST['contacto_acudiente'];
    $direccion = $_POST['direccion'];

    // Validación de campos
    if (empty($doc_identidad) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento) || 
        empty($altura) || empty($peso) || empty($pie_dominante) || empty($posicion) || 
        empty($eps) || empty($estado_eps) || empty($contacto_acudiente) || empty($direccion)) {
        $msg = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        // Comenzar la transacción
        mysqli_begin_transaction($conexion);

        // Insertar en la tabla de miembros
        $query_insert_miembro = mysqli_query($conexion, "INSERT INTO miembro (id_user, doc_identidad, nombre, apellido, fecha_nacimiento, altura, peso, pie_dominante, posicion, contacto_acudiente, direccion, eps, estado_eps) VALUES ('$id_usuario', '$doc_identidad', '$nombre', '$apellido', '$fecha_nacimiento', '$altura', '$peso', '$pie_dominante', '$posicion', '$contacto_acudiente', '$direccion', '$eps', '$estado_eps')");

        if ($query_insert_miembro) {
            // Confirmar la transacción si la consulta se realizó correctamente
            mysqli_commit($conexion);
            $msg = '<p class="msg_save">Miembro creado correctamente</p>';
            // Redirigir a otra página después de la creación
            header("Location: lista_usuarios.php");
            exit();
        } else {
            // Deshacer la transacción si hubo algún error
            mysqli_rollback($conexion);
            $msg = '<p class="msg_error">Error al crear el miembro</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Usuario</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a tu hoja de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="create.css">
</head>

<?php
    include("encabezado.php");
    ?>
<body>

<main>
        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="container cuadro">
                <h3>Datos De Usuario</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Nombres</label>
                        <input type="text" name="nombre" required class="form-control" id="exampleInputEmail1" placeholder="Nombres...">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Apellidos</label>
                        <input type="text" name="apellido" required class="form-control" id="exampleInputEmail1" placeholder="Apellidos...">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Documento Identidad</label>
                        <input type="number" name="doc_identidad" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Eps</label>
                        <input type="text" name="eps" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="tipoAfiliacion" class="form-label">Tipo De Afiliación</label>
                        <select name="estado_eps" required class="form-control" id="tipoAfiliacion">
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Régimen Contributivo">Contributivo</option>
                            <option value="Subsidiado">Subsidiado</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pieDominante" class="form-label">Pie Dominante</label>
                        <select name="pie_dominante" required class="form-control" id="pieDominante">
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Derecho">Derecho</option>
                            <option value="Izquierdo">Izquierdo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Peso</label>
                        <input type="number" name="peso" required class="form-control" id="exampleInputEmail1" placeholder="Ingrese Kg">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Altura</label>
                        <input type="number" name="altura" required class="form-control" id="exampleInputEmail1" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Posicion De Juego</label>
                        <input type="text" name="posicion" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-12">
                        <h3>Datos Complementarios</h3>
                    </div>
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Direccion De Residencia</label>
                        <input type="text" name="direccion" required class="form-control" id="exampleInputEmail1" placeholder="Direccion...">
                    </div>
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Telefono Del Acudiente</label>
                        <input type="number" name="contacto_acudiente" required class="form-control" id="exampleInputEmail1" placeholder="Teléfono">
                    </div>
                    <div class="col-md-12 botones">
                        <?php echo $msg; ?> <!-- Aquí se mostrarán los mensajes de error o éxito -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a class="btn btn-danger" href="index.php">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </main>
<script src="/Modulo_miembro/view/js/usuarios.js"></script>
<!-- Enlace a Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

