<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$skill_id = $_POST["skill_id"] ?? null;
$roleDAO = new classRoleDAO();

$roles = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $roleDAO->loadRolesBySkillId($skill_id);

foreach ($database as $role) {
    $role_id = $role->getRole_Id();
    $role_name = $role->getRole_Name();
    $role_desc = $role->getRole_Desc();

    // Insert checks here!

    $roleToArray = [
        "role_id" => $role_id, 
        "role_name" => $role_name,
        "role_desc" => $role_desc
    ];

    $roles[] = $roleToArray;
}

$output = ["records" => $roles];

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>