<?php
// Conexión a la base de datos
require_once '../../../conectar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del usuario
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no existe el usuario
    if (!$user) {
        die("Usuario no encontrado");
    }
} else {
    die("ID de usuario no especificado");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Si la contraseña está vacía, no la actualices
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Si no se ha proporcionado una nueva contraseña, mantén la original
        $password = $user['password'];
    }

    // Actualizar el usuario en la base de datos
    $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
    $stmt->execute(['username' => $username, 'password' => $password, 'id' => $id]);

    // Redirigir al listado de usuarios
    header("Location: index2.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Editar Usuario</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Deja vacío para mantener la actual">
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
</body>
</html>
