<?php

// namespace Tests\Unit;
require_once 'classRoleDAO.php';

use Tests\Support\UnitTester;

class testRoleDAOTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testAddRole()
    {
        $roleDAO = new classRoleDAO();
        $status = $roleDAO->addRole("The Wandering Emperor", "This role exists.");
        $this->tester->seeInDatabase('role', [
            'role_name' => 'The Wandering Emperor', 
            'role_desc' => 'This role exists.',
            'is_active' => 'active'
        ]);
    }
}
