<?php
require 'conectar.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    try {
        // Verificar si el usuario existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verificar la contraseña
            if (password_verify($password, $user["password"])) {
                // Iniciar sesión y redirigir al dashboard de AdminLTE
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                header("Location: AdminLTE-4.0.0-beta3/dist/pages/index2.php"); // Cambia la ruta si es necesario
                exit; // Detener ejecución
            } else {
                $error_message = "Contraseña incorrecta.";
            }
        } else {
            $error_message = "El usuario no existe.";
        }
        
    } catch (PDOException $e) {
        // Log de error y mensaje genérico
        error_log("Error en la base de datos: " . $e->getMessage());
        $error_message = "Ocurrió un problema. Intenta más tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #9c27b0, #e91e63);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 20px;
        }

        .header {
            background: linear-gradient(45deg, #ff4081, #9c27b0);
            padding: 20px;
            color: white;
            font-size: 1.5em;
            border-radius: 10px 10px 0 0;
        }

        .form input[type="text"],
        .form input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form button {
            width: 90%;
            padding: 10px;
            background: #2196f3;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        .form button:hover {
            background: #1976d2;
        }

        .form p {
            margin-top: 20px;
            font-size: 0.9em;
        }

        .form a {
            color: #2196f3;
            text-decoration: none;
        }

        .form a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p>Iniciar Sesión</p>
        </div>
        <form class="form" method="POST" action="">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
            <p>¿No tienes una cuenta? <a href="registrar.php">Regístrate aquí</a></p>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
