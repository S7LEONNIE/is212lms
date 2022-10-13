<?php

require_once "classCourse.php";
require_once "classConnectionManager.php";
class classLearningJourneyDAO {
    
    public function loadAll() {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "select course.course_name, course.course_id, course.course_desc, course.course_status, course.course_type, course.course_category from course 
        inner join lj_course on course.course_id = lj_course.course_id
        where lj_course.learning_journey_id = 
        (
            select lj_id from learning_journey
            inner join staff on learning_journey.staff_id = staff.staff_id
            where staff.staff_id = 1
        );"; 

        $stmt = $conn->prepare($sql);
        
        // STEP 3: Run SQL
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        // STEP 4: Display result
        $list_role = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_role[] =
                new classCourse(
                    $row['course_id'],
                    $row['course_name'],
                    $row['course_desc'],
                    $row['course_status'],
                    $row['course_type'],
                    $row['course_category']);
                }

        return $list_role;
    }

    public function addRole($role_name, $role_desc) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands

        $sql = "INSERT INTO role
                        (
                            role_name, 
                            role_desc
                        )
                    VALUES
                        (
                            :role_name,
                            :role_desc
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $stmt->bindParam(':role_desc', $role_desc, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }

}


?>