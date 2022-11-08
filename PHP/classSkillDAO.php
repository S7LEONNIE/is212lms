<?php

require_once "classSkill.php";
require_once "classConnectionManager.php";
class classSkillDAO {
    
    public function loadAll() {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            skill_id,
            skill_name,
            skill_desc,
            is_active
            FROM skill
            WHERE is_active = 'active'
            ORDER BY skill_id ASC;"; // ASC or DESC 
        $stmt = $conn->prepare($sql);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_skill = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_skill[] =
                new classSkill(
                    $row['skill_id'],
                    $row['skill_name'],
                    $row['skill_desc'],
                    $row['is_active']
                );
        }
        return $list_skill;
    }

    public function loadSkillsByRoleId($role_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT 
            -- role.role_id AS role_id,
            -- role.role_name AS role_name,
            -- role.role_desc AS role_desc,
            skill.skill_id AS skill_id,
            skill.skill_name AS skill_name,
            skill.skill_desc AS skill_desc,
            skill.is_active AS is_active
            FROM skill 
            INNER JOIN role_skill ON skill.skill_id = role_skill.skill_id
            INNER JOIN role ON role.role_id = role_skill.role_id
            WHERE role.role_id = :role_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_skill = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_skill[] =
            new classSkill(
                $row['skill_id'],
                $row['skill_name'],
                $row['skill_desc'],
                $row['is_active']
            );
        }
        return $list_skill;
    }

    public function loadSkillById($skill_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            skill_id,
            skill_name,
            skill_desc,
            is_active
            FROM skill
            WHERE skill_id = :skill_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        if ( $row = $stmt->fetch() ) {
            $skill = new classSkill(
                $row['skill_id'],
                $row['skill_name'],
                $row['skill_desc'],
                $row['is_active']
            );
            return $skill;
        }
        else {
            return FALSE;
        }
    }
    
    public function loadSkillsByCourseId($course_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            skill.skill_id AS skill_id,
            skill.skill_name AS skill_name,
            skill.skill_desc AS skill_desc,
            skill.is_active AS is_active
            FROM skill
            INNER JOIN course_skill ON skill.skill_id = course_skill.skill_id
            WHERE course_skill.course_id = :course_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_skill = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_skill[] =
                new classSkill(
                    $row['skill_id'],
                    $row['skill_name'],
                    $row['skill_desc'],
                    $row['is_active']
                );
            }
        return $list_skill;
    }

    public function addSkill($skill_name, $skill_desc) {

        if (!$skill_name) {
            return FALSE;
        }
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands

        $sql = "INSERT INTO skill
                        (
                            skill_name, 
                            skill_desc,
                            is_active
                        )
                    VALUES
                        (
                            :skill_name,
                            :skill_desc,
                            'active'
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_name', $skill_name, PDO::PARAM_STR);
        $stmt->bindParam(':skill_desc', $skill_desc, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        // $stmt = null;
        // $conn = null;
        return $status;
    }

    public function updateSkill($skill_id,$skill_name, $skill_desc) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "UPDATE skill 
                SET skill_name = :skill_name, skill_desc = :skill_desc
                WHERE skill_id = :skill_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_name', $skill_name, PDO::PARAM_STR);
        $stmt->bindParam(':skill_desc', $skill_desc, PDO::PARAM_STR);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        return $status;
    }

    public function deleteSkill($skill_id) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "UPDATE skill
        SET is_active = 'inactive' 
        WHERE skill_id = :skill_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
}


?>