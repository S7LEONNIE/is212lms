<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$lj_name = $_POST["lj_name"] ?? null;

$ljDAO = new classLearningJourneyDAO();
$status = FALSE;

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$status = $ljDAO->removeLearningJourney($lj_name);

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