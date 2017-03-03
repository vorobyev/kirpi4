<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Состав задачи';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = ['label' => "Задача №".$task->id, 'url' => ['task/view','id'=>$task->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="process-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'count_fact',
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
        ],
    ]); ?>
</div>
