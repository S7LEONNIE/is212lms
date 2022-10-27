<?php
require_once "common.php";

$roleDAO = new classLearningJourneyDAO();

$roles = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $roleDAO->loadAll();

foreach ($database as $role) {
    $course_id = $role->getcourse_Id();
    $course_name = $role->getcourse_Name();

    // Insert checks here!

    $roleToArray = [
        "course_id" => $course_id, 
        "course_name" => $course_name
    ];

    $roles[] = $roleToArray;
}

// $labels = ["Role ID", "Role Name", "Role Description"];

$output = ["records" => $roles];

// create json string and send back to client

$jsonObj = json_encode($output);
echo $jsonObj;
?>