<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cоздать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
        'columns' => [
            'id',

            [
                'attribute' => 'datetask',
                'format' => 'raw',
                'value' => function($data){       
                    if (isset($data->datetask)){
                        return date('d.m.Y H:i', strtotime($data->datetask));
                    } else {
                        return "";
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
                'attribute' => 'id_recipe',
                'format' => 'raw',
                'value' => function($data){       
                    if (isset($data->recipe)){
                        return $data->recipe->name;
                    } else {
                        return "<ОБЪЕКТ НЕ НАЙДЕН>";
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
                        return ['class'=>'alert alert-danger'];
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
            'count',
            // 'id_user',
            // 'mail:ntext',

[
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="text-align:center">{new_action3} {new_action2} {new_action1}</div>',
                'buttons' => [
                    'new_action2' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute(['task/update','id'=>$model->id]),[
                                   'title' => Yii::t('app', 'Изменить')
                               ]);

                   },
                   'new_action1' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['task/delete','id'=>$model->id]), [
                                   'title' => Yii::t('app', 'Удалить'),
                                   'data-confirm'=>"Вы действительно хотите удалить эту задачу? Вместе с ней удалятся все связанные с ней записи о процессе выполнения!",
                                   'data-method' => 'post',
                                   'data-pjax' => '1'
                       ]);
                   },
                   'new_action3' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['task/view','id'=>$model->id]), [
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
