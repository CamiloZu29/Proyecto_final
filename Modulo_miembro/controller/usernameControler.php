<?php
require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/config/db.php");

class usernameController
{
    private $model;
    private $conexion;

    public function __construct()
    {
        require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/model/usernameModel.php");
        $this->model = new usernameModel();

        // Inicializar la conexión a la base de datos utilizando la clase db
        $db = new db();
        $this->conexion = $db->conexion();
        if ($this->conexion instanceof PDO) {
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } else {
            // Manejar el error de conexión
            echo "Error de conexión: " . $this->conexion;
            exit;
        }
    }

    public function guardar($doc_identidad, $nombre, $apellido, $fecha_nacimiento, $foto, $altura, $peso, $pie_dominante, $posicion, $contacto_acudiente, $descripcion, $id_user, $direccion, $eps, $estado_eps)
    {
        // Calcular la edad a partir de la fecha de nacimiento
        $fecha_actual = new DateTime();
        $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nacimiento_dt)->y;
    
        // Obtener la categoría según la edad
        $categoria = $this->calcularCategoria($edad);
    
        // Si no se puede calcular la categoría, retorna false
        if ($categoria === false) {
            echo "No se encontró ninguna categoría para la edad del usuario.";
            return false; // O maneja el error de alguna otra manera
        }
    
        $cat_miembro = $categoria['id_categoria']; // Asegúrate de usar id_categoria
    
        // Procesar la imagen si se proporciona
        $ruta_imagen = $this->procesarImagen($foto, $nombre . '_' . $apellido);
    
        // Convertir fecha de nacimiento a string
        $fecha_nacimiento_str = $fecha_nacimiento_dt->format('Y-m-d');
    
        // Insertar en la base de datos
        $id = $this->model->insertar($doc_identidad, $nombre, $apellido, $fecha_nacimiento_str, $ruta_imagen, $altura, $peso, $pie_dominante, $posicion, $contacto_acudiente, $descripcion, $cat_miembro, $id_user, $direccion, $eps, $estado_eps);
    
        // Redireccionar según el resultado
        if ($id === false) {
            header("Location:create.php");
        } else {
            header("Location:mostrar.php?id=".$doc_identidad);
        }
    }
    


    private function calcularCategoria($edad)
{
    $query = "SELECT id_categoria, nombre_categoria FROM categorias WHERE edad_min <= :edad AND edad_max >= :edad";
    $stmt = $this->conexion->prepare($query);
    $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt->execute();
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    return $categoria ? $categoria : false;
}

public function mostrar($doc_identidad)
{
    $usuario = $this->model->mostrar($doc_identidad);
    if ($usuario !== false) {
        // Calcular la edad
        $fecha_nacimiento = new DateTime($usuario['fecha_nacimiento']);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha_nacimiento)->y;
        
        // Obtener la categoría según la edad
        $categoria = $this->calcularCategoria($edad);
        if ($categoria !== false) {
            $usuario['categoria'] = $categoria['nombre_categoria'];
        } else {
            $usuario['categoria'] = 'No definida';
        }

        return $usuario;
    } else {
        header("Location:index.php");
    }
}

    public function index()
    {
        return ($this->model->index()) ? $this->model->index() : false;
    }
    public function Modificar($doc_identidad, $nombre, $apellido, $fecha_nacimiento, $foto, $altura, $peso, $pie_dominante, $posicion, $contacto_acudiente, $descripcion, $cat_miembro, $id_user, $direccion, $eps, $estado_eps)
    {
        // Calcular la edad a partir de la fecha de nacimiento
        $fecha_actual = new DateTime();
        $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nacimiento_dt)->y;
    
        // Obtener la categoría según la edad
        $categoria = $this->calcularCategoria($edad);
    
        // Si no se puede calcular la categoría, maneja el error adecuadamente
        if ($categoria === false) {
            echo "No se encontró ninguna categoría para la edad del usuario.";
            return false; // O maneja el error de alguna otra manera
        }
    
        $cat_miembro = $categoria['id_categoria']; // Asegúrate de usar el campo correcto para id_categoria
    
        // Procesar la imagen si se proporciona (opcional)
        $ruta_imagen = '';
        if (!empty($foto)) {
            $ruta_imagen = $this->procesarImagen($foto, $nombre . '_' . $apellido);
        }
    
        // Convertir fecha de nacimiento a string
        $fecha_nacimiento_str = $fecha_nacimiento_dt->format('Y-m-d');
    
        // Llamar al método Modificar en el modelo para actualizar los datos del miembro
        $resultado = $this->model->Modificar(
            $doc_identidad, $nombre, $apellido, $fecha_nacimiento_str, 
            $ruta_imagen, $altura, $peso, $pie_dominante, $posicion, 
            $contacto_acudiente, $descripcion, $cat_miembro, $id_user, 
            $direccion, $eps, $estado_eps
        );
    
        // Verificar el resultado de la operación y redirigir según corresponda
        if ($resultado !== false) {
            // Redirigir a mostrar.php con el ID del miembro actualizado
            header("Location: mostrar.php?id=" . $doc_identidad);
        } else {
            // Redirigir a index.php en caso de error
            header("Location: index.php");
        }
    }
    

    public function eliminar($doc_identidad)
    {
        return ($this->model->eliminar($doc_identidad)) ? header("Location:index.php") : header("Location:Mostrar.php?id=".$doc_identidad);
    }

    private function procesarImagen($foto, $nombreUsuario)
    {
        if (isset($foto['tmp_name']) && !empty($foto['tmp_name'])) {
            list($ancho, $alto) = getimagesize($foto['tmp_name']);
            $nuevoAncho = 500;
            $nuevoAlto = 500;

            // Crear el directorio donde se guardará la imagen
            $baseDirectorio = "/view/imagenes/usuarios/";
            $directorio = $baseDirectorio . $nombreUsuario;
            if (!file_exists($baseDirectorio)) {
                mkdir($baseDirectorio, 0755, true); // Crear directorio base si no existe
            }
            if (!file_exists($directorio)) {
                mkdir($directorio, 0755, true);
            }

            // Generar un nombre aleatorio para la imagen
            $aleatorio = mt_rand(100, 999);
            $ruta = "";

            // Procesar la imagen dependiendo de su tipo
            if ($foto['type'] == "image/jpeg") {
                $ruta = $directorio . "/" . $aleatorio . ".jpg";
                $origen = imagecreatefromjpeg($foto['tmp_name']);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                imagejpeg($destino, $ruta);
            } elseif ($foto['type'] == "image/png") {
                $ruta = $directorio . "/" . $aleatorio . ".png";
                $origen = imagecreatefrompng($foto['tmp_name']);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                imagepng($destino, $ruta);
            }

            return $ruta;
        }

        return null;
    }
}
?>
<!--//tengo que llamar a "cat_miembro=categoria" para que me lo muestre automaticamente de la tabla "categoria" y de igual manera el id de usuario //-->