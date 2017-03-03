<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Состав рецетуры';
$this->params['breadcrumbs'][] = ['label' => 'Рецептуры', 'url' => ['recipe/index']];
$this->params['breadcrumbs'][] = ['label' => $recipe->name, 'url' => ['recipe/view','id'=>$recipe->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-compose-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create','id_recipe'=>$recipe->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'bordered'=>true,
        'striped'=>true,
        'condensed'=>true,
        'responsive'=>true,
        'hover'=>true,
        'layout'=>'{pager}{errors}{items}',
        'emptyText'=>"Элементы не найдены...",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '№'
            ],
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

[
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="text-align:center">{new_action3} {new_action2} {new_action1}</div>',
                'buttons' => [
                    'new_action2' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute(['recipe-compose/update','id'=>$model->id, 'id_recipe'=>$model->recipe->id]),[
                                   'title' => Yii::t('app', 'Изменить')
                               ]);

                   },
                   'new_action1' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['recipe-compose/delete','id'=>$model->id, 'id_recipe'=>$model->recipe->id]), [
                                   'title' => Yii::t('app', 'Удалить'),
                                   'data-confirm'=>"Вы действительно хотите удалить этот элемент?",
                                   'data-method' => 'post',
                                   'data-pjax' => '1'
                       ]);
                   },
                   'new_action3' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['recipe-compose/view','id'=>$model->id, 'id_recipe'=>$model->recipe->id]), [
                                   'title' => Yii::t('app', 'Просмотреть')
                       ]);
                   },
                ],      
                'urlCreator' => function ($action, $model, $key, $index) {
                  if ($action === 'new_action1') {
                      $url = $model->id;
                      return $url;
                  }
                }
            ], 
        ],
    ]); ?>
</div>
