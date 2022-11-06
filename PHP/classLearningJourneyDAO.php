<?php

require_once "classCourse.php";
require_once "classLJ.php";
require_once "classConnectionManager.php";
class classLearningJourneyDAO {
    
    public function getLJByStaffId($staff_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
                lj_id,
                lj_name,
                lj.role_id,
                role.role_name
                from learning_journey lj
                inner join role role on lj.role_id = role.role_id
                where lj.staff_id = :staff_id;"; 

        $stmt = $conn->prepare($sql);
        
        // STEP 3: Run SQL
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);
        $stmt->execute();

        // STEP 4: Display result
        $list_output = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $one_lj = new classLJ(
                    $row['lj_id'],
                    $row['lj_name'],
                    $staff_id,
                    $row['role_id']
            );
            $one_roleName = $row['role_name'];
            $one_output = ['lj' => $one_lj, 'role' => $one_roleName];
            $list_output[] = $one_output;
        };

        return $list_output;
    }

    public function getLJById($lj_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
                lj_id,
                lj_name,
                staff_id,
                lj.role_id,
                role.role_name
                from learning_journey lj
                inner join role on lj.role_id = role.role_id
                where lj.lj_id = :lj_id;"; 

        $stmt = $conn->prepare($sql);
        
        // STEP 3: Run SQL
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_INT);
        $stmt->execute();

        // STEP 4: Display result
        if ( $row = $stmt->fetch() ) {
            // $one_lj = $row;
            // $one_roleName = $row['role_name'];
            // $output = ['lj' => $one_lj, 'role' => $one_roleName];
            return $row;
        }
        else { return FALSE; }
    }

    public function loadAllOld() {
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

    public function addLearningJourney($lj_name, $staff_id, $role_id) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands

        $sql = "INSERT INTO learning_journey
                        (
                            lj_name, 
                            staff_id,
                            role_id
                        )
                    VALUES
                        (
                            :learningjourney_name,
                            :staff_no,
                            :role_no
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':learningjourney_name', $lj_name, PDO::PARAM_STR);
        $stmt->bindParam(':staff_no', $staff_id, PDO::PARAM_INT);
        $stmt->bindParam(':role_no', $role_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $status = $stmt->execute();
        $stmt->closeCursor();
        
        $pdo = null;
        $stmt = null;
        $conn = null;
        return $status;
    }

    public function removeLearningJourney($lj_id, $staff_id) {
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands: remove attached courses
        $sql = "delete from lj_course where learning_journey_id = :lj_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();
        $stmt->closeCursor();

        // 2nd Sql Statement: Remove LJ
        $sql = "delete from learning_journey 
                where lj_id = :learningjourney_id
                and staff_id = :staff_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':learningjourney_id', $lj_id, PDO::PARAM_STR);
        $stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();
        $stmt->closeCursor();
        
        $pdo = null;
        $stmt = null;
        $conn = null;
        return $status;
    }
    
    public function checkIfCourseInLJ($lj_id, $course_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
                learning_journey_id, course_id
                from lj_course
                where course_id = :course_id
                AND learning_journey_id = :lj_id;"; 

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_STR);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
        
        // STEP 3: Run SQL
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        // STEP 4: Display result
        if ($stmt->fetch()) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function addCourseToLJ($lj_id, $course_id) {
        
        // STEP 1: establish a connection
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "INSERT INTO lj_course
                        (
                            learning_journey_id, 
                            course_id
                        )
                    VALUES
                        (
                            :lj_id,
                            :course_id
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_STR);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
    
    public function dropAllCoursesFromLJ($lj_id) {
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands: remove attached courses
        $sql = "delete from lj_course where learning_journey_id = :lj_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();
        $stmt->closeCursor();
        
        $pdo = null;
        $stmt = null;
        $conn = null;
        return $status;
    }
    
    public function updateLJName($lj_id, $lj_name) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "UPDATE learning_journey
        SET lj_name = :lj_name 
        WHERE lj_id = :lj_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_INT);
        $stmt->bindParam(':lj_name', $lj_name, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }


}



?>