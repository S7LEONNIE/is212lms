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

    // public function loadSkillsByRoleId($role_id) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT 
    //         -- role.role_id AS role_id,
    //         -- role.role_name AS role_name,
    //         -- role.role_desc AS role_desc,
    //         skill.skill_id AS skill_id,
    //         skill.skill_name AS skill_name,
    //         skill.skill_desc AS skill_desc
    //         FROM skill 
    //         INNER JOIN role_skill ON skill.skill_id = role_skill.skill_id
    //         INNER JOIN role ON role.role_id = role_skill.role_id
    //         WHERE role.role_id = :role_id;";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     $list_skill = []; // Indexed Array of Post objects
    //     while( $row = $stmt->fetch() ) {
    //         $list_skill[] =
    //             new classSkill(
    //                 $row['skill_id'],
    //                 $row['skill_name'],
    //                 $row['skill_desc']);
    //             }
    //     return $list_skill;
    // }

    // public function loadSkillById($skill_id) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT
    //         skill_id,
    //         skill_name,
    //         skill_desc
    //         FROM skill
    //         WHERE skill_id = :skill_id;";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     if ( $row = $stmt->fetch() ) {
    //         $skill = new classSkill(
    //             $row['skill_id'],
    //             $row['skill_name'],
    //             $row['skill_desc']
    //         );
    //         return $skill;
    //     }
    //     else {
    //         return FALSE;
    //     }
    // }
    
    // public function loadSkillsByCourseId($course_id) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT
    //         skill.skill_id AS skill_id,
    //         skill.skill_name AS skill_name,
    //         skill.skill_desc AS skill_desc
    //         FROM skill
    //         INNER JOIN course_skill ON skill.skill_id = course_skill.skill_id
    //         WHERE course_skill.course_id = :course_id;";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     $list_skill = []; // Indexed Array of Post objects
    //     while( $row = $stmt->fetch() ) {
    //         $list_skill[] =
    //             new classSkill(
    //                 $row['skill_id'],
    //                 $row['skill_name'],
    //                 $row['skill_desc']
    //             );
    //         }
    //     return $list_skill;
    // }

}


?>