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

    // // The rest of this is code from my old WAD2 project. To be modified as necessary.

    // public function addItem($userid, $purchase_time, $item_name, $category, $price, $location, $latitude, $longitude) {
        
    //     // STEP 1: establish a connection

    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands

    //     $sql = "INSERT INTO item
    //                     (
    //                         userid, 
    //                         purchase_time, 
    //                         item_name,
    //                         category,
    //                         price,
    //                         location,
    //                         latitude,
    //                         longitude
    //                     )
    //                 VALUES
    //                     (
    //                         :userid,
    //                         :purchase_time,
    //                         :item_name,
    //                         :category,
    //                         :price,
    //                         :location,
    //                         :latitude,
    //                         :longitude
    //                     )";

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
    //     $stmt->bindParam(':purchase_time', $purchase_time, PDO::PARAM_STR);
    //     $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
    //     $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    //     $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    //     $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    //     $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
    //     $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $status = $stmt->execute();

    //     $stmt = null;
    //     $conn = null;
    //     return $status;
    // }
    
    // public function deleteItem($purchaseid) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2
    //     $sql = "DELETE FROM
    //                 item
    //             WHERE 
    //                 purchaseid = :purchaseid";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':purchaseid', $purchaseid, PDO::PARAM_INT);

    //     // STEP 3
    //     $status = $stmt->execute();

    //     $stmt = null;
    //     $conn = null;
    //     return $status;

    // }

    // public function updateItem($purchaseid, $purchase_time, $item_name, $category, $price, $location, $latitude, $longitude)  {
    
    //     // STEP 1: establish a connection

    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands

    //     $sql = "";

    //     $sql = "UPDATE
    //             item
    //         SET
    //             purchase_time = :purchase_time,
    //             item_name = :item_name,
    //             category = :category,
    //             price = :price,
    //             location = :location,
    //             latitude = :latitude,
    //             longitude = :longitude
    //         WHERE 
    //             purchaseid = :purchaseid";

    //     $stmt = $conn->prepare($sql);
        
    //     $stmt->bindParam(':purchaseid', $purchaseid, PDO::PARAM_INT);
    //     $stmt->bindParam(':purchase_time', $purchase_time, PDO::PARAM_STR);
    //     $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
    //     $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    //     $stmt->bindParam(':price', $price, PDO::PARAM_STR);
    //     $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    //     $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
    //     $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $status = $stmt->execute();

    //     $stmt = null;
    //     $conn = null;
    //     return $status;
    // }

    // public function updateItemNoLoc($purchaseid, $userid, $purchase_time, $item_name, $category, $price)  {
    
    //     // STEP 1: establish a connection

    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands

    //     $sql = "";

    //     $sql = "UPDATE
    //             item
    //         SET
    //             purchase_time = :purchase_time,
    //             item_name = :item_name,
    //             category = :category,
    //             price = :price
    //         WHERE 
    //             purchaseid = :purchaseid
    //         AND 
    //             userid = :userid";

    //     $stmt = $conn->prepare($sql);
        
    //     $stmt->bindParam(':purchaseid', $purchaseid, PDO::PARAM_INT);
    //     $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
    //     $stmt->bindParam(':purchase_time', $purchase_time, PDO::PARAM_STR);
    //     $stmt->bindParam(':item_name', $item_name, PDO::PARAM_STR);
    //     $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    //     $stmt->bindParam(':price', $price, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $status = $stmt->execute();

    //     $stmt = null;
    //     $conn = null;
    //     return $status;
    // }

    // public function loadByTime($userid, $month, $year) {
    //     if ($month != 0) {
    //         return $this->loadByMonth($userid, $month, $year);
    //     }
    //     else if ($year != 0) {
    //         return $this->loadByYear($userid, $year);
    //     }
    //     else { return $this->loadById($userid); }
    // }

    // public function loadByMonth($userid, $month, $year) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT
    //         purchaseid,
    //         userid,
    //         purchase_time,
    //         item_name,
    //         category,
    //         price,
    //         location,
    //         latitude,
    //         longitude
    //         FROM item
    //         WHERE userid = :userid 
    //         AND MONTH(purchase_time) = :month
    //         AND YEAR(purchase_time) = :year
    //         ORDER BY purchase_time ASC;"; // ASC or DESC 

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
    //     $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    //     $stmt->bindParam(':year', $year, PDO::PARAM_INT);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     $list_item = []; // Indexed Array of Post objects
    //     while( $row = $stmt->fetch() ) {
    //         $list_item[] =
    //             new classItem(
    //                 $row['purchaseid'],
    //                 $row['userid'],
    //                 $row['purchase_time'],
    //                 $row['item_name'],
    //                 $row['category'],
    //                 $row['price'],
    //                 $row['location'],
    //                 $row['latitude'],
    //                 $row['longitude']);
    //             }
    //     return $list_item;
    // }

    // public function loadByYear($userid, $year) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT
    //         purchaseid,
    //         userid,
    //         purchase_time,
    //         item_name,
    //         category,
    //         price,
    //         location,
    //         latitude,
    //         longitude
    //         FROM item
    //         WHERE userid = :userid 
    //         AND YEAR(purchase_time) = :year
    //         ORDER BY purchase_time ASC;"; // ASC or DESC 

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
    //     $stmt->bindParam(':year', $year, PDO::PARAM_INT);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     $list_item = []; // Indexed Array of Post objects
    //     while( $row = $stmt->fetch() ) {
    //         $list_item[] =
    //             new classItem(
    //                 $row['purchaseid'],
    //                 $row['userid'],
    //                 $row['purchase_time'],
    //                 $row['item_name'],
    //                 $row['category'],
    //                 $row['price'],
    //                 $row['location'],
    //                 $row['latitude'],
    //                 $row['longitude']);
    //             }
    //     return $list_item;
    // }
    
    // public function loadById($userid) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT
    //         purchaseid,
    //         userid,
    //         purchase_time,
    //         item_name,
    //         category,
    //         price,
    //         location,
    //         latitude,
    //         longitude
    //         FROM item
    //         WHERE userid = :userid
    //         ORDER BY purchase_time ASC;"; // ASC or DESC 

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     $list_item = []; // Indexed Array of Post objects
    //     while( $row = $stmt->fetch() ) {
    //         $list_item[] =
    //             new classItem(
    //                 $row['purchaseid'],
    //                 $row['userid'],
    //                 $row['purchase_time'],
    //                 $row['item_name'],
    //                 $row['category'],
    //                 $row['price'],
    //                 $row['location'],
    //                 $row['latitude'],
    //                 $row['longitude']);
    //             }
    //     return $list_item;
    // }

    
    // public function spentByMonth($userid, $month, $year) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT IFNULL(SUM(price), 0) as spent
    //         FROM item
    //         WHERE userid = :userid 
    //         AND MONTH(purchase_time) = :month
    //         AND YEAR(purchase_time) = :year;";

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
    //     $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    //     $stmt->bindParam(':year', $year, PDO::PARAM_INT);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     if($stmt->execute()){
    //         if($row=$stmt->fetch()){
    //             $spent = $row['spent'];
    //         }
    //     }
    //     return $spent;
    // }


    // public function loadByPurchaseId($purchaseid) {
    //     $connMgr = new classConnectionManager();
    //     $conn = $connMgr->connect();

    //     // STEP 2: SQL commands
    //     $sql = "SELECT
    //         purchaseid,
    //         userid,
    //         purchase_time,
    //         item_name,
    //         category,
    //         price,
    //         location,
    //         latitude,
    //         longitude
    //         FROM item
    //         WHERE purchaseid = :purchaseid"; // ASC or DESC 

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':purchaseid', $purchaseid, PDO::PARAM_STR);

    //     // STEP 3: Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     // STEP 4: Display result
    //     $list_item = []; // Indexed Array of Post objects
    //     while( $row = $stmt->fetch() ) {
    //         $list_item[] =
    //             new classItem(
    //                 $row['purchaseid'],
    //                 $row['userid'],
    //                 $row['purchase_time'],
    //                 $row['item_name'],
    //                 $row['category'],
    //                 $row['price'],
    //                 $row['location'],
    //                 $row['latitude'],
    //                 $row['longitude']);
    //             }
    //     return $list_item;
    // }

}


?>