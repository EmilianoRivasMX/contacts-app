<?php 

require 'connection.php';

$id = $_GET['id'];

// Verifica si existe un contacto asociado con el id recibido
$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
$stmt->execute([":id" => $id]);

if ($stmt->rowCount() == 0) {
    http_response_code(404);
    echo "HTTP 404 NOT FOUND";
    return;
}

// Elimina el contacto
$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

header("Location: home.php");