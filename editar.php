<?php
include_once 'conexion.php';

function editar() {
    global $conn; // Aseguramos acceso a la variable $conn

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['guardar'])) {
            $id = $_POST['id'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $especialidad = $_POST['especialidad'];
            $sueldo = $_POST['sueldo'];

            $sql = "UPDATE profesores SET nombres=?, apellidos=?, especialidad=?, sueldo=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdi", $nombres, $apellidos, $especialidad, $sueldo, $id);

            if ($stmt->execute()) {
                header("Location: form_datos.php");
                exit();
            } else {
                echo "Error al actualizar el registro: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Llamar a la función para manejar la solicitud
editar();
?>

