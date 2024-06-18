<?php
require_once('../../controller/usernameControler.php');
    $obj = new usernameController();
    $obj->eliminar($_GET['id']);
?>

