<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = "Задача №".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Состав задачи', ['process/index', 'id_task' => $model->id],['class' => 'btn btn-success btn-outline','name'=>'recipe-compose'])?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот элемент? Вместе с ним удалятся все связанные записи о процессе выполнения!',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'count',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data){       
                    if ($data->status == '1'){
                        return "Не выполнена";
                    } elseif ($data->status == '2') {
                        return "В процессе";
                    } else {
                        return "Выполнена";
                    }
                }
            ],
            [
                'attribute' => 'id_user',
                'format' => 'raw',
                'value' => function($data){ 
                    if (isset($data->user)){
                        return $data->user->username;
                    } else {
                        return "<ОБЪЕКТ НЕ НАЙДЕН>";
                    }
                }
            ],
                        [
                'attribute' => 'date_success',
                'format' => 'raw',
                'value' => function($data){       
                    if (isset($data->date_success)){
                        return date('d.m.Y H:i', strtotime($data->date_success));
                    } else {
                        return "";
                    }
                }
            ],
            'mail:ntext',
        ],
    ]) ?>

</div>
