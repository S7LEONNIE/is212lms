<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$role_id = $_POST["role_id"] ?? null;

$roleDAO = new classRoleDAO();
$status = FALSE;

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$status = $roleDAO->deleteRole($role_id);

$result = [];

if ($status){
    $result["status"] = "Successful";
}
else {
    http_response_code(404);
    $result["status"] = "Failed";
}

// create json string and send back to client
$jsonObj = json_encode($result);
echo $jsonObj;
?>