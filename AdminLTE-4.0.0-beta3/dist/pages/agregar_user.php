<?php
require '../../../conectar.php';

// Verificar si los datos han sido enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Validar si los campos no están vacíos
    if (!empty($username) && !empty($password)) {
        try {
            // Encriptar la contraseña antes de almacenarla
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Preparar la consulta para insertar el usuario
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $password_hash])) {
                // Redirigir a index2.php después de agregar el usuario
                header("Location: index2.php");
                exit; // Asegura que el script no continúe después de la redirección
            } else {
                echo "Error al registrar el usuario. Inténtalo de nuevo.";
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            error_log("Error en la base de datos: " . $e->getMessage());
            echo "Ocurrió un problema al registrar el usuario. Intenta más tarde.";
        }
    } else {
        echo "Por favor, ingresa un nombre de usuario y una contraseña.";
    }
}
?>
