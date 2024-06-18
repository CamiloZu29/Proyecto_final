<?php
session_start();
if(empty($_SESSION['active']))
{
    header('location: login.php');
}

?> 

<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/asistencias.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
<?php
    include("encabezado.php");
    ?>
<main>
    <div class="pt">
        <div class="table">
            <div class="table_header">
                <p>ASISTENCIAS</p>
                <div style="width: 900px; height: 40px;" class="container">
                    <form method="GET" action="asistencias.php">
                        <input name="search_name" type="text" autocomplete="off" placeholder="Nombre..." style="margin-right: 10px;">
                        <input type="date" name="fecha_filter">
                        <select name="category_filter" style="height: 40px; width: 150px; border-radius: 8px; margin-right: 10px;">
                            <option value='0'>Categorías</option>
                            <?php
                            $sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias";
                            $result_categorias = mysqli_query($conexion, $sql_categorias);
                            while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
                                echo "<option value='{$row_categoria['id_categoria']}'>{$row_categoria['nombre_categoria']}</option>";
                            }
                            ?>
                        </select>
                        <button type="button" onclick="window.location.href='agregar_asistencia.php'" style="margin-right: 10px;">Agregar asistencia</button>
                        <button type="button" onclick="window.location.href='asistencias.php'" style="margin-right: 10px;">Mostrar Todos</button>
                        <button type="submit" class="lupa"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Entrenador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
                        $category_filter = isset($_GET['category_filter']) ? $_GET['category_filter'] : '';
                        $fecha_filter = isset($_GET['fecha_filter']) ? $_GET['fecha_filter'] : '';

                        $sql = "SELECT a.id_asistencia, m.nombre, m.apellido, a.estado_asistencia, a.fecha, a.hora, a.entrenador, a.doc_asistencia 
                            FROM asistencias a
                            INNER JOIN miembro m ON m.doc_identidad = a.doc_asistencia";

                        $conditions = [];
                        $params = [];
                        $param_types = '';

                        if ($search_name) {
                            $conditions[] = "(m.nombre LIKE ? OR m.apellido LIKE ?)";
                            $params[] = "%$search_name%";
                            $params[] = "%$search_name%";
                            $param_types .= 'ss';
                        }

                        if ($category_filter) {
                            $conditions[] = "m.cat_miembro = ?";
                            $params[] = $category_filter;
                            $param_types .= 'i';
                        }

                        if ($fecha_filter) {
                            $conditions[] = "a.fecha = ?";
                            $params[] = $fecha_filter;
                            $param_types .= 's';
                        }

                        if (!empty($conditions)) {
                            $sql .= " WHERE " . implode(' AND ', $conditions);
                        }

                        $stmt = mysqli_prepare($conexion, $sql);

                        if ($param_types) {
                            mysqli_stmt_bind_param($stmt, $param_types, ...$params);
                        }

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        if (!$result) {
                            echo "<tr><td colspan='5'>Error al ejecutar la consulta</td></tr>";
                            error_log("Error en la consulta SQL: " . mysqli_error($conexion));
                            exit;
                        }

                        if (mysqli_num_rows($result) > 0) {
                            while ($fila = mysqli_fetch_array($result)) { // Iterar sobre resultados
                        ?>
                                <tr> <!-- Almacena la llave foránea como atributo -->
                                    <td><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></td>
                                    <td><?php echo $fila['estado_asistencia']; ?></td>
                                    <td><?php echo $fila['fecha']; ?></td>
                                    <td><?php echo $fila['hora']; ?></td>
                                    <td><?php echo $fila['entrenador']; ?></td>
                                    
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>




</body>

</html>