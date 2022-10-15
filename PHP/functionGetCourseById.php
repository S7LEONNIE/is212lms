<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$course_id = $_POST["course_id"] ?? null;
$courseDAO = new classCourseDAO();

$courses = array();

$database = $courseDAO->getCourseById($course_id);

foreach ($database as $course) {
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

    $courses[] = $courseToArray;
}

$output = ["records" => $courses];

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>