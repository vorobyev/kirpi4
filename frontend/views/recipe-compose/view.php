<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecipeCompose */

$this->title = $model->ingredient->name;
$this->params['breadcrumbs'][] = ['label' => 'Рецептуры', 'url' => ['recipe/index']];
$this->params['breadcrumbs'][] = ['label' => $recipe->name, 'url' => ['recipe/view','id'=>$recipe->id]];
$this->params['breadcrumbs'][] = ['label' => 'Состав рецептуры', 'url' => ['index','id_recipe'=>$recipe->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-compose-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id, 'id_recipe'=>$recipe->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id, 'id_recipe'=>$recipe->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_ingredient',
                'format' => 'raw',
                'value' => function($data){ 
                    if (isset($data->ingredient)){
                        return $data->ingredient->name;
                    } else {
                        return "<ОБЪЕКТ НЕ НАЙДЕН>";
                    }
                }
            ],
            'count',
            [
                'attribute' => 'id_measure',
                'format' => 'raw',
                'value' => function($data){ 
                    if (isset($data->measure)){
                        return $data->measure->name;
                    } else {
                        return "<ОБЪЕКТ НЕ НАЙДЕН>";
                    }
                }
            ],
            'order_pos',
        ],
    ]) ?>

</div>
