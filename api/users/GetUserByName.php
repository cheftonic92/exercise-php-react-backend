<?php


include("../../config/Database.php");
include("../../config/Headers.php");
include_once("../../models/User.php");




// Instanciar la base de datos y el objeto de usuario
$conn = new Database();
$db = $conn->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || empty($data->name)) {
    http_response_code(400);
    echo json_encode(array("message" => "Name is required"));
    exit();
}

$user = new User($db);

// Obtener usuario por nombre
$result = $user->getUserByName($data->name);

$num = $result->rowCount();

if ($num > 0) {
    $users_arr = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            "id" => $id,
            "name" => $name,
            "lastname" => $lastname,
            "age" => $age
        );
        array_push($users_arr, $user_item);
    }
    http_response_code(200);
    echo json_encode($users_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No users found."));
}
