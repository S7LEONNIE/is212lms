<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$lj_id = $_POST["lj_id"] ?? null;
$staff_id = $_POST["staff_id"] ?? null;

$ljDAO = new classLearningJourneyDAO();
$status = FALSE;

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$status = $ljDAO->removeLearningJourney($lj_id, $staff_id);

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