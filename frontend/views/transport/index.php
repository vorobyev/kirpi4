<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Транспорт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать транспортное средство', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'bordered'=>true,
        'striped'=>true,
        'condensed'=>true,
        'responsive'=>true,
        'hover'=>true,
        'layout'=>'{pager}{errors}{items}',
        'emptyText'=>"Транспортные средства не найдены...",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => '№'
            ],

            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="text-align:center">{new_action3} {new_action2} {new_action1}</div>',
                'buttons' => [
                    'new_action2' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute(['transport/update','id'=>$model->id]),[
                                   'title' => Yii::t('app', 'Изменить')
                               ]);

                   },
                   'new_action1' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['transport/delete','id'=>$model->id]), [
                                   'title' => Yii::t('app', 'Удалить'),
                                   'data-confirm'=>"Вы действительно хотите удалить это транспортное средство?",
                                   'data-method' => 'post',
                                   'data-pjax' => '1'
                       ]);
                   },
                   'new_action3' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['transport/view','id'=>$model->id]), [
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
