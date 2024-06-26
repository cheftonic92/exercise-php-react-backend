<?php

include("../../config/Database.php");
include_once("../../models/User.php");
include("../../config/Headers.php");

$conn = new Database();
$db = $conn->getConnection();

// Verifica si se proporcionó un ID válido
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(array('message' => 'ID not provided.'));
    exit();
}

$user = new User($db);

$id = $_GET['id'];

if (!$user->deleteUser($id)) {
    http_response_code(500);
    echo json_encode(
        array(
            'message' => 'Error deleting user.'
        )
    );
    return;
}

echo json_encode(
    array(
        'message' => 'User deleted successfully.'
    )
);
