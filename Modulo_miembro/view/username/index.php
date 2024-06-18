<?php
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/view/head/head.php");
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/controller/usernameControler.php");
$obj = new usernameController();
$rows = ($obj->index());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del registro</title>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Viga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header>
    <!-- Contenido del header si lo hay -->
</header>
<main>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">MIEMBROS</h2>
            <div>
                <a href="/Modulo_miembro/view/fpdf/reporte.php" target="_blank" class="btn btn-success mr-2"><i class="fa-solid fa-file-pdf"></i> Generar Reporte</a>
            </div>
        </div>

        <table class="table table-bordered text-center" id="usuariosTable">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="width: 100px;">Documento</th>
                    <th scope="col" style="width: 150px;">Nombres</th>
                    <th scope="col" style="width: 150px;">Apellidos</th>
                    <th scope="col" style="width: 150px;">EPS</th>
                    <th scope="col" style="width: 100px;"><i class="fas fa-eye"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php if($rows): ?>
                    <?php foreach($rows as $row): ?>
                        <tr>    
                            <td><?= htmlspecialchars($row[0])?></td>
                            <td><?= htmlspecialchars($row[1]) ?></td>
                            <td><?= htmlspecialchars($row[2]) ?></td>
                            <td><?= htmlspecialchars($row[10]) ?></td> <!-- Ajusta el índice según la EPS en tu base de datos -->
                            <td>
                                <a href="mostrar.php?id=<?= $row[0] ?>" class="btn btn-visualizar">Visualizar Deportista</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"></script>
<script>
    $(document).ready(function(){
        $('#usuariosTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            "lengthMenu": [
                [5, 10, 20, 50, -1],
                [5, 10, 20, 50, "Todos"]
            ],
            "pagingType": "simple_numbers",
            "pageLength": 5
        });
    });
</script>
<script src="script.js"></script>
</body>
</html>
