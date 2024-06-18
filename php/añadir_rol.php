<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/añadir_rol.css">
</head>

<body>
    <?php
    include("encabezado.php");
    ?>
    <main>
    <?php
include("conexion.php"); // Conexión a la base de datos

if (isset($_POST['enviar'])) {
    if (!empty($_POST['nombre_rol'])) {
        $nombreRol = $_POST['nombre_rol'];

        // Sentencia SQL para insertar los datos en la base de datos
        $sql = "INSERT INTO roles (nombre_rol) VALUES ('$nombreRol')";

        $resultado = mysqli_query($conexion, $sql);

        // Alertas, según si está bien o mal
        if ($resultado) {
            echo "<script language='JavaScript'>
            alert('El rol se añadió correctamente :)');
            location.assign('roles.php');
            </script>";
        } else {
            echo "<script language='JavaScript'>
            alert('El rol no se pudo añadir correctamente: " . mysqli_error($conexion) . "');
            location.assign('roles.php');
            </script>";
        }
    } else {
        echo "Asegúrate de completar todos los campos.";
    }
}
?>

<form id="updateForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <h2 style="margin-bottom: 30px;">Añadir Rol</h2>
    <div class="mb-3">
        <label for="nombre_rol" class="form-label">Nombre Rol:</label>
        <textarea id="nombre_rol" class="form-control-desc" name="nombre_rol" autocomplete="off"></textarea>
    </div>
    <input style="margin-top: 20px; cursor:pointer; text-decoration: none; color: black;" type="submit" name="enviar" autocomplete="off" value="Añadir Rol"> 
    <button style="margin-top: 20px; width: 50px; height: 20px;"> <a style="text-decoration: none; color: black;" href="roles.php">Volver</a></button>
</form>

    </main>
    <?php include("piepagina.html"); ?>
</body>

</html>