<?php
require_once "common.php";

$roleDAO = new classCustomizedSkillsAndCoursesDAO();

$roles = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $roleDAO->loadSkillsAndCourse();

foreach ($database as $role) {
    $skill_id = $role->getSkill_id();
    $skill_name = $role->getSkill_name();
    $skill_desc = $role->getSkill_desc();
    $course_name = $role->getCourse_name();
    $course_type = $role->getCourse_type();
    $course_desc = $role->getCourse_desc();
    // Insert checks here!

    $roleToArray = [
        "skill_id" => $skill_id, 
        "skill_name" => $skill_name,
        "skill_desc" => $skill_desc,
        "course_name" => $course_name,
        "course_type" => $course_type,
        "course_desc" => $course_desc,
    ];

    $roles[] = $roleToArray;
}

// $labels = ["Role ID", "Role Name", "Role Description"];

$output = ["records" => $roles];

// create json string and send back to client

$jsonObj = json_encode($output);
echo $jsonObj;
?>