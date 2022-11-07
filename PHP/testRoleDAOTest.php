<?php

// namespace Tests\Unit;
require_once 'classRoleDAO.php';
require_once 'classSkillDAO.php';

use Tests\Support\UnitTester;

class testRoleDAOTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests

    public function testLoadAll()
    {
        $roleDAO = new classRoleDAO();
        $database = $roleDAO->loadAll();
        $this->assertEquals($database[3]->getRole_Name(), 'Death, Destroyer of Worlds');
    }

    public function testAddRoleSuccess()
    {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole("The Wandering Emperor", "This role exists.");
        $this->tester->seeInDatabase('role', [
            'role_name' => 'The Wandering Emperor', 
            'role_desc' => 'This role exists.',
            'is_active' => 'active'
        ]);
        $this->assertEquals($status, 5);
    }

    public function testAddRoleFailLongName() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole(
            "This role name is way too long, This role name is way too long", 
            "This role doesn't exist."
        );
        $this->assertFalse($status);
    }
    
    public function testAddRoleFailEmptyName() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole("", "Oops, role name length is 0.");
        $this->assertFalse($status);
    }
    
    public function testAddRoleFailLongDesc() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole(
            "Long Description",
            "This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist.This role doesn't exist."
        );
        $this->assertFalse($status);
    }

    public function testAddRoleSuccessEmptyDesc() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole("Oops Empty Description", "");
        $this->tester->seeInDatabase('role', [
            'role_name' => 'Oops Empty Description', 
            'role_desc' => '',
            'is_active' => 'active'
        ]);
        $this->assertEquals($status, 5);
    }

    public function testAddRoleSuccessNumbers() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole(428571, 12340988);
        $this->tester->seeInDatabase('role', [
            'role_name' => '428571', 
            'role_desc' => '12340988',
            'is_active' => 'active'
        ]);
        $this->assertEquals($status, 5);
    }

    public function testGetRoleByIdSuccess() {
        $roleDAO = new classRoleDAO();
        $role = $roleDAO->getRoleById(1);
        $this->assertEquals($role->getRole_Id(), 1);
        $this->assertEquals($role->getRole_Name(), 'Engineer');
        $this->assertEquals($role->getRole_Desc(), 'This role is good at engineering.');
    }

    public function testGetRoleByIdFailNoId() {
        $roleDAO = new classRoleDAO();
        $role = $roleDAO->getRoleById(999);
        $this->assertEquals($role, FALSE);
    }

    public function testGetRoleByIdFailStringId() {
        $roleDAO = new classRoleDAO();
        $role = $roleDAO->getRoleById("The Wandering Emperor");
        $this->assertEquals($role, FALSE);
    }

    public function testGetRoleByIdSuccessNumberAsString() {
        $roleDAO = new classRoleDAO();
        $role = $roleDAO->getRoleById("2");
        $this->assertEquals($role->getRole_Id(), 2);
        $this->assertEquals($role->getRole_Name(), 'Manager');
        $this->assertEquals($role->getRole_Desc(), 'This role is good at managing.');
    }

    public function testGetRolesBySkillIdSuccess() {
        $roleDAO = new classRoleDAO();
        $role_list = $roleDAO->loadRolesBySkillId("2");
        $this->assertEquals(count($role_list), 2);
        $this->assertEquals($role_list[0]->getRole_Id(), 1);
        $this->assertEquals($role_list[0]->getRole_Name(), 'Engineer');
        $this->assertEquals($role_list[0]->getRole_Desc(), 'This role is good at engineering.');
        $this->assertEquals($role_list[1]->getRole_Id(), 2);
        $this->assertEquals($role_list[1]->getRole_Name(), 'Manager');
        $this->assertEquals($role_list[1]->getRole_Desc(), 'This role is good at managing.');
    }

    public function testUpdateRoleSuccess() {
        $roleDAO = new classRoleDAO();
        $roleDAO->updateRole(3, "the IT guy", "This role develops web apps.");
        $this->tester->seeInDatabase('role', [
            'role_id' => 3,
            'role_name' => 'the IT guy', 
            'role_desc' => 'This role develops web apps.',
            'is_active' => 'active'
        ]);
    }

    public function testUpdateRoleFailNoName() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->updateRole(1, "", "This role develops web apps.");
        $this->tester->assertFalse($status);
    }

    public function testUpdateRoleSuccessNoDesc() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->updateRole(1, "The Wandering Emperor", "");
        $this->tester->seeInDatabase('role', [
            'role_id' => 1,
            'role_name' => 'The Wandering Emperor',
            'role_desc' => '',
            'is_active' => 'active'
        ]);
    }

    // public function testUpdateRoleFailInvalidId() {
    //     $roleDAO = new classRoleDAO();
    //     $status = $roleDAO->updateRole(999, "The Wandering Emperor", "2WW Flash");
    //     $this->tester->assertFalse($status);
    // }

    public function testClearSkillsFromRoleSuccess() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->clearSkillsFromRole(1);
        $this->tester->assertTrue($status);
        
        $skillDAO = new classSkillDAO();
        $database = $skillDAO->loadSkillsByRoleId(1);
        $this->tester->assertEquals(count($database), 0);
    }

    // public function testClearSkillsFromRoleInvalidId() {
    //     $roleDAO = new classRoleDAO();
    //     $status = $roleDAO->clearSkillsFromRole(999);
    //     $this->tester->assertFalse($status);
    // }

    public function testAddSkillToRole() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addSkillToRole(1, 7);
        $this->tester->seeInDatabase('role_skill', [
            'role_id' => 1,
            'skill_id' => 7
        ]);
    }
    
    public function testAddSkillToRoleSuccess() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addSkillToRole(1, 7);
        $this->tester->seeInDatabase('role_skill', [
            'role_id' => 1,
            'skill_id' => 7
        ]);
    }

    // public function testAddSkillToRoleFailInvalidSkill() {
    //     $roleDAO = new classRoleDAO();
    //     $status = $roleDAO->addSkillToRole(1, 999);
    //     $this->tester->seeInDatabase('role_skill', [
    //         'role_id' => 1,
    //         'skill_id' => 7
    //     ]);
    // }

    public function testDeleteRoleSuccess() {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->deleteRole(4);
        $this->tester->seeInDatabase('role', [
            'role_id' => 4,
            'role_name' => "Death, Destroyer of Worlds",
            'role_desc' => 'This role is good at petting kittens.',
            'is_active' => 'inactive'
        ]);
    }
}
