<?php


namespace functional;

use app\fixtures\UserFixture;
use app\models\Post;
use app\fixtures\PostFixture;
use \FunctionalTester;
use yii\helpers\Url;
use function PHPUnit\Framework\identicalTo;

class PostCest
{
    public function _fixtures(): array
    {
        return ['posts' => [
            'class' => PostFixture::class,
            'dataFile' => codecept_data_dir('posts.php'),
        ],
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir('users.php'),
            ]
        ];
    }

    public function visitPostIndex(FunctionalTester $I): void
    {
        $I->amOnRoute('post/index');

        $I->seeResponseCodeIsSuccessful();
        $I->see('Posts', 'h1');

        $posts = $I->grabFixture('posts');
        foreach ($posts as $post) {
            $I->see($post['title']);
        }
    }

    public function createPostFromIndexPage(FunctionalTester $I): void
    {
        $user = $I->grabFixture('users');
        $I->amLoggedInAs($user);

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

    public function createPost(FunctionalTester $I): void
    {
        $user = $I->grabFixture('users', 0);
        $I->amLoggedInAs($user);

        $I->amOnRoute('post/create');
        $I->see($user->username);
        $I->fillField('Post[title]', 'title');
        $I->fillField('Post[content]', 'content');
        $I->click('Save');
//        $I->submitForm('form', [
//            'Post[title]' => 'title',
//            'Post[content]' => 'content',
//        ]);
//
        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'title' => 'title',
            'content' => 'content',
        ]);
    }

    public function updatePost(FunctionalTester $I): void
    {
        $user = $I->grabFixture('users');
        $I->amLoggedInAs($user);

        $postId = 20000;
        $post = $I->grabFixture('posts', $postId)->attributes;

        $I->amOnRoute('post/update', ['id' => $postId]);

//        $I->submitForm('form', [
//            'Post[title]' => 'updated title',
//        ]);
        $I->fillField('Post[title]', 'updated title');
        $I->click('Save');

        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'id' => $postId,
            'title' => 'updated title',
        ]);
    }

    public function visitUpdatePost(FunctionalTester $I): void
    {
        $user = $I->grabFixture('users');
        $I->amLoggedInAs($user);

        $postId = 20000;

        $I->amOnRoute('post/update', ['id' => $postId]);

        $I->seeResponseCodeIsSuccessful();

        $post = $I->grabFixture('posts', $postId);

        $I->seeInField('Post[title]',$post->title);
        $I->seeInField('Post[content]',$post->content);
    }

    public function deletePost(FunctionalTester $I): void
    {
        $user = $I->grabFixture('users');
        $I->amLoggedInAs($user);

        $uri = Url::to([
            '/post/delete',
            'id' => 10000,
        ]);
        $I->sendAjaxPostRequest($uri);

        $I->dontSeeRecord(Post::class, ['id' => 10000]);
    }

    public function createPostWithInvalidValues(FunctionalTester  $I): void
    {
        $user = $I->grabFixture('users');
        $I->amLoggedInAs($user);

        $I->amOnRoute('post/create');

//        $I->submitForm('form', []);
        $I->fillField('Post[title]', '');
        $I->click('Save');

        $I->see('Title cannot be blank');
    }
}
