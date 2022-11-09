<?php

class classConnectionManager {

    public function connect() {
        $servername = '127.0.0.1';
        $username = 'root';
        $password = 'root';
        $dbname = 'SPM_LJPS_DB';
        
        // Create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);     
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // if fail, exception will be thrown
        // Return connection object
        return $conn;
    }

}
?>