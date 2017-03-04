<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use frontend\assets\AppAssetTwo;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
AppAssetTwo::register($this);
$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
<div id="hiddenid" style="display:none"><?= $id ?></div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'dataProvider' => $dataProvider,
        'bordered'=>true,
        'striped'=>true,
        'condensed'=>true,
        'responsive'=>true,
        'hover'=>true,
        'layout'=>'{pager}{errors}{items}',
        'emptyText'=>"Задачи не найдены...",
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['onclick'=>'window.location.replace(window.location.protocol+"//"+window.location.hostname+window.location.pathname+"?r=taskuser/task&id='.$model->id.'")',
                'style'=>"cursor:pointer;", 'class'=>'oper'];
        },
        'columns' => [
            'id',
            [
                'attribute' => 'id_transport',
                'format' => 'raw',
                'value' => function($data){ 
                    if (isset($data->transport)){
                        return $data->transport->name;
                    } else {
                        return "<ОБЪЕКТ НЕ НАЙДЕН>";
                    }
                }
            ],
            [
                'attribute' => 'dateredline',
                'format' => 'raw',
                'value' => function($data){       
                    if (isset($data->dateredline)){
                        return date('d.m.Y H:i', strtotime($data->dateredline));
                    } else {
                        return "";
                    }
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'contentOptions'=>function($data){
                    if ($data->status == '1'){
                        return ['class'=>'alert alert-warning'];
                    } elseif ($data->status == '2') {
                        return ['class'=>'alert alert-info'];
                    } elseif ($data->status == '0') { 
                        return ['class'=>'alert alert-danger', 'style'=>'font-size:12pt; font-weight:bold'];
                    } else {
                        return ['class'=>'alert alert-success'];
                    }
                        
                    
                },
                'value' => function($data){       
                    if ($data->status == '1'){
                        return "Не выполнена";
                    } elseif ($data->status == '2') {
                        return "В процессе";
                    } elseif ($data->status == '0')  {
                        return "Не просмотрена";
                    } else {
                        return "Выполнена";
                    }
                }
            ],
            //'count',
            // 'id_user',
            // 'mail:ntext',
     
        ],
    ]); ?>
</div>
