<?php

require 'conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    try {
        // Preparar la consulta para insertar el usuario
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $password])) {
            // Redirigir al login si el registro es exitoso
            header("Location: login.php");
            exit; // Asegura que el script no continúe después de la redirección
        } else {
            $error_message = "Error al registrar usuario. Inténtalo de nuevo.";
        }
    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
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
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="hero.css">
    <style>

         /* Reset CSS */
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
                       
            display: flex;
            flex-direction: column;

        }
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(150deg, #551ff8, #6ac1fc);         
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.4);
            position: relative;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            position: relative;
            animation: fadeIn 1.5s ease-out;
        }
        .container {
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            
        }

        .header {
            background: linear-gradient(45deg, #ff4081, #9c27b0);
            padding: 20px;
            color: white;
            font-size: 1.5em;
        }

        .header img {
            width: 50px;
            height:50px;
            margin-top: 0;
        }

      

        .form {
            padding: 20px;
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

<div id="header"></div>
    <script>
        fetch("header.html")
            .then(response => response.text())
            .then(data => document.getElementById("header").innerHTML = data);
    </script>


    <div class="hero">
        <div class="container">
            <div class="header">
                <img src="https://img.icons8.com/ios-filled/50/ffffff/lock.png" alt="lock-icon">
                <p>Regístrate ahora</p>
            </div>
            <form class="form" method="POST" action="">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required autocomplete="new-password">
                <button type="submit">Registrar</button>
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                <?php if (!empty($error_message)): ?>
                    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Fullstack - Todos los derechos reservados</p>
    </footer>
</body>
</html>
