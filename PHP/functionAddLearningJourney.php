<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$learningjourney_name = $_POST["learningjourney_name"] ?? null;
// can do $_POST here too
if ($_GET["staff_id"] == null) 
{
    $staff_id = null;
}
if ($_GET["role_id"] == null)
{
    $role_id = null;
}


$ljDAO = new classLearningJourneyDAO();
$status = FALSE;

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$status = $ljDAO->addLearningJourney($learningjourney_name, $staff_id, $role_id);

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