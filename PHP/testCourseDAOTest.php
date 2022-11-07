<?php
// namespace Tests\Unit;
require_once 'classCourseDAO.php';
require_once 'classSkillDAO.php';

use Tests\Support\UnitTester;

class testCourseDAOTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testLoadAll()
    {
        $courseDAO = new classCourseDAO();
        $database = $courseDAO->loadAll();
        $this->assertEquals(count($database), 12);
        $this->assertEquals($database[11]->getCourse_Name(), 'Workplace Conflict Management for Professionals');
    }

    public function testLoadCoursesBySkillIdSuccess()
    {
        $courseDAO = new classCourseDAO();
        $database = $courseDAO->loadCoursesBySkillId(2);
        $this->assertEquals(count($database), 3);
        $this->assertEquals($database[0]->getCourse_Id(), 3);
        $this->assertEquals($database[0]->getCourse_name(), "Communications Course");
        $this->assertEquals($database[0]->getCourse_desc(), "This is about communication");
        $this->assertEquals($database[0]->getCourse_status(), "Active");
        $this->assertEquals($database[0]->getCourse_type(), "External");
        $this->assertEquals($database[0]->getCourse_category(), "Communications");
        $this->assertEquals($database[1]->getCourse_Id(), 4);
        $this->assertEquals($database[1]->getCourse_name(), "Management Communications Course");
        $this->assertEquals($database[1]->getCourse_desc(), "This is an SMU course");
        $this->assertEquals($database[1]->getCourse_status(), "Active");
        $this->assertEquals($database[1]->getCourse_type(), "External");
        $this->assertEquals($database[1]->getCourse_category(), "Super Communications");
        $this->assertEquals($database[2]->getCourse_Id(), 9);
        $this->assertEquals($database[2]->getCourse_name(), "Workplace Conflict Management for Professionals");
        $this->assertEquals($database[2]->getCourse_desc(), "This course will address the gaps to build consensus and utilise knowledge of conflict management techniques to diffuse tensions and achieve resolutions effectively in the best interests of the organisation.");
        $this->assertEquals($database[2]->getCourse_status(), "Active");
        $this->assertEquals($database[2]->getCourse_type(), "External");
        $this->assertEquals($database[2]->getCourse_category(), "Management");
    }

    public function testLoadCoursesBySkillIdFailInvalidId()
    {
        $courseDAO = new classCourseDAO();
        $database = $courseDAO->loadCoursesBySkillId(999);
        $this->assertEquals(count($database), 0);
    }

    public function testLoadCoursesByLjSuccess()
    {
        $courseDAO = new classCourseDAO();
        $database = $courseDAO->loadCoursesByLJ(2);
        $this->assertEquals(count($database), 3);
        $this->assertEquals($database[0]->getCourse_Id(), 2);
        $this->assertEquals($database[0]->getCourse_name(), "Super Engineering Course");
        $this->assertEquals($database[0]->getCourse_desc(), "This is about rocket science");
        $this->assertEquals($database[0]->getCourse_status(), "Active");
        $this->assertEquals($database[0]->getCourse_type(), "Internal");
        $this->assertEquals($database[0]->getCourse_category(), "Engineering");
        $this->assertEquals($database[1]->getCourse_Id(), 4);
        $this->assertEquals($database[1]->getCourse_name(), "Management Communications Course");
        $this->assertEquals($database[1]->getCourse_desc(), "This is an SMU course");
        $this->assertEquals($database[1]->getCourse_status(), "Active");
        $this->assertEquals($database[1]->getCourse_type(), "External");
        $this->assertEquals($database[1]->getCourse_category(), "Super Communications");
        $this->assertEquals($database[2]->getCourse_Id(), 7);
        $this->assertEquals($database[2]->getCourse_name(), "Defense against the Dark Arts");
        $this->assertEquals($database[2]->getCourse_desc(), "This is a course about magic");
        $this->assertEquals($database[2]->getCourse_status(), "Active");
        $this->assertEquals($database[2]->getCourse_type(), "External");
        $this->assertEquals($database[2]->getCourse_category(), "Magic");
    }

    public function testLoadCoursesByLjFailInvalidId()
    {
        $courseDAO = new classCourseDAO();
        $database = $courseDAO->loadCoursesByLJ(999);
        $this->assertEquals(count($database), 0);
    }

    public function testGetCourseByIdSuccess()
    {
        $courseDAO = new classCourseDAO();
        $course = $courseDAO->getCourseById(3);
        $this->assertEquals($course->getCourse_Id(), 3);
        $this->assertEquals($course->getCourse_name(), "Communications Course");
        $this->assertEquals($course->getCourse_desc(), "This is about communication");
        $this->assertEquals($course->getCourse_status(), "Active");
        $this->assertEquals($course->getCourse_type(), "External");
        $this->assertEquals($course->getCourse_category(), "Communications");
    }

    public function testGetCourseByIdFailInvalidId()
    {
        $courseDAO = new classCourseDAO();
        $course = $courseDAO->getCourseById(999);
        $this->assertFalse($course);
    }
    
    // public function testLoadCoursesUnderManager()
    // {}

    public function testUpdateCourseSuccess()
    {
        $courseDAO = new classCourseDAO();
        $status = $courseDAO->updateCourse(
            1,
            "Kitten Handling",
            "This is about petting kittens",
            "Internal",
            "Pets"
        );
        $this->tester->seeInDatabase('course', [
            'course_id' => 1,
            'course_name' => 'Kitten Handling', 
            'course_desc' => 'This is about petting kittens',
            'course_status' => 'active',
            'course_type' => 'Internal',
            'course_category' => 'Pets'
        ]);
    }

    public function testUpdateCourseFailNoName()
    {
        $courseDAO = new classCourseDAO();
        $status = $courseDAO->updateCourse(
            1,
            "",
            "This is about petting kittens",
            "Internal",
            "Pets"
        );
        $this->tester->seeInDatabase('course', [
            'course_id' => 1,
            'course_name' => 'Engineering Course'
        ]);
        $this->assertFalse($status);
    }

    public function testUpdateCourseFailInvalidId()
    {
        $courseDAO = new classCourseDAO();
        $status = $courseDAO->updateCourse(
            9999,
            "",
            "This is about petting kittens",
            "Internal",
            "Pets"
        );
        $this->assertFalse($status);
    }

    public function testClearSkillsFromCourseSuccess()
    {
        $courseDAO = new classCourseDAO();
        $skillDAO = new classSkillDAO();
        $status = $courseDAO->clearSkillsFromCourse(7);
        $database = $skillDAO->loadSkillsByCourseId(7);
        $this->assertTrue($status);
        $this->assertEquals(count($database), 0);
    }

    // public function testClearSkillsFromCourseFailInvalidId()
    // {
    //     $courseDAO = new classCourseDAO();
    //     $status = $courseDAO->clearSkillsFromCourse(999);
    //     $this->assertFalse($status);
    // }

    public function testAddSkillToCourseSuccess()
    {
        $courseDAO = new classCourseDAO();
        $status = $courseDAO->addSkillToCourse(7,1);
        $this->assertTrue($status);
        $this->tester->seeInDatabase('course_skill', [
            'course_id' => 7,
            'skill_id' => 1
        ]);
    }
    
    // public function testAddSkillToCourseFailInvalidCourseId()
    // {
    //     $courseDAO = new classCourseDAO();
    //     $status = $courseDAO->addSkillToCourse(999,1);
    //     $this->assertFalse($status);
    // }
    
    // public function testAddSkillToCourseFailInvalidSkillId()
    // {
    //     $courseDAO = new classCourseDAO();
    //     $status = $courseDAO->addSkillToCourse(1,999);
    //     $this->assertFalse($status);
    // }
}
