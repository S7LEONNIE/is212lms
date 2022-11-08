<?php
// namespace Tests\Unit;
require_once 'classLearningJourneyDAO.php';
require_once 'classCourseDAO.php';

use Tests\Support\UnitTester;

class testLJDAOTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testGetLjByStaffIdSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $lj_list = $ljDAO->getLJByStaffId(2);
        $this->assertEquals(count($lj_list), 1);
        $this->assertEquals($lj_list[0]['lj']->getLj_Id(), 2);
        $this->assertEquals($lj_list[0]['lj']->getLj_Name(), "Edel's Learning Journey");
        $this->assertEquals($lj_list[0]['lj']->getStaff_Id(), 2);
        $this->assertEquals($lj_list[0]['lj']->getRole_Id(), 2);
        $this->assertEquals($lj_list[0]['role'], "Manager");
    }

    public function testGetLjByStaffIdFailInvalidId() {
        $ljDAO = new classLearningJourneyDAO();
        $lj_list = $ljDAO->getLJByStaffId(999);
        $this->assertEquals(count($lj_list), 0);
    }

    public function testGetLjByIdSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $lj = $ljDAO->getLJById(1);
        $this->assertEquals($lj['lj_id'], 1);
        $this->assertEquals($lj['lj_name'], "John's Learning Journey");
        $this->assertEquals($lj['staff_id'], 1);
        $this->assertEquals($lj['role_id'], 1);
        $this->assertEquals($lj['role_name'], "Engineer");
    }

    public function testGetLjByIdFailInvalidId() {
        $ljDAO = new classLearningJourneyDAO();
        $lj = $ljDAO->getLJById(999);
        $this->assertFalse($lj);
    }

    // public function testLoadAllOld() {}

    public function testAddLearningJourneySuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->addLearningJourney("The Emperor's new Journey", 3, 4);
        $this->assertTrue($status);
        $this->tester->seeInDatabase('learning_journey', [
            'lj_id' => 5,
            'lj_name' => "The Emperor's new Journey", 
            'staff_id' => 3,
            'role_id' => 4
        ]);
    }

    public function testAddLearningJourneyFailLongName() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->addLearningJourney("This name is too long by far,This name is too long by far,", 3, 4);
        $this->assertFalse($status);
    }

    public function testAddLearningJourneyFailNoName() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->addLearningJourney("", 3, 4);
        $this->assertFalse($status);
    }
    
    public function testRemoveLJSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->removeLearningJourney(1, 1);
        $this->assertTrue($status);
    }

    // public function testRemoveLJFailInvalidId() {
    //     $ljDAO = new classLearningJourneyDAO();
    //     $status = $ljDAO->removeLearningJourney(999, 45);
    //     $this->assertFalse($status);
    // }

    public function testCheckIfCourseInLJSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->checkIfCourseInLJ(1, 1);
        $this->assertTrue($status);
    }
    public function testCheckIfCourseInLJNoCourse() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->checkIfCourseInLJ(1, 7);
        $this->assertFalse($status);
    }
    public function testCheckIfCourseInLJInvalidId() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->checkIfCourseInLJ(999, 7);
        $this->assertFalse($status);
    }
    public function testAddCourseToLjSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->addCourseToLJ(1, 7);
        $this->assertTrue($status);
    }
    // public function testAddCourseToLjFailInvalidLjId() {
    //     $ljDAO = new classLearningJourneyDAO();
    //     $status = $ljDAO->addCourseToLJ(999, 7);
    //     $this->assertFalse($status);
    // }
    // public function testAddCourseToLjFailInvalidCourseId() {
    //     $ljDAO = new classLearningJourneyDAO();
    //     $status = $ljDAO->addCourseToLJ(1, 999);
    //     $this->assertFalse($status);
    // }
    
    public function testDropAllCourseFromLjSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $courseDAO = new classCourseDAO();
        $status = $ljDAO->dropAllCoursesFromLJ(1);
        $database = $courseDAO->loadCoursesByLJ(1);
        $this->assertTrue($status);
        $this->assertEquals(count($database), 0);
    }

    public function testUpdateLjNameSuccess() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->updateLJName(3, "Path to Kittens");
        $this->assertTrue($status);
    }

    public function testUpdateLjNameFailLongName() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->updateLJName(3, "Path to fifty KittensPath to fifty KittensPath to fifty Kittens");
        $this->assertFalse($status);
    }

    public function testUpdateLjNameFailNoName() {
        $ljDAO = new classLearningJourneyDAO();
        $status = $ljDAO->updateLJName(3, "");
        $this->assertFalse($status);
    }

    // public function testUpdateLjNameFailInvalidId() {
    //     $ljDAO = new classLearningJourneyDAO();
    //     $status = $ljDAO->updateLJName(999, "Path to 999 Kittens");
    //     $this->assertFalse($status);
    // }
   
}
