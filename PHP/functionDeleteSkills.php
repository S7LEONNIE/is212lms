<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$skill_id = $_POST["skill_id"] ?? null;

$roleDAO = new classSkillDAO();
$status = FALSE;

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$status = $roleDAO->deleteSkill($skill_id);

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