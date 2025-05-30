<?php
// Conexión a la base de datos
require_once '../services/conexion.php';

// Verificar si los datos han sido enviados correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos
    $id_atencion = isset($_POST['id_atencion']) ? $_POST['id_atencion'] : null;
    $insumos = isset($_POST['insumos']) ? json_decode($_POST['insumos'], true) : [];

    // Validar si el id de atención y los insumos están presentes
    if (!$id_atencion || empty($insumos)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
        exit;
    }

    // Preparar la consulta para insertar los insumos
    $sql = "INSERT INTO atencion_insumos (atencion_id, codigo, insumo_medico, cantidad) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Verificar si la consulta se preparó correctamente
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
        exit;
    }

    // Insertar cada insumo
    foreach ($insumos as $insumo) {
        $codigo = $insumo['id']; // El id del medicamento es el código
        $insumo_medico = $insumo['nombre']; // El nombre del medicamento
        $cantidad = $insumo['cantidad']; // La cantidad

        // Vincular y ejecutar la consulta
        $stmt->bind_param('isss', $id_atencion, $codigo, $insumo_medico, $cantidad);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error al insertar los insumos']);
            exit;
        }
    }

    // Redirigir a la página de impresión
    echo json_encode(['success' => true, 'redirect_url' => '../print/print-atencion.php']);
} else {
    // Si la solicitud no es POST, devolver un error
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
