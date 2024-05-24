<?php

include("../../config/Database.php");
include("../../config/Headers.php");
include_once("../../models/User.php");

$conn = new Database();
$db = $conn->getConnection();


$data = json_decode(file_get_contents('php://input'));

if ($data) {
    $user = new User($db);
    $user->name = $data->name;
    $user->lastname = $data->lastname;
    $user->age = $data->age;

    if (!$user->createUser()) {
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
                'id' => $user->id,
                'name' => $user->name,
                'lastname' => $user->lastname,
                'age' => $user->age
            )
        )
    );
} else {
    echo json_encode(array('message' => 'No data provided.'));
}
