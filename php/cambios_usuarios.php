
<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 

<?php
session_start();
include "conexion.php";

// Obtener datos del usuario
$id_usuario = $_GET['id_usuario']; // Este ID debe ser pasado a la página, por ejemplo, como parámetro en la URL
$query_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
$result_user = mysqli_num_rows($query_user);

if ($result_user == 0) {
    header("Location: lista_usuarios.php");
} else {
    $data_user = mysqli_fetch_assoc($query_user);
}

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['email']) || empty($_POST['contraseña']) || empty($_POST['rol'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        $EMAIL = $_POST['email'];
        $PASSWORD = md5($_POST['contraseña']);
        $ROL = $_POST['rol'];

        $query_update = mysqli_query($conexion, "UPDATE usuarios SET email = '$EMAIL', contraseña = '$PASSWORD', rol = '$ROL' WHERE id_usuario = '$id_usuario'");

        if ($query_update) {
            $alert = '<p class="msg_save">Usuario actualizado correctamente</p>';
        } else {
            $alert = '<p class="msg_error">Error al actualizar el usuario</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link rel="stylesheet" href="../css/cambios_usuarios.css">
</head>
<body>
<?php
    include("encabezado.php");
    ?>
    <div class="form_registro">
        <h1>Actualizar Usuario</h1>
        <hr>

        <form action="" method="post">
            <label for="correo" class="mensaje">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="email" value="<?php echo $data_user['email']; ?>">
            <br>
            <label for="contraseña" class="mensaje2">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="contraseña" value="">
            <br>
            <label for="rol" class="mensaje3">Tipo de usuario</label>

            <?php
            $query_rol = mysqli_query($conexion, "SELECT * FROM roles");
            $result_rol = mysqli_num_rows($query_rol);
            ?>
            <select name="rol" id="rol">
                <?php
                if ($result_rol > 0) {
                    while ($rol = mysqli_fetch_array($query_rol)) {
                        $selected = ($rol['id_rol'] == $data_user['rol']) ? 'selected' : '';
                        echo "<option value='{$rol['id_rol']}' {$selected}>{$rol['nombre_rol']}</option>";
                    }
                }
                ?>
            </select>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <a href="lista_usuarios.php" class="btn_return">Regresar</a>
            <input type="submit" value="Actualizar Usuario" class="btn_save">
        </form>
    </div>
</body>
</html>
