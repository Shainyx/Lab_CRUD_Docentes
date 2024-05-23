<?php
include_once 'conexion.php';

function eliminado() {
    global $conn; // Aseguramos acceso a la variable $conn

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['eliminar'])) {
            $id = $_POST['id'];
            $sql = "DELETE FROM profesores WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: form_datos.php");
                exit();
            } else {
                echo "Error al eliminar el registro: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

eliminado();
?>
