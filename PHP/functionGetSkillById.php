<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$skill_id = $_POST["skill_id"] ?? null;
$skillDAO = new classskillDAO();

$skill = $skillDAO->getSkillById($skill_id);

if ($skill) {
    $skill_id = $skill->getSkill_Id();
    $skill_name = $skill->getSkill_Name();
    $skill_desc = $skill->getSkill_Desc();
    
        // Insert checks here!
    
    $skillToArray = [
        "skill_id" => $skill_id, 
        "skill_name" => $skill_name,
        "skill_desc" => $skill_desc
    ];
    
    $output = ["records" => $skillToArray];
}

else {
    http_response_code(404);
    $output = ["status" => "Could not find skill with id " . $skill_id];
}

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>