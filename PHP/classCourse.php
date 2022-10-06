<?php

class classCourse {
    // Properties

    private $course_id;
    private $course_name;
    private $course_desc;
    private $course_status;
    private $course_type;
    private $course_category;

    // Methods

    function __construct($id, $name, $desc, $status, $type, $category) {
        $this->course_id = $id;
        $this->course_name = $name;
        $this->course_desc = $desc;
        $this->course_status = $status;
        $this->course_type = $type;
        $this->course_category = $category;
    }

    // Setters

    function setCourse_Id($id) {
        $this->course_id = $id;
    }
    function setCourse_name($name) {
        $this->course_name = $name;
    }
    function setCourse_desc($desc) {
        $this->course_desc = $desc;
    }
    function setCourse_status($status) {
        $this->course_status = $status;
    }
    function setCourse_type($type) {
        $this->course_type = $type;
    }
    function setCourse_category($category) {
        $this->course_category = $category;
    }

    // Getters

    function getCourse_Id() {
        return $this->course_id;
    }
    function getCourse_name() {
        return $this->course_name;
    }
    function getCourse_desc() {
        return $this->course_desc;
    }
    function getCourse_status() {
        return $this->course_status;
    }
    function getCourse_type() {
        return $this->course_type;
    }
    function getCourse_category() {
        return $this->course_category;
    }
}

?>