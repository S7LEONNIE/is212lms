<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$lj_id = $_POST["lj_id"] ?? null;

$ljDAO = new classLearningJourneyDAO();
$status = FALSE;
$status_msg = '';
$result = [];

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$status = $ljDAO->dropAllCoursesFromLJ($lj_id);

$result = [];

if ($status){
    $result["status"] = "Successful";
}
else {
    http_response_code(404);
    $result["status"] = "Failed";
}

$result["status"] = $status_msg;

// create json string and send back to client
$jsonObj = json_encode($result);
echo $jsonObj;
?>