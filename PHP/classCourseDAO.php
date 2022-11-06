<?php

require_once "classCourse.php";
require_once "classConnectionManager.php";
class classCourseDAO {
    
    public function loadAll() {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            course_id,
            course_name,
            course_desc,
            course_status,
            course_type,
            course_category
            FROM course
            ORDER BY course_id ASC;"; // ASC or DESC 
        $stmt = $conn->prepare($sql);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_course = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_course[] =
                new classCourse(
                    $row['course_id'],
                    $row['course_name'],
                    $row['course_desc'],
                    $row['course_status'],
                    $row['course_type'],
                    $row['course_category']);
                }
        return $list_course;
    }

    public function loadCoursesBySkillId($skill_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            course.course_id AS course_id,
            course.course_name AS course_name,
            course.course_desc AS course_desc,
            course.course_status AS course_status,
            course.course_type AS course_type,
            course.course_category AS course_category
            FROM course 
            INNER JOIN course_skill ON course.course_id = course_skill.course_id
            WHERE course_skill.skill_id = :skill_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_course = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_course[] =
                new classCourse(
                    $row['course_id'],
                    $row['course_name'],
                    $row['course_desc'],
                    $row['course_status'],
                    $row['course_type'],
                    $row['course_category']);
                }
        return $list_course;
    }

    public function loadCoursesByLJ($lj_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            course.course_id AS course_id,
            course.course_name AS course_name,
            course.course_desc AS course_desc,
            course.course_status AS course_status,
            course.course_type AS course_type,
            course.course_category AS course_category
            FROM course 
            INNER JOIN lj_course ON course.course_id = lj_course.course_id
            WHERE lj_course.learning_journey_id = :lj_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':lj_id', $lj_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_course = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_course[] =
                new classCourse(
                    $row['course_id'],
                    $row['course_name'],
                    $row['course_desc'],
                    $row['course_status'],
                    $row['course_type'],
                    $row['course_category']);
                }
        return $list_course;
    }

    public function getCourseById($course_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            course_id,
            course_name,
            course_desc,
            course_status,
            course_type,
            course_category
            FROM course
            WHERE course_id = :course_id;"; // ASC or DESC 

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        if ( $row = $stmt->fetch() ) {
            $course = new classCourse(
                $row['course_id'],
                $row['course_name'],
                $row['course_desc'],
                $row['course_status'],
                $row['course_type'],
                $row['course_category']
            );
            return $course;
        }
        else {
            return FALSE;
        }

    }

    public function loadCoursesUnderManager() {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "select * from course where course_id IN (select course_id from lj_course 
        where learning_journey_id = (select lj_id from learning_journey
        where staff_id = (select staff_id from department_staff 
        where department_id = 1 AND is_manager = 0)));"; 

        $stmt = $conn->prepare($sql);
        
        // STEP 3: Run SQL
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);
        $stmt->execute();

        // STEP 4: Display result
        while($row = $stmt->fetch() ) {
            $coursesUnderManager[] =
                new classCourse(
                    $row['course_id'],
                    $row['course_name'],
                    $row['course_desc'],
                    $row['course_status'],
                    $row['course_type'],
                    $row['course_category']);
                }

        return $coursesUnderManager;
    }
    
    public function updateCourse($course_id, $course_name, $course_desc, $course_type, $course_category) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "UPDATE course 
                SET course_name = :course_name,
                course_desc = :course_desc,
                course_type = :course_type,
                course_category = :course_category
                WHERE course_id = :course_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_name', $course_name, PDO::PARAM_STR);
        $stmt->bindParam(':course_desc', $course_desc, PDO::PARAM_STR);
        $stmt->bindParam(':course_type', $course_type, PDO::PARAM_STR);
        $stmt->bindParam(':course_category', $course_category, PDO::PARAM_STR);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
    public function clearSkillsFromCourse($course_id) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "DELETE FROM course_skill 
                WHERE course_id = :course_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }

    public function addSkillToCourse($course_id, $skill_id) {
        
        // STEP 1: establish a connection
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "INSERT INTO course_skill
                        (
                            course_id, 
                            skill_id
                        )
                    VALUES
                        (
                            :course_id,
                            :skill_id
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
    
}


?>