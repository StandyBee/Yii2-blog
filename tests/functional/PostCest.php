<?php


namespace functional;

use app\models\Post;
use app\fixtures\PostFixture;
use \FunctionalTester;
use function PHPUnit\Framework\identicalTo;

class PostCest
{
    public function _fixtures(): array
    {
        return ['posts' => [
            'class' => PostFixture::class,
            'dataFile' => codecept_data_dir('posts.php'),
        ],
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

    public function updatePost(FunctionalTester $I): void
    {

        $postId = 20000;
        $post = $I->grabFixture('posts', $postId)->attributes;

        $I->amOnRoute('post/update', ['id' => $postId]);

        $I->submitForm('form', [
            'Post[title]' => 'updated title',
        ]);

        $I->seeResponseCodeIsSuccessful();

        $I->seeRecord(Post::class, [
            'id' => $postId,
            'title' => 'updated title',
        ]);
    }

    public function visitUpdatePost(FunctionalTester $I): void
    {

        $postId = 20000;

        $I->amOnRoute('post/update', ['id' => $postId]);

        $I->seeResponseCodeIsSuccessful();

        $post = $I->grabFixture('posts', $postId);

        $I->seeInField('Post[title]',$post->title);
        $I->seeInField('Post[content]',$post->content);
    }

    public function deletePost(FunctionalTester $I): void
    {
        //TODO: delete test
    }

    public function createPostWithInvalidValues(FunctionalTester  $I): void
    {
        $I->amOnRoute('post/create');

        $I->submitForm('form', []);

        $I->see('Title cannot be blank');
    }
}
