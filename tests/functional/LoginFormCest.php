<?php

use app\fixtures\UserFixture;

class LoginFormCest
{
    public function _fixtures(): array
    {
        return [
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir('users.php'),
            ],
        ];
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users');
        $I->amLoggedInAs($user);

        $I->amOnRoute('/post');

        $I->see('Logout');
    }

    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $user = $I->grabFixture('users', 0);
        $I->amLoggedInAs($user);
        $I->amOnRoute('/post');
        $I->see($user->username);
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->submitForm('#auth-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->submitForm('#auth-form', [
            'AuthForm[username]' => 'admin',
            'AuthForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->submitForm('#auth-form', [
            'AuthForm[username]' => 'ssd',
            'AuthForm[password]' => 'ss',
        ]);
        $I->amOnRoute('/post');
        $I->see('Create');
        $I->dontSeeElement('form#auth-form');
    }
}