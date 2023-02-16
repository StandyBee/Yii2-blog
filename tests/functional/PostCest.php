<?php


namespace functional;

use app\models\Post;
use app\fixtures\PostFixture;
use \FunctionalTester;

class PostCest
{
    // tests
    public function visitPostIndex(FunctionalTester $I): void
    {
        $I->haveFixtures([
            'posts' => [
                'class' => PostFixture::class,
                'dataFile' => codecept_data_dir('posts.php'),
            ],
        ]);

        $I->amOnRoute('post/index');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Posts', 'h1');
        $I->see('Test title');
    }

    public function createPostFromIndexPage(FunctionalTester $I):void
    {
        $I->amOnRoute('post/index');

        $I->click('Create Post');

        $I->fillField('Post[title]', 'title');
        $I->fillField('Post[content]', 'content');

        $I->click('Save');
        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'title' => 'title',
            'content' => 'content',
        ]);
    }

    public function createPost(FunctionalTester $I):void
    {
        $I->amOnRoute('post/create');

        $I->submitForm('form', [
            'Post[title]' => 'title',
            'Post[content]' => 'content',
        ]);

        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'title' => 'title',
            'content' => 'content',
        ]);
    }


}
