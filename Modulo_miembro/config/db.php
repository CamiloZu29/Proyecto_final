<?php
class db {
    private $host = "localhost";
    private $dbname = "spartanos";
    private $user = "root"; // Corregido el nombre de usuario
    private $password = "";

    public function conexion() {
        try {
            $PDO = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password);
            return $PDO;
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}

?>