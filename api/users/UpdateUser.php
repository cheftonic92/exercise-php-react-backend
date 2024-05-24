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

$data = json_decode(file_get_contents('php://input'));

if ($data) {
    $user->name = $data->name;
    $user->lastname = $data->lastname;
    $user->age = $data->age;

    if (!$user->updateUser($id)) {
        http_response_code(500);
        echo json_encode(
            array(
                'message' => 'Error al añadir usuario.'
            )
        );
        return;
    }

    echo json_encode(
        array(
            'user' => array(
                'id' => $id,
                'name' => $user->name,
                'lastname' => $user->lastname,
                'age' => $user->age
            )
        )
    );
} else {
    echo json_encode(array('message' => 'No data provided.'));
}
