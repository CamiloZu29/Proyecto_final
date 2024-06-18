<?php
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/view/head/head.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Usuario</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a tu hoja de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="../css/create.css">
</head>

<body>
    <header>
        <?php include('c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/view/head/head.php'); ?>
    </header>

    <main>
        <form action="store.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="container cuadro">
                <strong>SPARTAN WEB</strong>
                <img src="../imagenes/linea.png" alt="Línea">
                <img src="../imagenes/LogoSpartanWeb.png" class="contenido-formulario">
                <h3>Datos De Usuario</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Nombres</label>
                        <input type="text" name="nombre" required class="form-control" id="exampleInputEmail1" placeholder="Nombres...">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Apellidos</label>
                        <input type="text" name="apellido" required class="form-control" id="exampleInputEmail1" placeholder="Apellidos...">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Documento Identidad</label>
                        <input type="number" name="doc_identidad" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Eps</label>
                        <input type="text" name="eps" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Tipo De Afiliacion</label>
                        <input type="text" name="estado_eps" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Pie Dominante</label>
                        <input type="text" name="pie_dominante" required class="form-control" id="exampleInputEmail1" placeholder="Derecho/Izquierdo">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Peso</label>
                        <input type="number" name="peso" required class="form-control" id="exampleInputEmail1" placeholder="Ingrese Kg">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Altura</label>
                        <input type="number" name="altura" required class="form-control" id="exampleInputEmail1" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Posicion De Juego</label>
                        <input type="text" name="posicion" required class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="col-md-12 foto">
                        <label for="foto">Añadir Foto +</label>
                        <div class="profile-picture">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5" />
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            </svg>
                        </div>
                        <input type="file" accept="image/*" id="foto" name="foto" class="form-control nuevaFoto">
                    </div>
                    <div class="col-md-12">
                        <h3>Datos Complementarios</h3>
                    </div>
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Direccion De Residencia</label>
                        <input type="text" name="direccion" required class="form-control" id="exampleInputEmail1" placeholder="Direccion...">
                    </div>
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Telefono Del Acudiente</label>
                        <input type="number" name="contacto_acudiente" required class="form-control" id="exampleInputEmail1" placeholder="Teléfono">
                    </div>
                    <div class="col-md-12 botones">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a class="btn btn-danger" href="index.php">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="/Modulo_miembro/view/js/usuarios.js"></script>
    <!-- Enlace a Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php
require_once("c://xampp/htdocs/Modulo_miembro/view/head/footer.php");
?>
