<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$course_id = $_POST["course_id"] ?? null;
$skillDAO = new classSkillDAO();

$skills = array();

$database = $skillDAO->loadSkillsByCourseId($course_id);

foreach ($database as $skill) {
    $skill_id = $skill->getSkill_Id();
    $skill_name = $skill->getSkill_Name();
    $skill_desc = $skill->getSkill_Desc();

    // Insert checks here!

    $skillToArray = [
        "skill_id" => $skill_id, 
        "skill_name" => $skill_name,
        "skill_desc" => $skill_desc
    ];

    $skills[] = $skillToArray;
}

$output = ["records" => $skills];

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>