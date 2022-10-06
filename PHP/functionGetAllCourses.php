<?php
require_once "common.php";

$courseDAO = new classCourseDAO();

$courses = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $courseDAO->loadAll();

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

// $labels = ["Course ID", "Course Name", "Course Description"];

$output = ["records" => $courses];

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>