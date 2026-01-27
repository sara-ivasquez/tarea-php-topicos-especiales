<?php
/**
 * Procesa y guarda los datos del formulario en la base de datos
 */

require_once '../config/conexion.php';

// Inicializar variables de respuesta
$respuesta = [
    'exito' => false,
    'mensaje' => ''
];

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Obtener y sanitizar el nombre ingresado
    $nombre_usuario = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    
    // Validar que el nombre no esté vacío
    if (empty($nombre_usuario)) {
        $respuesta['mensaje'] = 'El nombre no puede estar vacío';
    } 
    // Validar longitud del nombre
    elseif (strlen($nombre_usuario) > 100) {
        $respuesta['mensaje'] = 'El nombre no puede exceder los 100 caracteres';
    }
    // Si pasa las validaciones, guardar en la base de datos
    else {
        $conexion = obtenerConexion();
        
        if ($conexion !== null) {
            try {
                // Preparar la consulta SQL con prepared statement
                $consulta = "INSERT INTO usuarios (nombre) VALUES (:nombre)";
                $stmt = $conexion->prepare($consulta);
                
                // Vincular parámetros y ejecutar
                $stmt->bindParam(':nombre', $nombre_usuario, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    $respuesta['exito'] = true;
                    $respuesta['mensaje'] = 'Usuario guardado exitosamente';
                } else {
                    $respuesta['mensaje'] = 'Error al guardar el usuario';
                }
                
            } catch (PDOException $error) {
                error_log("Error en la consulta: " . $error->getMessage());
                $respuesta['mensaje'] = 'Error al procesar la solicitud';
            }
        } else {
            $respuesta['mensaje'] = 'Error de conexión con la base de datos';
        }
    }
} else {
    $respuesta['mensaje'] = 'Método de solicitud no válido';
}

// Retornar respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>
