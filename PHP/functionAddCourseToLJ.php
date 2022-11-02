<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$lj_list = $_POST["lj_list"] ?? null;
$course_id = $_POST["course_id"] ?? null;

$ljDAO = new classLearningJourneyDAO();
$status = FALSE;
$status_msg = '';
$result = [];

foreach ($lj_list as $lj_id) {
    // check lj course
    $exists = $ljDAO->checkIfCourseInLJ($lj_id, $course_id);
    if ($exists) {
        $status_msg = $status_msg . 'LJ with id ' . $lj_id . ' already has course; '; 
        continue;
    }
    $status = $ljDAO->addCourseToLJ($lj_id, $course_id);
    if ($status){
        $status_msg = $status_msg . 'Added Course to LJ with id ' . $lj_id . '; '; 
    }
    else {
        http_response_code(404);
        $status_msg = $status_msg . "Failed to add course to LJ with id ' . $lj_id . '; ";
    }    
}

$result["status"] = $status_msg;

// create json string and send back to client
$jsonObj = json_encode($result);
echo $jsonObj;
?>