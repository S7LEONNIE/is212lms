<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$staff_id = $_POST["staff_id"] ?? null;

$ljDAO = new classLearningJourneyDAO();

$lj_list = array();

// $database = $itemDAO->loadByMonth($userId, $date[1], $date[0]);
$database = $ljDAO->getLJByStaffId($staff_id);

foreach ($database as $one_output) {
    $lj = $one_output['lj'];
    $lj_id = $lj->getLj_Id();
    $lj_name = $lj->getLj_Name();
    $staff_id = $lj->getStaff_Id();
    $role_id = $lj->getRole_Id();
    $role_name = $one_output['role'];

    // Insert checks here!

    $outputToArray = [
        "lj_id" => $lj_id, 
        "lj_name" => $lj_name,
        "staff_id" => $staff_id,
        "role_id" => $role_id,
        "role_name" => $role_name
    ];

    $lj_list[] = $outputToArray;
}

$output = ["records" => $lj_list];

// create json string and send back to client

$jsonObj = json_encode($output);
echo $jsonObj;
?>