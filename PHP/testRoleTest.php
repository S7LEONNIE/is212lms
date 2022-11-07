<?php

// namespace Tests\Unit;
require_once '.\PHP\classRole.php';

use Tests\Support\UnitTester;

class MyTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $role = new classRole(FALSE, TRUE, FALSE, TRUE);
        $this->assertEquals($role->getRole_Id(), FALSE);

        // $user->setName('toolooooongnaaaaaaameeee');
        // $this->assertFalse($user->validate(['username']));

        // $user->setName('davert');
        // $this->assertTrue($user->validate(['username']));
    }
}

// vendor/bin/codecept run unit

?>