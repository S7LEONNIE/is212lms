<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$lj_id = $_POST["lj_id"] ?? null;
$course_id = $_POST["course_id"] ?? null;

$ljDAO = new classLearningJourneyDAO();
$status = FALSE;

// check lj course
// actually the check should be on the front end instead/as well

$status = $ljDAO->addCourseToLJ($lj_id, $course_id);

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