<?php

namespace app\fixtures;

use app\models\Post;
use yii\test\ActiveFixture;

class PostFixture extends ActiveFixture
{
    public $modelClass = Post::class;
}