<?php
require_once "common.php";

$_POST = json_decode(file_get_contents("php://input"), true);
$role_name = $_POST["role_name"] ?? null;
$role_desc = $_POST["role_desc"] ?? null;
$role_skills = $_POST["role_skills"] ?? null;

$roleDAO = new classRoleDAO();
$status_msg = '';
$role_id = FALSE;
$status = FALSE;

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$role_id = $roleDAO->addRole($role_name, $role_desc);

$result = [];

if ($role_id) {
    $status_msg = $status_msg . "Cleared skills from role; ";
    $added_skills = [];
    foreach ($role_skills as $skill_id) {
        array_push($added_skills, $skill_id); 
        $status = $roleDAO->addSkillToRole($role_id, $skill_id);
        if ($status) {
            $status_msg = $status_msg . "Added skill with id " . $skill_id . " to role; ";
        }
        else {
            http_response_code(404);
            $status_msg = $status_msg . "Failed to add skill with id " . $skill_id . " to role; ";
        }
    }
}
else {
    http_response_code(404);
    $status_msg = $status_msg . "Failed to create role; ";
}

$result['role_id'] = $role_id;
$result["status"] = $status_msg;

// create json string and send back to client
$jsonObj = json_encode($result);
echo $jsonObj;
?>