<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$course_id = $_POST["course_id"] ?? null;
$course_name = $_POST["course_name"] ?? null;
$course_desc = $_POST["course_desc"] ?? null;
$course_type = $_POST["course_type"] ?? null;
$course_category = $_POST["course_category"] ?? null;
$course_skills = $_POST["course_skills"] ?? null;

$courseDAO = new classCourseDAO();
$status = FALSE;
$status_msg = '';

// Update course details (name, desc, type, category)
$status = $courseDAO->updateCourse($course_id, $course_name, $course_desc, $course_type, $course_category);

// clear all skills from the course
if ($status){ 
    $status_msg = $status_msg . "Updated Course; ";
    $status = $courseDAO->clearSkillsFromCourse($course_id);
}
else {
    http_response_code(404);
    $status_msg += "Failed to update Course;";
}

// add skills back to the course
if ($status) {
    $status_msg = $status_msg . "Cleared skills from course; ";
    $added_skills = [];
    foreach ($course_skills as $skill_id) {
        array_push($added_skills, $skill_id); 
        $status = $courseDAO->addSkillToCourse($course_id, $skill_id);
        if ($status) {
            $status_msg = $status_msg . "Added skill with id " . $skill_id . " to course; ";
        }
        else {
            http_response_code(404);
            $status_msg = $status_msg . "Failed to add skill with id " . $skill_id . " to course; ";
        }
    }
}
else {
    http_response_code(404);
    $status_msg = $status_msg . "Failed to clear skills from course; ";
}

$result = [];
$result["status"] = $status_msg;

// create json string and send back to client
$jsonObj = json_encode($result);
echo $jsonObj;
?>
