<?php

class classStaff {
    // Properties

    private $staff_id;
    private $staff_fName;
    private $staff_lName;
    private $staff_email;
    private $staff_designation;

    // Methods

    function __construct($id, $fName, $lName, $email, $designation) {
        $this->staff_id = $id;
        $this->staff_fName = $fName;
        $this->staff_lName = $lName;
        $this->staff_email = $email;
        $this->staff_designation = $designation;
    }

    // Setters

    function setStaff_Id($id) {
        $this->staff_id = $id;
    }
    function setStaff_fName($fName) {
        $this->staff_fName = $fName;
    }
    function setStaff_lName($lName) {
        $this->staff_lName = $lName;
    }
    function setStaff_email($email) {
        $this->staff_email = $email;
    }
    function setStaff_designation($designation) {
        $this->staff_designation = $designation;
    }

    // Getters

    function getStaff_Id() {
        return $this->staff_id;
    }
    function getStaff_fName() {
        return $this->staff_fName;
    }
    function getStaff_lName() {
        return $this->staff_lName;
    }
    function getStaff_email() {
        return $this->staff_email;
    }
    function getStaff_designation() {
        return $this->staff_designation;
    }
}

?>