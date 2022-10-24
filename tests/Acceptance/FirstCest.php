<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function loginWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Login');
    }
    
    public function loginSuccesful(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Username', 'john.doe@gmail.com');
        $I->fillField('Password', '1');
        $I->click('LOGIN');
        $I->see('Popular Jobs');
    }

    public function searchbarWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Search');
    }

    public function searchbarResults(AcceptanceTester $I)
    {
        $I->amOnPage('/job');
        $I->fillField('Search', 'Defense');
        $I->click('Search');
        $I->see('Defense against the Dark Arts');
    }

}

// php vendor/bin/codecept run --steps