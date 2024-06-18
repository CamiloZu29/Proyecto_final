<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: login.php');
    exit();
}

include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../css/lista_usuarios.css">
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
                    <p>Usuarios</p>
                    <div style="width: 550px; height: 40px;" class="container">
                    <form method="GET" action="lista_usuarios.php" style="display: flex; align-items: center;">
    <button type="button" onclick="window.location.href='registro_usuario.php'" style="margin-right: 10px;">Nuevo Usuario</button>
    <input name="search_email" type="text" autocomplete="off" placeholder="Email..." style="margin-right: 10px;">
    <select name="role_filter" style="height: 40px; width: 150px; border-radius: 8px; margin-right: 10px;">
        <option value='0'>Roles</option>
        <?php
        $sql_roles = "SELECT id_rol, nombre_rol FROM roles";
        $result_roles = mysqli_query($conexion, $sql_roles);
        while ($row_rol = mysqli_fetch_assoc($result_roles)) {
            echo "<option value='{$row_rol['id_rol']}'>{$row_rol['nombre_rol']}</option>";
        }
        ?>
    </select>
    <button type="button" onclick="window.location.href='lista_usuarios.php'" style="margin-right: 10px;">Mostrar Todos</button>
    <button type="submit" class="lupa"><i class="bi bi-search"></i></button>
</form>

                    </div>
                </div>
                <div class="table_section">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search_email = isset($_GET['search_email']) ? $_GET['search_email'] : '';
                            $role_filter = isset($_GET['role_filter']) ? $_GET['role_filter'] : '';
                            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                            $records_per_page = 10;
                            $offset = ($page - 1) * $records_per_page;

                            $sql = "SELECT u.id_usuario, u.email, u.contraseña, r.nombre_rol 
                                    FROM usuarios u 
                                    INNER JOIN roles r ON u.rol = r.id_rol";

                            $conditions = [];
                            $params = [];
                            $param_types = '';

                            if ($search_email) {
                                $conditions[] = "u.email LIKE ?";
                                $params[] = "%$search_email%";
                                $param_types .= 's';
                            }

                            if ($role_filter && $role_filter != '0') {
                                $conditions[] = "u.rol = ?";
                                $params[] = $role_filter;
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
                            $count_sql = "SELECT COUNT(*) AS total FROM usuarios u";
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
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($fila = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $fila['id_usuario']; ?></td>
                                        <td><?php echo $fila['email']; ?></td>
                                        <td><?php echo $fila['contraseña']; ?></td>
                                        <td><?php echo $fila['nombre_rol']; ?></td>
                                        <td>
                                            <button><a href="cambios_usuarios.php?id_usuario=<?php echo $fila['id_usuario']; ?>" style="text-decoration: none; color: black;">Ver Detalles</a></button>
                                            <button onclick="confirmDeletion(<?php echo $fila['id_usuario']; ?>)">Eliminar</button>
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
                        <a href="?page=<?php echo $page - 1; ?>&search_email=<?php echo $search_email; ?>&role_filter=<?php echo $role_filter; ?>">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search_email=<?php echo $search_email; ?>&role_filter=<?php echo $role_filter; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search_email=<?php echo $search_email; ?>&role_filter=<?php echo $role_filter; ?>">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        function confirmDeletion(id) {
            if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
                window.location.href = "eliminar_usuario.php?id_usuario=" + id;
            }
        }
    </script>
</body>
</html>
