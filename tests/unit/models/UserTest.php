<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        $user = new User();
        $user->id = 10000;
        $user->username = 'admin';
        $user->password = 'admin';
        $user->auth_key = 'test100key';
        $user->save();
    }
    public function testFindUserById()
    {
        verify($user = User::findIdentity(10000))->notEmpty();
        verify($user->username)->equals('admin');

        verify(User::findIdentity(999))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = User::findByUsername('admin'))->notEmpty();
        verify(User::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('admin');
        //dd($user->auth_key);
        verify($user->auth_key)->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->password)->notEmpty();
        verify($user->validatePassword('123456'))->empty();
    }

}
