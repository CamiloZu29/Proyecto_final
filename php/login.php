<?php
session_start();

$alert = '';

if (!empty($_POST)) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $alert = 'Ingrese el correo electrónico y la clave';
    } else {
        require_once "conexion.php";

        $EMAIL = mysqli_real_escape_string($conexion, $_POST['email']);
        $PASSWORD = md5(mysqli_real_escape_string($conexion, $_POST['password'])); // Usando MD5 como en tu ejemplo

        // Usar sentencias preparadas para evitar inyecciones SQL
        $query = $conexion->prepare("SELECT * FROM usuarios WHERE email = ? AND contraseña = ?");
        $query->bind_param("ss", $EMAIL, $PASSWORD);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_array(MYSQLI_ASSOC);

            $_SESSION['active'] = true;
            $_SESSION['id_user'] = $data['id_usuario'];
            $_SESSION['EMAIL'] = $data['email'];
            $_SESSION['PASSWORD'] = $data['contraseña'];
            $_SESSION['rol'] = $data['rol'];

            // Determinar a qué página redirigir según el rol
            switch ($data['rol']) {
                case '1':
                    header('location: prueba.php'); // Ruta para administradores
                    break;
                case '2':
                    header('location: ../vistauser/pruebau.php'); // Ruta para usuarios normales
                    break;
                default:
                    header('location: otro.php'); // Redirección por defecto para roles desconocidos
                    break;
            }
            exit(); // Asegúrate de que el script se detenga después de la redirección
        } else {
            $alert = 'El usuario o la clave son incorrectos';
        }

        // Cerrar la conexión
        $query->close();
        $conexion->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="login.css"> <!-- Asegúrate de que tu archivo CSS está enlazado correctamente -->
</head>
<body>
    <div class="Login">
        <div class="header">
            <h1>SPARTANWEB</h1>
            <hr class="divider">
            <img class="img" src="spartanlogo.png" alt="">
        </div> 
        <form action="" method="post"> <!-- Verifica que action esté apuntando correctamente a tu archivo PHP -->
            <p class="mensaje"><i>Correo</i></p>
            <div class="Email">
                <input type="text" name="email">
            </div>
            <p class="mensaje2">Contraseña</p>
            <div class="alert"><?php echo (isset($alert) ? $alert : ''); ?></div> <!-- Asegúrate de que $alert se muestra correctamente -->
            <div class="password">
                <input type="password" name="password">
            </div>
            <div class="confirmar">
                <input type="submit" value="Confirmar">
            </div>
        </form>
    </div>
</body>
</html>
