<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Эта ошибка возникла при обработке сервером Вашего запроса.
    </p>
    <p>
        Если Вы думаете, что это ошибка сервера, пожалуйста, обратитесь к администратору.
    </p>

</div>
