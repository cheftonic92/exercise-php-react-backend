<?php

include("../../config/Database.php");
include_once("../../models/User.php");
include("../../config/Headers.php");

$conn = new Database();
$db = $conn->getConnection();

$user = new User($db);

if ($user->deleteAll()) {
    echo json_encode(
        array(
            'message' => 'All users deleted successfully.'
        )
    );
} else {
    http_response_code(500);
    echo json_encode(
        array(
            'message' => 'Error deleting all users.'
        )
    );
}
