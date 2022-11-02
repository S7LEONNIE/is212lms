<?php
require_once "common.php";

$roleDAO = new classRoleDAO();

$roles = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $roleDAO->loadAll();

foreach ($database as $role) {
    $role_id = $role->getRole_Id();
    $role_name = $role->getRole_Name();
    $role_desc = $role->getRole_Desc();
    $is_active = $role->get_isActive();

    // Insert checks here!

    $roleToArray = [
        "role_id" => $role_id, 
        "role_name" => $role_name,
        "role_desc" => $role_desc,
        "is_active" => $is_active
    ];

    $roles[] = $roleToArray;
}

// $labels = ["Role ID", "Role Name", "Role Description"];

$output = ["records" => $roles];

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>