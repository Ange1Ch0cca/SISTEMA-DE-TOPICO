<?php
include '../services/conexion.php'; // Incluir el archivo de conexión

// Obtener los datos enviados desde el formulario
$dni = $_POST['dni'];
$nombres = $_POST['nombres'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$programa_estudios = $_POST['programa_estudios'];
$semestre = $_POST['semestre'];

// Insertar los datos en la tabla pacientes
$sql = "INSERT INTO pacientes (dni, nombres, apellido_paterno, apellido_materno, programa_estudios, semestre) 
        VALUES ('$dni', '$nombres', '$apellido_paterno', '$apellido_materno', '$programa_estudios', '$semestre')";

if ($conn->query($sql) === TRUE) {
    // Redirigir a otra página después de un registro exitoso
    header("Location: ../view/pacientes.php"); // Cambia 'pagina_exito.php' por la página deseada
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close(); // Cerrar la conexión
?>
