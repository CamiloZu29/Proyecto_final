<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 
<?php
include "conexion.php";

if(!empty($_POST)) {
    $alert='';

    if(empty($_POST['email']) || empty($_POST['contraseña']) || empty($_POST['rol'])) {
        $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {
        $EMAIL = $_POST['email'];
        $PASSWORD = md5($_POST['contraseña']);
        $ROL = $_POST['rol'];
        $NOMBRE_USUARIO = $_POST['nombre_usuario'];

        $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email= '$EMAIL'");
        $result = mysqli_fetch_array($query);

        if($result > 0) {
            $alert = '<p class="msg_error">El correo electrónico ya existe</p>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO usuarios (email,contraseña,rol,nombre_user) VALUES ('$EMAIL', '$PASSWORD', '$ROL', '$NOMBRE_USUARIO')");

            if($query_insert) {
                // Obtener el ID del usuario recién registrado
                $id_usuario = mysqli_insert_id($conexion);
                
                // Redirigir al usuario a la página para crear un nuevo miembro
                header("Location: crear_miembro.php?id_usuario=$id_usuario");
                exit();
            } else {
                $alert = '<p class="msg_error">Error al crear el usuario</p>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registro_usuario.css">
    <title>Registro de Usuario</title>
</head>
<body>
<?php
    include("encabezado.php");
    ?>
    <div class="form_registro">
        <h1>Registro de usuarios</h1>
        <hr>

        <form action="" method="post">
            <label for="correo" class="mensaje">Correo Electronico</label>
            <input type="email" name="email" id="email" class="email">
            <br>
            <label for="contraseña" class="mensaje2">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="contraseña">
            <br>
            <label for="nombre_usuario" class="mensaje2">Nombre de Usuario</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" class="email">
            <br>
            <label for="rol" class="mensaje3">Tipo de usuario</label>

            <?php
            $query_rol = mysqli_query($conexion, "SELECT * FROM roles");
            $result_rol = mysqli_num_rows($query_rol);
            ?>
            <select name="rol" id="rol">
                <?php
                if($result_rol > 0) {
                    while ($rol = mysqli_fetch_array($query_rol)) {
                        ?>
                        <option value="<?php echo $rol["id_rol"]; ?>"> <?php echo $rol["nombre_rol"]; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>
            <br>
            <input type="submit" value="Crear Usuario" class="btn_save">
        </form>
    </div>
</body>
</html>
