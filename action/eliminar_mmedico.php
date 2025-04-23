<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID válido a través de la URL
if (isset($_GET['id'])) {
    $mmedicamento_id = $_GET['id'];  // ID del mmedicamento a eliminar

    // Prepara la consulta para verificar si existe el mmedicamento con ese ID
    $stmt = $conn->prepare("SELECT * FROM mmedicamentos WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $mmedicamento_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el mmedicamento
    if ($result->num_rows > 0) {
        // Elimina el mmedicamento de la base de datos
        $stmt = $conn->prepare("DELETE FROM mmedicamentos WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $mmedicamento_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de mmedicamentos
            header("Location: ../view/almacen_mmedico.php?message=El mmedicamento ha sido eliminado exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            header("Location: ../view/almacen_mmedico.php?error=Error al eliminar el mmedicamento.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró un mmedicamento con el ID proporcionado
        header("Location: ../view/almacen_mmedico.php?error=ID de mmedicamento no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    header("Location: ../view/almacen_mmedico.php?error=ID no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
