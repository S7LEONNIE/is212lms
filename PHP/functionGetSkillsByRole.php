<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$role_id = $_POST["roleId"] ?? null;
$skillDAO = new classSkillDAO();

$skills = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $skillDAO->loadSkillsByRoleId($role_id);

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