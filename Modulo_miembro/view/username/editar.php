<?php
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/view/head/head.php");
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/controller/usernameControler.php");
$obj = new usernameController();
$user = $obj->mostrar($_GET['id']);
?>
<!--se conecta con modificar.php-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a tu hoja de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="../css/editar.css">
    
</head>
<body>
<div class="container mt-5">
<h2 class="text-center mb-4" style="color: white; background-color: black; text-shadow: 2px 2px 6px red;">MODIFICANDO REGISTRO</h2>


    <form action="Modificar.php" method="post" autocomplete="off">
            <div class="form-group row">
                <label for="doc_identidad" class="col-sm-2 col-form-label">Documento Identidad</label>
                <div class="col-sm-10">
                    <input type="text" name="doc_identidad" readonly class="form-control-plaintext" id="doc_identidad" value="<?= $user['doc_identidad'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" name="nombre" class="form-control" id="nombre" value="<?= $user['nombre'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
                <div class="col-sm-10">
                    <input type="text" name="apellido" class="form-control" id="apellido" value="<?= $user['apellido'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                <div class="col-sm-10">
                    <input type="date" name="fecha_nacimiento" class="form-control" id="fecha_nacimiento" value="<?= $user['fecha_nacimiento'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="altura" class="col-sm-2 col-form-label">Altura</label>
                <div class="col-sm-10">
                    <input type="text" name="altura" class="form-control" id="altura" value="<?= $user['altura'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="peso" class="col-sm-2 col-form-label">Peso</label>
                <div class="col-sm-10">
                    <input type="text" name="peso" class="form-control" id="peso" value="<?= $user['peso'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="pie_dominante" class="col-sm-2 col-form-label">Pie Dominante</label>
                <div class="col-sm-10">
                    <select name="pie_dominante" required class="form-control" id="pie_dominante">
                        <option value="" disabled <?= empty($user['pie_dominante']) ? 'selected' : '' ?>>Seleccione</option>
                        <option value="Derecho" <?= $user['pie_dominante'] == 'Derecho' ? 'selected' : '' ?>>Derecho</option>
                        <option value="Izquierdo" <?= $user['pie_dominante'] == 'Izquierdo' ? 'selected' : '' ?>>Izquierdo</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="posicion" class="col-sm-2 col-form-label">Posición</label>
                <div class="col-sm-10">
                    <input type="text" name="posicion" class="form-control" id="posicion" value="<?= $user['posicion'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                <div class="col-sm-10">
                    <input type="text" name="direccion" class="form-control" id="direccion" value="<?= $user['direccion'] ?>">
                </div>
            </div>  
            <div class="form-group row">
                <label for="eps" class="col-sm-2 col-form-label">EPS</label>
                <div class="col-sm-10">
                    <input type="text" name="eps" class="form-control" id="eps" value="<?= $user['eps'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="estado_eps" class="col-sm-2 col-form-label">Tipo De Afiliacion</label>
                <div class="col-sm-10">
                    <select name="estado_eps" required class="form-control" id="estado_eps">
                        <option value="" disabled <?= empty($user['estado_eps']) ? 'selected' : '' ?>>Seleccione</option>
                        <option value="Régimen Contributivo" <?= $user['estado_eps'] == 'Régimen Contributivo' ? 'selected' : '' ?>>Contributivo</option>
                        <option value="Subsidiado" <?= $user['estado_eps'] == 'Subsidiado' ? 'selected' : '' ?>>Subsidiado</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="contacto_acudiente" class="col-sm-2 col-form-label">Contacto Acudiente</label>
                <div class="col-sm-10">
                    <input type="text" name="contacto_acudiente" class="form-control" id="contacto_acudiente" value="<?= $user['contacto_acudiente'] ?>">
                </div>
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-success" value="Guardar Cambios">
                <a class="btn btn-danger" href="mostrar.php?id=<?= $user['doc_identidad'] ?>">Cancelar</a>
            </div>
        </form>
</div>
<?php
require_once("c://xampp/htdocs/Modulo_miembro/view/head/footer.php");
?>
<!-- Enlace a Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
