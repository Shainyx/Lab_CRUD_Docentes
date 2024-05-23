<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Docentes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Especialidad</th>
                <th>Sueldo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once 'mostrar.php';
            include_once 'conexion.php';
            
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
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Error al actualizar el registro: " . $stmt->error;
                    }

                    $stmt->close();
                }

                if (isset($_POST['eliminar'])) {
                    $id = $_POST['id'];
                    $sql = "DELETE FROM profesores WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);

                    if ($stmt->execute()) {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Error al eliminar el registro: " . $stmt->error;
                    }

                    $stmt->close();
                }
            }

            $consulta = registros();
            $editableId = isset($_POST['modificar']) ? $_POST['id'] : null;

            if ($consulta->num_rows > 0) {
                while($row = $consulta->fetch_assoc()) {
                    $isEditable = $row["id"] == $editableId;
                    echo "<tr>";
                    echo "<form method='POST' action=''>";
                    echo "<td>" . $row["id"] . "</td>";
                    if ($isEditable) {
                        echo "<td><input type='text' name='nombres' value='" . $row["nombres"] . "'></td>";
                        echo "<td><input type='text' name='apellidos' value='" . $row["apellidos"] . "'></td>";
                        echo "<td><input type='text' name='especialidad' value='" . $row["especialidad"] . "'></td>";
                        echo "<td><input type='text' name='sueldo' value='" . $row["sueldo"] . "'></td>";
                    } else {
                        echo "<td>" . $row["nombres"] . "</td>";
                        echo "<td>" . $row["apellidos"] . "</td>";
                        echo "<td>" . $row["especialidad"] . "</td>";
                        echo "<td>" . $row["sueldo"] . "</td>";
                    }
                    echo "<td>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    if ($isEditable) {
                        echo "<input type='submit' name='guardar' value='Guardar'>";
                    } else {
                        echo "<input type='submit' name='modificar' value='Modificar'>";
                    }
                    echo "</form>";
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='submit' name='eliminar' value='Eliminar'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>






