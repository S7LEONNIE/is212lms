<?php

class classSkill {
    // Properties

    private $skill_id;
    private $skill_name;
    private $skill_desc;

    // Methods

    function __construct($skill_id, $skill_name, $skill_desc) {
        $this->skill_id = $skill_id;
        $this->skill_name = $skill_name;
        $this->skill_desc = $skill_desc;
    }

    // Setters

    function setSkill_Id($skill_id) {
        $this->skill_id = $skill_id;
    }
    function setSkill_name($skill_name) {
        $this->skill_name = $skill_name;
    }
    function setSkill_desc($skill_desc) {
        $this->skill_desc = $skill_desc;
    }

    // Getters

    function getSkill_Id() {
        return $this->skill_id;
    }
    function getSkill_Name() {
        return $this->skill_name;
    }
    function getSkill_desc() {
        return $this->skill_desc;
    }
}

?>