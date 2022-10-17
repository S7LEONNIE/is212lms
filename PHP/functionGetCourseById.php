<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$course_id = $_POST["course_id"] ?? null;
$courseDAO = new classCourseDAO();

$courses = array();

$course = $courseDAO->getCourseById($course_id);

if ($course) {
    $course_id = $course->getCourse_Id();
    $course_name = $course->getCourse_name();
    $course_desc = $course->getCourse_desc();
    $course_status = $course->getCourse_status();
    $course_type = $course->getCourse_type();
    $course_category = $course->getCourse_category();
    
        // Insert checks here!
    
    $courseToArray = [
        "course_id" => $course_id, 
        "course_name" => $course_name,
        "course_desc" => $course_desc,
        "course_status" => $course_status, 
        "course_type" => $course_type, 
        "course_category" => $course_category
    ];
    
    $output = ["records" => $courseToArray];
}

else {
    http_response_code(404);
    $output = ["status" => "Could not find course with id " . $course_id];
}

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>