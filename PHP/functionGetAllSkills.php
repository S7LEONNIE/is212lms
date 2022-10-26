<?php
require_once "common.php";

$skillDAO = new classSkillDAO();

$skills = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $skillDAO->loadAll();

foreach ($database as $skill) {
    $skill_id = $skill->getSkill_Id();
    $skill_name = $skill->getSkill_Name();
    $skill_desc = $skill->getSkill_Desc();
    $is_active = $skill->get_isActive();

    // Insert checks here!

    $skillToArray = [
        "skill_id" => $skill_id, 
        "skill_name" => $skill_name,
        "skill_desc" => $skill_desc,
        "is_active" => $is_active,
    ];

    $skills[] = $skillToArray;
}

// $labels = ["Skill ID", "Skill Name", "Skill Description"];

$output = ["records" => $skills];

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>