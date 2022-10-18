<?php
require_once "common.php";

$courseDAO = new classCourseDAO();

$courses = array();

$database = $courseDAO->loadCoursesUnderManager();

foreach ($database as $course) {
    $course_id = $course->getCourse_Id();
    $course_name = $course->getCourse_name();
    $course_desc = $course->getCourse_desc();
    $course_status = $course->getCourse_status();
    $course_type = $course->getCourse_type();
    $course_category = $course->getCourse_category();
    // Insert checks here!

    $coursesToArray = [
        "course_id" => $course_id, 
        "course_name" => $course_name,
        "course_desc" => $course_desc,
        "course_status" => $course_status,
        "course_type" => $course_type,
        "course_category" => $course_category,
    ];

    $courses[] = $coursesToArray;
}

// $labels = ["Role ID", "Role Name", "Role Description"];

$output = ["records" => $courses];

// create json string and send back to client

$jsonObj = json_encode($output);
echo $jsonObj;
?>