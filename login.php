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

         /* Reset CSS */
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;

        }
       
        /* HEADER */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #0d0155;
            padding: 20px 50px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: background 0.3s ease;
        }

             /* BOTÓN CTA */
             .cta-button {
            display: inline-block;
            background: #F59E0B;
            color: white;
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 40px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .cta-button:hover {
            background: #D97706;
            transform: scale(1.05);
        }
        

        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        footer {
            background: #0d0155;
            color: white;
            padding: 20px;
            text-align: center;
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
            margin-bottom: 10px;
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
                <p>Iniciar Sesión</p>
            </div>
            <form class="form" method="POST" action="">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required autocomplete="new-password">
                <button type="submit">Iniciar Sesión</button>
                <p>¿No tienes una cuenta? <a href="registrar.php">Regístrate aquí</a></p>
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
