<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredient */

$this->title = 'Изменение ингредиента: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="ingredient-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'answer' => $answer
    ]) ?>

</div>
