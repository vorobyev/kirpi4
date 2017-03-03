<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ingredient */

$this->title = 'Создание ингредиента';
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
