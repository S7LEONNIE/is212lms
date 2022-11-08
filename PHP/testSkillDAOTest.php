<?php
// namespace Tests\Unit;
require_once 'classSkillDAO.php';

use Tests\Support\UnitTester;

class testSkillDAOTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testLoadAll()
    {
        $skillDAO = new classSkillDAO();
        $database = $skillDAO->loadAll();
        $this->assertEquals(count($database), 10);
        $this->assertEquals($database[5]->getSkill_Name(), 'Lightning Bolt');
    }
    
    public function testLoadSkillsByRoleIdSuccess()
    {
        $skillDAO = new classSkillDAO();
        $database = $skillDAO->loadSkillsByRoleId(3);
        $this->assertEquals(count($database), 2);
        $this->assertEquals($database[1]->getSkill_Name(), 'Operator');
    }

    public function testLoadSkillsByRoleIdFailInvalidId()
    {
        $skillDAO = new classSkillDAO();
        $database = $skillDAO->loadSkillsByRoleId(999);
        $this->assertEquals(count($database), 0);
    }

    public function testLoadSkillsByIdSuccess()
    {
        $skillDAO = new classSkillDAO();
        $skill = $skillDAO->loadSkillById(4);
        $this->assertEquals($skill->getSkill_Id(), 4);
        $this->assertEquals($skill->getSkill_Name(), 'SQL');
        $this->assertEquals($skill->getSkill_Desc(), 'This skill makes you good at DBMS.');
        $this->assertEquals($skill->get_IsActive(), 'active');
    }
    
    public function testLoadSkillsByIdFailInvalidId()
    {
        $skillDAO = new classSkillDAO();
        $skill = $skillDAO->loadSkillById(999);
        $this->assertFalse($skill);
    }
    
    public function testLoadSkillsByCourseIdSuccess()
    {
        $skillDAO = new classSkillDAO();
        $skills = $skillDAO->loadSkillsByCourseId(4);
        $this->assertEquals(count($skills), 2);
        $this->assertEquals($skills[0]->getSkill_Id(), 2);
        $this->assertEquals($skills[0]->getSkill_Name(), 'Communications');
        $this->assertEquals($skills[0]->getSkill_Desc(), 'This skills makes you good at communication.');
        $this->assertEquals($skills[0]->get_IsActive(), 'active');
        $this->assertEquals($skills[1]->getSkill_Id(), 3);
        $this->assertEquals($skills[1]->getSkill_Name(), 'Super Communications');
        $this->assertEquals($skills[1]->getSkill_Desc(), 'This skills makes you very good at communication.');
        $this->assertEquals($skills[1]->get_IsActive(), 'active');
    }

    public function testLoadSkillsByCourseIdFailInvalidId()
    {
        $skillDAO = new classSkillDAO();
        $skills = $skillDAO->loadSkillsByCourseId(999);
        $this->assertEquals(count($skills), 0);
    }
    
    public function testAddSkillSuccess()
    {
        $skillDAO = new classSkillDAO();
        $status = $skillDAO->addSkill("Kitten Handling", "This skill makes you good at petting kittens.");
        $this->tester->seeInDatabase('skill', [
            'skill_name' => 'Kitten Handling', 
            'skill_desc' => 'This skill makes you good at petting kittens.',
            'is_active' => 'active'
        ]);
    }
    
    public function testAddSkillFailNoName()
    {
        $skillDAO = new classSkillDAO();
        $status = $skillDAO->addSkill("", "This skill can't find kittens.");
        $this->assertFalse($status);
    }

    public function testAddSkillSuccessNoDesc()
    {
        $skillDAO = new classSkillDAO();
        $status = $skillDAO->addSkill("Kitten Hide and Seek", "");
        $this->tester->seeInDatabase('skill', [
            'skill_name' => 'Kitten Hide and Seek', 
            'skill_desc' => '',
            'is_active' => 'active'
        ]);
    }

    public function testUpdateSkillSuccess()
    {
        $skillDAO = new classSkillDAO();
        $status = $skillDAO->updateSkill(6, "Kitten Handling", "This skill makes you good at petting kittens.");
        $this->tester->seeInDatabase('skill', [
            'skill_id' => 6,
            'skill_name' => 'Kitten Handling', 
            'skill_desc' => 'This skill makes you good at petting kittens.',
            'is_active' => 'active'
        ]);
    }

    public function testUpdateSkillSuccessNoDesc()
    {
        $skillDAO = new classSkillDAO();
        $status = $skillDAO->updateSkill(3, "Kitten Handling", "");
        $this->tester->seeInDatabase('skill', [
            'skill_id' => 3,
            'skill_name' => 'Kitten Handling', 
            'skill_desc' => '',
            'is_active' => 'active'
        ]);
    }

    // public function testUpdateSkillFailInvalidId()
    // {
    //     $skillDAO = new classSkillDAO();
    //     $status = $skillDAO->updateSkill(999, "Kitten Handling", "Petting Kittens");
    //     $this->assertFalse($status);
    // }

    public function testDeleteSkillSuccess()
    {
        $skillDAO = new classSkillDAO();
        $status = $skillDAO->deleteSkill(3);
        $this->tester->seeInDatabase('skill', [
            'skill_id' => 3,
            'skill_name' => 'Super Communications', 
            'skill_desc' => 'This skills makes you very good at communication.',
            'is_active' => 'inactive'
        ]);
    }

    // public function testDeleteSkillFailInvalidId()
    // {
    //     $skillDAO = new classSkillDAO();
    //     $status = $skillDAO->deleteSkill(999);
    //     $this->assertEquals($status, FALSE);
    // }
}
