<?php

class classCustomizedSkillsAndCourses {
    // Properties

    private $skill_id;
    private $skill_name;
    private $skill_desc;
    private $course_name;
    private $course_type;
    private $course_desc;

    // Methods

    function __construct($sid, $sname, $sdesc, $cname, $ctype, $cdesc) {
        $this->skill_id = $sid;
        $this->skill_name = $sname;
        $this->skill_desc = $sdesc;
        $this->course_name = $cname;
        $this->course_type = $ctype;
        $this->course_desc = $cdesc;
    }

    // Setters
    public function getSkill_id()
    {
        return $this->skill_id;
    }

    /**
     * Set the value of skill_id
     *
     * @return  self
     */ 
    public function setSkill_id($skill_id)
    {
        $this->skill_id = $skill_id;

        return $this;
    }

    /**
     * Get the value of skill_name
     */ 
    public function getSkill_name()
    {
        return $this->skill_name;
    }

    /**
     * Set the value of skill_name
     *
     * @return  self
     */ 
    public function setSkill_name($skill_name)
    {
        $this->skill_name = $skill_name;

        return $this;
    }

    /**
     * Get the value of skill_desc
     */ 
    public function getSkill_desc()
    {
        return $this->skill_desc;
    }

    /**
     * Set the value of skill_desc
     *
     * @return  self
     */ 
    public function setSkill_desc($skill_desc)
    {
        $this->skill_desc = $skill_desc;

        return $this;
    }

    /**
     * Get the value of course_name
     */ 
    public function getCourse_name()
    {
        return $this->course_name;
    }

    /**
     * Set the value of course_name
     *
     * @return  self
     */ 
    public function setCourse_name($course_name)
    {
        $this->course_name = $course_name;

        return $this;
    }

    /**
     * Get the value of course_type
     */ 
    public function getCourse_type()
    {
        return $this->course_type;
    }

    /**
     * Set the value of course_type
     *
     * @return  self
     */ 
    public function setCourse_type($course_type)
    {
        $this->course_type = $course_type;

        return $this;
    }

    /**
     * Get the value of course_desc
     */ 
    public function getCourse_desc()
    {
        return $this->course_desc;
    }

    /**
     * Set the value of course_desc
     *
     * @return  self
     */ 
    public function setCourse_desc($course_desc)
    {
        $this->course_desc = $course_desc;

        return $this;
    }
}

?>