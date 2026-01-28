<?php
/**
 * Archivo de configuración de conexión a la base de datos
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_usuarios');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/** 
 * Establece conexión con la base de datos usando PDO
 * @return PDO|null Objeto PDO si la conexión es exitosa, null en caso de error
 */
function obtenerConexion() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        
        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $conexion = new PDO($dsn, DB_USER, DB_PASS, $opciones);
        return $conexion;
        
    } catch (PDOException $error) {
        error_log("Error de conexión: " . $error->getMessage());
        return null;
    }
}
?>
