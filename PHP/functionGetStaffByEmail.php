<?php
require_once "common.php";
$_POST = json_decode(file_get_contents("php://input"), true);
$staff_email = $_POST["staff_email"] ?? null;
$staffDAO = new classStaffDAO();

$staff = $staffDAO->loadStaffByEmail($staff_email);

if ($staff) {
    $staff_id = $staff->getStaff_Id();
    $staff_fName = $staff->getStaff_fName();
    $staff_lName = $staff->getStaff_lName();
    $staff_email = $staff->getStaff_email();
    $staff_designation = $staff->getStaff_designation();
    
        // Insert checks here!
    
    $staffToArray = [
        "staff_id" => $staff_id,
        "staff_fName" => $staff_fName,
        "staff_lName" => $staff_lName,
        "staff_email" => $staff_email,
        "staff_designation" => $staff_designation
    ];
    
    $output = ["records" => $staffToArray];
}

else {
    http_response_code(404);
    $output = ["status" => "Could not find staff with email " . $staff_email];
}

// create json string and send back to client
$jsonObj = json_encode($output);
echo $jsonObj;
?>