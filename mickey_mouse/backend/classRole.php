<?php

class classRole {
    // Properties

    private $role_id;
    private $role_name;
    private $role_desc;

    // Methods

    function __construct($role_id, $role_name, $role_desc) {
        $this->role_id = $role_id;
        $this->role_name = $role_name;
        $this->role_desc = $role_desc;
    }

    // Setters

    function setRole_Id($role_id) {
        $this->role_id = $role_id;
    }
    function setRole_Name($role_name) {
        $this->role_name = $role_name;
    }
    function setRole_desc($role_desc) {
        $this->role_desc = $role_desc;
    }

    // Getters

    function getRole_Id() {
        return $this->role_id;
    }
    function getRole_Name() {
        return $this->role_name;
    }
    function getRole_desc() {
        return $this->role_desc;
    }
}

?>