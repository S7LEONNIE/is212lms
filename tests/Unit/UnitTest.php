<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;

class ExampleTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }

    public function testValidation()
    {
        $user = new \App\classCourse();

        $user->setName(null);
        $this->assertFalse($user->validate(['course_name']));

        $user->setName('toolooooongnaaaaaaameeee2222222222222');
        $this->assertFalse($user->validate(['course_name']));

        $user->setName('122');
        $this->assertTrue($user->validate(['course_name']));
    }


    
}

// php vendor/bin/codecept run Unit UnitTest