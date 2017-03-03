<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecipeCompose */

$this->title = 'Добавление записи';
$this->params['breadcrumbs'][] = ['label' => 'Рецептуры', 'url' => ['recipe/index']];
$this->params['breadcrumbs'][] = ['label' => $recipe->name, 'url' => ['recipe/view','id'=>$recipe->id]];
$this->params['breadcrumbs'][] = ['label' => 'Состав рецептуры', 'url' => ['index','id_recipe'=>$recipe->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-compose-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
