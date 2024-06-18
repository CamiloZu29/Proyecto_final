<?php
session_start();
if(empty($_SESSION['active'])) {
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
    <title>Document</title>
    <link rel="stylesheet" href="../css/asistencias.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php include("encabezado.php"); ?>

<main>
    <?php
    // Inicializar la variable categoría
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
        $errores = [];

        // Verificar si los arrays existen y contienen datos
        if (empty($_POST['nombre_apellido']) || empty($_POST['doc_identidad']) || empty($_POST['estado_asistencia']) || empty($_POST['fecha']) || empty($_POST['hora']) || empty($_POST['entrenador'])) {
            $errores[] = 'Faltan datos por ingresar o seleccionar.';
        } else {
            foreach ($_POST['nombre_apellido'] as $index => $nombre_apellido) {
                if (empty($_POST['doc_identidad'][$index]) || !isset($_POST['estado_asistencia'][$_POST['doc_identidad'][$index]]) || !isset($_POST['fecha'][$index]) || empty($_POST['hora'][$index]) || empty($_POST['entrenador'][$index])) {
                    $errores[] = 'Faltan datos por ingresar o seleccionar en una de las filas.';
                    break;
                }
            }
        }

        if (empty($errores)) {
            // Preparar la consulta SQL
            $sql_insert = "INSERT INTO asistencias (doc_asistencia, nombre_apellido, estado_asistencia, fecha, hora, entrenador) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $sql_insert);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssssss', $doc_asistencia, $nombre_apellido, $estado_asistencia, $fecha, $hora, $entrenador);
                foreach ($_POST['nombre_apellido'] as $index => $nombre_apellido) {
                    $doc_asistencia = $_POST['doc_identidad'][$index];
                    $estado_asistencia = isset($_POST['estado_asistencia'][$doc_asistencia]) ? $_POST['estado_asistencia'][$doc_asistencia] : '';
                    $fecha = $_POST['fecha'][$index];
                    $hora = $_POST['hora'][$index];
                    $entrenador = $_POST['entrenador'][$index];

                    if (!mysqli_stmt_execute($stmt)) {
                        echo "Error al insertar el registro: " . mysqli_error($conexion) . "<br>";
                    }
                }

                echo "<script>
                        alert('Asistencia guardada exitosamente.');
                        window.location.href = 'asistencias.php';
                      </script>";

                mysqli_stmt_close($stmt);
            } else {
                echo "<p>Error al preparar la consulta: " . mysqli_error($conexion) . "</p>";
            }
        } else {
            // Convertir el array de errores a una cadena antes de mostrar
            echo "<script>
                    alert('" . implode('\\n', $errores) . "');
                  </script>";
        }
    }

    $sql_miembros = "SELECT nombre, apellido, doc_identidad FROM miembro INNER JOIN usuarios u ON id_user = id_usuario
                                        WHERE rol = 3 and cat_miembro = '$categoria'";
    $resultado_miembros = mysqli_query($conexion, $sql_miembros);

    $num_filas = mysqli_num_rows($resultado_miembros);
    ?>

    <form method="post">
        <div class="pt">
            <div class="table">
                <div class="table_header">
                    <p>AGREGAR ASISTENCIA</p>
                    <div style="width: 700px; height: 40px;" class="container">
                        <input type='hidden' name='categoria' value='<?php echo $categoria; ?>'>
                        <input type='date' id='fecha' name='fecha_general' value='<?php echo isset($_POST['fecha_general']) ? $_POST['fecha_general'] : ''; ?>'>
                        <input type='time' id='hora' name='hora_general' value='<?php echo isset($_POST['hora_general']) ? $_POST['hora_general'] : ''; ?>'>
                        <?php
                        $sql_usuarios = "SELECT nombre_user FROM usuarios WHERE rol = 2";
                        $result_usuarios = mysqli_query($conexion, $sql_usuarios);
                        ?>
                        <select name="nombre_user" id="nombre_user" style="height: 40px; width: 170px; border-radius: 8px; margin-right: 10px;">
                            <option value="">Seleccionar entrenador</option>
                            <?php
                            while ($row_usuario = mysqli_fetch_assoc($result_usuarios)) {
                                $selected = (isset($_POST['nombre_user']) && $_POST['nombre_user'] == $row_usuario['nombre_user']) ? 'selected' : '';
                                echo "<option value='{$row_usuario['nombre_user']}' $selected>{$row_usuario['nombre_user']}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" name="guardar" value="Guardar">
                    </div>

                    <div class='desple'>
                        <?php
                        $sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias";
                        $result_categorias = mysqli_query($conexion, $sql_categorias);
                        ?>
                        <form method='post'>
                            <select name='categoria' id='lang' onchange='this.form.submit()' style="height: 40px; width: 150px; border-radius: 8px; margin-right: 10px;">
                                <option value='0'>Seleccionar categoría</option>
                                <?php
                                while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
                                    $selected = (isset($_POST['categoria']) && $_POST['categoria'] == $row_categoria['id_categoria']) ? 'selected' : '';
                                    echo "<option value='{$row_categoria['id_categoria']}' $selected>{$row_categoria['nombre_categoria']}</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="table_section">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre y Apellido</th>
                                <th>Estado de Asistencia</th>
                                <th style='display: none;'>Fecha</th>
                                <th style='display: none;'>Hora</th>
                                <th style='display: none;'>Entrenador</th>
                                <th style='display: none;'>Documento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row_miembro = mysqli_fetch_assoc($resultado_miembros)) {
                                $doc_identidad = $row_miembro['doc_identidad'];
                                $nombre_apellido = $row_miembro['nombre'] . " " . $row_miembro['apellido'];
                                $estado_asistencia_si = isset($_POST['estado_asistencia'][$doc_identidad]) && $_POST['estado_asistencia'][$doc_identidad] == 'Sí' ? 'checked' : '';
                                $estado_asistencia_no = isset($_POST['estado_asistencia'][$doc_identidad]) && $_POST['estado_asistencia'][$doc_identidad] == 'No' ? 'checked' : '';
                                echo "<tr>";
                                echo "<td><input type='text' name='nombre_apellido[]' value='" . htmlspecialchars($nombre_apellido) . "' readonly></td>";
                                echo "<td>";
                                echo "<label><input type='radio' name='estado_asistencia[" . htmlspecialchars($doc_identidad) . "]' value='Sí' $estado_asistencia_si> Sí</label>";
                                echo "<label><input type='radio' name='estado_asistencia[" . htmlspecialchars($doc_identidad) . "]' value='No' $estado_asistencia_no> No</label>";
                                echo "</td>";
                                echo "<td style='display: none;'><input type='text' class='fecha-texto' readonly='readonly' name='fecha[]' value='" . htmlspecialchars(isset($_POST['fecha_general']) ? $_POST['fecha_general'] : '') . "'></td>";
                                echo "<td style='display: none;'><input type='text' class='hora-texto' readonly='readonly' name='hora[]' value='" . htmlspecialchars(isset($_POST['hora_general']) ? $_POST['hora_general'] : '') . "'></td>";
                                echo "<td style='display: none;'><input type='text' class='entrenador-texto' name='entrenador[]' readonly='readonly' value='" . htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : '') . "'></td>";
                                echo "<td style='display: none;'><input type='text' name='doc_identidad[]' value='" . htmlspecialchars($doc_identidad) . "' readonly></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</main>

<script>
document.getElementById('fecha').addEventListener('input', function() {
    var fechaInputs = document.querySelectorAll('.fecha-texto');
    fechaInputs.forEach(function(input) {
        input.value = this.value;
    }, this);
});

document.getElementById('hora').addEventListener('input', function() {
    var horaInputs = document.querySelectorAll('.hora-texto');
    horaInputs.forEach(function(input) {
        input.value = this.value;
    }, this);
});

document.getElementById('email').addEventListener('input', function() {
    var entrenadorInputs = document.querySelectorAll('.entrenador-texto');
    entrenadorInputs.forEach(function(input) {
        input.value = this.value;
    }, this);
});
</script>

</body>
</html>
