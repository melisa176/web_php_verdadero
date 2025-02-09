<?php
// Conexión a la base de datos
require_once '../../../conectar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Redirigir al listado de usuarios
    header("Location: index2.php");
    exit();
} else {
    die("ID de usuario no especificado");
}
