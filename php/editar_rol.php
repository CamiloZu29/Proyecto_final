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
    <link rel="stylesheet" href="../css/editar_rol.css">
</head>

<body>
<?php
    include("encabezado.php");
    ?>
    <main>
        <?php
        include("conexion.php"); // Conexión a la base de datos

        if (isset($_POST['enviar'])) {
            $id = $_POST['id_rol'];
            $nombreRol = $_POST['nombre_rol'];

            // Sentencia SQL que actualiza en la base de datos, los campos que el usuario cambie
            $sql = "UPDATE roles SET nombre_rol='$nombreRol' WHERE id_rol=$id";

            // Ejecuta la consulta
            $resultado = mysqli_query($conexion, $sql);

            // Alertas, según si está bien o mal
            if ($resultado) {
                echo "<script lenguage='JavaScript'>
        alert('Los datos se han actualizado correctamente en el rol :)');
        location.assign('roles.php');
        </script>";
            } else {
                echo "<script lenguage='JavaScript'>
        alert('Los datos no se han podido actualizar correctamente: " . mysqli_error($conexion) . "');
        location.assign('roles.php');
        </script>";
            }
        } else {
            // Si no se ha enviado el formulario, muestra el formulario de actualización
            $id = $_GET['id_rol'];
            // Consulta SQL para obtener datos basados en el identificador
            $sql = "SELECT * FROM roles WHERE id_rol = $id";

            $resultado = mysqli_query($conexion, $sql);

            if (mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_assoc($resultado);
                $id = $fila["id_rol"];
                $nombreRol = $fila['nombre_rol'];
        ?>
                <form id="updateForm" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <h2 style="margin-bottom: 30px;">Actualización Rol</h2>
                    <div class="mb-3">
                        <input type="hidden" name="id_rol" value="<?php echo $id; ?>">
                        <label for="nombre_rol" class="form-label">Nombre Rol:</label>
                        <textarea id="nombre_rol" class="form-control-desc" name="nombre_rol" autocomplete="off"><?php echo $nombreRol; ?></textarea>
                    </div>
                    <input style="margin-top: 10px; cursor:pointer; text-decoration: none; color: black;" type="submit" name="enviar" autocomplete="off" value="Actualizar">
                    <button style="margin-top: 20px; width: 50px; height: 20px;"> <a style="text-decoration: none; color: black;" href="roles.php">Volver</a></button>
                </form>
        <?php
            } else {
                echo "No se encontraron datos para actualizar.";
            }
        }
        ?>

    </main>
    <?php include("piepagina.html"); ?>
</body>

</html>