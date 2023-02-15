<?php

/** @var yii\web\View $this */
/** @var string $message */

use yii\helpers\Html;

$this->title = 'My page';

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::encode($message) ?></p>
</div>

