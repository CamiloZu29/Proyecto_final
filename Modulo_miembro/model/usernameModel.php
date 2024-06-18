<!--//se almacena la conexion que nos esta retornando este-->
<?php
class usernameModel {
    private $PDO;

    public function __construct() {
        require_once("c://xampp/htdocs/proyecto_completo/Proyecto_final/Modulo_miembro/config/db.php");
        $con = new db();
        $this->PDO = $con->conexion();
    }

    public function insertar($doc_identidad, $nombre, $apellido, $fecha_nacimiento, $foto, $altura, $peso, $pie_dominante, $posicion, $contacto_acudiente, $descripcion, $cat_miembro, $id_user, $direccion, $eps, $estado_eps) {
        $stament = $this->PDO->prepare("INSERT INTO miembro (doc_identidad, nombre, apellido, fecha_nacimiento, foto, altura, peso, pie_dominante, posicion, contacto_acudiente, descripcion, cat_miembro, id_user, direccion, eps, estado_eps) VALUES (:doc_identidad, :nombre, :apellido, :fecha_nacimiento, :foto, :altura, :peso, :pie_dominante, :posicion, :contacto_acudiente, :descripcion, :cat_miembro, :id_user, :direccion, :eps, :estado_eps)");
        $stament->bindParam(":doc_identidad", $doc_identidad);
        $stament->bindParam(":nombre", $nombre);
        $stament->bindParam(":apellido", $apellido);
        $stament->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $stament->bindParam(":foto", $foto);
        $stament->bindParam(":altura", $altura);
        $stament->bindParam(":peso", $peso);
        $stament->bindParam(":pie_dominante", $pie_dominante);
        $stament->bindParam(":posicion", $posicion);
        $stament->bindParam(":contacto_acudiente", $contacto_acudiente);
        $stament->bindParam(":descripcion", $descripcion);
        $stament->bindParam(":cat_miembro", $cat_miembro); // Asegurarse de pasar el id_categoria
        $stament->bindParam(":id_user", $id_user);
        $stament->bindParam(":direccion", $direccion);
        $stament->bindParam(":eps", $eps);
        $stament->bindParam(":estado_eps", $estado_eps);
        
        return ($stament->execute()) ? $this->PDO->lastInsertId() : false;
    }
    public function calcularCategoria($edad) {
        // Consulta la base de datos para obtener la categoría correspondiente
        $query = "SELECT id_categoria FROM categorias WHERE edad_min <= :edad AND edad_max >= :edad LIMIT 1";
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
        $stmt->execute();
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $categoria ? $categoria : false;
    }
    
    
    public function Mostrar($doc_identidad) {
        $statement = $this->PDO->prepare("SELECT * FROM miembro WHERE doc_identidad = :doc_identidad limit 1");
        $statement->bindParam(":doc_identidad", $doc_identidad);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

    public function index() {
        $statement = $this->PDO->prepare("SELECT * FROM miembro");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    public function Modificar($doc_identidad, $nombre, $apellido, $fecha_nacimiento, $foto, $altura, $peso, $pie_dominante, $posicion, $contacto_acudiente, $descripcion, $cat_miembro, $id_user, $direccion, $eps, $estado_eps) {
        $statement = $this->PDO->prepare("
            UPDATE miembro 
            SET 
                nombre = :nombre, 
                apellido = :apellido, 
                fecha_nacimiento = :fecha_nacimiento, 
                foto = :foto, 
                altura = :altura, 
                peso = :peso, 
                pie_dominante = :pie_dominante, 
                posicion = :posicion, 
                contacto_acudiente = :contacto_acudiente, 
                descripcion = :descripcion, 
                cat_miembro = :cat_miembro, 
                id_user = :id_user,
                direccion = :direccion,
                eps = :eps,
                estado_eps = :estado_eps
            WHERE doc_identidad = :doc_identidad
        ");
        
        $statement->bindParam(":doc_identidad", $doc_identidad);
        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":apellido", $apellido);
        $statement->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $statement->bindParam(":foto", $foto);
        $statement->bindParam(":altura", $altura);
        $statement->bindParam(":peso", $peso);
        $statement->bindParam(":pie_dominante", $pie_dominante);
        $statement->bindParam(":posicion", $posicion);
        $statement->bindParam(":contacto_acudiente", $contacto_acudiente);
        $statement->bindParam(":descripcion", $descripcion);
        $statement->bindParam(":cat_miembro", $cat_miembro); // Asegurarse de pasar el id_categoria
        $statement->bindParam(":id_user", $id_user);
        $statement->bindParam(":direccion", $direccion);
        $statement->bindParam(":eps", $eps);
        $statement->bindParam(":estado_eps", $estado_eps);

        if ($statement->execute()) {
            return $doc_identidad;
        } else {
            $errorInfo = $statement->errorInfo();
            error_log("SQL Error: " . print_r($errorInfo, true));
            return false;
        }
    }
    public function eliminar($doc_identidad) {
        $statement = $this->PDO->prepare("DELETE FROM miembro WHERE doc_identidad = :doc_identidad");
        $statement->bindParam(":doc_identidad", $doc_identidad);
        return ($statement->execute()) ? true : false;
    }
}
?>
