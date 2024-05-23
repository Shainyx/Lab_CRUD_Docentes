<?php
include_once 'conexion.php';

function registros() {
    global $conn; // Aseguramos acceso a la variable $conn
    $sql = "SELECT * FROM profesores";
    $query = mysqli_query($conn, $sql);
    return $query;
}
?>
