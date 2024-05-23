<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con PHP y MySQL</title>
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
            // Conexión a la base de datos
            $conn = new mysqli("localhost", "root", "", "instituto");

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $editableId = null;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['eliminar'])) {
                    $id = $_POST['id'];
                    $sql = "DELETE FROM profesores WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                }

                if (isset($_POST['guardar'])) {
                    $id = $_POST['id'];
                    $nombres = $_POST['nombres'];
                    $apellidos = $_POST['apellidos'];
                    $especialidad = $_POST['especialidad'];
                    $sueldo = $_POST['sueldo'];

                    $sql = "UPDATE profesores SET nombres=?, apellidos=?, especialidad=?, sueldo=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssdi", $nombres, $apellidos, $especialidad, $sueldo, $id);
                    $stmt->execute();
                    $stmt->close();
                }

                if (isset($_POST['modificar'])) {
                    $editableId = $_POST['id'];
                }
            }

            $sql = "SELECT id, nombres, apellidos, especialidad, sueldo FROM profesores";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $isEditable = ($row['id'] == $editableId);
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
                    echo "<input type='submit' name='eliminar' value='Eliminar'>";
                    echo "</td>";
                    echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron resultados</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>



