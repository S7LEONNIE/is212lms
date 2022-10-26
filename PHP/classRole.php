<?php

class classRole {
    // Properties

    private $role_id;
    private $role_name;
    private $role_desc;

    // Methods

    function __construct($role_id, $role_name, $role_desc, $is_active) {
        $this->role_id = $role_id;
        $this->role_name = $role_name;
        $this->role_desc = $role_desc;
        $this->is_active = $is_active;
    }

    // Setters

    function setRole_Id($role_id) {
        $this->role_id = $role_id;
    }
    function setRole_Name($role_name) {
        $this->role_name = $role_name;
    }
    function setRole_Desc($role_desc) {
        $this->role_desc = $role_desc;
    }
    function set_IsActive($isActive) {
        $this->is_active = $isActive;
    }

    // Getters

    function getRole_Id() {
        return $this->role_id;
    }
    function getRole_Name() {
        return $this->role_name;
    }
    function getRole_Desc() {
        return $this->role_desc;
    }
    function get_IsActive() {
        return $this->is_active;
    }
}

?>