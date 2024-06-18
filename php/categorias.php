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
    <link rel="stylesheet" href="../css/categorias.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script type="text/javascript">
        function confirmar(){
            return confirm('¿Estas seguro de querer eliminar esta categoria?');
        }
    </script>
    <script type="text/javascript">
        function confirmar(){
            return confirm('¿Estas seguro de querer eliminar esta categoria?');
        }

        window.onload = function() {
            <?php
            if (isset($_GET['mensaje'])) {
                if ($_GET['mensaje'] == 'eliminado') {
                    echo "alert('Categoría eliminada correctamente.');";
                } elseif ($_GET['mensaje'] == 'error_foranea') {
                    echo "alert('No se puede eliminar la categoría, ya que tiene miembros asociados.');";
                } elseif ($_GET['mensaje'] == 'no_existe') {
                    echo "alert('La categoría no existe.');";
                } else {
                    echo "alert('Error al eliminar la categoría.');";
                }
            }
            ?>
        };
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
                    <p>Categorias</p>
                    <button style="background-color: #242424"><a style=" text-decoration: none; color: white;"  href="añadir_categoria.php">
                    Añadir Categoria</a></button>
                </div>
                <div class="table_section">
                    <table>
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Edad minima</th>
                                <th>Edad maxima</th>
                                <th><i class="bi bi-pencil-fill"></i></th>
                                <th><i class="bi bi-trash-fill"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM categorias";
                            $result = $conexion->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($fila = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $fila['nombre_categoria']; ?></td>
                                        <td><?php echo $fila['edad_min']; ?></td>
                                        <td><?php echo $fila['edad_max']; ?></td>
                                        <td>
                                            <button><a
                                                    href="editar_categoria.php?id_categoria=<?php echo $fila['id_categoria']; ?>"
                                                    style="text-decoration: none; color: black;">Editar</a></button>
                                        </td>
                                        <td>
                                            <button style="background-color: #A73838;"><a onclick="return confirmar()"
                                                    href="eliminar_categoria.php?id_categoria=<?php echo $fila['id_categoria']; ?>"
                                                    style="text-decoration: none; color: black;">Eliminar</a></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
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
