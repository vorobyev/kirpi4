<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */

$this->title = 'Изменение рецептуры: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рецептуры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="recipe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'answer' => $answer
    ]) ?>
    <div class="alert alert-info">
       <b>ВАЖНО!</b> Изменение рецептуры не повлияет на уже существующие задачи (только на вновь создаваемые)
    </div>
</div>
