<?php

require_once "classRole.php";
require_once "classConnectionManager.php";
class classRoleDAO {
    
    public function loadAll() {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            role_id,
            role_name,
            role_desc,
            is_active
            FROM role
            WHERE is_active = 'active' ORDER BY role_id ASC;"; // ASC or DESC 
        $stmt = $conn->prepare($sql);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_role = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_role[] =
                new classRole(
                    $row['role_id'],
                    $row['role_name'],
                    $row['role_desc'],
                    $row['is_active']);
                }
        return $list_role;
    }

    public function addRole($role_name, $role_desc) {
        
        // STEP 1: establish a connection

        if(strlen($role_name) > 50 || strlen($role_desc) > 255 || 
           strlen($role_name) == 0) {
            return FALSE;
        }

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands

        $sql = "INSERT INTO role
                        (
                            role_name, 
                            role_desc,
                            is_active
                        )
                    VALUES
                        (
                            :role_name,
                            :role_desc,
                            'active'
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $stmt->bindParam(':role_desc', $role_desc, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        // if failed insert, return status:
        if (!$status) {
            return $status;
        }

        // if successful insert, query DB to get the id of that role:
        // STEP 1: establish a connection
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            role_id
            FROM role
            WHERE role_name = :role_name
            AND role_desc = :role_desc
            ORDER BY role_id DESC
            LIMIT 1;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $stmt->bindParam(':role_desc', $role_desc, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        if ( $row = $stmt->fetch() ) {
            $role_id = $row['role_id'];
            return $role_id;
        }
        else {
            return FALSE;
        }
    }
    
    public function getRoleById($role_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            role_id,
            role_name,
            role_desc,
            is_active
            FROM role
            WHERE role_id = :role_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        if ( $row = $stmt->fetch() ) {
            $role = new classRole(
                $row['role_id'],
                $row['role_name'],
                $row['role_desc'],
                $row['is_active']
            );
            return $role;
        }
        else {
            return FALSE;
        }
    }

    public function loadRolesBySkillId($skill_id) {
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "SELECT
            role.role_id AS role_id,
            role.role_name AS role_name,
            role.role_desc AS role_desc,
            role.is_active AS is_active
            FROM role
            INNER JOIN role_skill ON role.role_id = role_skill.role_id
            WHERE role_skill.skill_id = :skill_id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        $list_role = []; // Indexed Array of Post objects
        while( $row = $stmt->fetch() ) {
            $list_role[] =
                new classRole(
                    $row['role_id'],
                    $row['role_name'],
                    $row['role_desc'],
                    $row['is_active']
                );
            }
        return $list_role;
    }

    public function updateRole($role_id, $role_name, $role_desc) {

        if(!$role_name) {
            return FALSE;
        }
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "UPDATE role 
                SET role_name = :role_name, role_desc = :role_desc
                WHERE role_id = :role_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $stmt->bindParam(':role_desc', $role_desc, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
    
    public function clearSkillsFromRole($role_id) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "DELETE FROM role_skill 
                WHERE role_id = :role_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
    
    public function addSkillToRole($role_id, $skill_id) {
        
        // STEP 1: establish a connection
        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "INSERT INTO role_skill
                        (
                            role_id, 
                            skill_id
                        )
                    VALUES
                        (
                            :role_id,
                            :skill_id
                        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_STR);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }


    public function deleteRole($role_id) {
        
        // STEP 1: establish a connection

        $connMgr = new classConnectionManager();
        $conn = $connMgr->connect();

        // STEP 2: SQL commands
        $sql = "UPDATE role
        SET is_active = 'inactive' 
        WHERE role_id = :role_id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

        // STEP 3: Run SQL
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;
        return $status;
    }
    
}


?>