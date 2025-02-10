<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "cas207";
$dbname = "login_db";

try {
    // Cambiar $host a $servername
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Configuración de PDO para mostrar excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mensaje de éxito

} catch (PDOException $e) {
    // Manejo de errores
    die("Error en la conexión: " . $e->getMessage());
}
?>
