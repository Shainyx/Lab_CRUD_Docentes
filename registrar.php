<?php

    include 'conexion.php';

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $especialidad = $_POST['especialidad'];
        $sueldo = $_POST['sueldo'];

        $conexion = conectar();

        $sql = "INSERT INTO profesores (nombres, apellidos, especialidad, sueldo) VALUES ('$nombre', '$apellido', '$especialidad', $sueldo)";

        if($conexion->query($sql) === TRUE){
            #header("Location: form_registrar.html");
            header("Location: form_datos.php");
            #echo "REGISTRADO CORRECTAMENTE";
            exit();
        }else{
            echo "ERROR AL REGISTRAR AL DOCENTE: " . $conexion->error;
        }

        $conexion->close();
    }

?>