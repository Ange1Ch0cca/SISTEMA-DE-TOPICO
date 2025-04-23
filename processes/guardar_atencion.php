<?php
// Conexión a la base de datos
require_once '../services/conexion.php';

// Verificar si los datos han sido enviados correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos enviados
    $dni = isset($_POST['dni']) ? $_POST['dni'] : null;
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : null;
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
    $programa_estudios = isset($_POST['programa_estudios']) ? $_POST['programa_estudios'] : null;
    $semestre = isset($_POST['semestre']) ? $_POST['semestre'] : null;
    $procedimiento = isset($_POST['procedimiento']) ? $_POST['procedimiento'] : null;
    $encargado = isset($_POST['encargado']) ? $_POST['encargado'] : null;
    $fecha_atencion = isset($_POST['fecha_atencion']) ? $_POST['fecha_atencion'] : null;

    // Validar si los campos necesarios están presentes
    if (!$dni || !$nombres || !$apellidos || !$programa_estudios || !$semestre || !$procedimiento || !$encargado || !$fecha_atencion) {
        echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
        exit;
    }

    // Insertar los datos de la atención
    try {
        $sql = "INSERT INTO atenciones (dni, nombres, apellidos, fecha_atencion, programa_estudios, semestre, procedimiento, encargado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssss', $dni, $nombres, $apellidos, $fecha_atencion, $programa_estudios, $semestre, $procedimiento, $encargado);
        $stmt->execute();

        // Obtener el ID de la atención insertada
        $id_atencion = $stmt->insert_id;

        // Responder con éxito y el ID de la atención
        echo json_encode(['success' => true, 'id_atencion' => $id_atencion]);

    } catch (Exception $e) {
        // Manejo de errores de la base de datos
        echo json_encode(['success' => false, 'message' => 'Error al procesar los datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido']);
}
?>
