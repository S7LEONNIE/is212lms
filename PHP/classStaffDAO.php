<?php

require_once "classStaff.php";
require_once "classConnectionManager.php";
class classStaffDAO {
    
    public function loadStaffByEmail($staff_email) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT * FROM staff
            WHERE email = :staff_email;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':staff_email', $staff_email, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        if ( $row = $stmt->fetch() ) {
            $staff = new classStaff(
                $row['staff_id'],
                $row['staff_fname'],
                $row['staff_lname'],
                $row['email'],
                $row['designation']
            );
            return $staff;
        }
        else {
            return FALSE;
        }
    }

}


?>