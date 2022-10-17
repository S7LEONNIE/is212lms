<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$role_id = $_POST["role_id"] ?? null;
$roleDAO = new classroleDAO();

$role = $roleDAO->getRoleById($role_id);

if ($role) {
    $role_id = $role->getRole_Id();
    $role_name = $role->getRole_Name();
    $role_desc = $role->getRole_Desc();
    
        // Insert checks here!
    
    $roleToArray = [
        "role_id" => $role_id, 
        "role_name" => $role_name,
        "role_desc" => $role_desc
    ];
    
    $output = ["records" => $roleToArray];
}

else {
    http_response_code(404);
    $output = ["status" => "Could not find role with id " . $role_id];
}

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>