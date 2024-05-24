<?php

include("../../config/Database.php");
include_once("../../models/User.php");
include("../../config/Headers.php");

$conn = new Database();
$db = $conn->getConnection();

$user = new User($db);

$result = $user->getAll();
$num = $result->rowCount();

if ($num > 0) {
    $users = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            'id' => $id,
            'name' => $name,
            'lastname' => $lastname,
            'age' => $age
        );

        array_push($users, $user_item);
    }

    echo json_encode($users);
} else {
    echo json_encode(array('message' => 'No users found.'));
}
