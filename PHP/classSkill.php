<?php

class classSkill {
    // Properties

    private $skill_id;
    private $skill_name;
    private $skill_desc;
    private $is_active;

    // Methods

    function __construct($skill_id, $skill_name, $skill_desc, $is_active) {
        $this->skill_id = $skill_id;
        $this->skill_name = $skill_name;
        $this->skill_desc = $skill_desc;
        $this->is_active = $is_active;
    }

    // Setters

    function setSkill_Id($skill_id) {
        $this->skill_id = $skill_id;
    }
    function setSkill_Name($skill_name) {
        $this->skill_name = $skill_name;
    }
    function setSkill_Desc($skill_desc) {
        $this->skill_desc = $skill_desc;
    }
    function set_IsActive($isActive) {
        $this->is_active = $isActive;
    }

    // Getters

    function getSkill_Id() {
        return $this->skill_id;
    }
    function getSkill_Name() {
        return $this->skill_name;
    }
    function getSkill_Desc() {
        return $this->skill_desc;
    }
    function get_IsActive() {
        return $this->is_active;
    }
}

?>