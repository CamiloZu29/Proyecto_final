<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 
<?php
include("conexion.php");

// Verificar la conexión a la base de datos
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/roles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script type="text/javascript">
        function confirmar(){
            return confirm('¿Estas seguro de querer eliminar esta categoria?');
        }
    </script>
</head>

<body>
<?php
    include("encabezado.php");
    ?>
    <main>
        <div class="pt">
            <div class="table">
                <div class="table_header">
                    <p>Roles</p>
                    <button style="background-color: #242424"><a style=" text-decoration: none; color: white;"  href="añadir_rol.php">
                    Añadir Rol</a></button>
                </div>
                <div class="table_section">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th><i class="bi bi-pencil-fill"></i></th>
                                <th><i class="bi bi-trash-fill"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM roles";
                            $result = $conexion->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($fila = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $fila['id_rol']; ?></td>
                                        <td><?php echo $fila['nombre_rol']; ?></td>
                                        <td>
                                            <button><a
                                                    href="editar_rol.php?id_rol=<?php echo $fila['id_rol']; ?>"
                                                    style="text-decoration: none; color: black;">Editar</a></button>
                                        </td>
                                        <td>
                                            <button style="background-color: #A73838;"><a onclick="return confirmar()"
                                                    href="eliminar_rol.php?id_rol=<?php echo $fila['id_rol']; ?>"
                                                    style="text-decoration: none; color: black;">Eliminar</a></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
                            }
                            $conexion->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
