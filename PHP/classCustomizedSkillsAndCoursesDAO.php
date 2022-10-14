<?php

require_once "classCustomizedSkillsAndCourses.php";
require_once "classConnectionManager.php";
class classCustomizedSkillsAndCoursesDAO {
    
    public function loadSkillsAndCourse() {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "select skill.skill_id, skill.skill_name, skill.skill_desc, course.course_name, course.course_type, course.course_desc from skill 
        inner join course_skill on skill.skill_id = course_skill.skill_id inner join
        course on course_skill.course_id = course.course_id;"; 

        $stmt = $conn->prepare($sql);
        
        // STEP 3: Run SQL
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);
        $stmt->execute();

        // STEP 4: Display result
        $skills_and_courses = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $skills_and_courses[] =
                new classCustomizedSkillsAndCourses(
                    $row['skill_id'],
                    $row['skill_name'],
                    $row['skill_desc'],
                    $row['course_name'],
                    $row['course_type'],
                    $row['course_desc']);
                }

        return $skills_and_courses;
    }

}


?>