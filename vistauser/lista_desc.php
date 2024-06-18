<?php
include ("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/lista_desc.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    include("encabezado.html")
    ?>
    <main>
        <div class="pt">
            <div class="table">
                <div class="table_header">
                    <p>Descripciones</p>
                    <div style="width: 550px; height: 40px;" class="container">
                        <form method="GET" action="lista_desc.php">
                            <input name="search_name" type="text" autocomplete="off" placeholder="Nombre..."
                                style="margin-right: 10px;">
                            <select name="category_filter"
                                style="height: 40px; width: 150px; border-radius: 8px; margin-right: 10px;">
                                <option value='0'>Categorías</option>
                                <?php
                                $sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias";
                                $result_categorias = mysqli_query($conexion, $sql_categorias);
                                while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
                                    echo "<option value='{$row_categoria['id_categoria']}'>{$row_categoria['nombre_categoria']}</option>";
                                }
                                ?>
                                <?php
                                $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
                                $category_filter = isset($_GET['category_filter']) ? $_GET['category_filter'] : '';
                                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                $records_per_page = 10;
                                $offset = ($page - 1) * $records_per_page;

                                $sql = "SELECT m.doc_identidad, m.nombre, m.apellido, m.cat_miembro, c.nombre_categoria 
                                FROM miembro m 
                                INNER JOIN categorias c ON m.cat_miembro = c.id_categoria";

                                $conditions = [];
                                $params = [];
                                $param_types = '';

                                if ($search_name) {
                                    $conditions[] = "m.nombre LIKE ?";
                                    $params[] = "%$search_name%";
                                    $param_types .= 's';
                                }

                                if ($category_filter) {
                                    $conditions[] = "m.cat_miembro = ?";
                                    $params[] = $category_filter;
                                    $param_types .= 'i';
                                }

                                if (!empty($conditions)) {
                                    $sql .= " WHERE " . implode(' AND ', $conditions);
                                }

                                $sql .= " LIMIT ? OFFSET ?";
                                $params[] = $records_per_page;
                                $params[] = $offset;
                                $param_types .= 'ii';

                                $stmt = mysqli_prepare($conexion, $sql);

                                if ($param_types) {
                                    mysqli_stmt_bind_param($stmt, $param_types, ...$params);
                                }

                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                // Obtener el total de registros para la paginación
                                $count_sql = "SELECT COUNT(*) AS total FROM miembro m";
                                if (!empty($conditions)) {
                                    $count_sql .= " WHERE " . implode(' AND ', $conditions);
                                }

                                $count_stmt = mysqli_prepare($conexion, $count_sql);

                                // Vincular parámetros para la consulta de conteo, sin los últimos dos parámetros
                                if ($param_types) {
                                    $count_param_types = substr($param_types, 0, -2); // quitar los últimos dos caracteres ('ii' de LIMIT y OFFSET)
                                    $count_params = array_slice($params, 0, -2);
                                    if ($count_param_types) {
                                        mysqli_stmt_bind_param($count_stmt, $count_param_types, ...$count_params);
                                    }
                                }

                                mysqli_stmt_execute($count_stmt);
                                $count_result = mysqli_stmt_get_result($count_stmt);
                                $total_records = mysqli_fetch_assoc($count_result)['total'];
                                $total_pages = ceil($total_records / $records_per_page);
                                ?>
                            </select>
                            <button type="submit" class="lupa" style="margin-right: 10px;"><i
                                    class="bi bi-search"></i></button>
                            <button type="button" onclick="window.location.href='lista_desc.php'">Mostrar Todos</button>
                        </form>
                    </div>
                </div>
                <div class="table_section">
                    <table>
                        <thead>
                            <tr>
                                <th>Doc.</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Categoria</th>
                                <th><i class="bi bi-eye-fill"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($fila = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $fila['doc_identidad']; ?></td>
                                        <td><?php echo $fila['nombre']; ?></td>
                                        <td><?php echo $fila['apellido']; ?></td>
                                        <td><?php echo $fila['nombre_categoria']; ?></td>
                                        <td>
                                            <button><a
                                                    href="descripcion.php?doc_identidad=<?php echo $fila['doc_identidad']; ?>"
                                                    style="text-decoration: none; color: black;">Ver Plantilla</a></button>
                                        </td>
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
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a
                            href="?page=<?php echo $page - 1; ?>&search_name=<?php echo $search_name; ?>&category_filter=<?php echo $category_filter; ?>">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search_name=<?php echo $search_name; ?>&category_filter=<?php echo $category_filter; ?>"
                            <?php if ($i == $page)
                                echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a
                            href="?page=<?php echo $page + 1; ?>&search_name=<?php echo $search_name; ?>&category_filter=<?php echo $category_filter; ?>">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <br>
    <br>
    <br>
    <?php
    include("piepagina.html")
    ?>

</body>

</html>