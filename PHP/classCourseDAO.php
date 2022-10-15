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
            -- role.role_id AS role_id,
            -- role.role_name AS role_name,
            -- role.role_desc AS role_desc,
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
            WHERE course_id = :course_id"; // ASC or DESC 

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        // STEP 3: Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // STEP 4: Display result
        while( $row = $stmt->fetch() ) {
            $course = new classCourse(
                $row['course_id'],
                $row['course_name'],
                $row['course_desc'],
                $row['course_status'],
                $row['course_type'],
                $row['course_category']
            );
        }

        return $course;
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

}


?>