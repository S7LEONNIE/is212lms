<?php

class classLJ {
    // Properties

    private $lj_id;
    private $lj_name;
    private $staff_id;
    private $role_id;

    // Methods

    function __construct($lj_id, $lj_name, $staff_id, $role_id) {
        $this->lj_id = $lj_id;
        $this->lj_name = $lj_name;
        $this->staff_id = $staff_id;
        $this->role_id = $role_id;
    }

    // Setters

    function setLj_Id($lj_id) {
        $this->lj_id = $lj_id;
    }
    function setLj_Name($lj_name) {
        $this->lj_name = $lj_name;
    }
    function setStaff_Id($staff_id) {
        $this->staff_id = $staff_id;
    }
    function setRole_Id($role_id) {
        $this->role_id = $role_id;
    }

    // Getters

    function getLj_Id() {
        return $this->lj_id;
    }
    function getLj_Name() {
        return $this->lj_name;
    }
    function getStaff_Id() {
        return $this->staff_id;
    }
    function getRole_Id() {
        return $this->role_id;
    }
}

?>